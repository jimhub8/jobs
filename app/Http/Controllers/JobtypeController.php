<?php

namespace App\Http\Controllers;

use App\models\Jobtype;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobtypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Jobtype::paginate(500);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $jobtype = new Jobtype;
        $jobtype->user_id = Auth::id();
        $jobtype->title = $request->title;
        $jobtype->code = $request->code;
        $jobtype->description = $request->description;
        $jobtype->amount = $request->amount;
        $jobtype->save();
        return $jobtype;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\models\Jobtype  $jobtype
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
     * @param  \App\models\Jobtype  $jobtype
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $jobtype = Jobtype::find($id);
        $jobtype->title = $request->title;
        $jobtype->code = $request->code;
        $jobtype->description = $request->description;
        $jobtype->amount = $request->amount;
        $jobtype->save();
        return $jobtype;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\models\Jobtype  $jobtype
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
