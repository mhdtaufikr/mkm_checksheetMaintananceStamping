<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChecksheetFormHead;
use App\Models\Machine;
use App\Models\Checksheet;
use App\Models\ChecksheetItem;
use Illuminate\Support\Facades\Auth;
use App\Models\ChecksheetFormDetail;

class ChecksheetController extends Controller
{
    public function index(){

        $item = ChecksheetFormHead::get();

        return view('checksheet.index',compact('item'));
    }

    public function checksheetScan(Request $request){
        $item = Machine::where('machine_name',$request->mechine)->first();
        
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
        $results = ChecksheetItem::select('checksheets.checksheet_id','machines.machine_name', 'checksheet_items.item_name', 'checksheets.checksheet_category', 'checksheets.checksheet_type')
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

    // Menyimpan setiap item ke dalam tabel
    foreach ($items as $itemName => $itemData) {
        $checksheetDetail = new ChecksheetFormDetail();
        $checksheetDetail->id_header = $idHeader;
        $checksheetDetail->item_name = $itemName;
        $checksheetDetail->checksheet_type = $itemData['checksheet_type'];
        $checksheetDetail->spec = $itemData['spec'];
        $checksheetDetail->act = $itemData['act'];
        $checksheetDetail->B = isset($itemData['B']) ? $itemData['B'] : 0;
        $checksheetDetail->R = isset($itemData['R']) ? $itemData['R'] : 0;
        $checksheetDetail->G = isset($itemData['G']) ? $itemData['G'] : 0;
        $checksheetDetail->PP = isset($itemData['PP']) ? $itemData['PP'] : 0;
        $checksheetDetail->judge = $itemData['judge'];
        $checksheetDetail->remarks = $itemData['remarks'];
        $checksheetDetail->save();
    }

    // Redirect atau response sesuai kebutuhan Anda
    return redirect()->route('machine')->with('status', 'Checksheet submitted successfully.');
}

    public function checksheetDetail($id){
        $id = decrypt($id);
        $itemHead = ChecksheetFormHead::where('id',$id)->first();
        $itemDetail = ChecksheetFormDetail::where('id_header',$id)->get();
    
        return view('checksheet.detail',compact('itemHead','itemDetail'));
    }

    public function checksheetSignature(Request $request){
        dd($request->all());
    }

}
