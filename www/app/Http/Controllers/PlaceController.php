<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\PlaceRepository;

class PlaceController extends Controller
{
    private $places;

    public function __construct(PlaceRepository $placeRepository)
    {
        $this->places = $placeRepository;
    }

    public function index()
    {
        return response()->json($this->places->index());
    }

    public function show($id)
    {
        return response()->json($this->places->find($id));
    }
}
