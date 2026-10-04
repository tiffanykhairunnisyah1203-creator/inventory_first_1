<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Bukti Transaksi #<?php echo e($data->id); ?></title>
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
        <p class="text-center" style="margin: 5px 0 0; font-size: 12px;">Waktu: <?php echo e($data->created_at->format('d M Y H:i')); ?></p>
        
        <div class="divider"></div>
        
        <table>
            <tr>
                <td><strong>ID Transaksi</strong></td>
                <td class="text-right">#TRX-<?php echo e($data->id); ?></td>
            </tr>
            <tr>
                <td><strong>Jenis</strong></td>
                <td class="text-right uppercase"><?php echo e($data->jenis_transaksi); ?></td>
            </tr>
            <tr>
                <td><strong>Kategori</strong></td>
                <td class="text-right"><?php echo e($data->jenis_penarikan ?? 'Umum'); ?></td>
            </tr>
            <?php if($data->no_kendaraan): ?>
            <tr>
                <td><strong>No. Kendaraan</strong></td>
                <td class="text-right"><?php echo e($data->no_kendaraan); ?></td>
            </tr>
            <?php endif; ?>
            <?php if($data->nama_driver): ?>
            <tr>
                <td><strong>Penerima/Driver</strong></td>
                <td class="text-right"><?php echo e($data->nama_driver); ?></td>
            </tr>
            <?php endif; ?>
        </table>
        
        <div class="divider"></div>
        
        <p style="margin:0; font-size: 12px;"><strong>Keterangan:</strong><br><?php echo e($data->keterangan); ?></p>
        
        <div class="divider"></div>
        
        <table>
            <tr>
                <td><strong>TOTAL NOMINAL</strong></td>
                <td class="text-right font-bold" style="font-size: 16px;">
                    Rp <?php echo e(number_format($data->jumlah, 0, ',', '.')); ?>

                </td>
            </tr>
            <tr>
                <td><strong>STATUS</strong></td>
                <td class="text-right"><?php echo e(strtoupper($data->status)); ?></td>
            </tr>
        </table>
        
        <div class="divider"></div>
        <p class="text-center" style="font-size: 12px; margin:0;">Dicetak oleh Sistem</p>
    </div>
</body>
</html><?php /**PATH C:\Project_Laravel10\Gudang\Gudang\Gudang\resources\views/admin/keuangan/cetak-struk.blade.php ENDPATH**/ ?>