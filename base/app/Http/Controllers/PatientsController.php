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
}
