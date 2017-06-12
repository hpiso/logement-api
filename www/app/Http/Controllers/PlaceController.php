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

    public function index(Request $request)
    {
        return response()->json($this->places->index($request->input()));
    }

    public function show($id)
    {
        return response()->json($this->places->find($id));
    }

    public function store(Request $request)
    {
        return response()->json($this->places->save($request->input()));
    }
}
