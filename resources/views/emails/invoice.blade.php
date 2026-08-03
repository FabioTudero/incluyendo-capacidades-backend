<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Factura #{{ $invoice->id }}</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 14px;
            color: #1e293b;
        }

        .brand {
            font-size: 15px;
            font-weight: bold;
            color: #2563eb;
            margin-bottom: 24px;
        }

        .total {
            font-size: 16px;
            font-weight: bold;
        }

        .footer {
            margin-top: 24px;
            font-size: 12px;
            color: #64748b;
        }
    </style>
</head>
<body>
    <div class="brand">INCLUYENDO CAPACIDADES</div>

    <p>Hola {{ $invoice->client->name }},</p>

    <p>Adjuntamos la factura #{{ $invoice->id }} correspondiente al {{ \Carbon\Carbon::parse($invoice->date)->format('d/m/Y') }}.</p>

    <p class="total">Total: {{ number_format($invoice->total, 2, ',', '.') }} &euro;</p>

    <p>Gracias por confiar en nosotros.</p>

    <div class="footer">Este correo se ha generado autom&aacute;ticamente, no es necesario responder.</div>
</body>
</html>
