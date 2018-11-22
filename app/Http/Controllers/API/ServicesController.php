<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Http\Request;
use App\Service;
use App\Http\Resources\Service as ServiceResource;
use App\Http\Resources\ServiceCollection;
use App\Observation;
use App\Http\Resources\ObservationCollection;
use Carbon\Carbon as Carbon;

class ServicesController extends Controller
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
        //$services = Service::paginate($per_page, ['*'], 'page', $page);

        $services = Service::orderBy('active', 'desc')->orderBy('status')->orderby('status_change', 'desc')->get();

        return new ServiceCollection($services);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $service = Service::findOrFail($id);

        return new ServiceResource($service);
    }

    /**
     * Store a newly created resource in storage, POST request
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate(
            $request,
            array(
                'name'          => 'required|max:64',
                'host_id'       => 'required|integer',
                'probe_id'      => 'required|integer',
                'port'          => 'nullable|integer',
                'uri'           => 'nullable|max:128',
                'active'        => 'required|integer|min:0|max:1',
                'user'          => 'nullable|max:64',
                'pass'          => 'nullable|max:64'
            )
        );

        $service = new Service;

        $service->name = $request->name;
        $service->host_id = $request->host_id;
        $service->probe_id = $request->probe_id;
        $service->port = $request->port;
        $service->uri = $request->uri;
        $service->active = $request->active === 1  ? true : false;
        $service->user = $request->user;
        $service->pass = $request->pass;
        $service->status_change = Carbon::now();
        
        $service->save();

        return new ServiceResource($service);
    }

    /**
     * Update resource in storage
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->validate(
            $request,
            array(
                'id'            => 'required|integer',
                'name'          => 'required|max:64',
                'host_id'       => 'required|integer',
                'probe_id'      => 'required|integer',
                'port'          => 'nullable|integer',
                'uri'           => 'nullable|max:128',
                'active'        => 'required|integer|min:0|max:1',
                'user'          => 'nullable|max:64',
                'pass'          => 'nullable|max:64'
            )
        );
        
        $service = Service::findOrFail($request->id);
        $service->exists = true;

        $service->name = $request->name;
        $service->host_id = $request->host_id;
        $service->probe_id = $request->probe_id;
        //if ($request->input('port'))
            $service->port = $request->port;
        //if ($request->input('uri'))
            $service->uri = $request->uri;
        $service->active = $request->active === 1  ? true : false;
        //if ($request->input('user'))
            $service->user = $request->user;
        //if ($request->input('pass'))
            $service->pass = $request->pass;
        
        $service->save();

        return new ServiceResource($service);
    }

    /**
     * Display the specified resource.
     *
     * @return Jsonable array
     */
    public function serviceStats()
    {
        $stats=array();

        $stats['up'] = Service::where('active', 1)->where('status', 1)->get()->count();
        $stats['down'] = Service::where('active', 1)->where('status', 0)->get()->count();
        $stats['non_monitored'] = Service::where('active', 0)->get()->count();

        return json_encode($stats);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getObservations($id)
    {
        $observations = Observation::where('service_id', $id)->where('status',0)->orderby('id', 'desc')->take(10)->get();
        return new ObservationCollection($observations);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getLastHourObservations($id)
    {
        $observations = Observation::where('service_id', $id)->orderby('id', 'desc')->take(60)->get();
        return new ObservationCollection($observations);
    }    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $service = Service::findOrFail($id);

        if ($service->delete()) {
            return new ServiceResource($service);
        } else {
            return false;
        }
    }
}
