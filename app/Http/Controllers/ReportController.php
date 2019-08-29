<?php

namespace App\Http\Controllers;

use App\models\Jobtype;
use App\models\Lead;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function product_report(Request $request)
    {
        // return $request->all();
        $start_date = Carbon::parse($request->start_date);
        $end_date = Carbon::parse($request->end_date);
        $dates = array('start_date' => $start_date, 'end_date' => $end_date);
        $jobs = Jobtype::whereIn('user_id', $request->staff)->whereBetween('created_at', $dates)->get();
        return $jobs;
    }

    public function marketing(Request $request)
    {
        // return $request->all();
        $start_date = Carbon::parse($request->start_date);
        $end_date = Carbon::parse($request->end_date);
        $dates = array('start_date' => $start_date, 'end_date' => $end_date);
        $jobs = Lead::whereIn('user_id', $request->staff)->whereBetween('created_at', $dates)->where('status', $request->status)->get();
        return $jobs;
    }
}
