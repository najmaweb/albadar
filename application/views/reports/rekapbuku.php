<html>
    <head>
        <title><?php echo $formtitle;?></title>
        <style>
            h1,h2,h3{
                text-align: center;
            }
            .commonreport{
                width: 100%;
            }
            .commonreport thead tr th{
                border: 1px solid black;
            }
            .commonreport tbody tr td{
                padding: 10px;
                border-bottom: solid 1px black;

            }
            .number{
                text-align: right;
            }
            .commonreport tfoot tr td{
                padding: 10px;
                border-bottom: solid 1px black;
                font-weight: bold;
            }
         </style>
    </head>
    <body>
        <h1><?php echo $formtitle;?></h1>
        <h3>Tahun ajaran <?php echo date("Y")?>/<?php echo date("Y")+1?></h3>
        <table class="commonreport">
            <thead>
                <tr><th>No</th><th>NIS</th><th>Nama</th><th>Jumlah Terbayar</th><th>Kekurangan</th></tr>
            </thead>
            <tbody>
            <?php 
                $c = 1;
                $tot = 0;$sisa = 0;
            ?>
            <?php foreach($rekapdu as $rkd){?>
                <tr>
                    <td class="number"><?php echo $c;?></td>
                    <td class="number"><?php echo $rkd->nis;?></td>
                    <td><?php echo $rkd->name;?></td>
                    <td class="number"><?php echo "Rp." . number_format($rkd->tot);?></td>
                    <td class="number"><?php echo "Rp." . number_format($rkd->sisa);?></td>
                </tr>
            <?php
                $tot+= $rkd->tot; 
                $sisa+= $rkd->sisa; 
                $c++;
            ?>
            <?php }?>
            </tbody>
            <tfoot>
                <tr>
                <td>Total</td>
                <td></td>
                <td></td>
                <td class="number"><?php echo "Rp." . number_format($tot);?></td>
                <td class="number"><?php echo "Rp." . number_format($sisa);?></td>
                </tr>
            </tfoot>
        </table>
    </body>
</html>