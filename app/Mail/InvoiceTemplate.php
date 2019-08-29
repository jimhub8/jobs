<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Excel;
use App\Exports\InvoiceExport;

class InvoiceTemplate extends Mailable
{
    use Queueable, SerializesModels;
    public $logo, $data;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data, $logo)
    {
        $this->logo = $logo;
        $this->data = $data;
        // $this->pdf = $pdf;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // $pdf = PDF::loadView('mailtemplates.invoice', $this->data);
        // dd($this->data['mail_cc']);
        // $pdf = Excel::download(new InvoiceExport, 'users.pdf');

        // $pdf = base64_encode($pdf->output());
        return $this->from($this->data['mail_from'])
            ->markdown('mailtemplates.invoice')
            // ->attachData((($pdf)), 'invoice.pdf', [
            //     'mime' => 'application/pdf',
            // ])
            ->to($this->data['mail_to'])
            // ->cc($this->data['mail_cc'])
            // ->bcc($this->data['mail_bcc'])
            ->subject($this->data['mail_subject']);
    }
}
