<div class="form-group">
				<label>Distributor</label>
				<select required="" name="val[distributor_id]" class="form-control border-input">
					<option value="">Select Distributor</option>
					<?php if($aDist) {
					foreach ($aDist as $aWhouse) {
					?>
						<?php if($aRow) { ?>
							<option <?php if($aRow['distributor_id'] == $aWhouse['id']) { echo "selected = 'selected'"; } ?> value="<?php echo $aWhouse['id']; ?>"><?php echo $aWhouse['name']; ?></option>
						<?php } else { ?>
							<option value="<?php echo $aWhouse['id']; ?>"><?php echo $aWhouse['name']; ?></option>
						<?php } ?>	
					<?php }} ?>
				</select>
				
			</div>