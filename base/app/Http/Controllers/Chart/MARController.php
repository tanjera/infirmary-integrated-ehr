<?php

namespace App\Http\Controllers\Chart;

use App\Http\Controllers\Controller;
use App\Models\Chart\MAR\Dose;
use App\Models\Chart\Order;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;

class MARController extends Controller
{
    public function index(Request $req) {
        $patient = Patient::find($req->id);

        return view('chart.mar.index')->with("patient", $patient);
    }
    private function populateDoses() {

    }
}
