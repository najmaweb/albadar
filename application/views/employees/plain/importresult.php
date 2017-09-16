<!DOCTYPE html>
<html>
    <head>
        <title>Import dari file CSV</title>
        <?php
        $this->load->view("commons/headcontent");
        ?>
    </head>
    <body class="bootstrap-admin-with-small-navbar">
        <!-- small navbar -->
        <?php $this->load->view("commons/topmenu");?>
        <!-- main / large navbar -->
        <?php $this->load->view("commons/level2menu");?>
        <div class="container">
            <!-- left, vertical navbar & content -->
            <div class="row">
                <!-- left, vertical navbar -->
                <?php $this->load->view("commons/horizontalmenu");?>
                <!-- content -->
                <div class="col-md-10">
                    <div class="row">
                        <form action="/employees/savefromcsv" method="POST">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="head panel-heading">
                                    <div class="text-muted bootstrap-admin-box-title">CSV Import</div>
                                    <button class="xright btn btn-sm btn-default" id="btnsavedata" name="btnsavedata" type="submit">
                                        <i class="glyphicon glyphicon-save"></i> Simpan
                                    </button>
                                </div>
                                <div class="bootstrap-admin-panel-content">
                                    <table class="table table-striped table-bordered" id="tProcess">
                                        <thead>
                                            <tr>
                                                <th>Tgl Mulai</th>
                                                <th>Emp. ID</th>
                                                <th>Nama</th>
                                                <th>Fname</th>
                                                <th>Mname</th>
                                                <th>Lname</th>
                                                <th>Department</th>
                                                <th>Shift</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($results as $obj){?>
                                            <tr class="odd gradeX">
                                                <td><?php echo $obj["startdate"];?><input type="hidden" name="startdate[]" value="<?php echo  $obj["startdate"];?>"></td>
                                                <td><?php echo $obj["emp_id"];?><input type="hidden" name="emp_id[]" value="<?php echo  $obj["emp_id"];?>"></td>
                                                <td><?php echo $obj["name"];?><input type="hidden" name="name[]" value="<?php echo  $obj["name"];?>"></td>
                                                <td><?php echo $obj["fname"];?><input type="hidden" name="fname[]" value="<?php echo  $obj["fname"];?>"></td>
                                                <td><?php echo $obj["mname"];?><input type="hidden" name="mname[]" value="<?php echo  $obj["mname"];?>"></td>
                                                <td><?php echo $obj["lname"];?><input type="hidden" name="lname[]" value="<?php echo  $obj["lname"];?>"></td>
                                                <td><?php echo $obj["department_id"];?><input type="hidden" name="department_id[]" value="<?php echo  $obj["department_id"];?>"></td>
                                                <td><?php echo $obj["shift_id"];?><input type="hidden" name="shift_id[]" value="<?php echo  $obj["shift_id"];?>"></td>
                                            </tr>
                                            <?php }?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- footer -->
        <?php $this->load->view("commons/footer");?>
        <?php $this->load->view("commons/assets");?>
        <script type="text/javascript" src="/assets/vendors/datatables/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="/assets/js/DT_bootstrap.js"></script>
    </body>
</html>

