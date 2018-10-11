<?php include 'include/header.php'; ?>


	<!-- breadcrumbs -->
	<div class="breadcrumbs">
		<div class="container">
			<div class="col-md-3">
				<ol class="breadcrumb breadcrumb1 animated wow slideInLeft" data-wow-delay=".5s">
					<li><a href="<?= base_url(); ?>"><span class="glyphicon glyphicon-home" aria-hidden="true"></span>Home</a></li>
					<li class="active">Login</li>
				</ol>
			</div>
		</div>
	</div>
	<!-- //breadcrumbs -->


	<!-- login -->
	<div class="login">
		<div class="container">
			<h2>Login Form</h2>

			<?php 
				if (validation_errors()) {
			?>
				<div class="alert alert-danger login-form-grids">	
					<?php echo validation_errors(); ?>
				</div>

			<?php } ?>

			<?php 
				if ($this->session->flashdata('loginerrormsg')) {
			?>
				<div class="alert alert-danger login-form-grids">	
					<?php echo $this->session->flashdata('loginerrormsg'); ?>
				</div>

			<?php } ?>

			<?php 
				if ($this->session->flashdata('registersuccessmsg')) {
			?>
				<div class="alert alert-success login-form-grids">	
					<?php echo $this->session->flashdata('registersuccessmsg'); ?>
				</div>

			<?php } ?>

			

		
			<div class="login-form-grids animated wow slideInUp" data-wow-delay=".5s">
				<?php echo form_open('user/login',['method'=>'post']);	?>	
				<?php echo form_hidden('role','4'); ?>

					<?= form_input(['type'=>'email','name'=>'email','autocomplete'=>'off','value'=>set_value('email'),'placeholder'=>'Email address','required'=>'required']); ?>
					<?= form_password(['name'=>'password','autocomplete'=>'off','value'=>set_value('password'),'placeholder'=>'password','required'=>'required']); ?>
					
					<div class="forgot">
						<a href="<?= base_url('user/forgotpassword'); ?>" >Forgot Password?</a>
					</div>
					<input type="submit" name="login" value="Login">
				<?php echo form_close(); ?>
			</div>
			<h4>For New People</h4>
			<p><a href="<?= base_url('user/register'); ?>">Register Here</a> (Or) go back to <a href="<?= base_url('home'); ?>">Home<span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span></a></p>
		</div>
	</div>
<!-- //login -->




<?php include 'include/footer.php'; ?>