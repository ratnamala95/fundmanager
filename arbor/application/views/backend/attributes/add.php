<div class="header">
    <h4 class="title" style="float: left;"><?php echo $title; ?></h4>
    
    <div class="clearfix">&nbsp;</div>
</div>

<div class="content">
<form method="post">
	<?php if($bEdit) { ?>
		<input type="hidden" name="val[id]" value="<?php echo $aRow['id']; ?>">
	<?php } ?>	
	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
				<label>Name</label>
				<input type="text" required="" name="val[name]" class="form-control border-input" placeholder="Name" 
				value="<?php set_default_value('val[name]', $aRow ? $aRow['name'] : ''); ?>">
			</div>			
			
			<div class="text-left">
				<button type="submit" class="btn btn-info btn-fill btn-wd"><?php echo $bEdit ? "Update" : "Add"; ?></button>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>    
</form>
</div>