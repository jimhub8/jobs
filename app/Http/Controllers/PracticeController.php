<?php

namespace App\Http\Controllers;

use App\models\Practice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PracticeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Practice::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $practice = new Practice();
        $practice->area = $request->area;
        $practice->user_id = Auth::id();
        $practice->firm_id = Auth::user()->firm_id;
        $practice->save();
        return $practice;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\models\Practice  $practice
     * @return \Illuminate\Http\Response
     */
    public function show(Practice $practice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\models\Practice  $practice
     * @return \Illuminate\Http\Response
     */
    public function edit(Practice $practice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\models\Practice  $practice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Practice $practice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\models\Practice  $practice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Practice $practice)
    {
        //
    }
}
