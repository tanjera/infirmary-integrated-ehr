<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PatientsController extends Controller
{
    public function index(Request $req) {
        $patients = Patient::all();
        return view('patients.index')->with("patients", $patients);
    }
    public function create(Request $req){
        return view('patients.create');
    }
    public function add(Request $req){
        $validated = $req->validate([
            'name_first' => 'required',
            'name_last' => 'required',

            'date_of_birth' => 'required',
            'medical_record_number' => 'required|unique:patients',

            'sex' => 'required',
            'gender' => 'required',
            'pronouns' => 'required',
            'code_status' => 'required',
        ]);

        Patient::create([
            'name_first' => $req->name_first,
            'name_middle' => $req->name_middle,
            'name_last' => $req->name_last,
            'name_preferred' => $req->name_preferred,

            'date_of_birth' => $req->date_of_birth,
            'medical_record_number' => $req->medical_record_number,

            'sex' => $req->sex,
            'gender' => $req->gender,
            'pronouns' => $req->pronouns,

            'code_status' => $req->code_status,
            'address' => $req->address,
            'telephone' => $req->telephone
        ]);

        return redirect('/patients')->with('message', 'Patient #' . $req->medical_record_number . ' saved successfully!');
    }
    public function edit(Request $req){
        $patient = Patient::find($req->id);
        return view('patients.edit')->with("patient", $patient);
    }
    public function update(Request $req){
        $patient = Patient::find($req->id);

        $validated = $req->validate([
            'name_first' => 'required',
            'name_last' => 'required',

            'date_of_birth' => 'required',
            'medical_record_number' => 'required',

            'sex' => 'required',
            'gender' => 'required',
            'pronouns' => 'required',
            'code_status' => 'required',
        ]);



        $patient->update([
            'name_first' => $req->name_first,
            'name_middle' => $req->name_middle,
            'name_last' => $req->name_last,
            'name_preferred' => $req->name_preferred,

            'date_of_birth' => $req->date_of_birth,
            'medical_record_number' => $req->medical_record_number,

            'sex' => $req->sex,
            'gender' => $req->gender,
            'pronouns' => $req->pronouns,

            'code_status' => $req->code_status,
            'address' => $req->address,
            'telephone' => $req->telephone
        ]);

        return redirect('/patients')->with('message', 'Patient #' . $patient->medical_record_number . ' saved successfully!');
    }
    public function confirm(Request $req){
        $patient = Patient::find($req->id);
        return view('patients.confirm')->with("patient", $patient);
    }
    public function delete(Request $req){
        // Never delete a patient... may break old associations (e.g. in charting)
        // Replace MRN (unique) w/ uuid to open MRN for future registrations
        $patient = Patient::find($req->id);
        $patient->update([
            'active' => false,
            'medical_record_number' => $patient->id
        ]);

        return redirect('/patients')->with('message', 'Patient #' . $patient->medical_record_number .' deleted successfully!');
    }
}
