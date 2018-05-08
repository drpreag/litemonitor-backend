<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Service;
use App\Http\Resources\Service as ServiceResource;
use App\Http\Resources\ServiceCollection;

class ServicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $page = intval ($request->input('page', 1));
        $per_page = intval ($request->input('per_page', 15));

        $services = Service::paginate($per_page, ['*'], 'page', $page);
        return new ServiceCollection($services);
    }

    /**
     * Display the specified resource.
     *
     * @return json array 
     */
    public function serviceStats()
    {
        $stats=array();

        $stats['up'] = Service::where('active',1)->where('status',1)->get()->count();
        $stats['down'] = Service::where('active',1)->where('status',0)->get()->count();
        $stats['non_monitored'] = Service::where('active',0)->get()->count();

        return json_encode($stats);
    }    
}
