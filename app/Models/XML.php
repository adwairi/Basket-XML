<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;


class XML extends Model
{
    private $filters;
    private $xml;

    function __construct($filters = [])
    {
        $this->filters = $filters;
        $contents = Storage::disk('public')->get('hotels.xml');
        $this->xml = simplexml_load_string($contents);

        $this->output();
    }

    public function output(){

        $hotels = [];
        foreach($this->xml->HOTELS[0] as $hotel) {

            $hotel->attributes()['AVAILABLE'] = ($hotel->attributes()['AVAILABLE'] == 'Yes') ? 'true' : 'false';

            if(isset($this->filters['HotelName']) && trim($this->filters['HotelName']) != '' && ($hotel->attributes()['HOTEL_NAME'] != $this->filters['HotelName'])){
                continue;
            }
            if(isset($this->filters['HotelRating']) && trim($this->filters['HotelRating']) != '' && ((int)$hotel->attributes()['RATING'] != $this->filters['HotelRating'])){
                continue;
            }
            if(isset($this->filters['IsReady']) && trim($this->filters['IsReady']) != '' && ($hotel->attributes()['AVAILABLE'] != $this->filters['IsReady'])){
                continue;
            }



            $hotelArray = [
                'id'            => (int)$hotel->attributes()['HOTEL_ID'],
                'HotelName'     => (string)$hotel->attributes()['HOTEL_NAME'],
                'location'      => (string)$hotel->attributes()['LOCATION'],
                'HotelRating'   => (int)$hotel->attributes()['RATING'],
                'IsReady'       => (boolean)$hotel->attributes()['AVAILABLE'],
                'price'         => (float)$hotel->attributes()['STARTING_PRICE'],
                'currency'      => (string)$hotel->attributes()['CURRENCY'],
                'isRecommended' => (int)$hotel->attributes()['ISRECOMMENDEDPRODUCT'],
            ];
            $rooms = [];
            foreach($hotel->ROOMS->ROOM as $room) {
                $rooms[] = [
                    'id'        => (int)$room->ROOMID,
                    'name'      => (string)$room->ROOM_NAME,
                    'occupancy' => (int)$room->OCCUPANCY,
                    'status'    => (boolean)($room->ROOM_STATUS == 'AVAILABLE')?true:false,
                ];
            }
            $hotelArray['rooms'] = $rooms;
            $hotels[]=$hotelArray;

        }


        Manipulator::union($hotels);
    }
}
