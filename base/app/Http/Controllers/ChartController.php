<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Facility;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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
    public function allergies(Request $req) {
        $patient = Patient::find($req->id);

        return view('chart.allergies')->with("patient", $patient);
    }
    public function notes(Request $req) {
        $patient = Patient::find($req->id);

        return view('chart.notes')->with("patient", $patient);
    }
    public function results(Request $req) {
        $patient = Patient::find($req->id);

        return view('chart.results')->with("patient", $patient);
    }
    public function orders(Request $req) {
        $patient = Patient::find($req->id);

        return view('chart.orders')->with("patient", $patient);
    }
    public function flowsheet(Request $req) {
        $patient = Patient::find($req->id);

        return view('chart.flowsheet')->with("patient", $patient);
    }
    public function mar(Request $req) {
        $patient = Patient::find($req->id);

        return view('chart.mar')->with("patient", $patient);
    }
}
