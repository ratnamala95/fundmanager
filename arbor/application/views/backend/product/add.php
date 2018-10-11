<div class="header">
    <h4 class="title" style="float: left;"><?php echo $title; ?></h4>
    
    <div class="clearfix">&nbsp;</div>
</div>

<?php
if($bEdit) {$attributes = $aRow['attributes'] ? unserialize($aRow['attributes']) : "";}
$size = isset($attributes['size'])  ? $attributes['size'] : array();
$style = isset($attributes['style'])  ? $attributes['style'] : array();
$codes = isset($attributes['codes'])  ? $attributes['codes'] : array();
?>

<div class="content">
<form method="post" enctype="multipart/form-data">
	<?php if($bEdit) { ?>
		<input type="hidden" name="val[id]" value="<?php echo $aRow['id']; ?>">
	<?php } ?>	
	<div class="row">
		<div class="col-md-6">


			<div class="form-group">
				<label>Category</label>
				<select required="" name="val[category]" class="form-control border-input">
					<option value="">Select category</option>
					<?php if($aCats) {
					foreach ($aCats as $aCat) {
					?>
						<?php if($aRow) { ?>
							<option <?php if($aRow['category'] == $aCat['id']) { echo "selected = 'selected'"; } ?> value="<?php echo $aCat['id']; ?>"><?php echo $aCat['name']; ?></option>
						<?php } else { ?>
							<option value="<?php echo $aCat['id']; ?>"><?php echo $aCat['name']; ?></option>
						<?php } ?>	
					<?php }} ?>
				</select>
				
			</div>

			<div class="form-group">
				<label>Name</label>
				<input type="text" required="" name="val[name]" class="form-control border-input" placeholder="Name" 
				value="<?php set_default_value('val[name]', $aRow ? $aRow['name'] : ''); ?>">
			</div>

			<div class="form-group">
				<label>Description</label>
				<textarea name="val[description]" class="form-control border-input"><?php set_default_value('val[description]', $aRow ? $aRow['description'] : ''); ?></textarea>			
			</div>

			<div class="form-group">
				<label>Image</label>
				<input type="file" name="image" class="form-control border-input" value="">
				<br>
				<?php if($aRow && $aRow['image']) { ?>
					<img src="<?php echo base_url('assets/uploads/'.$aRow['image']);?>" width="100px;">
				<?php } ?>
			</div>	

			

			<div class="form-group">
				<label>Size</label>
				<?php echo form_dropdown('val[attributes][size][]',$aSizes, $size,array("required" =>"required","multiple" => "multiple","class" => "form-control border-input")); ?>		
			</div>

			<div class="form-group">
				<label>Style</label>
				<?php echo form_dropdown('val[attributes][style][]',$aStyles, $style ,array("required" =>"required","multiple" => "multiple","class" => "form-control border-input")); ?>
			</div>	

			<div class="form-group">
				<label>Code</label>
				<?php if($bEdit) { ?>
					<input type="text" name="val[code]" value="<?php echo $aRow['code']; ?>" class="form-control border-input" placeholder="Code">
				<?php } else{?>
					<input type="text" name="val[code]" class="form-control border-input" placeholder="Code">
				<?php }?>
			</div>	
			
			<div class="form-group">
				<label class="custom-control custom-checkbox">
				Upcomming Product	<input type="checkbox" class="custom-control-input" name="val[upcomming]" value="1">
				<span class="custom-control-indicator"></span>
				<span class="custom-control-description"></span>
			</label>
			</div>
			
			<div class="form-group">
				<label>Product Status</label><br>
				<label class="switch"><?php if($bEdit) {?><input type="checkbox" id="togBtn" name="val[status]" <?php echo $aRow['status']==1?'checked value="1"':' value="0"';?>><?php } else{?>
					<input type="checkbox" id="togBtn" name="val[status]" checked value="1">
					<?php }?>	
					<div class="slider round">
						<span class="on">Active</span>
						<span class="off">Inactive</span>
					</div>
				</label>
			</div>
			
			<div class="text-left">
				<button type="submit" class="btn btn-info btn-fill btn-wd"><?php echo $bEdit ? "Update" : "Add"; ?></button>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>    
</form>
</div>