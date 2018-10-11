<?php //pr($aRow); ?>
<div class="content">

<form method="post">
	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
				<label>Product Code</label>
				<input type="text" readonly="" required="" name="val[card_code]" class="form-control border-input" placeholder="Product Code" value="<?php echo $aRow['card_code'] ?>">
			</div>
			<div class="form-group">
				<label>Weight</label>
				<input type="text" required="" name="val[weight]" class="form-control border-input" placeholder="Weight" value="<?php echo $aRow['weight'] ?>">
			</div>
			<div class="form-group">
				<label>Size</label>
				<input type="text" required="" name="val[size]" class="form-control border-input" placeholder="Size" value="<?php echo $aRow['size'] ?>">
			</div>
			<div class="form-group">
				<label>Price</label>
				<input type="text" required="" name="val[price]" class="form-control border-input" placeholder="Price" value="<?php echo $aRow['price'] ?>">
			</div>
			<div class="form-group">
				<label>Description</label>
				<textarea  required="" name="val[description]" class="form-control border-input"><?php echo $aRow['description'] ?></textarea>			
			</div>			
			<div class="form-group">
				<label>Video Url</label>
				<input type="text" required="" name="val[video_url]" class="form-control border-input" placeholder="Video url" value="<?php echo $aRow['video_url'] ?>">
			</div>
			<div class="form-group">
				<label>Featured</label><div class="clearfix"></div>
				<input type="radio" required="" name="val[featured]" <?php if($aRow['featured'] == 1){ echo 'checked="checked"'; } ?> value="1" > Yes 
				<input type="radio" required="" name="val[featured]" <?php if($aRow['featured'] == 0){ echo 'checked="checked"'; } ?> value="0"> No
			</div>
			<div class="form-group">
				<label>Status</label><div class="clearfix"></div>
				<input type="radio" required="" name="val[status]" <?php if($aRow['status'] == 1){ echo 'checked="checked"'; } ?> value="1" > Active 
				<input type="radio" required="" name="val[status]" <?php if($aRow['status'] == 0){ echo 'checked="checked"'; } ?> value="0"> Inactive
			</div>
			
			<div class="text-left">
				<button type="submit" class="btn btn-info btn-fill btn-wd">Update</button>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>    
</form>
</div>