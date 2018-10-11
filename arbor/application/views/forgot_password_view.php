<?php include 'include/header.php'; ?>

<!-- breadcrumbs -->
	<div class="breadcrumbs">
		<div class="container">
			<div class="col-md-3">
				<ol class="breadcrumb breadcrumb1 animated wow slideInLeft" data-wow-delay=".5s">
					<li><a href="<?= base_url(); ?>"><span class="glyphicon glyphicon-home" aria-hidden="true"></span>Home</a></li>
					<li class="active">Forgot Password</li>
				</ol>
			</div>
		</div>
	</div>
<!-- //breadcrumbs -->


<!-- forgot password -->
	<div class="login">
		<div class="container">
			<h2>Forgot Password Form</h2>

			<?php 
				if (validation_errors()) {
			?>
				<div class="alert alert-danger login-form-grids">	
					<?php echo validation_errors(); ?>
				</div>

			<?php } ?>

			<?php 
				if ($this->session->flashdata('forgoterrorsmsg')) {
			?>
				<div class="alert alert-danger login-form-grids">	
					<?php echo $this->session->flashdata('forgoterrorsmsg'); ?>
				</div>

			<?php } ?>

			<?php 
				if ($this->session->flashdata('forgotsuccessmsg')) {
			?>
				<div class="alert alert-success login-form-grids">	
					<?php echo $this->session->flashdata('forgotsuccessmsg'); ?>
				</div>

			<?php } ?>
			

			<div class="login-form-grids animated wow slideInUp" data-wow-delay=".5s">
				<?= form_open('user/forgotpassword',['method'=>'post']); ?>
					
					<?= form_input(['type'=>'email','name'=>'email','autocomplete'=>'off','value'=>set_value('email'),'placeholder'=>'Email address']); ?>
					
					
					<input type="submit" name="reset" value="Reset password">
				<?= form_close(); ?>
			</div>
			<h4>For New People</h4>
			<p><a href="<?= base_url('user/register'); ?>">Register Here</a> (Or) go back to <a href="<?= base_url('home'); ?>">Home<span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span></a></p>
		</div>
	</div>
<!-- //forgot password -->

<?php include 'include/footer.php'; ?>