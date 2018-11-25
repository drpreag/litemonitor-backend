<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// use Illuminate\Http\Response as Response;
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

        $flappings = Flapping::orderby('id', 'desc')->get()->take(10);

        if ($flappings) {
            return new FlappingCollection($flappings);
        }
        return \Response::json([
            'Not found'
        ], 404);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getLast()
    {
        $flapping = Flapping::orderby('id', 'desc')->get()->take(1);
        if ($flapping) {
            return new FlappingResource($flapping[0]);
        }
        return \Response::json([
            'Not found'
        ], 404);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getNext($id)
    {
        $flapping = Flapping::find($id+1);
       
        if ($flapping) {
            return new FlappingResource($flapping);
        }
        return \Response::json([
            'Not found'
        ], 404);
    }
}
