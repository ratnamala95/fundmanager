<?php //pr($row);die;?>
<div class="form-group">
	<label>Enter number of pieces available for each size!!</label><br>
	<?php if($row != ''){foreach($row['attributes']['size'] as $key => $size){?>
	<label><?php echo $aSizes[$size];?></label>
	<input type="text" name="val[size][]" class="form-control border-input" value="0">
	<?php }?>
	<input type="hidden" name="val[code]" value="<?php echo $row['code']?>">
<?php } ?>
</div>
