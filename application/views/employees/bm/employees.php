<!DOCTYPE html>
<html lang="en">
<head>
	<!-- start: Meta -->
	<meta charset="utf-8">
	<title><?php echo $title;?></title>
	<meta name="description" content="<?php echo $this->config->item('appname');?>">
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
				<a class="brand" href="/"><span><?php echo $this->config->item("appname");?></span></a>
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
						<h2><i class="halflings-icon user"></i><span class="break"></span>Daftar Karyawan</h2>
						<div class="box-icon">
							<a href="/<?php echo $parent;?>/import" class="btn-setting"><i class="halflings-icon import"></i></a>
							<a href="#" class="btn-setting"><i class="halflings-icon wrench"></i></a>
							<a href="<?php echo $parent;?>/add" class=""><i class="halflings-icon plus"></i></a>
						</div>
					</div>
					<div class="box-content">
						<table class="table table-striped table-bordered bootstrap-datatable datatable">
						  <thead>
							  <tr>
								  <th width=25%>Nama</th>
								  <th width=20%>Tanggal Join</th>
								  <th width=20%>Role</th>
								  <th width=20%>Status</th>
								  <th width=15%>Actions</th>
							  </tr>
						  </thead>   
						  <tbody>
						  <?php foreach($objs as $obj){?>
							<tr>
								<td class="nname"><?php echo $obj->nname;?></td>
								<td class="center"><?php echo $obj->startdate;?></td>
								<td class="center"><?php echo $obj->role;?></td>
								<td class="center">
									<span class="label label-success">Active</span>
								</td>
								<td class="center">
									<a class="btn btn-success" href="#">
										<i class="halflings-icon white zoom-in"></i>  
									</a>
									<a class="btn btn-info" href="/<?php echo $parent;?>/edit/<?php echo $obj->id;?>">
										<i class="halflings-icon white edit"></i>  
									</a>
									<a class="btn btn-danger btn-remove">
										<i class="halflings-icon white trash"></i> 
									</a>
								</td>
							</tr>
							<?php }?>
						  </tbody>
					  </table>            
					</div>
				</div><!--/span-->
			</div><!--/row-->
		</div><!--/.fluid-container-->
		<!-- end: Content -->
		</div><!--/#content.span10-->
		</div><!--/fluid-row-->
		<?php $this->load->view($parent."/".$theme."/modals");?>
	<div class="clearfix"></div>
	<?php $this->load->view("commons/bm/footer");?>
	<?php $this->load->view("commons/bm/js");?>
	<script type="text/javascript" src="/js/employees/bm/employees.js"></script>
</body>
</html>
