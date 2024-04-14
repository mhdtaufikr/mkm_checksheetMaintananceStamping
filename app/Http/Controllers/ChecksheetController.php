<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChecksheetFormHead;
use App\Models\Machine;
use App\Models\Checksheet;
use App\Models\ChecksheetItem;

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

}
