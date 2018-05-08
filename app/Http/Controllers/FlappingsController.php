<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Flapping;
use App\Http\Resources\Flapping as FlappingResource;
use App\Http\Resources\FlappingCollection;

class FlappingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //$page = intval ($request->input('page', 1));
        //$per_page = intval ($request->input('per_page', 15));

        $flappings = Flapping::orderby('id','desc')->get()->take(10);
        return new FlappingCollection($flappings);
    }
}
