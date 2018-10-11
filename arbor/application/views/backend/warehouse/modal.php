<?php //pr($data);?>

<?php foreach($data as $dat){?>
<div class="form-group">
	<input type="hidden" value="<?php echo $dat['product_name'];?>" name="val[product_id]">
	<input type="hidden" value="<?php echo $dat['warehouse_id'];?>" name="val[warehouse_id]">
	<input type="hidden" value="<?php echo $dat['code'];?>" name="val[code]">
	<label><?php echo $dat['code'];?></label>
</div>

<div class="form-group">
	<label>Sizes & Quantity</label><br>
	<?php foreach($dat['size'] as $size => $quant){?>
	<input class="single-checkbox" type="checkbox" name="val[size][]" value="<?php echo $size;?>" id="check" class="custom-control custom-checkbox" onchange="change(<?= $size; ?>)">	<?php echo $aSizes[$size]?>
	<input type="text" name="val[quantity][]" value="0" placeholder="0" class="form-control border-input <?= $size; ?>" style="width:50%;" id="quantity" disabled>
	<br>
	<?php }?>
</div>
<?php }?>
