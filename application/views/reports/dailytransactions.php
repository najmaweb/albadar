<html>
    <head>
        <title>Laporan Transaksi Harian</title>
        <link rel="stylesheet" href="/assets/css/najma.reports.css" />
    </head>
    <body>
        <h1>Laporan Transaksi Harian</h1>
        <h3>Tanggal <?php echo date("d m Y");?></h3>
        <table class="commonreport">
            <thead>
                <tr><th>No</th><th>Jam</th><th>Uraian</th><th>Jumlah</th><th>Nama Petugas</th></tr>
            </thead>
            <tbody>
                <?php foreach($dailyreports as $report){?>
                <tr><td class="number">1</td><td class="center"><?php echo date("H:i:s")?></td><td>Pembayaran SPP</td><td>Risma</td><td class="number"><?php echo "Rp." . number_format(450000);?></td></tr>
                <?php }?>
            </tbody>
            <tfoot>
                <tr><td>Total</td><td colspan=4 class="number"><?php echo "Rp." . number_format(450000);?></td></tr>
            </tfoot>
        </table>
    </body>
</html>