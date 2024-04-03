<?php

namespace App\Http\Controllers;

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
                    'number' => $i,
                ]);
            }
        }
    }
}
