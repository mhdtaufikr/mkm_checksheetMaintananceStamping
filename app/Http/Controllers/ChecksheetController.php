<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChecksheetFormHead;
use App\Models\Machine;
use App\Models\Checksheet;
use App\Models\ChecksheetItem;
use Illuminate\Support\Facades\Auth;
use App\Models\ChecksheetFormDetail;
use App\Models\Signature;
use App\Models\Rule;
use App\Models\User;
use Illuminate\Support\Str;
use App\Models\ChecksheetJourneyLog;
use Illuminate\Support\Facades\Mail;
use App\Mail\ApprovalReminder;
use App\Mail\RemandNotification;
use App\Mail\CheckerReminder;
use App\Mail\ChecksheetApprovalNotification;
use DB;
use PDF;

class ChecksheetController extends Controller
{
    public function index(Request $request)
{
    if (Auth::user()->role == "Checker") {
        $item = ChecksheetFormHead::orderBy('created_at', 'desc')->get();
    }elseif(Auth::user()->role == "Approval") {
        $item = ChecksheetFormHead::orderBy('created_at', 'desc')->get();
    }elseif(Auth::user()->role == "user"){
        $item = ChecksheetFormHead::where('created_by',Auth::user()->name)->orderBy('created_at', 'desc')->get();
    }else{
        $item = ChecksheetFormHead::orderBy('created_at', 'desc')->get();
    }
    // Retrieve all ChecksheetFormHead records sorted by the newest data

    // Attach logs to each item
    foreach ($item as $items) {
        $items->logs = ChecksheetJourneyLog::where('checksheet_id', $items->id)
            ->orderBy('created_at', 'desc')->get();
    }

    // Retrieve all machine names
    $machines = Machine::pluck('machine_name')->toArray();

    return view('checksheet.index', compact('item', 'machines'));
}

   public function checksheetScan(Request $request){


        if (empty($request->mechine)) {

            $item = Machine::where('machine_no',$request->no_mechine)->first();

        }else {
            $item = Machine::where('machine_name',$request->mechine)->first();
        }

        return view('checksheet.form',compact('item'));
    }


    public function storeHeadForm(Request $request){

        // Create a new instance of ChecksheetHead model
        $checksheetHead = new ChecksheetFormHead();
        // Assign values from the request to the model attributes
        $checksheetHead->document_number = $request->no_document;
        $checksheetHead->department = $request->department;
        $checksheetHead->shop = $request->shop;
        $checksheetHead->effective_date = $request->effective_date;
        $checksheetHead->revision = $request->revision;
        $checksheetHead->op_number = $request->op_number;
        $checksheetHead->manufacturing_date = $request->mfg_date;
        $checksheetHead->planning_date = $request->planning_date;
        $checksheetHead->machine_name = $request->machine_name;
        $checksheetHead->process = $request->process;
        $checksheetHead->actual_date = $request->actual_date;
        $checksheetHead->status = 0; // Set status to 0
        $checksheetHead->created_by = Auth::user()->name;

        // Save the data to the database
        $checksheetHead->save();

        // Get the ID of the newly created record
        $id = $checksheetHead->id;

        // Redirect the user to the 'fill' route with the ID as a parameter
        return redirect()->route('fill', ['id' => encrypt($id)])->with('status', 'Checksheet head form submitted successfully.');
    }


    public function checksheetfill($id){
        $id = decrypt($id);
       // Fetch the machine name based on the given ID
        $item = ChecksheetFormHead::where('id', $id)->first('machine_name');

        // Now, use the machine name to filter the query
        $results = ChecksheetItem::select('checksheets.checksheet_id','machines.machine_name', 'checksheet_items.item_name', 'checksheets.checksheet_category', 'checksheets.checksheet_type','checksheet_items.spec')
            ->join('checksheets', 'checksheet_items.checksheet_id', '=', 'checksheets.checksheet_id')
            ->join('machines', 'checksheet_items.machine_id', '=', 'machines.id')
            ->where('machines.machine_name', $item->machine_name)
            ->get();
            // Inisialisasi array untuk menyimpan hasil pengelompokkan
            $groupedResults = [];

            // Perulangan melalui hasil query
            foreach ($results as $result) {
                // Tambahkan hasil ke dalam array berdasarkan checksheet_id
                $groupedResults[$result->checksheet_id][] = [
                    'machine_name' => $result->machine_name,
                    'item_name' => $result->item_name,
                    'checksheet_category' => $result->checksheet_category,
                    'checksheet_type' => $result->checksheet_type,
                    'spec' => $result->spec,
                    'checksheet_type' =>$result->checksheet_type,
                ];
            }

        return view('checksheet.fill',compact('result','groupedResults','id'));
    }

