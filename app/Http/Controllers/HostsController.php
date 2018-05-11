<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Host;
use App\Http\Resources\Host as HostResource;
use App\Http\Resources\HostCollection;
use Carbon\Carbon as Carbon;
use Illuminate\Support\Facades\Log;

class HostsController extends Controller
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

        $hosts = Host::paginate($per_page, ['*'], 'page', $page);
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
        $host = Host::findOrFail ($id);
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
        // validation
        $this->validate(
            $request,
            array(
                'name'          => 'required|unique:hosts|max:64',
                'description'   => 'max:255',
                'fqdn'          => 'required|unique:hosts|max:255',
                'icmp_probe'    => 'required|integer|min:0|max:1'
            )
        );
        
        $host = new Host;

        $host->name = $request->name;
        $host->description = $request->description;
        $host->fqdn = $request->fqdn;            
        $host->icmp_probe = $request->icmp_probe ? true : false;
        $host->icmp_status = false;        
        $host->status_change = 
        $host->last_status_down = 
        $host->last_status_up = Carbon::now();

        $host->save();

        return new HostResource($host);
    }

    /**
     * Update resource in storage 
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    //public function update(Request $request, $id)
    public function update(Request $request)
    {
        // validation
        $this->validate(
            $request,
            array(
                'name'          => 'required|max:64|unique:hosts,name,'.$request->id,
                'description'   => 'max:255',
                'fqdn'          => 'required|max:255|unique:hosts,fqdn,'.$request->id,
                'icmp_probe'    => 'required|integer|min:0|max:1'
            )
        );

        $host = Host::findOrFail($request->id);
        $host->exists = true;

        $host->name = $request->name;
        $host->description = $request->description;
        $host->fqdn = $request->fqdn;            
        $host->icmp_probe = $request->icmp_probe ? true : false;

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
        $host = Host::findOrFail ($id);

        if ($host->delete())
            return new HostResource($host);
        else
            return false;
    }    

    /**
     * Display the specified resource.
     *
     * @return json array 
     */
    public function hostStats()
    {
        $stats=array();

        $stats['up'] = Host::where('icmp_probe',1)->where('icmp_status',1)->get()->count();
        $stats['down'] = Host::where('icmp_probe',1)->where('icmp_status',0)->get()->count();
        $stats['non_monitored'] = Host::where('icmp_probe',0)->get()->count();

        return json_encode($stats);
    }    
}
