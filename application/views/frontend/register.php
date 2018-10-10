<div class="header">
	<h4 class="title"><?php echo $title; ?></h4>
</div>
<div class="content">
	<?php loadView('template/message'); ?>
	<form method="post">
		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<label>Name</label>
					<input type="text" name="val[name]" class="form-control border-input" placeholder="Full Name" value="">
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<label>Email</label>
					<input type="email" name="val[email]" class="form-control border-input" placeholder="someone@example.com">
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<label>Password</label>
					<input type="password" name="val[password]" class="form-control border-input" value="123456">
				</div>
			</div>
		</div>
		<div class="text-center">
			<button type="submit" class="btn btn-info btn-fill btn-wd">Register</button>
		</div>
		<div class="clearfix"></div>
	</form>
</div>
