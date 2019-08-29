<?php

namespace App\Http\Controllers;

use App\models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\models\AutoGenerate;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Client::paginate(500);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request->all();
        // return Auth::id();
        $client = new Client;
        $client_id = new AutoGenerate;
        $client->user_id = Auth::id();
        $client->name = $request->name;
        $client->email = $request->email;
        $client->client_id = $client_id->client_id();
        $client->phone = $request->phone;
        $client->contact_person = $request->contact_person;
        $client->contact_person_phone = $request->contact_person_phone;
        $client->address = $request->address;
        $client->save();
        return $client;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Client::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $client = Client::find($id);
        $client->address = $request->address;
        $client->address_2 = $request->address_2;
        $client->city = $request->city;
        $client->company_name = $request->company_name;
        $client->country = $request->country;
        $client->display_name = $request->display_name;
        $client->email = $request->email;
        $client->name = $request->name;
        $client->phone = $request->phone;
        $client->client_type = $request->client_type;
        $client->website = $request->website;
        $client->work_phone = $request->work_phone;
        $client->zip_code = $request->zip_code;
        $client->save();
        return $client;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function searchClient($search)
    {
        // return $search;
        // return Client::all();
        return Client::where('display_name', 'LIKE', "%{$search}%")->orWhere('name', 'LIKE', "%{$search}%")->Userid()->get();
    }
}
