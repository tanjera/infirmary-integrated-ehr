<?php

namespace App\Http\Controllers;

use App\Models\Allergy;
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
        $allergies = Allergy::where('patient', $patient->id)->get();

        return view('chart.allergies.index')->with("patient", $patient)->with("allergies", $allergies);
    }
    public function createAllergy(Request $req){
        $patient = Patient::find($req->id);

        return view('chart.allergies.create')->with("patient", $patient);
    }
    public function addAllergy(Request $req){
        $validated = $req->validate([
            'allergen' => 'required',
            'reaction' => 'required',
            'severity' => 'required'
        ]);

        Allergy::create([
            'patient' => $req->id,
            'allergen' => $req->allergen,
            'reaction' => $req->reaction,
            'severity' => $req->severity,
            'notes' => $req->notes,
        ]);

        return redirect("/chart/allergies/$req->id")->with('message', "Allergy to $req->allegen saved successfully!");
    }
    public function deleteAllergy(Request $req){
        $allergy = Allergy::find($req->id);
        $patient = $allergy->patient;
        $allergy->delete();

        return redirect("/chart/allergies/$patient")->with('message', "Allergy deleted successfully!");
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
