<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bus as Bus;
use App\Models\Books as Books;
use App\Models\DisplayBuses as DisplayBuses;

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
        
        $buses = DisplayBuses::where('date', '>=', date("Y")."-".date("m")."-".date("d"))->get();
        
        return json_encode($buses);
    }

    public function Book(Request $request) {

        $id_bus = $request->input('idbus');
        $id_user = $request->input('iduser');

        $fp = fsockopen("localhost", 27015, $errno, $errstr);
        if (!$fp) {
            return -1;
        }
        $is_ok = 0;
        while ($is_ok != 1) {
            $is_ok = fread($fp, 10);
        }

        fclose($fp);

        $purchased_places = Books::selectRaw('count(idbook) as places')
                                    ->where('bus_idbus', '=', $id_bus)
                                    ->first()->places;

        $remaining_places = (Bus::select('place_number')
                                ->where('idbus', '=', $id_bus)
                                ->first()->place_number) - $purchased_places;

        if ($remaining_places < 1) {
            return -1;
        }

        $max_id_book = Books::selectRaw('coalesce(max(idbook)) + 1 as maxid')->first()->maxid + 1;
        
        Books::insert(
            [
                'idbook' => intval($max_id_book),
                'bus_idbus' => $id_bus,
                'users_iduser' => $id_user
            ]
        );

        return (0);

    }


}