    public function storeDetailForm(Request $request)
    {
        // Mendapatkan data dari request
        $formData = $request->all();

        // Mendapatkan id header
        $idHeader = $formData['id_header'];

        // Mendapatkan item-item yang akan disimpan
        $items = $formData['items'];

        // Mendapatkan nilai pic dan remarks dari request
        $pic = $formData['pic'];
        $remarks = $formData['remarks'];

        $getMail = Rule::where('rule_name', 'Checker')->get();

        // Update pic and remarks for the header id
        $checksheetHead = ChecksheetFormHead::find($idHeader);
        if ($checksheetHead) {
            $checksheetHead->pic = $pic;
            $checksheetHead->remark = $remarks;
            $checksheetHead->status = 1; // Update status to 1
            $checksheetHead->save();
        }

        // Menyimpan setiap item ke dalam tabel
        foreach ($items as $itemName => $itemData) {
            $checksheetDetail = new ChecksheetFormDetail();
            $checksheetDetail->id_header = $idHeader;
            $checksheetDetail->checksheet_category = $itemData['checksheet_category']; // Add checksheet category
            $checksheetDetail->item_name = $itemName;
            $checksheetDetail->checksheet_type = $itemData['checksheet_type'];
            $checksheetDetail->act = $itemData['act'] ?? null;
            $checksheetDetail->B = isset($itemData['B']) ? $itemData['B'] : 0;
            $checksheetDetail->R = isset($itemData['R']) ? $itemData['R'] : 0;
            $checksheetDetail->G = isset($itemData['G']) ? $itemData['G'] : 0;
            $checksheetDetail->PP = isset($itemData['PP']) ? $itemData['PP'] : 0;
            $checksheetDetail->judge = $itemData['judge'] ?? null;
            $checksheetDetail->remarks = $itemData['remarks'] ?? null;
            $checksheetDetail->save();
        }

        foreach ($getMail as $mail) {
            if ($checksheetHead && $checksheetHead->status == 1) {
                Mail::to($mail->rule_value)->send(new CheckerReminder($checksheetHead));
            }
        }

        // Redirect atau response sesuai kebutuhan Anda
        return redirect()->route('machine')->with('status', 'Checksheet submitted successfully.');
    }



    public function checksheetDetail($id){
        $id = decrypt($id);
        $itemHead = ChecksheetFormHead::where('id', $id)->first();
        $itemDetail = ChecksheetFormDetail::where('id_header', $id)->get();

        // Group item details based on asset categories
        $groupedResults = [];
        foreach ($itemDetail as $detail) {
            // Query the checksheet_items table to get the spec
            $item = ChecksheetItem::where('item_name', $detail->item_name)->first();

            // Add the spec to the detail object
            $detail->spec = $item ? $item->spec : ''; // If item not found, set spec to empty string

            $groupedResults[$detail->checksheet_category][] = $detail;
        }

        return view('checksheet.detail', compact('itemHead', 'groupedResults', 'id'));
    }



    public function checksheetSignature(Request $request){
        // Decode the JSON signature data
        $signatures = json_decode($request->signature1);

        // Extract the checksheet ID
        $checksheet_id = $request->checksheet_id;

        // Create a new instance of the Signature model
        $signature = new Signature();

        // Fill the model attributes
        $signature->checksheet_id = $checksheet_id;
        $signature->signature1 = $signatures->signature1;
        $signature->signature2 = $signatures->signature2;
        $signature->signature3 = $signatures->signature3;
        $signature->signature4 = $signatures->signature4;

        // Save the signature to the database
        $signature->save();

        return redirect()->back()->with('status', 'Success Sign Checksheet');

        // Optionally, you can return a response or redirect the user
    }


