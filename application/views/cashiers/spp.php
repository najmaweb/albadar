<!DOCTYPE html>
<html>
    <head>
        <title>Pembayaran SPP</title>
        <?php
        $this->load->view("commons/headcontent");
        ?>
        <link rel="stylesheet" href="/assets/js/autocomplete/styles.css" />
        <link rel="stylesheet" href="/assets/css/najma.spp.css" />
    </head>
    <body class="bootstrap-admin-with-small-navbar">
        <!-- small navbar -->
        <?php $this->load->view("commons/topmenu");?>
        <!-- main / large navbar -->
        <?php $this->load->view("commons/level2menu");?>
        <div class="container">
            <!-- left, vertical navbar & content -->
            <div class="row">
            <?php $this->load->view("commons/horizontalmenu");?>
                <!-- content -->
                <div class="col-md-10">

                    <form class="form-horizontal" action="/cashier/previewkwitansi" method="POST">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default bootstrap-admin-no-table-panel">
                                <div class="panel-heading">
                                    <div class="text-muted bootstrap-admin-box-title">Entri Pembayaran SPP <span id="err_message"><?php echo $err_message;?></span></div>
                                </div>
                                <div class="bootstrap-admin-no-table-panel-content bootstrap-admin-panel-content collapse in">
                                    <!--<form class="form-horizontal" action="/cashier/savespp" method="POST">-->
                                        <fieldset>
                                            <div class="form-group">
                                                <label class="col-lg-3 control-label" for="sname">Nama Siswa</label>
                                                <div class="col-lg-9" id="the-basics">
                                                    <input class="form-control typeahead" name="name" id="sname" type="text" value="" placeholder="Nama Siswa" />
                                                    <input type="hidden" name="nis" id="nis"/>
                                                    <input type="hidden" name="studentname" id="studentname"/>
                                                    <input type="hidden" name="grade" id="grade"/>
                                                </div>
                                            </div>
                                            <div class="form-group has-warning">
                                                <label class="col-lg-3 control-label" for="spp">SPP&nbsp;<input type="checkbox" id="sppcheckbox"></label>
                                                <div class="col-lg-9">
                                                    <input type="hidden" name="spp" id="spp" value=0/>
                                                    <input type="hidden" id="orispp" name="orispp"  class="form-control affect-total" value="0">
                                                    <input type="text" disabled="disabled" id="spp_" name="spp_"  class="form-control affect-total" value="0">
                                                </div>
                                            </div>
                                            <div class="form-group has-error" id="sppmonthdiv">
                                                <label class="col-lg-3 control-label" for="sppfrstmonth">Untuk Bulan</label>
                                                <div class="col-lg-2">
                                                    <?php echo form_dropdown("sppfrstmonth",$months,$curmonth,"class='form-control sppperiod' id='sppfrstmonth'");?>
                                                </div>
                                                <div class="col-lg-2">
                                                    <?php echo form_dropdown("sppfrstyear",$years,1,"class='form-control sppperiod' id='sppfrstyear'");?>
                                                </div>
                                                <div class="col-lg-1" style="text-align:center">
                                                <label class=" control-label text-align:center" for="sppnextmonth">s/d</label>
                                                </div>
                                                <div class="col-lg-2">
                                                    <?php echo form_dropdown("sppnextmonth",$months,$curmonth,"class='form-control sppperiod' id='sppnextmonth'");?>
                                                </div>
                                                <div class="col-lg-2">
                                                    <?php echo form_dropdown("sppnextyear",$years,1,"class='form-control sppperiod' id='sppnextyear'");?>
                                                </div>
                                            </div>
                                            <div class="form-group has-warning">
                                                <label class="col-lg-3 control-label" for="psb">DU/PSB&nbsp;</label>
                                                <div class="col-lg-9">
                                                    <input type="text" id="psb" name="psb"  class="form-control affect-total" value="0">
                                                </div>
                                            </div>
                                            <div class="form-group has-warning">
                                                <label class="col-lg-3 control-label" for="book">Buku&nbsp;</label>
                                                <div class="col-lg-9">
                                                    <input type="text" id="book" name="book"  class="form-control affect-total" value="0">
                                                </div>
                                            </div>
                                            <div class="form-group bimbel">
                                                <label class="col-lg-3 control-label" for="bimbel">Bimbel&nbsp;<input type="checkbox" id="bimbelcheckbox"></label>
                                                <div class="col-lg-9">
                                                    <input type="text" id="bimbel_" name="bimbel_"  class="form-control affect-total" value="0">
                                                    <input type="hidden" id="bimbel" name="bimbel"  class="form-control affect-total" value="0">
                                                    <input type="hidden" id="oribimbel" name="oribimbel"  class="form-control affect-total" value="0">

                                                </div>
                                            </div>
                                            <div class="form-group bimbel" id="bimbelmonthdiv">
                                                <label class="col-lg-3 control-label" for="frstmonth">Untuk Bimbel Bulan</label>
                                                <div class="col-lg-2">
                                                    <?php echo form_dropdown("frstmonth",$months,1,"class='form-control bimberperiod' id='frstmonth'");?>
                                                </div>
                                                <div class="col-lg-2">
                                                    <?php echo form_dropdown("frstyear",$years,1,"class='form-control bimberperiod' id='frstyear'");?>
                                                </div>
                                                <div class="col-lg-1" style="text-align:center">
                                                <label class=" control-label text-align:center" for="nextmonth">s/d</label>
                                                </div>
                                                <div class="col-lg-2">
                                                    <?php echo form_dropdown("nextmonth",$months,1,"class='form-control bimberperiod' id='nextmonth'");?>
                                                </div>
                                                <div class="col-lg-2">
                                                    <?php echo form_dropdown("nextyear",$years,1,"class='form-control bimberperiod' id='nextyear'");?>
                                                </div>
                                            </div>
                                            <div class="form-group has-warning">
                                                <label class="col-lg-3 control-label" for="inputError">Total</label>
                                                <div class="col-lg-9">
                                                    <input type="text" id="total" name="total"  class="form-control" value="0">
                                                </div>
                                            </div>
                                            <div class="form-group has-success">
                                                <label class="col-lg-3 control-label" for="inputError">Dibayarkan</label>
                                                <div class="col-lg-9">
                                                    <input type="text" id="cashpay" name="paid" class="form-control" value="0">
                                                </div>
                                            </div>
                                            <div class="form-group has-success">
                                                <label class="col-lg-3 control-label" for="inputError">Jumlah Kembalian</label>
                                                <div class="col-lg-9">
                                                    <input type="text" disabled="disabled" id="returnmoney" name="returnmoney" class="form-control" value="0">
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                            <button type="reset" class="btn btn-default">Batalkan</button>
                                        </fieldset>
                                    <!--</form>-->
                                </div>
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- footer -->
        <?php $this->load->view("commons/footer");?>
        <?php $this->load->view("commons/assets");?>

        <script type="text/javascript" src="/assets/js/autocomplete/jquery-1.8.2.min.js"></script>
        <script type="text/javascript" src="/assets/js/autocomplete/jquery.autocomplete.js"></script>
        <script type="text/javascript" src="/assets/js/najma.spp.js"></script>
    </body>
</html>
