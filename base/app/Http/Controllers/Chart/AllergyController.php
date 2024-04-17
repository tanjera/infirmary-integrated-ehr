<?php

namespace App\Http\Controllers\Chart;

use App\Models\Chart\Allergy;
use App\Models\Patient;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AllergyController extends Controller
{
    public function index(Request $req) {
        $patient = Patient::find($req->id);
        $allergies = Allergy::where('patient', $patient->id)->get();

        return view('chart.allergies.index')->with("patient", $patient)->with("allergies", $allergies);
    }
    public function create(Request $req){
        if (!Auth::user()->canChart())
            abort(403);

        $patient = Patient::find($req->id);

        return view('chart.allergies.create')->with("patient", $patient);
    }
    public function add(Request $req){
        if (!Auth::user()->canChart())
            abort(403);

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

        return redirect("/chart/allergies/$req->id")->with('message', "Allergy to $req->allergen saved successfully!");
    }
    public function delete(Request $req){
        if (!Auth::user()->canChart())
            abort(403);

        $allergy = Allergy::find($req->id);
        $patient = $allergy->patient;
        $allergy->delete();

        return redirect("/chart/allergies/$patient")->with('message', "Allergy deleted successfully!");
    }
}
