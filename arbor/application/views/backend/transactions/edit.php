<?php //pr($aRow);die;?>
<div class="header">
    <h4 class="title" style="float: left;"><?php echo $title; ?></h4>
    
    <div class="clearfix">&nbsp;</div>
</div>

<?php
if($bEdit) { $aRow['inventory'] = $aRow['inventory'] ? unserialize($aRow['inventory']) : "";}
//pr($attributes);
//$size = isset($attributes['size'])  ? $attributes['size'] : array();
//$style = isset($attributes['style'])  ? $attributes['style'] : array();
//$codes = isset($attributes['codes'])  ? $attributes['codes'] : array();
?>

<div class="content">
<form method="post" enctype="multipart/form-data">
	<div class="form-group">
		<label>Warehouse:	<?php echo $aWare['name'];?></label>
	</div>
	
	<div class="form-group">
		<label>User:	<?php echo $aUsr['name'];?></label>
	</div>
	
	<div class="form-group">
		<label>Product Code:	<?php echo $aRow['product_code'];?></label>
	</div>
	
	<div class="form-group">
		<label>Order Id:	<?php echo $aRow['order_id'];?></label>
	</div>
	
	<div class="form-group">
		<label>Date:	<?php echo $aRow['date'];?></label>
	</div>
	
	<?php foreach($aRow['inventory'] as $size => $quantity){?>
	<div class="row">
	<div class="form-group col-md-5">
		<label><?php echo $aSizes[$size];?></label>
		<input type="hidden" name="val[size][]" value="<?php echo $size?>">
		<input type="text" name="val[quantity][]" class="form-control border-input" placeholder="<?php echo $quantity;?>" value="<?php echo $quantity;?>">
	</div>
	</div>
	<?php }?>
	
	<div class="text-left">
				<button type="submit" class="btn btn-info btn-fill btn-wd"><?php echo $bEdit ? "Update" : "Add"; ?></button>
			</div>
			<div class="clearfix"></div>
</form>
</div>