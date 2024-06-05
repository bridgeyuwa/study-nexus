<?php

namespace App\Http\Controllers;

use App\Models\Catchment;
use App\Models\Region;
use App\Models\Category;
use Illuminate\Http\Request;

class CatchmentController extends Controller {

    public function index() {

        //$catchments = Catchment::all();
     $regions = Region::with('catchments.institutions')->get();
       //dd($regions);


        return view('catchment.index', compact('regions'));
    }

    public function show(Catchment $catchment) {
        $institutions = $catchment->institutions()->with(['state','schooltype','category'])->get();



        return view('catchment.show', compact('catchment','institutions'));
    }



      public function policy() {


        return view('catchment.policy');
    }
}
