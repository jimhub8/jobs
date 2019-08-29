<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\models\Saleorder;
use App\models\api\OrderApi;
use App\models\OrderPayment;

class OrdersApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function orderStatus(Request $request)
    {
        // return response()->json(['success' => $request->all()], 200);
        // dd($request->all());
        // return $request->data['formobg']['speciial_instruction'];
        if (($request->data['formobg']['status'])) {
            $Saleorder = Saleorder::where('order_no', $request->data['formobg']['bar_code'])->first();
            // dd($Saleorder);
            // dd($request->data['formobg']['bar_code']);
            $Saleorder->status = $request->data['formobg']['status'];
            $Saleorder->save();
        }
        if($request->data['formobg']['status'] == 'Dispatched') {
            $order_send = new OrderApi();
            $order_send->send_orders($Saleorder, $request->data['formobg']);
        }
        if($request->data['formobg']['status'] == 'Delivered') {
            $order_send = new OrderPayment();
            $order_send->payments($Saleorder);
        }

        if($request->data['formobg']['status'] == 'Returned') {
            $order_send = new OrderApi();
            $order_send->receive_returns($Saleorder, $request->data['formobg']);
        }
        return response()->json(['success' => $Saleorder], 200);
    }

}
