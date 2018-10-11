<?php //pr($aRow);//die;?>
<div class="header">
 <h4 class="title" style="float: left;"><?php echo $title; ?></h4>

 <div class="clearfix">&nbsp;</div>
</div>

<div class="content">
<form method="post" enctype="multipart/form-data" id="update">
		<?php if($bEdit && isset($aRow)) { ?>
		<input type="hidden" name="val[id]" value="<?php echo $aRow['id']; ?>">
		<?php } ?>
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
				<?php if($aRow) { ?>
					<input type="hidden" name="val[product_name]" value="<?php echo $aRow['product_name']; ?>">
				<?php } elseif($aPro){?>
					<input type="hidden" name="val[product_name]" value="<?php echo $aPro['id']; ?>">
				<?php }?>

				</div>

				<div class="form-group">
				<?php if($aRow) { ?>
					<input type="hidden" name="val[category]" value="<?php echo $aRow['category']; ?>">
				<?php } elseif($aPro){?>
					<input type="hidden" name="val[category]" value="<?php echo $aPro['category']; ?>">
				<?php }?>
				</div>
				<div class="form-group">
					<?php if($bEdit){?>
					<label><strong><h3><?php echo $aRow['code'];?></h3></strong></label>
					<input type="hidden" name="val[code]" value="<?php echo $aRow['code'];?>">
					<?php } else{?>
				<?php }?>
				</div>

				<div class="form-group" >
				<?php if($bEdit) { ?>

					<input type="hidden" name="val[warehouse_id]" class="form-control border-input" value="<?php echo $aRow['warehouse_id'];?>">
				<?php } else{?>
					<label>Warehouse</label>
					<select name="val[warehouse_id]" class="form-control border-input" required="required">
						<option value="">Select Warehouse</option>
						<?php foreach($aWare as $ware){?>
						<option value="<?php echo $ware['id']?>"><?php echo $ware['name']?></option>
						<?php }?>
					</select>
				<?php }?>

				</div>

				<?php if(!$bEdit){?>
				<div class="form-group">
					<label>Product</label><br>
					<select class="form-control border-input product" name="val[product_name]" required="required">
						<option value="">Select Product</option>
						<?php foreach($aProdu as $id => $name){
								if($id!=''){
						?>
						<option value="<?php echo $id;?>"><?php echo $name;?></option>
						<?php }}?>
					</select>
				</div>
				<?php }?>

				<div class="form-group">
					<label>Pieces per set</label>
					<input type="number" name="val[pieces_per_set]" class="form-control border-input" placeholder="Pieces per set" value="<?php if(isset($aRow['pieces_per_set']) && ''!=$aRow['pieces_per_set']) { echo $aRow['pieces_per_set']; } ?>" required="required">

				</div>

				<div class="form-group">
				<?php if($bEdit) { ?>
					<label>Sizes</label><br>
				<?php foreach($row['size'] as $size => $val){
				?>
					<label><?php echo $aSizes[$val]; ?></label>
					<input type="text" name="val[size][]" class="form-control border-input" value="0" placeholder="Quantity">
				<?php }?>
				<?php }?>
				</div>
				<?php if(!$bEdit){?>
					<div class="form-group" id="size">
						<label>Sizes</label><br>
						<input type="text" class="form-control border-input" placeholder="Enter Size">
					</div>
				<?php }?>

				<div class="form-group">
					<label>GST per piece</label>
					<?php if($bEdit){?>
						<input type="number" class="form-control border-input" placeholder="Enter gst% per piece" name="val[gst]" value="<?php echo $aRow['gst'];?>">
					<?php }else{?>
						<input type="number" class="form-control border-input" placeholder="Enter gst% per piece" name="val[gst]">
					<?php }?>
				</div>

				<!-- <div class="form-group">
					<label>Price</label>
					<input type="text"  name="val[price]" class="form-control border-input" placeholder="0.00	" value="<?php if($aRow) echo $aRow['price'];?>">
				</div> -->

				<div class="form-group">
					<label>Sale Price</label>
					<input type="text" required="" name="val[sale_price]" class="form-control border-input" placeholder="0.00" value="<?php if($aRow) echo $aRow['sale_price'];?>">
				</div>




				<div class="text-left">
					<button type="submit" class="btn btn-info btn-fill btn-wd"><?php echo $bEdit ? "Update" : "Add"; ?></button>
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
</form>
</div>
