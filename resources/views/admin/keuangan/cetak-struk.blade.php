<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Bukti Transaksi #{{ $data->id }}</title>
    <style>
        body { font-family: 'Courier New', Courier, monospace; color: #000; padding: 20px; }
        .struk-container { width: 400px; margin: 0 auto; border: 1px dashed #000; padding: 20px; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .font-bold { font-weight: bold; }
        .divider { border-top: 1px dashed #000; margin: 15px 0; }
        table { width: 100%; margin-bottom: 10px; }
        td { padding: 4px 0; font-size: 14px; }
    </style>
</head>
<body onload="window.print()">
    <div class="struk-container">
        <h3 class="text-center" style="margin: 0;">BUKTI TRANSAKSI</h3>
        <p class="text-center" style="margin: 5px 0 0; font-size: 12px;">Waktu: {{ $data->created_at->format('d M Y H:i') }}</p>
        
        <div class="divider"></div>
        
        <table>
            <tr>
                <td><strong>ID Transaksi</strong></td>
                <td class="text-right">#TRX-{{ $data->id }}</td>
            </tr>
            <tr>
                <td><strong>Jenis</strong></td>
                <td class="text-right uppercase">{{ $data->jenis_transaksi }}</td>
            </tr>
            <tr>
                <td><strong>Kategori</strong></td>
                <td class="text-right">{{ $data->jenis_penarikan ?? 'Umum' }}</td>
            </tr>
            @if($data->no_kendaraan)
            <tr>
                <td><strong>No. Kendaraan</strong></td>
                <td class="text-right">{{ $data->no_kendaraan }}</td>
            </tr>
            @endif
            @if($data->nama_driver)
            <tr>
                <td><strong>Penerima/Driver</strong></td>
                <td class="text-right">{{ $data->nama_driver }}</td>
            </tr>
            @endif
        </table>
        
        <div class="divider"></div>
        
        <p style="margin:0; font-size: 12px;"><strong>Keterangan:</strong><br>{{ $data->keterangan }}</p>
        
        <div class="divider"></div>
        
        <table>
            <tr>
                <td><strong>TOTAL NOMINAL</strong></td>
                <td class="text-right font-bold" style="font-size: 16px;">
                    Rp {{ number_format($data->jumlah, 0, ',', '.') }}
                </td>
            </tr>
            <tr>
                <td><strong>STATUS</strong></td>
                <td class="text-right">{{ strtoupper($data->status) }}</td>
            </tr>
        </table>
        
        <div class="divider"></div>
        <p class="text-center" style="font-size: 12px; margin:0;">Dicetak oleh Sistem</p>
    </div>
</body>
</html>