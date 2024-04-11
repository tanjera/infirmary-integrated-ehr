<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Facility;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CensusController extends Controller
{
    public function facility_index(Request $req) {
        $facilities = Facility::all();
        $rooms = Room::all();

        return view('census.facility')->with("facilities", $facilities)->with("rooms", $rooms);
    }

    public function unit_index(Request $req) {
        $facility = Facility::where('id', $req->id)->first();
        $rooms = Room::where('facility', $facility->id)->get();
        $patient_ids = $rooms->pluck('patient');
        $patients = Patient::whereIn('id', $patient_ids)->get();

        return view('census.unit')->with("facility", $facility)->with("patients", $patients)->with("rooms", $rooms);
    }
}
