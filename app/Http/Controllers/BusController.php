<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bus as Bus;

class BusController extends Controller
{
    public function Create(Request $request) {

        $date = $request->input('date');
        $from = $request->input('from');
        $to = $request->input('to');
        $nb_places = $request->input('nb_places');

        $max_id_bus = Bus::selectRaw('coalesce(max(idbus)) + 1 as maxid')->first()->maxid;

        Bus::insert(
            [
                'idbus' => intval($max_id_bus),
                'date' => $date,
                'from_city' => $from,
                'to_city' => $to,
                'place_number' => $nb_places
            ]
        );

    }

    public function getBuses() {
        
        $buses = Bus::where('date', '>=', date("Y")."-".date("m")."-".date("d"))->get();
        
        return json_encode($buses);
    }
}
