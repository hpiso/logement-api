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
        return $this->place->all();
    }

    public function find($id)
    {
        return $this->place->findOrFail($id);
    }


}