<!DOCTYPE html>
<html>
<head>
<title> Ecommerce Online Shopping</title>
<!-- for-mobile-apps -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false);
		function hideURLbar(){ window.scrollTo(0,1); } </script>
<!-- //for-mobile-apps -->
<?= link_tag('assets/frontend/css/bootstrap.css'); ?>
<?= link_tag('assets/frontend/css/style.css'); ?>
<!-- font-awesome icons -->
<?= link_tag('assets/frontend/css/font-awesome.css'); ?>

<!-- Price range css -->
<?= link_tag('assets/frontend/css/jquery-ui1.css'); ?>

<!-- //font-awesome icons -->
<!-- js -->
<script src="<?= base_url('assets/frontend/js/jquery-1.11.1.min.js') ?>"></script>
<!-- //js -->
<link href='//fonts.googleapis.com/css?family=Raleway:400,100,100italic,200,200italic,300,400italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic' rel='stylesheet' type='text/css'>
<link href='//fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic,800,800italic' rel='stylesheet' type='text/css'>
<!-- start-smoth-scrolling -->
<script src="<?= base_url('assets/frontend/js/move-top.js') ?>"></script>
<script src="<?= base_url('assets/frontend/js/easing.js') ?>"></script>
<script type="text/javascript">var baseUrl= "<?php echo base_url(); ?>";</script>

<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/frontend/css/header-style.css'); ?>">
 <link rel="stylesheet" href="http://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script type="text/javascript">
	jQuery(document).ready(function($) {
		$(".scroll").click(function(event){		
			event.preventDefault();
			$('html,body').animate({scrollTop:$(this.hash).offset().top},1000);
		});
	});
</script>
<!-- start-smoth-scrolling -->

<style type="text/css">
	
.ui-draggable, .ui-droppable {
	background-position: top;
	margin-top: -20px;
}
.ui-widget-header {
	background: rgb(254,145,38);
}	
</style>
</head>	
<body>
<!-- header -->
	<div class="header">


		<div class="container">
			<div class="row ps-header-main">

				<div class="col-md-4">
					<div class="logo-nav-left animated wow zoomIn" data-wow-delay=".5s">
						<h1 style="margin: 9px;">			
							<!--<a href="index.html">Best Store <span>Shop anywhere</span></a>-->
							<a href="<?= base_url('home'); ?>"><img src="<?= base_url('assets/images/logo.png'); ?>" class="logo"></a>
						</h1>
					</div>
				</div>


				<div class="col-md-4">
					<div class="search-box">	
						<div class="w3l_search">
							<form action="<?php echo base_url('search'); ?>" method="post">
								<input name="search" value="<?php echo set_value('search'); ?>" placeholder="Search for a Product..." required="" type="search">
								<!--<button type="submit" class="btn btn-default search" aria-label="Left Align">
								<i class="fa fa-search" aria-hidden="true"> </i>
								</button>-->
								
							</form>
						</div>
					</div>	
				</div>

				<div class="col-md-4">
					<div class="header-grid-left animated wow slideInLeft" data-wow-delay=".5s">

					<ul>

						

					<?php if($this->session->userdata('REATILER_ID')) { ?>	

						
						<li>
							<ul class="ps-main_menu ">

								<li><a href="<?= base_url('search'); ?>"><i class="fa fa-shopping-bag" aria-hidden="true"></i> Shop</a></li>

								<?php 
									if (isset($totalproductcart) && $totalproductcart>0) {

								?>		

									<li><a href="<?php echo base_url('cart'); ?>"><i class="glyphicon glyphicon-shopping-cart" aria-hidden="true"><span class="badge badge-success"><?php echo $totalproductcart; ?></span></i></a></li>

								<?php 		
									} else {
								?>		

									<li><a href="javascript:void(0)" onclick="alert('Cart is empty')"><i class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></i> Cart</a></li>

								<?php		
									} 
								?>


								<li class="myaccount">
									<?php 
										if ($this->session->userdata('REATILER_IMAGE')) {
									?>		
										<a href="javascript:void(0)" id=""><img class="img img-circle" src="<?php echo base_url('assets/uploads/'.$this->session->userdata('REATILER_IMAGE')); ?>" style="width: 22px; height: 22px;"></a>
									<?php 		
											
										} else { 
									?>
										<a href="javascript:void(0)" id=""><img class="img img-circle" style="width: 20px; height: 18px;" src="<?php echo base_url('assets/images/user-512.png')?>" ></a>
									<?php } ?>


									<ul class="ps-sub_menu ps-my-account">
										<li><a href="<?= base_url('dashboard'); ?>"><i class="glyphicon glyphicon-dashboard" aria-hidden="true"></i> Dashboard</a></li>	
										<li><a href="<?= base_url('dashboard/orders'); ?>"><i class="glyphicon glyphicon-shopping-cart"></i> Orders</a></li>
										<li><a href="<?= base_url('dashboard/review'); ?>"><i class="glyphicon glyphicon-pencil"></i>Review</a></li>
										<li><a href="<?= base_url('dashboard/changepassword'); ?>"><i class="glyphicon glyphicon-cog"></i> Setting</a></li>
										<li><a href="<?= base_url('dashboard/logout'); ?>"><i class="glyphicon glyphicon-log-out" aria-hidden="true"></i> Logout</a></li>
									</ul>
								</li>	


								

							</ul>
						</li>					
					 	
							

					<?php } else { ?>
						<li>
							<ul class="ps-main_menu ">
								<li><a href="<?= base_url('search'); ?>"><i class="fa fa-shopping-bag" aria-hidden="true"></i> Shop</a></li>

								<?php 
									if (isset($totalproductcart) && $totalproductcart>0) {

								?>		

									<li><a href="<?php echo base_url('cart'); ?>"><i class="glyphicon glyphicon-shopping-cart" aria-hidden="true"><span class="badge badge-success"><?php echo $totalproductcart; ?></span></i></a></li>

								<?php 		
									} else {
								?>		

									<li><a href="javascript:void(0)" onclick="alert('Cart is empty')"><i class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></i> Cart</a></li>

								<?php		
									} 
								?>
								<li class="myaccount">							
									<a href="javascript:void(0)" id=""><img class="img img-circle" style="width: 20px; height: 18px;" src="<?php echo base_url('assets/images/user-512.png'); ?>" ></a>
									<ul class="ps-sub_menu ps-my-account">
										<li><a href="<?= base_url('user/login'); ?>"><i class="glyphicon glyphicon-log-in" aria-hidden="true"></i> Login</a></li>
										<li><a href="<?= base_url('user/register'); ?>"><i class="glyphicon glyphicon-book" aria-hidden="true"></i> Register</a></li>
									</ul>
								</li>
							</ul>		
						</li>	



					<?php } ?>

					
					
					</ul>

				</div>
			</div>
				<div class="clearfix"> </div>
		</div>





	</div>	
	




</div>
<!-- //header -->



