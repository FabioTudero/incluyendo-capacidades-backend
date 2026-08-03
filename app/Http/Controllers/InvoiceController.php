<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\InvoiceMail;
use App\Models\Invoice;

class InvoiceController extends Controller
{
    public function index()
    {
        return response()->json(Invoice::with(['client', 'lines'])->get());
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'date' => 'required|date',
            'lines' => 'required|array|min:1',
            'lines.*.service_id' => 'required|exists:services,id',
            'lines.*.price' => 'required|numeric|min:0',
            'lines.*.hours' => 'required|numeric|min:0',
        ]);

        $invoice = Invoice::create([
            'client_id' => $validatedData['client_id'],
            'date' => $validatedData['date'],
        ]);

        $invoice->lines()->createMany($validatedData['lines']);
        $invoice->load(['client', 'lines.service']);

        try {
            Mail::to($invoice->client->email)->send(new InvoiceMail($invoice));
        } catch (\Throwable $e) {
            Log::error('No se pudo enviar la factura #' . $invoice->id . ' por correo: ' . $e->getMessage());
        }

        return response()->json($invoice, 201);
    }

    public function show($id)
    {
        $invoice = Invoice::with(['client', 'lines.service'])->findOrFail($id);
        return response()->json($invoice);
    }

    public function generatePDF($id)
    {
        $invoice = Invoice::with(['client', 'lines.service'])->findOrFail($id);

        $pdf = \PDF::loadView('invoices.pdf', compact('invoice'));

        return $pdf->download('invoice_' . $invoice->id . '.pdf');
    }
}
