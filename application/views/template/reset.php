<div class="header">
	<h4 class="title"><?php echo $title; ?></h4>
</div>
<div class="content">
	<?php loadView('template/message'); ?>
	<form method="post" id="validatedForm">
		<?php if($reset){?>
		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<label>New Password</label>
					<input type="password" id="pass" name="info[password]" class="form-control border-input" placeholder="Enter Password" value="Faker">
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<label>Confirm Password</label>
					<input type="password" id="conf" name="info[confirm]" class="form-control border-input" placeholder="Confirm Password" value="Faker" onblur="confirm();">
				</div>
			</div>
		</div>
		<?php }else{?>
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label>Enter Email</label>
						<input type="email" name="info[email]" class="form-control border-input" placeholder="Email" value="">
					</div>
				</div>
			</div>
		<?php } ?>
		<div class="text-center">
			<button type="submit" class="btn btn-info btn-fill btn-wd">Login</button>
		</div>
		<div class="clearfix"></div>
	</form>
</div>
