<html>
<head>
    <script type="text/javascript" src="/assets/js/jquery-2.0.3.min.js"></script>
    <link rel="stylesheet" href="/assets/css/kwitansi.css" />
</head>
<body>
<button class="btn btn-default"><i class="glyphicon glyphicon-eye-open"></i> Cetak</button>
<button class="btn btn-default" id="btngotocashier"><i class="glyphicon glyphicon-eye-open"></i> Kasir</button>
<table id="rpt" width=100%>
    <thead>
        <tr><td width="16%"></td><td width="16%"></td><td width="16%"></td><td width="16%"></td><td width="16%"></td><td width="16%"></td></tr>
        <tr><td class="image" colspan=2><img src="/assets/images/logo100x500.png"></td><td colspan=2 >KWITANSI</td><td id="nokwitansi" colspan=2 >No. EL/06/17/0001</td></tr>
    </thead>
    <tbody>
        <tr><td class="line" colspan=6></td</tr>
        <tr><td>Telah terima dari</td><td>: <?php echo substr($studentname,0,18);?> - <?php echo $grade;?></td><td id="terbilang" rowspan="2" colspan="4">Tujuh Juta Rupiah</td></tr>
        <tr><td>Sejumlah Uang</td><td>: <?php echo number_format($topaid);?></td></tr>
        <tr><td class="line" colspan=6></td</tr>

        <tr><td class="centeraligned bold">No</td><td colspan=3 class="centeraligned  bold">Keterangan</td><td colspan=2 class="centeraligned bold">Jumlah</td></tr>

        <tr><td class="line" colspan=6></td</tr>
        <?php $counter = 1;?>
        <?php if($spp){?>
        <tr><td class="centeraligned number"><?php echo $counter;?></td><td colspan=3>SPP Jan - Mei 2017</td><td colspan=2 class="rightaligned number"><?php echo $spp;?></td></tr>
        <?php 
        $counter++;
        }?>
        <?php if($bimbel){?>
        <tr><td class="centeraligned number"><?php echo $counter;?></td><td colspan=3>Bimbel Jan - Mei 2017</td><td colspan=2 class="rightaligned number"><?php echo $bimbel;?></td></tr>
        <?php 
        $counter++;
        }?>
        <?php if($book){?>
        <tr><td class="centeraligned number"><?php echo $counter;?></td><td colspan=3>Buku</td><td colspan=2 class="rightaligned number"><?php echo number_format($book);?></td></tr>
        <?php 
        $counter++;
        }?>
        <?php if($psb){?>
        <tr><td class="centeraligned number"><?php echo $counter;?></td><td colspan=3>PSB</td><td colspan=2 class="rightaligned number"><?php echo number_format($psb);?></td></tr>
        <?php }?>
        <tr><td colspan=2>&nbsp;</td><td colspan=2>&nbsp;</td><td colspan=2>&nbsp;</td></tr>
        <tr><td colspan=2>&nbsp;</td><td colspan=2>&nbsp;</td><td colspan=2>&nbsp;</td></tr>
        <tr><td colspan=2>&nbsp;</td><td colspan=2>&nbsp;</td><td colspan=2>&nbsp;</td></tr>
        <tr><td colspan=2>&nbsp;</td><td colspan=2>&nbsp;</td><td colspan=2>&nbsp;</td></tr>
        <tr><td class="line" colspan=6></td</tr>
        <tr><td>Total Tagihan</td><td>1000000</td><td colspan=2>&nbsp;</td><td>TOTAL</td><td class="rightaligned number"><?php echo $total;?></td></tr>
        <tr><td>Yang sudah dibayar</td><td>1000000</td><td colspan=2>&nbsp;</td><td></td><td></td></tr>
        <tr><td>Sisa Tagihan</td><td>1000000</td><td colspan=2>&nbsp;</td><td></td><td></td></tr>
        <tr><td>Status</td><td>Belum Lunas</td><td colspan=2>&nbsp;</td><td></td><td></td></tr>
    </tbody>
</table>
<script type="text/javascript" src="/assets/js/previewkwitansi.js"></script>
</body>
</html>