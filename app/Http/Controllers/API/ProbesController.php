<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Probe;
use App\Http\Resources\ProbeCollection;

class ProbesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $probes = Probe::orderby('id')->get();
        return new ProbeCollection($probes);
    }
}
