<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$color = $this->db->get_where('ftp_settings',['name'=>'systemGeneralColor'])->row()->value;
if(empty($color)) {
	$color = '#d9534f';
}
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Super FTP Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="<?php echo base_url();?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- styles -->
    <link href="<?php echo base_url();?>assets/css/styles.css" rel="stylesheet">
    <!-- favicon -->
	<link rel="shortcut icon" href="<?php echo base_url();?>assets/images/favicon.ico" type="image/x-icon">
	<link rel="icon" href="<?php echo base_url();?>assets/images/favicon.ico" type="image/x-icon">
    <!-- System Color Style -->
	<style>
		.header {
			background-color: <?php echo $color;?> !important;
			border: none !important;
		}
		footer {
			background-color: <?php echo $color;?> !important;
			border: none !important;
		}
	</style>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class="login-bg">
  	<div class="header">
	     <div class="container">
	        <div class="row">
	           <div class="col-md-12">
	              <!-- Logo -->
	              <div class="logo">
	                 <h1><a href="index.html">Super FTP</a></h1>
	              </div>
	           </div>
	        </div>
	     </div>
	</div>

	<div class="page-content container">
		<div class="row">
			<div class="col-md-4 col-md-offset-4">
			
				<div class="login-wrapper">
			        <div class="box">
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
			            <div class="content-wrap">
			                <h6>Sign In</h6>	
                            <form action="<?php echo base_url();?>login-check" method="post">
                                <input class="form-control" name="user" type="text" placeholder="User Name">
                                <input class="form-control" name="password" type="password" placeholder="Password">
                                <div class="action">
                                    <button type="submit" class="btn btn-primary signup">Login</button>
                                </div>   
                            </form>		                             
			            </div>
			        </div>
			    </div>
			</div>
		</div>
	</div>



    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="<?php echo base_url();?>assets/vendors/jquery/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="<?php echo base_url();?>assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url();?>assets/js/custom.js"></script>
  </body>
</html>