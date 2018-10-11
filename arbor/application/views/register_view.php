<?php include 'include/header.php'; ?>
<!-- breadcrumbs -->
	<div class="breadcrumbs">
		<div class="container">
			<div class="col-md-3">
				<ol class="breadcrumb breadcrumb1 animated wow slideInLeft" data-wow-delay=".5s">
					<li><a href="<?= base_url(); ?>"><span class="glyphicon glyphicon-home" aria-hidden="true"></span>Home</a></li>
					<li class="active">Register</li>
				</ol>
			</div>
		</div>
	</div>
	<!-- //breadcrumbs -->



<!-- register -->
	<div class="register">
		<div class="container">
			<h2>Register Here</h2>
			<?php 
				if (validation_errors()) {
			?>
				<div class="alert alert-danger login-form-grids">	
					<?php echo validation_errors(); ?>
				</div>

			<?php } ?>
			
			<?php 
				if ($this->session->flashdata('registererror')) {
			?>
				<div class="alert alert-danger login-form-grids">	
					<?php echo $this->session->flashdata('registererror'); ?>
				</div>

			<?php } ?>

			<?php echo form_open('user/register',['method'=>'post']);	?>	
			<?php echo form_hidden('role','4'); ?>
			

			<div class="login-form-grids">

					<?php echo form_input(['placeholder'=>'Full Name','name'=>'name','value'=>set_value('name'),'autocomplete'=>'off','required'=>'required']); ?>	

					<?php echo form_input(['type'=>'email','placeholder'=>'Email Address','name'=>'email','value'=>set_value('email'),'style'=>'margin-top: 12px;','autocomplete'=>'off','required'=>'required']); ?>
				
					<input type="text" name="distributor_name" id="autocomplete" placeholder="Type distributor name" value="<?php set_value('distributor_name'); ?>" autocomplete="off" required="required" >

					<input type="hidden" name="distributor_id" id="selectuser_id" placeholder="Distributor Id" autocomplete="off" required="required">

					<select class="selectbox-cls" name="city_id" required="required">
						<option value="">Select city</option>
						<?php 
							foreach ($rowcity as $resultscity) {
								echo '<option value="'.$resultscity["id"].'">'.$resultscity["name"].'</option>';
							}
						?>
					</select>	
					
					<?php echo form_password(['placeholder'=>'Password','name'=>'password','value'=>set_value('password'),'autocomplete'=>'off','required'=>'required']); ?>				
					<?php echo form_password(['placeholder'=>'Password Confirmation','name'=>'passconf','value'=>set_value('passconf'),'autocomplete'=>'off','required'=>'required']); ?>
					
					<!--<div class="register-check-box">
						<div class="check">
							<label class="checkbox">
								
								<input type="checkbox" name="checkbox"><i> </i>I accept the terms and conditions
							</label>
						</div>
					</div>-->
					<input type="submit" name="register" value="Register">
				
			</div>
			<?php echo form_close(); ?>			
			<div class="register-home">
				<a href="<?= base_url('home'); ?>">Home</a>
			</div>
		</div>
	</div>
<!-- //register -->
<script type="text/javascript">
	function findwarehouseid(obj) {
		var cityId = obj.val();
		var datastring ='id='+cityId;
		$.post("<?php echo base_url('user/findwarehouse') ?>", datastring , function(response) {
			
			$("#warehouse_id").val(response);
		});
	}
</script>








<script type="text/javascript">

$( function() {

 // Single Select
	$( "#autocomplete" ).autocomplete({
	  	source: function( request, response ) {
	   // Fetch data
			   $.ajax({
				    url: "<?php echo base_url('user/distributoralldata'); ?>",
				    type: 'post',
				    dataType: "json",
				    data: {
				     search: request.term
				    },
				    success: function( data ) {
				     response( data );
				    }
			   });
	  	},
		
		select: function (event, ui) {
		   // Set selection
		   $('#autocomplete').val(ui.item.label); // display the selected text
		   $('#selectuser_id').val(ui.item.value); // save selected id to input
		   return false;
		}
	});
});

</script>

<link rel="stylesheet" href="http://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

<?php include 'include/footer.php'; ?>