<?php //pr($aRows); ?>
<div class="content">

<form method="post">
	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
				<label>Site Email</label>
				<input type="email" required="" name="val[site_email]" class="form-control border-input" placeholder="Site Email"
				value="<?php echo $this->Dbaction->getSettingByKey('site_email'); ?>">
			</div>	
					
			<div class="text-left">
				<button type="submit" class="btn btn-info btn-fill btn-wd">Save Setting</button>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>    
</form>
</div>