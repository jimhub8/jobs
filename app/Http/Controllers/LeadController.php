<?php

namespace App\Http\Controllers;

use App\models\Lead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Lead::latest()->paginate(500);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $lead = new Lead();
        $lead->user_id = Auth::id();
        $lead->client_name = $request->client_name;
        $lead->client_phone = $request->client_phone;
        $lead->client_email = $request->client_email;
        $lead->details = $request->details;
        $lead->status = $request->status;
        $lead->save();
        return $lead;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\models\Lead  $lead
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Lead::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\models\Lead  $lead
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $lead = Lead::find($id);
        $lead->user_id = Auth::id();
        $lead->client_name = $request->client_name;
        $lead->phone = $request->phone;
        $lead->email = $request->client_email;
        $lead->details = $request->details;
        $lead->status = $request->status;
        $lead->save();
        return $lead;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\models\Lead  $lead
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Lead::find($id)->delete();
    }
}
