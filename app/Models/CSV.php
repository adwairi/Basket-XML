<?php

namespace App\Models;


class CSV
{
    private $filters;
    private $csv;

    function __construct($filters = [])
    {
        $this->filters = $filters;

        $contents = Storage::disk('public')->get('hotels.csv');
        $this->csv = $contents;

        $this->output();

    }

    public function output(){
        // your parser goes here.
        // then use ExpandManiPulator::union($hotelsArray)
    }
}
