<?php

namespace App\Http\Controllers;

use Stevebauman\Location\Facades\Location;

abstract class Controller
{
    public function getLocation()
    {
        $location = Location::get();

        if ($location) {
            $city = $location->cityName;
            $region = $location->regionName;
            $country = $location->countryName;

            return "$city, $region, $country";
        }

        return "NO DATA";
    }
}
