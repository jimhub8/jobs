<?php

namespace App\Http\Controllers;

use App\models\Firm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FirmController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Firm::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $firm = new Firm();
        $firm->user_id = Auth::id();
        $firm->name = $request->name;
        $firm->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\models\Firm  $firm
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\models\Firm  $firm
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $firm = Firm::find($id);
        $request->user_id = Auth::id();
        $request->name = $firm->name;
        $request->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\models\Firm  $firm
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
