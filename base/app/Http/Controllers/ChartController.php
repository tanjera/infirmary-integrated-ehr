<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Facility;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ChartController extends Controller
{
    public function entry(Request $req) {
        $patient = Patient::find($req->id);

        return view('chart')->with("patient", $patient);
    }
}
