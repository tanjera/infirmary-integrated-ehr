<?php

namespace App\Http\Controllers\Chart;

use App\Models\Chart\Order;
use App\Models\Patient;
use App\Models\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index(Request $req) {
        $patient = Patient::find($req->id);

        $filter = $req->route()->named('chart.active.orders') ? "active" : "all";

        if ($filter == 'active')
            $orders = Order::where('patient', $req->id)
                ->where('status', 'active')->get();
        else {
            $orders = Order::where('patient', $req->id)->get()
                ->sortBy(function (Order $item) {

                    switch ($item->status) {
                        default:
                            return 0;
                        case "active":
                            return 1;
                        case "pending":
                            return 2;
                        case "completed":
                            return 3;
                        case "discontinued":
                            return 4;
                    }
                });
        }

        $author_ids = $orders->pluck('ordered_by')->merge($orders->pluck('cosigned_by'));
        $authors = User::select('id', 'name')->whereIn('id', $author_ids)->get();

        return view('chart.orders.index')->with("patient", $patient)->with("orders", $orders)
            ->with("authors", $authors)->with("filter", $filter);
    }
    public function view(Request $req) {
        $order = Order::find($req->id);
        $patient = Patient::find($order->patient);
        $authors = User::select('id', 'name')->whereIn('id', [$order->ordered_by, $order->cosigned_by])->get();

        return view('chart.orders.view')->with("patient", $patient)->with("order", $order)
            ->with("authors", $authors);
    }
    public function cosign(Request $req) {
        $order = Order::find($req->id);

        if (Auth::user()->id != $order->cosigned_by) {
            return redirect("/chart/orders/view/$req->id")->with('message', "Incorrect cosigner- cosign attempt refused.");
        } else if ($order->cosign_complete) {
            return redirect("/chart/orders/view/$req->id")->with('message', "Order already cosigned.");
        } else {
            $order->update([
                'cosign_complete' => true
            ]);

            return redirect("/chart/orders/view/$req->id")->with('message', "Cosign completed successfully.");
        }
    }
    public function activate(Request $req) {
        $order = Order::find($req->id);
        $user = Auth::user();

        if ($user->canChart() && $order->status == "pending") {
            $order->update([
                'status' => "active",
                'status_by' => $user->id
            ]);

            return redirect("/chart/orders/view/$req->id")->with('message', "Order activated successfully.");
        } else {

            return redirect("/chart/orders/view/$req->id")->with('message', "Error occurred. Unable to activate order.");
        }
    }
    public function complete(Request $req) {
        $order = Order::find($req->id);
        $user = Auth::user();

        if ($user->canChart() && $order->status == "active") {
            $order->update([
                'status' => "completed",
                'status_by' => $user->id
            ]);

            return redirect("/chart/orders/view/$req->id")->with('message', "Order completed successfully.");
        } else {

            return redirect("/chart/orders/view/$req->id")->with('message', "Error occurred. Unable to complete order.");
        }
    }
    public function discontinue(Request $req) {
        $order = Order::find($req->id);
        $user = Auth::user();

        if ($user->canOrder() && ($order->status == "active" || $order->status == "pending")) {
            $order->update([
                'status' => "discontinued",
                'status_by' => $user->id
            ]);

            return redirect("/chart/orders/view/$req->id")->with('message', "Order discontinued successfully.");
        } else {

            return redirect("/chart/orders/view/$req->id")->with('message', "Error occurred. Unable to discontinue order.");
        }
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
                'period_amount' => 'required|integer',
                'period_unit' => 'required',
                'total_doses' => 'required|integer',
                'indication' => 'required',
            ]);

            $order = Order::create([
                'patient' => $req->id,
                'status' => ($req->pend_order != "on" ? "active" : "pending"),
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
                'status' => ($req->pend_order != "on" ? "active" : "pending"),
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
        $order = Order::find($req->id);
        $patient = Patient::find($order->patient);

        $order->delete();

        return redirect("chart/orders/$patient->id")->with('message', "Order deleted successfully.");
    }
}
