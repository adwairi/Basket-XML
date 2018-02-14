<?php

namespace App\Models;


use App\Models\CSV;

class ExpandManiPulator extends Manipulator
{
    // If we need to add new file structure (ex: CSV, YMAL, ...etc)
    private $csvArray;

    function __construct($filters = [])
    {
        parent::__construct($filters);
//        $this->csvArray = new CSV($filters);
    }


}
