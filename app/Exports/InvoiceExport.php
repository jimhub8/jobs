<?php
namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\User;

class InvoiceExport implements FromView
{
    public function view(): View
    {
        return view('home', [
            'users' => User::all()
        ]);
    }
}