    public function checksheetApprove($id){
        $id = decrypt($id);
        $itemHead = ChecksheetFormHead::where('id', $id)->first();
        $itemDetail = ChecksheetFormDetail::where('id_header', $id)->get();

        // Group item details based on asset categories
        $groupedResults = [];
        foreach ($itemDetail as $detail) {
            // Query the checksheet_items table to get the spec
            $item = ChecksheetItem::where('item_name', $detail->item_name)->first();

            // Add the spec to the detail object
            $detail->spec = $item ? $item->spec : ''; // If item not found, set spec to empty string

            $groupedResults[$detail->checksheet_category][] = $detail;
        }

        return view('checksheet.approve', compact('itemHead', 'groupedResults', 'id'));
    }

    public function checksheetChecker($id){
        $id = decrypt($id);
        $itemHead = ChecksheetFormHead::where('id', $id)->first();
        $itemDetail = ChecksheetFormDetail::where('id_header', $id)->get();

        // Group item details based on asset categories
        $groupedResults = [];
        foreach ($itemDetail as $detail) {
            // Query the checksheet_items table to get the spec
            $item = ChecksheetItem::where('item_name', $detail->item_name)->first();

            // Add the spec to the detail object
            $detail->spec = $item ? $item->spec : ''; // If item not found, set spec to empty string

            $groupedResults[$detail->checksheet_category][] = $detail;
        }

        return view('checksheet.checkher', compact('itemHead', 'groupedResults', 'id'));
    }

    public function checksheetApproveStore(Request $request)
{
    $checksheetHeader = ChecksheetFormHead::findOrFail($request->id);
    $getMail = User::where('name', $checksheetHeader->created_by)->first();
    $authUser = Auth::user(); // Get the authenticated user

    switch ($request->approvalStatus) {
        case 'approve':
            $checksheetHeader->status = 4; // Waiting Approval

            // Generate PDF
            $pdf = $this->generatePdfmail($checksheetHeader->id);

            // Send email with PDF to the authenticated user
            Mail::to($authUser->email)
                ->send(new ChecksheetApprovalNotification($checksheetHeader, $pdf));

            break;
        case 'remand':
            $checksheetHeader->status = 3; // Remand
            Mail::to($getMail->email) // Replace with appropriate recipient
                ->send(new RemandNotification($checksheetHeader, $request->remark));
            break;
        default:
            break;
    }
    $checksheetHeader->save();

    $log = new ChecksheetJourneyLog();
    $log->checksheet_id = $request->id;
    $log->user_id = Auth::id();
    $log->action = $checksheetHeader->status;
    $log->remark = $request->remark;
    $log->save();

    return redirect()->route('machine')->with('status', 'Checksheet submitted successfully.');
}

public function generatePdfmail($id)
{
    $checksheetHead = ChecksheetFormHead::find($id);
    $checksheetDetails = ChecksheetFormDetail::where('id_header', $id)
        ->leftJoin('checksheet_items', 'checksheet_form_details.item_name', '=', 'checksheet_items.item_name')
        ->select('checksheet_form_details.*', 'checksheet_items.spec')
        ->get();

    $pdf = PDF::loadView('checksheet.pdf', compact('checksheetHead', 'checksheetDetails'))->setPaper('a4', 'landscape');

    return $pdf;
}



    public function checksheetCheckerStore(Request $request)
    {
        $checksheetHeader = ChecksheetFormHead::findOrFail($request->id);
        $checksheetHead = ChecksheetFormHead::findOrFail($request->id);

        $getMail = User::where('name',$checksheetHeader->created_by)->first();

        switch ($request->approvalStatus) {
            case 'approve':
                $checksheetHeader->status = 2; // Waiting Approval
                $getMail = Rule::where('rule_name', 'Approval')->get();
                foreach ($getMail as $mail) {
                    if ($checksheetHead && $checksheetHead->status == 1) {
                        Mail::to($mail->rule_value)->send(new ApprovalReminder($checksheetHead));
                    }
                }
                break;
            case 'remand':
                $checksheetHeader->status = 3; // Remand
                Mail::to($getMail->email) // Replace with appropriate recipient
                    ->send(new RemandNotification($checksheetHeader, $request->remark));
                break;
            default:
                break;
        }
        $checksheetHeader->save();

        $log = new ChecksheetJourneyLog();
        $log->checksheet_id = $request->id;
        $log->user_id = Auth::id();
        $log->action = $checksheetHeader->status;
        $log->remark = $request->remark;
        $log->save();

        return redirect()->route('machine')->with('status', 'Checksheet submitted successfully.');
    }

