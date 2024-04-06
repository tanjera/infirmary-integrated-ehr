<?php

namespace App\Http\Controllers;

use App\Models\Facility;
use App\Models\Patient;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public static function populate(string $facility, int $amount) {
        $existing = Room::all()->where('facility', $facility);

        for ($i = 0; $i < $amount; $i++) {
            if ($existing->where('number', $i)->count() == 0) {
                Room::create([
                    'facility' => $facility,
                    'number' => $i + 1,
                ]);
            }
        }
    }
    public function select(Request $req){
        $facilities = Facility::all();
        $rooms = Room::where('patient', null)->get();

        $available = [];
        foreach ($rooms as $room) {
            $facility = $facilities->where('id', $room->facility)->first();
            $available += ["$room->id" => "$facility->acronym-$room->number"];
        }

        return view('rooms.select')->with('patient', $req->id)->with("available", $available);
    }
    public function assign(Request $req){
        $room = Room::where('id', $req->room)->first();
        $facility = Facility::where('id', $room->facility)->first();
        $patient = Patient::where('id', $req->id)->first();

        $room->update([ 'patient' => $patient->id ]);

        return redirect('/patients')->with('message', "Patient #$patient->medical_record_number assigned to $facility->acronym-$room->number");
    }
    public function unassign(Request $req){
        $rooms = Room::where('patient', $req->id)->get();

        foreach($rooms as $room)
            $room->update([ 'patient' => null ]);

        return redirect('/patients');
    }
}
