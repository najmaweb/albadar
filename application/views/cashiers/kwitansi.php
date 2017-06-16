<html>
<head>
    <link rel="stylesheet" href="/assets/css/kwitansi.css" />
</head>
<body>
<table id="rpt" width=100%>
    <thead>
        <tr><td width="16%"></td><td width="16%"></td><td width="16%"></td><td width="16%"></td><td width="16%"></td><td width="16%"></td></tr>
        <tr><td class="image" colspan=2><img src="/assets/images/logo100x500.png"></td><td colspan=2 >KWITANSI</td><td id="nokwitansi" colspan=2 >No. EL/06/17/0001</td></tr>
    </thead>
    <tbody>
        <tr><td class="line" colspan=6></td</tr>
        <tr><td>Telah terima dari</td><td>: <?php echo substring($studentname,1,20);?> - <?php echo $grade;?></td><td id="terbilang" rowspan="2" colspan="4">Tujuh Juta Rupiah</td></tr>
        <tr><td>Sejumlah Uang</td><td>: <?php echo number_format(7000000);?></td></tr>
        <tr><td class="line" colspan=6></td</tr>

        <tr><td class="centeraligned bold">No</td><td colspan=3 class="centeraligned  bold">Keterangan</td><td colspan=2 class="centeraligned bold">Jumlah</td></tr>

        <tr><td class="line" colspan=6></td</tr>
        <tr><td class="centeraligned number">1</td><td colspan=3>SPP Jan - Mei 2017</td><td colspan=2 class="rightaligned number"><?php echo number_format(4000000);?></td></tr>
        <tr><td class="centeraligned number">2</td><td colspan=3>Bimbel Jan - Mei 2017</td><td colspan=2 class="rightaligned number"><?php echo number_format(3000000);?></td></tr>
        <tr><td colspan=2>&nbsp;</td><td colspan=2>&nbsp;</td><td colspan=2>&nbsp;</td></tr>
        <tr><td colspan=2>&nbsp;</td><td colspan=2>&nbsp;</td><td colspan=2>&nbsp;</td></tr>
        <tr><td colspan=2>&nbsp;</td><td colspan=2>&nbsp;</td><td colspan=2>&nbsp;</td></tr>
        <tr><td colspan=2>&nbsp;</td><td colspan=2>&nbsp;</td><td colspan=2>&nbsp;</td></tr>
        <tr><td class="line" colspan=6></td</tr>
        <tr><td>Total Tagihan</td><td>1000000</td><td colspan=2>&nbsp;</td><td>TOTAL</td><td class="rightaligned"><?php echo number_format(1000000);?></td></tr>
        <tr><td>Yang sudah dibayar</td><td>1000000</td><td colspan=2>&nbsp;</td><td></td><td></td></tr>
        <tr><td>Sisa Tagihan</td><td>1000000</td><td colspan=2>&nbsp;</td><td></td><td></td></tr>
        <tr><td>Status</td><td>Belum Lunas</td><td colspan=2>&nbsp;</td><td></td><td></td></tr>
    </tbody>
</table>
</body>
</html>