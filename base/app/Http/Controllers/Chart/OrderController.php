<?php

namespace App\Http\Controllers\Chart;

use App\Models\Order;
use App\Models\Patient;
use App\Models\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index(Request $req) {
        $patient = Patient::find($req->id);
        $orders = Order::where('patient', $req->id)->get();

        $author_ids = $orders->pluck('ordered_by')->merge($orders->pluck('cosigned_by'));
        $authors = User::select('id', 'name')->whereIn('id', $author_ids)->get();

        return view('chart.orders.index')->with("patient", $patient)->with("orders", $orders)
            ->with("authors", $authors);
    }
    public function view(Request $req) {
    }
    public function create(Request $req){
        if (!Auth::user()->canChart())
            abort(403);

        $patient = Patient::find($req->id);
        $cosigners = User::whereIn('license', User::$licenses_canOrder)->select('id', 'name')->get();

        return view('chart.orders.create')->with("patient", $patient)->with("cosigners", $cosigners);
    }
    public function add(Request $req){
        if (!Auth::user()->canChart())
            abort(403);

        if ($req->category == 'medication') {
            $validated = $req->validate([
                'method' => 'required',
                'priority' => 'required',
                'start_time' => 'required',
                'drug' => 'required',
                'dose_amount' => 'required',
                'dose_unit' => 'required',
                'route' => 'required',
                'period_type' => 'required',
                'period_amount' => 'required',
                'period_unit' => 'required',
                'total_doses' => 'required',
                'indication' => 'required',
            ]);

            $order = Order::create([
                'patient' => $req->id,
                'ordered_by' => Auth::user()->id,
                'cosigned_by' => $req->cosign_by,
                'category' => $req->category,
                'method' => $req->method,
                'priority' => $req->priority,
                'start_time' => $req->start_time,
                'end_time' => $req->end_time,
                'note' => $req->note,

                'drug' => $req->drug,
                'dose_amount' => $req->dose_amount,
                'dose_unit' => $req->dose_unit,
                'route' => $req->route,
                'period_type' => $req->period_type,
                'period_amount' => $req->period_amount,
                'period_unit' => $req->period_unit,
                'total_doses' => $req->total_doses,
                'indication' => $req->indication,
            ]);
        }
        else if ($req->category == 'general') {
            $validated = $req->validate([
                'category' => 'required',
                'method' => 'required',
                'priority' => 'required',
                'start_time' => 'required',
                'note' => 'required',
            ]);

            $order = Order::create([
                'patient' => $req->id,
                'ordered_by' => Auth::user()->id,
                'cosigned_by' => $req->cosign_by,
                'category' => $req->category,
                'method' => $req->method,
                'priority' => $req->priority,
                'start_time' => $req->start_time,
                'end_time' => $req->end_time,
                'note' => $req->note,
            ]);
        }

        return redirect("chart/orders/$req->id")->with('message', "Order created successfully.");
    }
    public function delete(Request $req){
    }
}
