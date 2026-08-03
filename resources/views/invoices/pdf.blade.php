<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Factura #{{ $invoice->id }}</title>
    <style>
        @page {
            margin: 40px;
        }

        body {
            font-family: sans-serif;
            font-size: 12px;
            color: #1e293b;
        }

        .header {
            width: 100%;
            border-bottom: 2px solid #2563eb;
            padding-bottom: 16px;
            margin-bottom: 24px;
        }

        .header td {
            vertical-align: top;
        }

        .company {
            font-size: 15px;
            font-weight: bold;
            color: #2563eb;
        }

        .invoice-title {
            font-size: 20px;
            font-weight: bold;
            text-align: right;
        }

        .invoice-date {
            text-align: right;
            color: #64748b;
            margin-top: 4px;
        }

        .section-label {
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.4px;
            color: #64748b;
            margin-bottom: 4px;
        }

        .client-name {
            font-size: 13px;
            font-weight: bold;
        }

        table.lines {
            width: 100%;
            border-collapse: collapse;
            margin-top: 24px;
        }

        table.lines th {
            text-align: left;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.4px;
            color: #64748b;
            border-bottom: 1px solid #cbd5e1;
            padding: 8px 6px;
        }

        table.lines td {
            padding: 8px 6px;
            border-bottom: 1px solid #e2e8f0;
        }

        table.lines th.numeric,
        table.lines td.numeric {
            text-align: right;
        }

        table.totals {
            width: 100%;
            margin-top: 12px;
        }

        table.totals td {
            padding: 4px 6px;
            text-align: right;
        }

        table.totals .label {
            color: #64748b;
        }

        table.totals .grand-total .label,
        table.totals .grand-total .value {
            font-size: 14px;
            font-weight: bold;
            color: #1e293b;
            border-top: 2px solid #2563eb;
            padding-top: 8px;
        }
    </style>
</head>
<body>
    <table class="header">
        <tr>
            <td class="company">INCLUYENDO CAPACIDADES</td>
            <td>
                <div class="invoice-title">Factura #{{ $invoice->id }}</div>
                <div class="invoice-date">{{ \Carbon\Carbon::parse($invoice->date)->format('d/m/Y') }}</div>
            </td>
        </tr>
    </table>

    <div class="section-label">Cliente</div>
    <div class="client-name">{{ $invoice->client->name }}</div>

    <table class="lines">
        <thead>
            <tr>
                <th>Servicio</th>
                <th class="numeric">Horas</th>
                <th class="numeric">Precio/hora</th>
                <th class="numeric">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($invoice->lines as $line)
                <tr>
                    <td>{{ $line->service->name }}</td>
                    <td class="numeric">{{ number_format($line->hours, 2) }}</td>
                    <td class="numeric">{{ number_format($line->price, 2, ',', '.') }} &euro;</td>
                    <td class="numeric">{{ number_format($line->subtotal, 2, ',', '.') }} &euro;</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <table class="totals">
        <tr>
            <td class="label">Horas totales</td>
            <td class="value" style="width: 120px;">{{ number_format($invoice->total_hours, 2) }}</td>
        </tr>
        <tr class="grand-total">
            <td class="label">Total</td>
            <td class="value" style="width: 120px;">{{ number_format($invoice->total, 2, ',', '.') }} &euro;</td>
        </tr>
    </table>
</body>
</html>
