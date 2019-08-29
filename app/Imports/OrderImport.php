<?php

namespace App\Imports;

use App\models\Saleorder;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\models\AutoGenerate;

HeadingRowFormatter::default('none');

class OrderImport implements ToModel, WithHeadingRow
{

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // dd($row);
        $order_id = new AutoGenerate;
        // $order_id->orderNo();
        return new Saleorder([
            "Order ID" => $row["Order ID"],
            "Name of The client" => $row["Name of The client"],
            "Address" => $row["Address"],
            "Postal Code" => $row["Postal Code"],
            "City" => $row["City"],
            "Region" => $row["Region"],
            "Phone" => $row["Phone"],
            "COD Amount " => $row["COD Amount "],
            "quantity" => $row["quantity"],
            "Sender Name" => $row["Sender Name"],
            "Sender Address" => $row["Sender Address"],
            "Sender mail" => $row["Sender mail"],
            "order date" => $row["order date"],
        ]);
    }
}
