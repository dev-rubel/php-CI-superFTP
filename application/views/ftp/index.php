<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$color = $this->db->get_where('ftp_settings',['name'=>'systemGeneralColor'])->row()->value;
if(empty($color)) {
	$color = '#d9534f';
}
if(!empty($active)) {
	$current = $active;	
} else {
	$current = '';
}
?><!DOCTYPE html>
<html>
  <head>
    <title><?php echo !empty($title)?$title:'Super FTP'; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="<?php echo base_url();?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- styles -->
    <link href="<?php echo base_url();?>assets/css/styles.css" rel="stylesheet">
    <link href="<?php echo base_url();?>assets/css/forms.css" rel="stylesheet">
	<!-- datatable -->
	<link href="<?php echo base_url();?>assets/vendors/datatables/dataTables.bootstrap.css" rel="stylesheet" media="screen">
	<link href="<?php echo base_url();?>assets/css/style.css" rel="stylesheet" media="all">
	<!-- favicon -->
	<link rel="shortcut icon" href="<?php echo base_url();?>assets/images/favicon.ico" type="image/x-icon">
	<link rel="icon" href="<?php echo base_url();?>assets/images/favicon.ico" type="image/x-icon">
	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	<script src="<?php echo base_url();?>assets/vendors/jquery/jquery.js"></script>
	<!-- Toster -->
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
	<!-- System Color Style -->
	<style>
		.nav-text,
		.header,
		footer,
		.faddedBox::before,
		.spinner > div
		{
			background-color: <?php echo $color;?> !important;
			border: none !important;
		}
		.tree li,
		.tree li a,
		.tree li button, .tree li button:active, .tree li button:focus,
		.current a,
		#controlPanel i,
		#controlPanel a
		{
			color: <?php echo $color;?> !important;
		}
		#controlPanel {
			border-bottom: 1px solid <?php echo $color;?> !important;
		}

	</style>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
  	<div class="header">
	     <div class="container">
	        <div class="row">
	           <div class="col-md-5">
	              <!-- Logo -->
	              <div class="logo">
	                 <h1><a href="index.html">Super FTP</a></h1>
	              </div>
	           </div>
	           <div class="col-md-5">
	              
	           </div>
	           <div class="col-md-2">
	              <div class="navbar navbar-inverse" role="banner">
	                  <nav class="collapse navbar-collapse bs-navbar-collapse navbar-right" role="navigation">
	                    <ul class="nav navbar-nav">
	                      <li class="dropdown">
	                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo ucwords($_SESSION['userInfo']['userFullName']); ?> <b class="caret"></b></a>
	                        <ul class="dropdown-menu animated fadeInUp">
	                          <li><a href="<?php echo base_url();?>user-profile">Profile</a></li>
	                          <li><a href="<?php echo base_url();?>logout">Logout</a></li>
	                        </ul>
	                      </li>
	                    </ul>
	                  </nav>
	              </div>
	           </div>
	        </div>
	     </div>
	</div>

    <div class="page-content">
    	<div class="row">
			<div class="col-md-2">		  	
				<?php $this->load->view('ftp/nav',['current'=>$current]); ?>
			</div>
			<div class="col-md-8">

				<!-- Flash message section -->
				<?php 
					$flashMsg = $this->session->flashdata('msg'); 
					if(!empty($flashMsg)):
						foreach($flashMsg as $k=>$messages):
							foreach($messages as $k2=>$message):
				?>	  	
						<div class="alert alert-<?php echo $k;?>">
							<strong><?php echo ucfirst($k);?>!</strong> <?php echo $message ?>.
						</div>
					<?php endforeach; endforeach; endif; ?>
				<!-- End flash message section -->

				<div class="spinner">
					<div class="rect1"></div>
					<div class="rect2"></div>
					<div class="rect3"></div>
					<div class="rect4"></div>
					<div class="rect5"></div>
				</div>
				<div id="wrapperContent">						
					<?php echo $ftpContent; ?>	
				</div>
				<br> <br> <br> <br> <br>
		  </div>
		  <?php echo $ftpList; ?>		  
		
    </div>

    <footer class="footer navbar-fixed-bottom">
         <div class="container">
        	 <div class="row">
				<div class="text-center">
				<strong>Current Date:</strong> <?php echo date('Y-M-d'); ?>
				</div>
            </div>
         </div>
      </footer>

	
	<!-- jQuery UI -->
	<script src="<?php echo base_url();?>assets/vendors/jquery/jquery-ui.js"></script>	
	<!-- Bootstrap -->
	<script src="<?php echo base_url();?>assets/bootstrap/js/bootstrap.min.js"></script>
	<!-- Toster -->
	<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
	<!-- datatable -->
	<script src="<?php echo base_url();?>assets/vendors/datatables/js/jquery.dataTables.min.js"></script>
	<script src="<?php echo base_url();?>assets/vendors/datatables/dataTables.bootstrap.js"></script>
	
	<script src="<?php echo base_url();?>assets/js/custom.js"></script>
	<script src="<?php echo base_url();?>assets/js/tables.js"></script>
  </body>
</html>