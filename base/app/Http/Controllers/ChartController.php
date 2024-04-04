<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Facility;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ChartController extends Controller
{
    public function dashboard(Request $req) {
        $patient = Patient::find($req->id);
        $room = Room::where('patient', $patient->id)->first();
        $facility = Facility::where('id', $room->facility)->first();

        return view('chart.dashboard')->with("patient", $patient)->with("room", $room)->with("facility", $facility);
    }
}
