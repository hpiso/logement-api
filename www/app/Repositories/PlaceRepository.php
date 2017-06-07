<?php

namespace App\Repositories;

use App\Models\Place;
use Illuminate\Http\Request;

class PlaceRepository
{
    private $place;

    public function __construct(Place $place)
    {
        $this->place = $place;
    }

    public function index($filters)
    {
        $query = Place::query();

        if (array_key_exists('radius', $filters) &&
            array_key_exists('lat', $filters) &&
            array_key_exists('long', $filters)) {


            $query->selectRaw('*, ( 3959 * acos( cos( radians(' . $filters['lat'] . ') ) * cos( radians( latitude ) ) * cos( radians( longitude )
             - radians(' . $filters['long'] . ') ) + sin( radians(' . $filters['lat'] . ') ) * sin( radians( latitude ) ) ) )
             AS distance');
            $query->having('distance', '<', $filters['radius']);
        }

        return $query->with('user')->get();
    }

    public function find($id)
    {
        return $this->place->with('user')->findOrFail($id);
    }


}