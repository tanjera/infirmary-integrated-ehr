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
    private function populateDoses(Patient $patient, Order $order) {
        $doses = Dose::where('order', $order->id)->get();

        // Clear all doses that have not been modified (still marked as due)
        foreach($doses->where('status', 'due')->get() as $dose)
            $dose->delete();

        if ($order->period_type == 'once') {
            // One-time order
            Dose::create([
                'patient' => $patient->id,
                'order' => $order->id,
                'due_at' => $order->start_time,
                'status' => 'due',
            ]);
        } else {
            for ($i = 0; $i < $order->total_doses; $i++) {
                switch ($order->period_unit) {
                    default:
                    case 'minute':
                        $min = $i * $order->period_amount;
                        break;
                    case 'hour':
                        $min = $i * ($order->period_amount * 60);
                        break;
                    case 'day':
                        $min = $i * ($order->period_amount * 60 * 24);
                        break;
                    case 'week':
                        $min = $i * ($order->period_amount * 60 * 24 * 7);
                        break;
                }

                $at_time = $order->start_time->add(new \DateInterval('PT' . $min . 'M'));

                Dose::create([
                    'patient' => $patient->id,
                    'order' => $order->id,
                    'due_at' => $at_time,
                    'status' => 'due',
                ]);
            }
        }
    }
}