    public function checksheetUpdate($id){
        $id = decrypt($id);
        $itemHead = ChecksheetFormHead::where('id', $id)->first();
        $itemDetail = ChecksheetFormDetail::where('id_header', $id)->get();

        // Group item details based on asset categories
        $groupedResults = [];
        foreach ($itemDetail as $detail) {
            // Query the checksheet_items table to get the spec
            $item = ChecksheetItem::where('item_name', $detail->item_name)->first();

            // Add the spec to the detail object
            $detail->spec = $item ? $item->spec : ''; // If item not found, set spec to empty string

            $groupedResults[$detail->checksheet_category][] = $detail;
        }

        return view('checksheet.update', compact('itemHead', 'groupedResults', 'id'));
    }

    public function checksheetUpdateDetail(Request $request)
{
    // Retrieve request data
    $requestData = $request->all();
    $id = $requestData['id'];
    $noDocument = $requestData['no_document'];

    // Update values in the checksheet_form_details table
    foreach ($requestData['items'] as $itemName => $itemData) {
        $detail = ChecksheetFormDetail::where('id_header', $id)
            ->where('item_name', $itemName)
            ->first();
        if ($detail) {
            $detail->update($itemData);
        }
    }

    // Check for changes in checksheet_form_details
    $detailsBeforeUpdate = ChecksheetFormDetail::where('id_header', $id)
        ->pluck('id', 'item_name');

    // Update values in the checksheet_form_heads table if necessary
    $head = ChecksheetFormHead::find($id);

    if ($head) {
        // Prepare an array for fields that need updating
        $updates = [];

        // Update pic and remarks if they have changed
        if ($head->pic !== $requestData['pic']) {
            $updates['pic'] = $requestData['pic'];
        }
        if ($head->remark !== $requestData['remarks']) {
            $updates['remark'] = $requestData['remarks'];
        }

        // Update other fields in checksheet_form_heads if necessary
        $otherFields = ['no_document', 'department', 'shop', 'effective_date', 'revision', 'op_number', 'mfg_date', 'planning_date', 'machine_name', 'process', 'actual_date'];
        foreach ($otherFields as $field) {
            if (isset($requestData[$field]) && $head->$field !== $requestData[$field]) {
                $updates[$field] = $requestData[$field];
            }
        }

        if (!empty($updates)) {
            $head->update($updates);

            // Log changes in checksheet_journey_logs for checksheet_form_heads
            $logData = [
                'checksheet_id' => $id,
                'user_id' => auth()->id(),
                'action' => '5', // Assuming action '5' represents an update
                'remark' => 'Checksheet updated: ' . implode(', ', array_keys($updates)),
            ];
            ChecksheetJourneyLog::create($logData);
        }

        // Update checksheet status to 1 (done)
        $head->update(['status' => 1]);
    }

    // Retrieve emails of users with the "Checker" role and send reminder emails
    $getMail = Rule::where('rule_name', 'Checker')->get();
    foreach ($getMail as $mail) {
        if ($head && $head->status == 1) {
            Mail::to($mail->rule_value)->send(new CheckerReminder($head));
        }
    }

    // Redirect to /checksheet with success message
    return redirect('/checksheet')->with('status', 'Checksheet updated successfully');
}

public function generatePdf($id)
{
    $id = decrypt($id);

    // Retrieve the checksheet head
    $checksheetHead = ChecksheetFormHead::find($id);

    // Retrieve the checksheet details with the spec from the checksheet_items table
    $checksheetDetails = ChecksheetFormDetail::where('id_header', $id)
        ->leftJoin('checksheet_items', 'checksheet_form_details.item_name', '=', 'checksheet_items.item_name')
        ->select('checksheet_form_details.*', 'checksheet_items.spec')
        ->get();

    // Load the view and pass the data to it
    $pdf = PDF::loadView('checksheet.pdf', compact('checksheetHead', 'checksheetDetails'))->setPaper('a4', 'landscape');

    // Return the generated PDF
    return $pdf->download('checksheet_' . $checksheetHead->document_number . '.pdf');
}

}
