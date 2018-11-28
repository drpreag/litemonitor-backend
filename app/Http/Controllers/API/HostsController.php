<?php

namespace App\Http\Controllers\API;

use App\Host;
use App\Service;
use App\RolePermission;
use App\Http\Controllers\Controller;
use App\Http\Resources\Host as HostResource;
use App\Http\Resources\HostCollection;
use App\Http\Resources\ServiceCollection;
use Illuminate\Http\Request;
use Psy\Util\Json;

class HostsController extends Controller
{
    public function Permission ()
    {
        $usersRole = auth('api')->user()->role_id;
        $permission = RolePermission::
            where('object', "Hosts")->
            where('role_id', $usersRole)->
            first();
        return ($permission);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (! $this->Permission()->b)
            return \Response::json(['error' => 'Not nought privileges' ], 401);

        $hosts = Host::orderBy('active', 'desc')->get();
        return new HostCollection($hosts);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (! $this->Permission()->r)
            return \Response::json(['error' => 'Not nought privileges' ], 401);

        $host = Host::findOrFail($id);
        return new HostResource($host);
    }

    /**
     * Store a newly created resource in storage
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (! $this->Permission()->a)
            return \Response::json(['error' => 'Not nought privileges' ], 401);

        // validation
        $this->validate(
            $request,
            array(
                'name'          => 'required|unique:hosts|max:64',
                'description'   => 'max:255',
                'fqdn'          => 'required|unique:hosts|max:255',
                'active'        => 'required|integer|min:0|max:1'
            )
        );
        
        $host = new Host;

        $host->name = $request->name;
        $host->description = $request->description;
        $host->fqdn = $request->fqdn;
        $host->active = $request->active === 1 ? true : false;

        $host->save();

        return new HostResource($host);
    }

    /**
     * Update resource in storage
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if (! $this->Permission()->e)
            return \Response::json(['error' => 'Not nought privileges' ], 401);

        // validation
        $this->validate(
            $request,
            array(
                'id'            => 'required|integer',
                'name'          => 'required|max:64|unique:hosts,name,'.$request->id,
                'description'   => 'max:255',
                'fqdn'          => 'required|max:255|unique:hosts,fqdn,'.$request->id,
                'active'        => 'required|integer|min:0|max:1'
            )
        );

        $host = Host::findOrFail($request->id);
        $host->exists = true;

        $host->name = $request->name;
        $host->description = $request->description;
        $host->fqdn = $request->fqdn;
        $host->active = $request->active === 1 ? true : false;

        $host->save();
    
        return new HostResource($host);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! $this->Permission()->d)
            return \Response::json(['error' => 'Not nought privileges' ], 401);

        $host = Host::findOrFail($id);

        if ($host->delete()) {
            return new HostResource($host);
        } else {
            return false;
        }
    }

    /**
     * Display the specified resource.
     *
     * @return json array
     */
    public function hostStats()
    {
        $stats=array();

        $stats['monitored'] = Host::where('active', 1)->get()->count();
        $stats['non_monitored'] = Host::where('active', 0)->get()->count();

        return json_encode($stats);
    }

    /**
     * Display the specified resource.
     *
     * @return json array
     */
    public function hostServices($id)
    {
        if (is_numeric($id)) {
            $services = Service::where('host_id', $id)->get();

            if ($services->count() > 0) {
                return new ServiceCollection($services);
            }
        }
        return null;
    }
}
