<?php

namespace App\Http\Controllers\Chart;

use App\Models\Patient;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ChartController extends Controller
{
    public function index(Request $req) {
        $patient = Patient::find($req->id);


        return view('chart.index')->with("patient", $patient);
    }
    public function demographics(Request $req) {
        $patient = Patient::find($req->id);

        return view('chart.demographics')->with("patient", $patient);
    }
    public function results(Request $req) {
        $patient = Patient::find($req->id);

        return view('chart.results')->with("patient", $patient);
    }
    public function flowsheet(Request $req) {
        $patient = Patient::find($req->id);

        return view('chart.flowsheet')->with("patient", $patient);
    }
}
