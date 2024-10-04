<?php

namespace App\Http\Controllers\Chart;

use App\Http\Controllers\Controller;
use App\Models\Chart\MAR\Dose;
use App\Models\Chart\Order;
use App\Models\Patient;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MARController extends Controller
{
    public function index(Request $req) {
        $patient = Patient::find($req->id);
        $orders = Order::where('patient', $patient->id)
            ->where('category', 'medication')
            ->where('status', '<>', 'pending')
            ->orderBy('drug')->get()
            ->sortBy(function (Order $item) {
                switch ($item->period_type) {
                    default:
                        return 0;
                    case "prn":
                        return 1;
                }
            })
            ->sortBy(function (Order $item) {
                switch ($item->status) {
                    default:
                        return 0;
                    case "completed":
                        return 3;
                    case "discontinued":
                        return 4;
                }
            });
        $doses = Dose::where('patient', $patient->id)->get();

        if ($req->has("at_time"))
            $at_time = $req->at_time;
        else
            $at_time = (new \DateTime("now", Auth::user()->getTimeZone()));

        return view('chart.mar.index')->with("patient", $patient)
            ->with("orders", $orders)->with("doses", $doses)->with("at_time", $at_time);
    }

    public function dose(Request $req) {
        $dose = Dose::find($req->id);
        $patient = Patient::find($dose->patient);
        $order = Order::find($dose->order);

        if ($req->has("at_time"))
            $at_time = $req->at_time;
        else
            $at_time = (new \DateTime("now", Auth::user()->getTimeZone()));

        $author_ids = $order->pluck('ordered_by')->merge($order->pluck('cosigned_by'));
        $authors = User::select('id', 'name')->whereIn('id', $author_ids)->get();

        return view('chart.mar.dose')->with("patient", $patient)->with("authors", $authors)
            ->with("order", $order)->with("dose", $dose)->with("at_time", $at_time);
    }

    public function given(Request $req) {
        return $this->status($req, true);
    }
    public function status(Request $req, bool $given = false) {
        if (!Auth::user()->canChart())
            abort(403);

        $dose = Dose::find($req->id);
        $patient = Patient::find($dose->patient);

        if ($given)
            $dose->status = 'given';

        if ($req->has("at_time"))
            $at_time = $req->at_time;
        else
            $at_time = (new \DateTime("now", Auth::user()->getTimeZone()));

        return view('chart.mar.status')->with("patient", $patient)
            ->with("dose", $dose)->with("at_time", $at_time);
    }

    public function modify(Request $req){
        if (!Auth::user()->canChart())
            abort(403);

        $dose = Dose::find($req->id);

        $dose->update([
            'status' => str_replace(' ', '_', strtolower($req->status)),
            'status_at' => Auth::user()->dt_revertTimeZone($req->status_at),
            'status_by' => Auth::user()->id
        ]);

        $patient = Patient::find($dose->patient);

        return redirect("chart/mar/$patient->id")->with('message', "Dose status modified successfully.");
    }

    public static function populateDoses(Order $order) {
        $doses = Dose::where('order', $order->id)->get();
        $patient = Patient::find($order->patient);

        // Clear all doses that have not been modified (still marked as due)
        foreach($doses->where('status', 'due') as $dose)
            $dose->delete();

        if ($order->period_type == 'prn') {
            // Don't do anything- doses are only created on an "as-needed" basis (no pun intended!)
        } else if ($order->period_type == 'once') {
            // One-time order
            Dose::create([
                'patient' => $patient->id,
                'order' => $order->id,
                'due_at' => $order->start_time,
                'status' => 'due'
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
                    'status' => 'due'
                ]);
            }
        }
    }
    public static function deleteDoses(Order $order) {
        $doses = Dose::where('order', $order->id)->get();

        foreach ($doses as $dose)
            $dose->delete();
    }
    public static function discontinueDoses(Order $order) {
        $doses = Dose::where('order', $order->id)
            ->where('due_at', '>=', new \DateTime("now", Auth::user()->getTimeZone()))->get();

        foreach ($doses as $dose)
            $dose->delete();
    }
}
