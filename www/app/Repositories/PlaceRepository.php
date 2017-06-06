<?php

namespace App\Repositories;

use App\Models\Place;

class PlaceRepository
{
    private $place;

    public function __construct(Place $place)
    {
        $this->place = $place;
    }

    public function index()
    {
        return $this->place->with('user')->get();
    }

    public function find($id)
    {
        return $this->place->with('user')->findOrFail($id);
    }


}