<!DOCTYPE html>
<html lang="en">
<head>
	<!-- start: Meta -->
	<meta charset="utf-8">
	<title><?php echo $title;?></title>
	<meta name="description" content="EmployeeDB">
	<meta name="author" content="Puji">
	<meta name="keyword" content="">
	<!-- end: Meta -->
	<!-- start: Mobile Specific -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- end: Mobile Specific -->
	<?php $this->load->view("commons/bm/styling");?>
	</head>
<body>
	<!-- start: Header -->
	<div class="navbar">
		<div class="navbar-inner">
			<div class="container-fluid">
				<a class="btn btn-navbar" data-toggle="collapse" data-target=".top-nav.nav-collapse,.sidebar-nav.nav-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</a>
				<a class="brand" href="index.html"><span><?php echo $this->config->item("appname");?></span></a>
				<!-- start: Header Menu -->
				<div class="nav-no-collapse header-nav">
					<ul class="nav pull-right">
					<?php $this->load->view("commons/bm/hiddenphonedropdown");?>
					<?php $this->load->view("commons/bm/notificationdropdown");?>
					<?php $this->load->view("commons/bm/messagedropdown");?>
					<?php $this->load->view("commons/bm/settings");?>
					<?php $this->load->view("commons/bm/profile");?>
				</ul>
				</div>
				<!-- end: Header Menu -->
			</div>
		</div>
	</div>
	<!-- start: Header -->
		<div class="container-fluid-full">
		<div class="row-fluid">
		<?php $this->load->view("commons/bm/sidemenu");?>			
			<!-- start: Content -->
			<div id="content" class="span10">
			<ul class="breadcrumb">
			<li>
			<i class="icon-home"></i>
			<a href="/<?php echo $parent;?>"><?php echo $breadcrumb[1];?></a> 
			<i class="icon-angle-right"></i>
		</li>
		<li><a href="#"><?php echo $breadcrumb[2];?></a></li>
	</ul>
			<div class="row-fluid sortable">
				<div class="box span12">
					<div class="box-header" data-original-title>
						<h2><i class="halflings-icon edit"></i><span class="break"></span>Penambahan Pegawai</h2>
						<div class="box-icon">
							<a href="#" class="btn_save" title="Simpan"><i class="halflings-icon hdd"></i></a>
						</div>
					</div>
					<div class="box-content">
						<form class="form-horizontal" action="/<?php echo $parent;?>/save" method="post">
						  <fieldset>
							<div class="control-group">
								<label class="control-label" for="focusedInput">Nama Panggilan</label>
								<div class="controls">
								  <input class="input-xlarge focused" id="nname" name="nname" type="text" />
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="focusedInput">Nama Lengkap</label>
								<div class="controls">
								  <input class="input-xlarge" id="fname" name="fname" type="text" placeholder="Nama Awal">
								  <input class="input-xlarge" id="mname" name="mname" type="text" placeholder="Nama Tengah">
								  <input class="input-xlarge" id="lname" name="lname" type="text" placeholder="Nama Akhir">
								</div>
							</div>
							<div class="control-group">
							  <label class="control-label" for="typeahead">Company </label>
							  <div class="controls">
								<?php echo form_dropdown("company_id",$companies,"0");?>
							  </div>
							</div>
							<div class="control-group">
							  <label class="control-label" for="department">Department </label>
							  <div class="controls">
								<?php echo form_dropdown("department_id",$departments,"0");?>
							  </div>
							</div>
							<div class="control-group">
							  <label class="control-label" for="role">Role </label>
							  <div class="controls">
								<?php echo form_dropdown("role",$roles,"0");?>
							  </div>
							</div>
							<div class="control-group">
							  <label class="control-label" for="date01">Tanggal Join</label>
							  <div class="controls">
								<input type="text" class="input-xlarge datepicker" id="date01" value="02/16/12">
							  </div>
							</div>
							<div class="control-group">
								<label class="control-label" for="selectError3">Jenis Kelamin</label>
								<div class="controls">
								  <select id="selectError3">
									<option>Laki-laki</option>
									<option>Wanita</option>
								  </select>
								</div>
							  </div>
							<div class="control-group hidden-phone">
							  <label class="control-label" for="textarea2">Keterangan</label>
							  <div class="controls">
								<textarea class="cleditor" id="textarea2" rows="3"></textarea>
							  </div>
							</div>
							<div class="form-actions">
							  <button type="submit" id="btnsave" class="btn btn-primary">Save changes</button>
							  <button type="reset" class="btn">Cancel</button>
							</div>
						  </fieldset>
						</form>
					</div>
				</div><!--/span-->
			</div><!--/row-->
			<div class="row-fluid sortable">
				<div class="box span12">
					<div class="box-header" data-original-title>
						<h2><i class="halflings-icon edit"></i><span class="break"></span>Foto Pegawai</h2>
						<div class="box-icon">
							<a href="#" class="btn-setting"><i class="halflings-icon wrench"></i></a>
							<a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
							<a href="#" class="btn-close"><i class="halflings-icon remove"></i></a>
						</div>
					</div>
					<div class="box-content">
						<form class="form-horizontal">
							<fieldset>
							<div class="control-group">
							<label class="control-label" for="fileInput">Upload Foto</label>
							<div class="controls">
							<input class="input-file uniform_on" id="fileInput" type="file">
							</div>
						</div>          
							<div class="form-actions">
								<button type="submit" class="btn btn-primary">Save changes</button>
								<button class="btn">Cancel</button>
							  </div>
							</fieldset>
						</form>
					</div>
				</div><!--/span-->
			</div><!--/row-->
		</div><!--/.fluid-container-->
			<!-- end: Content -->
		</div><!--/#content.span10-->
		</div><!--/fluid-row-->
	<div class="modal hide fade" id="myModal">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">×</button>
			<h3>Settings</h3>
		</div>
		<div class="modal-body">
			<p>Here settings can be configured...</p>
		</div>
		<div class="modal-footer">
			<a href="#" class="btn" data-dismiss="modal">Close</a>
			<a href="#" class="btn btn-primary">Save changes</a>
		</div>
	</div>
	<div class="clearfix"></div>
	<?php $this->load->view("commons/bm/footer");?>	
	<?php $this->load->view("commons/bm/js");?>
	<script type="text/javascript">
		$(".btn_save").click(function(){
			$("#btnsave").click();
		});
	</script>
	</body>
</html>
