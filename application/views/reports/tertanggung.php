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
        <h3>Tanggal 1 Juli 2017</h3>
        <table class="commonreport">
            <thead>
                <tr><th>No</th><th>Siswa</th><th>SPP</th><th>DU</th><th>Buku</th><th>Bimbel</th></tr>
            </thead>
            <tbody>
                <tr><td class="number">1</td><td>060513 - Ahza Wynniar Ardinata</td><td class="number"><?php echo "Rp." . number_format(450000);?></td><td class="number"><?php echo "Rp." . number_format(450000);?></td><td class="number"><?php echo "Rp." . number_format(450000);?></td><td class="number"><?php echo "Rp." . number_format(450000);?></td></tr>
                <tr><td class="number">2</td><td>060514 - Amalia Wafa Al Husna</td><td class="number"><?php echo "Rp." . number_format(650000);?></td><td class="number"><?php echo "Rp." . number_format(450000);?></td><td class="number"><?php echo "Rp." . number_format(450000);?></td><td class="number"><?php echo "Rp." . number_format(450000);?></td></tr>
                <tr><td class="number">3</td><td>060515 - Arin Nadia Nabila</td><td class="number"><?php echo "Rp." . number_format(400000);?></td><td class="number"><?php echo "Rp." . number_format(450000);?></td><td class="number"><?php echo "Rp." . number_format(450000);?></td><td class="number"><?php echo "Rp." . number_format(450000);?></td></tr>
                <tr><td class="number">4</td><td>060516 - Attaya Raynard Anindya Rasyid</td><td class="number"><?php echo "Rp." . number_format(450000);?></td><td class="number"><?php echo "Rp." . number_format(450000);?></td><td class="number"><?php echo "Rp." . number_format(450000);?></td><td class="number"><?php echo "Rp." . number_format(450000);?></td></tr>

            </tbody>
            <tfoot>
                <tr><td colspan=2>Total</td><td class="number"><?php echo "Rp." . number_format(450000);?></td><td class="number"><?php echo "Rp." . number_format(450000);?></td><td class="number"><?php echo "Rp." . number_format(450000);?></td><td class="number"><?php echo "Rp." . number_format(450000);?></td></tr>
            </tfoot>
        </table>
    </body>
</html>