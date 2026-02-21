<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>{{ $quote->quote_number }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #0f172a; }
        h1 { margin: 0 0 8px; font-size: 20px; }
        .meta { margin-bottom: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 12px; }
        th, td { border: 1px solid #cbd5e1; padding: 8px; text-align: left; }
        th { background: #f1f5f9; }
        .totals { margin-top: 14px; width: 320px; margin-left: auto; }
        .totals td { border: none; padding: 4px 0; }
        .totals tr td:last-child { text-align: right; }
        .title-row { margin-bottom: 18px; }
    </style>
</head>
<body>
    <div class="title-row">
        <h1>Aladdin CRM - Teklif</h1>
        <div class="meta">
            <div><strong>Teklif No:</strong> {{ $quote->quote_number }}</div>
            <div><strong>Firma:</strong> {{ $quote->company?->name }}</div>
            <div><strong>Durum:</strong> {{ strtoupper((string) $quote->status?->value ?? (string) $quote->status) }}</div>
            <div><strong>Para Birimi:</strong> {{ $quote->currency?->value ?? $quote->currency }}</div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Aciklama</th>
                <th>Adet</th>
                <th>Birim Fiyat</th>
                <th>Iskonto %</th>
                <th>KDV %</th>
                <th>Toplam</th>
            </tr>
        </thead>
        <tbody>
            @foreach($quote->items as $item)
                <tr>
                    <td>{{ $item->description }}</td>
                    <td>{{ number_format((float) $item->quantity, 2, ',', '.') }}</td>
                    <td>{{ number_format((float) $item->unit_price, 2, ',', '.') }}</td>
                    <td>{{ number_format((float) $item->discount_rate, 2, ',', '.') }}</td>
                    <td>{{ number_format((float) $item->tax_rate, 2, ',', '.') }}</td>
                    <td>{{ number_format((float) $item->line_total, 2, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <table class="totals">
        <tr>
            <td>Ara Toplam</td>
            <td>{{ number_format((float) $quote->subtotal, 2, ',', '.') }}</td>
        </tr>
        <tr>
            <td>Iskonto</td>
            <td>{{ number_format((float) $quote->discount_total, 2, ',', '.') }}</td>
        </tr>
        <tr>
            <td>KDV</td>
            <td>{{ number_format((float) $quote->tax_total, 2, ',', '.') }}</td>
        </tr>
        <tr>
            <td><strong>Genel Toplam</strong></td>
            <td><strong>{{ number_format((float) $quote->grand_total, 2, ',', '.') }}</strong></td>
        </tr>
    </table>

    @if($quote->note)
        <p style="margin-top: 16px;"><strong>Not:</strong> {{ $quote->note }}</p>
    @endif
</body>
</html>
