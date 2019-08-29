<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\models\Saleorder;
use App\models\Warehouse;
use App\models\Client;
use App\models\ReceiveOrder;
use App\models\Product;

class UploadApiController extends Controller
{
    public function importOrder(Request $request)
    {
        $user = auth('api')->user();
        $arr = $request->data['data'];
        $client = $request->data['client'];
        // dd($client['email']);

        foreach ($arr as $key => $order) {
            // dd($order);
            $order_data = new Saleorder();
            if ($request->warehouse) {
                $order_data->warehouse_id = $request->warehouse;
            } else {
                // $warehouse = Warehouse::where('name', $order['warehouse'])->first();
                $warehouse = Warehouse::find(1);
                $order_data->warehouse_id = ($warehouse) ? $warehouse->id : 1;
            }
            if ($request->client) {
                $order_data->sender_id = $request->client;
            } else {
                $client = Client::select('id')->where('email', $client['email'])->first();
                // dd($client);
                // $client = Client::where('name', $order['client'])->first();
                $order_data->sender_id = ($client) ? $client->id : 1;
            }


            $order_data->order_no = $order["Order ID"];
            $order_data->client_name = $order["Name of The client"];
            $order_data->client_address = $order["Address"];
            // $order_data-> = $order["Postal Code"];
            $order_data->client_city = $order["City"];
            // $order_data-> = $order["Region"];
            $order_data->client_phone = $order["Phone"];
            $order_data->amount = $order["COD Amount"];

            $order_data->user_id = $user->id;
            $order_data->status = 'Processing';
            $order_data->save();
            $product = new ReceiveOrder();
            $product->order_qty = $order['quantity'];
            $product->remaining = $order['quantity'];
            $product_det = Product::where('product_name', $order['Sender Name'])->first();
            $product->product_id = ($product_det) ? $product_det->id : null;
            $product->order_id = $order_data->id;
            // $product->order_id = $order_data->id;
            $product->save();
        }
        // return $orders;
        return response()->json(['success' => $order_data], 200);
    }
}
