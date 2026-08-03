<?php

namespace App\Mail;

use App\Models\Invoice;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Invoice $invoice)
    {
    }

    public function build()
    {
        $pdf = \PDF::loadView('invoices.pdf', ['invoice' => $this->invoice]);

        return $this->subject('Factura #' . $this->invoice->id . ' - Incluyendo Capacidades')
            ->view('emails.invoice')
            ->attachData($pdf->output(), 'factura_' . $this->invoice->id . '.pdf', [
                'mime' => 'application/pdf',
            ]);
    }
}
