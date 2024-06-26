<?php

namespace App\Http\Controllers;

use App\Models\Allergy;
use App\Models\Patient;
use App\Models\Facility;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use mysql_xdevapi\Collection;

class PatientController extends Controller
{
    public function index(Request $req) {
        $patients = Patient::all();

        $facilities = Facility::all();
        $rooms = Room::all();

        $assignments = [];
        foreach ($rooms as $room) {
            if (!is_null($room->patient)) {
                $facility = $facilities->where('id', $room->facility)->first();
                $assignments += ["$room->patient" => "$facility->acronym-$room->number"];
            }
        }

        return view('patients.index')->with("patients", $patients)
            ->with("assignments", $assignments);
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
            'telephone' => $req->telephone,

            'insurance_provider' => $req->insurance_provider,
            'insurance_account_number' => $req->insurance_account_number,

            'next_of_kin_name' => $req->next_of_kin_name,
            'next_of_kin_relationship' => $req->next_of_kin_relationship,
            'next_of_kin_address' => $req->next_of_kin_address,
            'next_of_kin_telephone' => $req->next_of_kin_telephone,
        ]);

        return redirect('/patients')->with('message', "Patient #$req->medical_record_number saved successfully!");
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
            'telephone' => $req->telephone,

            'insurance_provider' => $req->insurance_provider,
            'insurance_account_number' => $req->insurance_account_number,

            'next_of_kin_name' => $req->next_of_kin_name,
            'next_of_kin_relationship' => $req->next_of_kin_relationship,
            'next_of_kin_address' => $req->next_of_kin_address,
            'next_of_kin_telephone' => $req->next_of_kin_telephone,
        ]);

        return redirect('/patients')->with('message', "Patient #$patient->medical_record_number saved successfully!");
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

        return redirect('/patients')->with('message', "Patient #$patient->medical_record_number deleted successfully!");
    }
}
