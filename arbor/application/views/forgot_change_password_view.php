<?php include 'include/header.php'; ?>

<!-- breadcrumbs -->
	<div class="breadcrumbs">
		<div class="container">
			<div class="col-md-3">
				<ol class="breadcrumb breadcrumb1 animated wow slideInLeft" data-wow-delay=".5s">
					<li><a href="<?= base_url(); ?>"><span class="glyphicon glyphicon-home" aria-hidden="true"></span>Home</a></li>
					<li class="active">Change Password</li>
				</ol>
			</div>
		</div>
	</div>
<!-- //breadcrumbs -->


<!-- forgot password -->
	<div class="login">
		<div class="container">
			<h2>Change Password Form</h2>

			<?php 
				if (validation_errors()) {
			?>
				<div class="alert alert-danger login-form-grids">	
					<?php echo validation_errors(); ?>
				</div>

			<?php } ?>

			<?php 
				if ($this->session->flashdata('changepasserrormsg')) {
			?>
				<div class="alert alert-danger login-form-grids">	
					<?php echo $this->session->flashdata('changepasserrormsg'); ?>
				</div>

			<?php } ?>

			
			

			<div class="login-form-grids animated wow slideInUp" data-wow-delay=".5s">
				<?= form_open('user/forgotchangepassword',['method'=>'post']); ?>
					<input type="hidden" name="emailId" value="<?php echo $emailId; ?>">
					<?php echo form_password(['placeholder'=>'Password','name'=>'password','value'=>set_value('password'),'autocomplete'=>'off']); ?>				
					<?php echo form_password(['placeholder'=>'Password Confirmation','name'=>'passconf','value'=>set_value('passconf'),'autocomplete'=>'off']); ?>
					
					
					<input type="submit" name="changepassword" value="Change password">
				<?= form_close(); ?>
			</div>
			
		</div>
	</div>
<!-- //forgot password -->

<?php include 'include/footer.php'; ?>