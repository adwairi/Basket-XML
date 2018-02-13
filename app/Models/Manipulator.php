<?php

namespace App\Models;

use Illuminate\Support\Collection;
use App\Models\XML;
use App\Models\JSON;
use SimpleXMLElement;

class Manipulator
{
    protected static $hotels = array();
    protected static $outputXML = array();

    function __construct($filters = [])
    {
        new XML($filters);
        new JSON($filters);
    }

    public static function union($handleArray){
        self::$hotels = array_merge(self::$hotels, $handleArray);
    }

    public function getResult(){
        return self::__toXML();
    }

    private function __toXML(){

        $sxe = new SimpleXMLElement('<hotels/>');
        foreach (self::$hotels as $hotel){
            $hotelXML = $sxe->addChild('hotel');
            foreach ($hotel as $key => $hotelAttr){
                if ($key != 'rooms')
                    $hotelXML->addAttribute($key, $hotelAttr);

                if ($key == 'rooms'){
                    $roomsXML = $hotelXML->addChild('rooms');
                    foreach ($hotelAttr as $room){
                        $roomXML = $roomsXML->addChild('room');
                        foreach ($room as $key=>$item){
                            $roomXML->addChild($key, $item);
                        }
                    }
                }
            }
        }
        self::$outputXML = $sxe->asXML();
        return self::$outputXML;
    }


}
