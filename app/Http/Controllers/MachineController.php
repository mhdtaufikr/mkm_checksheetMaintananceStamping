<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Machine;
use App\Models\Checksheet;
use App\Models\ChecksheetItem;
use App\Models\Dropdown;


class MachineController extends Controller
{
   public function index(){

      $item = Machine::get();
      $dropdown = Dropdown::where('category','Category')->get();

    return view('master.mechine.index',compact('item','dropdown'));
   }


   public function store(Request $request) {
    // Validate the request data
    $request->validate([
        'mechine' => 'required|string', // adjust the validation rules as needed
        'type' => 'required|string',
        'no_document' => 'required|string',
    ]);

    // Check if the machine name already exists in the database
    $existingMachine = Machine::where('machine_name', $request->mechine)->first();

    if ($existingMachine) {
        // Handle the case where the machine name already exists
        return redirect()->back()->with('failed', 'Machine already exists.');
    }

    // Store the machine data in the database
    $machine = new Machine();
    $machine->machine_no = $request->mechine_no;
    $machine->machine_name = $request->mechine;
    $machine->type = $request->type;
    $machine->no_document = $request->no_document;
    $machine->effective_date = $request->effective_date;
    $machine->mfg_date = $request->mfg_date;
    $machine->revision = $request->revision;
    $machine->no_procedure = $request->no_procedure;
    $machine->op_name = $request->op_name;
    $machine->process = $request->process;
    $machine->save();

    // Redirect the user after successfully storing the data
    return redirect()->back()->with('status', 'Machine created successfully.');
}



  public function detail($id){
   $id = decrypt($id);
   $machine = Machine::where('id',$id)->first();
   $checksheet = Checksheet::where('machine_id',$id)->get();
   $checksheetItem = ChecksheetItem::where('machine_id',$id)->get();
   $dropdown = Dropdown::where('category','ChecksheetType')->get();

   return view('master.mechine.detail',compact('machine','checksheet','checksheetItem','dropdown'));
  }

    public function storeChecksheet(Request $request){
        // Validate the request data
        $request->validate([
            'machine_id' => 'required|exists:machines,id',
            'mechine' => 'required|string',
            'type' => 'required|string',
        ]);

        // Check if a checksheet with the specified machine name already exists
        $existingChecksheet = CheckSheet::where('checksheet_category', $request->mechine)->first();

        if ($existingChecksheet) {
            // Handle the case where the checksheet already exists
            return redirect()->back()->with('failed', 'Checksheet with category "'.$request->mechine.'" already exists.');
        }

        // Create a new checksheet master record
        $checksheet = new CheckSheet();
        $checksheet->machine_id = $request->machine_id;
        $checksheet->checksheet_category = $request->mechine;
        $checksheet->checksheet_type = $request->type;
        $checksheet->save();

        // Redirect the user after successfully storing the data
        return redirect()->back()->with('status', 'Checksheet items stored successfully');
    }


    public function storeItemChecksheet(Request $request){

        // Validate the incoming request data
        $request->validate([
            'machine_id' => 'required|numeric', // Assuming machine_id is required and numeric
            'type' => 'required|numeric', // Assuming type is required and numeric
            'mechine.*' => 'required|string', // Assuming mechine array elements are required strings

        ]);

        // Capitalize the first letter of each word in the 'mechine' and 'spec' arrays
        $mechineFormatted = array_map(function($item) {
            return ucwords(strtolower($item));
        }, $request->mechine);

        $specFormatted = array_map(function($item) {
            return ucwords(strtolower($item));
        }, $request->spec);

        // Check if any of the items already exist in the database
        foreach ($mechineFormatted as $key => $itemName) {
            $existingItem = ChecksheetItem::where('item_name', $itemName)
                ->where('machine_id', $request->machine_id)
                ->where('checksheet_id', $request->type)
                ->first();

            // If the item already exists, throw a validation exception
            if ($existingItem) {
                return redirect()->route('machine.detail', ['id' => encrypt($request->machine_id)])->with('failed', 'The item "'.$itemName.'" already exists.');
            }

            // Create a new checksheet item instance
            $checksheetItem = new ChecksheetItem();

            // Assign values to the checksheet item instance
            $checksheetItem->machine_id = $request->machine_id;
            $checksheetItem->checksheet_id = $request->type; // Assuming 'type' corresponds to 'checksheet_id'
            $checksheetItem->item_name = $itemName;
            $checksheetItem->spec = $specFormatted[$key]; // Assign item spec

            // Save the checksheet item instance to the database
            $checksheetItem->save();
        }

        // If you want to return a response, you can do so here
        return redirect()->route('machine.detail', ['id' => encrypt($request->machine_id)])->with('status', 'Checksheet items stored successfully');
    }



    public function deleteChecksheet(Request $request,$id){
        // Delete record from checksheets table
        \DB::table('checksheets')->where('checksheet_id', $id)->delete();

        // Delete records from checksheet_items table
        \DB::table('checksheet_items')->where('checksheet_id', $id)->delete();

        // Redirect back to machine detail route with a success message
        return redirect()->route('machine.detail', ['id' => encrypt($request->machine_id)])->with('status', 'Checksheet and associated items deleted successfully.');
    }

        public function deleteChecksheetItem(Request $request, $id){
        // Delete records from checksheet_items table
        \DB::table('checksheet_items')->where('item_id', $id)->delete();

        // Redirect back to machine detail route with a success message
        return redirect()->route('machine.detail', ['id' => encrypt($request->machine_id)])->with('status', 'Checksheet and associated items deleted successfully.');
        }

        public function updateChecksheet(Request $request, $id)
            {
                // Find the checksheet by ID
                $checksheet = Checksheet::findOrFail($id);

                // Update the checksheet attributes
                $checksheet->checksheet_category = $request->mechine;
                $checksheet->checksheet_type = $request->type;

                // Check if any changes were made to the checksheet
                if ($checksheet->isDirty()) {
                    // Save the updated checksheet
                    $checksheet->save();

                    // Redirect back with success message
                    return redirect()->route('machine.detail', ['id' => encrypt($request->machine_id)])->with('status', 'Checksheet updated successfully.');
                } else {
                    // No changes were made to the checksheet
                    return redirect()->back()->with('failed', 'No changes were made to the checksheet.');
                }
            }

            public function updateChecksheetItem(Request $request, $id) {
                // Find the checksheet item
                $checksheetItem = ChecksheetItem::findOrFail($id);

                if ($checksheetItem->item_name !== $request->mechine || $checksheetItem->checksheet_id != $request->checksheet_id) {
                    $checksheetItem->item_name = $request->mechine;
                    $checksheetItem->checksheet_id = $request->type;
                }

                // Check if any changes were made
                if ($checksheetItem->isDirty()) {
                    // Save changes
                    $checksheetItem->save();

                    // Redirect back with a success message
                    return redirect()->back()->with('status', 'Checksheet item updated successfully.');
                } else {
                    // No changes were made
                    return redirect()->back()->with('failed', 'No changes were made to the checksheet item.');
                }
            }


    }

