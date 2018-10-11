<?php //pr($aRow);?>
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

      <?php if($bEdit) {?>
        <input type="hidden" name="val[warehouse_id]" value="<?php echo $aRow['warehouse_id']; ?>">
      <?php }else{ ?>
			<div class="form-group">
				<label>Warehouse</label>
				<select id="warehouse" required="" name="val[warehouse_id]" class="form-control border-input ware">
					<?php if(!$aDists) { ?><option value="">Select Warehouse</option><?php } ?>

					<?php if($currWare) { ?>
					<option value="<?php echo $currWare['id'];?>" selected><?php echo $currWare['name'];?></option>
					<?php } else { ?>
					<?php if($aWhouses) {
					foreach ($aWhouses as $aWhouse) {
					?>
						<?php if($aRow) { ?>
							<option <?php if($aRow['warehouse_id'] == $aWhouse['id']) { echo "selected = 'selected'"; } ?> value="<?php echo $aWhouse['id']; ?>"><?php echo $aWhouse['name']; ?></option>
						<?php } else { ?>
							<option value="<?php echo $aWhouse['id']; ?>"><?php echo $aWhouse['name']; ?></option>
						<?php } ?>
					<?php } } } ?>

				</select>
			</div>
    <?php } ?>

      <?php if($bEdit){ ?>
        <input type="hidden" name="val[distributor_id]" value="<?php echo $aRow['distributor_id']; ?>">
      <?php } else { ?>
			<div class="form-group">
				<label>Distributor</label>
				<select id="dist" required="" name="val[distributor_id]" class="form-control border-input">
					<?php if($currWare) echo"<option value=''>Select Distributor</option>";?>
					<?php if($aRow){
							foreach($aDists as $dist){?>
					<option value="<?php echo $dist['id'];?>" <?php if($aRow['distributor_id'] == $dist['id']) echo 'selected'?>><?php echo $dist['name']?></option>
					<?php } } else if($aDists) {
						foreach($aDists as $dist){?>
						<option value="<?php echo $dist['id'];?>" <?php if(!$currWare) echo 'selected'?>><?php echo $dist['name']?></option>
					<?php } } ?>
				</select>

			</div>
    <?php } ?>

			<div class="form-group">
				<label>Name</label>
				<input type="text" required="" name="val[name]" class="form-control border-input" placeholder="Name"
				value="<?php set_default_value('val[name]', $aRow ? $aRow['name'] : ''); ?>">
			</div>

			<div class="form-group">
				<label>Email</label>
				<input type="email" required="" name="val[email]" class="form-control border-input" placeholder="Email"
				value="<?php set_default_value('val[email]', $aRow ? $aRow['email'] : ''); ?>">
			</div>

			<div class="form-group">
				<label>Credit Limit</label>
				<input type="text" required="" name="val[credit_limit]" class="form-control border-input" placeholder="Credit Limit"
				value="<?php set_default_value('val[credit_limit]', $aRow ? $aRow['credit_limit'] : ''); ?>">
			</div>

      		<div class="form-group">
				<label>GST Number</label>
				<input type="text" required="" name="val[gst]" class="form-control border-input" placeholder="GST Number"
				value="<?php set_default_value('val[gst]', $aRow ? $aRow['gst'] : ''); ?>">
			</div>

			<div class="form-group">
				<label>Phone Number</label>
				<input type="tel" required="" name="val[phNum]" class="form-control border-input" placeholder="Phone Number"
				value="<?php set_default_value('val[phNum]', $aRow ? $aRow['phNum'] : ''); ?>">
			</div>

			<div class="form-group">
				<label>Mobile Number</label>
				<input type="tel" required="" name="val[mobNum]" class="form-control border-input" placeholder="Mobile Number"
				value="<?php set_default_value('val[mobNum]', $aRow ? $aRow['mobNum'] : ''); ?>">
			</div>

			<div class="form-group">
				<label>Adress</label>
				<textarea name="val[address]" class="form-control border-input" placeholder="Address"><?php set_default_value('val[address]', $aRow ? $aRow['address'] : ''); ?></textarea>
			</div>
			<div class="form-group">
				<label>City</label>
				<select class="form-control border-input" name="val[city_id]">
					<option val="">Select City</option>
					<?php
						if (isset($aCities) && count($aCities)>0) {
							foreach ($aCities as $cityName) {
								$strSelected="";
								if (isset($aRow['city_id']) && ''!=$aRow['city_id'] && $aRow['city_id']==$cityName['id']) {
									$strSelected="selected='selected'";
								}
					?>
						<option value="<?php echo $cityName['id']; ?>" <?php echo $strSelected; ?> ><?php echo $cityName['name']; ?></option>

					<?php
							}
						}
					?>
				</select>
			</div>
			<?php if($aUsr['role'] == RETAILER_ROLE) { ?>
			<div class="form-group">
				<label>Image</label>
				<input type="file" name="image" class="form-control border-input" value="">
				<br>
				<?php if($aRow && $aRow['image']) { ?>
					<img src="<?php echo base_url('assets/uploads/'.$aRow['image']);?>" width="100px;">
				<?php } ?>
			</div>
			<?php } ?>

			<?php if(!$bEdit) { ?>
			<div class="form-group">
				<label>Password</label>
				<input type="password" required="" name="val[password]" class="form-control border-input" placeholder="Password"
				value="<?php set_default_value('val[email]', $aRow ? $aRow['password'] : ''); ?>">
			</div>
			<?php } ?>


			<div class="text-left">
				<button type="submit" class="btn btn-info btn-fill btn-wd"><?php echo $bEdit ? "Update" : "Add"; ?></button>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>
</form>
</div>
