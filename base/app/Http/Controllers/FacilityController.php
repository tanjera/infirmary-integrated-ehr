<?php

namespace App\Http\Controllers;

use App\Models\Facility;
use App\Models\Room;
use Illuminate\Http\Request;

use App\Http\Controllers\RoomController;

class FacilityController extends Controller
{
    public function index(Request $req) {
        $facilities = Facility::all();
        return view('facilities.index')->with("facilities", $facilities);
    }
    public function create(Request $req){
        return view('facilities.create');
    }
    public function add(Request $req){
        $validated = $req->validate([
            'name' => 'required',
            'acronym' => 'required',
            'type' => 'required',
            'rooms' => 'integer|gt:0|lt:100',
        ]);

        $facility = Facility::create([
            'name' => $req->name,
            'acronym' => $req->acronym,
            'type' => $req->type,
        ]);

        RoomController::populate($facility->id, $req->rooms);

        return redirect('/facilities')->with('message', 'Facility "' . $req->name . '" saved successfully!');
    }
    public function edit(Request $req){
        $facility = Facility::find($req->id);

        $rooms = Room::all()->where('facility', $facility->id)->count();

        return view('facilities.edit')->with("facility", $facility)->with("rooms", $rooms);
    }
    public function update(Request $req)
    {
        $facility = Facility::find($req->id);

        $validated = $req->validate([
            'name' => 'required',
            'acronym' => 'required',
            'type' => 'required',
        ]);

        $facility->update([
            'name' => $req->name,
            'acronym' => $req->acronym,
            'type' => $req->type,
        ]);

        RoomController::populate($facility->id, $req->rooms);

        return redirect('/facilities')->with('message', 'Facility "' . $req->name . '" saved successfully!');
    }
    public function confirm(Request $req){
        $facility = Facility::find($req->id);
        return view('facilities.confirm')->with("facility", $facility);
    }
    public function delete(Request $req){
        $facility = Facility::find($req->id);
        $facility->delete();

        return redirect('/facilities')->with('message', 'Facility "' . $facility->name .'" deleted successfully!');
    }
}
