<?php

namespace App\Models;

use Illuminate\Support\Facades\Storage;


class JSON
{
    private $filters;
    private $json;

    function __construct($filters = [])
    {
        $this->filters = $filters;

        $contents = Storage::disk('public')->get('hotels.json');
        $this->json = json_decode($contents, true);

        $this->output();
    }

    public function output(){
//        print_r($this->json);die;
        $hotels = [];
        foreach($this->json["avaliabilitiesResponse"]["Hotels"]["Hotel"] as $hotel) {
            if (isset($this->filters['HotelName']) && trim($this->filters['HotelName']) != '' && ($hotel['HotelsName'] != $this->filters['HotelName'])) {
                continue;
            }
            if (isset($this->filters['HotelRating']) && trim($this->filters['HotelRating']) != '' && ($hotel['Rating'] != $this->filters['HotelRating'])) {
                continue;
            }
            if (isset($this->filters['IsReady']) && trim($this->filters['IsReady']) != '' && ($hotel['IsReady'] != $this->filters['IsReady'])) {
                continue;
            }
            $hotelArray = [
                'id'            => $hotel['HotelCode'],
                'HotelName'     => $hotel['HotelsName'],
                'location'      => $hotel['Location'],
                'HotelRating'   => $hotel['Rating'],
                'IsReady'       => $hotel['IsReady'],
                'price'         => $hotel['LowestPrice'],
                'currency'      => $hotel['Currency']
            ];
            $rooms = [];
            if (is_array($hotel['AvailableRooms']['AvailableRoom'])) {
                if (isset($hotel['AvailableRooms']['AvailableRoom'][0])) {
                    foreach ($hotel['AvailableRooms']['AvailableRoom'] as $room) {
                        $rooms[] = [
                            'id'        => $room["RoomCode"],
                            'name'      => $room["RoomName"],
                            'occupancy' => $room["Occupancy"],
                            'status'    => $room["Status"],
                        ];
                    }
                    $hotelArray['rooms'] = $rooms;
                } else {
                    $rooms[] = [
                        'id' => $hotel['AvailableRooms']['AvailableRoom']["RoomCode"],
                        'name' => $hotel['AvailableRooms']['AvailableRoom']["RoomName"],
                        'occupancy' => $hotel['AvailableRooms']['AvailableRoom']["Occupancy"],
                        'status' => $hotel['AvailableRooms']['AvailableRoom']["Status"],
                    ];
                    $hotelArray['rooms'] = $rooms;
                }
            }

            $hotels[]=$hotelArray;
        }

        Manipulator::union($hotels);

    }
}
