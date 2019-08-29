<?php

namespace App\models;

class AutoGenerate
{
    public function case_no()
    {
        $cases = Cases::select('case_no')->orderBy('id', 'Desc')->first();
        if ($cases) {
            $inv_arr = explode('_', $cases->case_no);
            $in_ar = (int) $inv_arr[1];
            // $id = ''.str_pad($product->id + 1, 8, "0", STR_PAD_LEFT);
            $case_no = ($cases) ? 'CASE_' . str_pad($cases->id + 1, 8, "0", STR_PAD_LEFT) : 'CASE_' . str_pad(1, 8, "0", STR_PAD_LEFT);
            $validator = \Validator::make(['case_no' => $case_no], ['case_no' => 'unique:cases,case_no']);
            if ($validator->fails()) {
                for ($i = 1; $i < 50; $i++) {
                    $case_no = ($cases) ? 'CASE_' . str_pad($in_ar + $i, 8, "0", STR_PAD_LEFT) : 'CASE_' . str_pad(1, 8, "0", STR_PAD_LEFT);
                    $validator = \Validator::make(['case_no' => $case_no], ['case_no' => 'unique:cases,case_no']);
                    if (!$validator->fails()) {
                        return $case_no;
                    }
                }
            } else {
                return $case_no;
            }
        } else {
            return 'CASE_' . str_pad(1, 8, "0", STR_PAD_LEFT);
        }
    }
    public function client_id()
    {
        $cases = Client::select('client_id')->orderBy('id', 'Desc')->first();
        if ($cases) {
            $inv_arr = explode('_', $cases->client_id);
            $in_ar = (int) $inv_arr[1];
            // $id = ''.str_pad($product->id + 1, 8, "0", STR_PAD_LEFT);
            $client_id = ($cases) ? 'CL_' . str_pad($cases->id + 1, 8, "0", STR_PAD_LEFT) : 'CL_' . str_pad(1, 8, "0", STR_PAD_LEFT);
            $validator = \Validator::make(['client_id' => $client_id], ['client_id' => 'unique:cases,client_id']);
            if ($validator->fails()) {
                for ($i = 1; $i < 50; $i++) {
                    $client_id = ($cases) ? 'CL_' . str_pad($in_ar + $i, 8, "0", STR_PAD_LEFT) : 'CL_' . str_pad(1, 8, "0", STR_PAD_LEFT);
                    $validator = \Validator::make(['client_id' => $client_id], ['client_id' => 'unique:cases,client_id']);
                    if (!$validator->fails()) {
                        return $client_id;
                    }
                }
            } else {
                return $client_id;
            }
        } else {
            return 'CL_' . str_pad(1, 8, "0", STR_PAD_LEFT);
        }
    }
}
