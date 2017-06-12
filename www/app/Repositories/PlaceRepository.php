<?php

namespace App\Repositories;

use App\Models\Place;
use App\Models\User;
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

        if (isset($filters['radius']) && $filters['radius'] != '' &&
            isset($filters['lat']) && $filters['lat'] != '' &&
            isset($filters['long']) && $filters['long'] != '') {


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

    public function save($params)
    {
        $user = User::where('name', 'admin')->first();

        $this->place->fill($params);
        $this->place->user()->associate($user);
        $this->place->save();

        return $this->place;
    }

    public function update($params, $id)
    {
        $place = $this->place->find($id);

        $place->fill($params);
        $place->save();

        return $place;
    }

    public function delete($id)
    {
        $this->place->findOrFail($id)->delete();
    }
}