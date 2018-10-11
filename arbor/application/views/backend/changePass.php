<div class="header">
	<h4 class="title"><?php echo $title; ?></h4>
</div>
<div class="content">
	<form method="post">
    <?php if($aUsr['role']==ADMIN_ROLE) {?>
    <div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label>Enter Password</label></label>
					<input type="password" name="val[password]" class="form-control border-input" placeholder="Password">
				</div>
			</div>
		</div>
    <?php }else{ ?>
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label>Old Password</label></label>
					<input type="password" name="val[oldpassword]" class="form-control border-input" placeholder="Old Password">
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label>New Password</label>
					<input type="password" name="val[newpassword]" class="form-control border-input" placeholder="New Password">
				</div>
			</div>
		</div>
    <div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label>Confirm Password</label>
					<input type="password" name="val[password]" class="form-control border-input" placeholder="Confirm Password">
				</div>
			</div>
		</div>
  <?php } ?>
		<div class="text-center col-md-6">
			<button type="submit" class="btn btn-info btn-fill btn-wd" style="<?php if($aUsr['role']==ADMIN_ROLE){ echo 'float:right;';} ?>">Confirm</button>
		</div>
		<div class="clearfix"></div>
	</form>
</div>
