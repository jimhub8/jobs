<?php

namespace App\Http\Controllers;

use App\models\AutoGenerate;
use App\models\Cases;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CasesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Cases::paginate(500);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $request->all();
        $cases = new Cases();
        $cases->user_id = Auth::id();
        $cases->client_id = $request->client_id;
        $cases->firm_id = Auth::user()->firm_id;
        $cases->case = $request->case;
        $cases->case_no = $request->case_no;
        $cases->case_stage = $request->case_stage;
        $cases->next_stage = $request->next_stage;
        $cases->firm_member = $request->firm_member;
        $cases->status = $request->status;
        $cases->practice_area = $request->practice_area;
        $cases->leading_attoney = $request->leading_attoney;
        $cases->save();
        return $cases;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\models\Cases  $cases
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Cases::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\models\Cases  $cases
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // return $request->all();
        $cases = Cases::find($id);
        $cases->user_id = Auth::id();
        $cases->client_id = $request->client_id;
        $cases->firm_id = $request->firm_id;
        $cases->case = $request->case;
        $cases->case_no = $request->case_no;
        $cases->case_stage = $request->case_stage;
        $cases->next_stage = $request->next_stage;
        $cases->firm_member = $request->firm_member;
        $cases->status = $request->status;
        $cases->save();
        return $cases;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\models\Cases  $cases
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Cases::find($id)->delete();
    }

    public function filterCases(Request $request)
    {
        // return $request->all();
        $case_stage = $request->case_stage;
        $leading_attoney = $request->leading_attoney;
        $practice_area = $request->practice_area;
        if ($case_stage && $leading_attoney && $practice_area) {
            return $cases = Cases::where('case_stage', $request->case_stage)
                ->where('leading_attoney', $request->leading_attoney)
                ->where('practice_area', $request->practice_area)
                ->paginate(500);
        } elseif ($case_stage && $leading_attoney && !$practice_area) {
            return $cases = Cases::where('case_stage', $request->case_stage)
                ->where('leading_attoney', $request->leading_attoney)
                ->paginate(500);
        } elseif ($case_stage && !$leading_attoney && !$practice_area) {
            return $cases = Cases::where('case_stage', $request->case_stage)
                ->paginate(500);
        } elseif (!$case_stage && $leading_attoney && !$practice_area) {
            return $cases = Cases::where('leading_attoney', $request->leading_attoney)
                ->paginate(500);
        } elseif (!$case_stage && $leading_attoney && $practice_area) {
            return $cases = Cases::where('leading_attoney', $request->leading_attoney)
                ->where('practice_area', $request->practice_area)
                ->paginate(500);
        } elseif (!$case_stage && !$leading_attoney && $practice_area) {
            return $cases = Cases::where('practice_area', $request->practice_area)
                ->paginate(500);
        } else {
            return $cases = Cases::paginate(500);
        }
    }

    public function case_no()
    {
        $case_no = new AutoGenerate;
        return $case_no->case_no();
    }
}
