<div class="form-group">
				<label>Category</label>
				<select required="" name="val[category]" class="form-control border-input">
					<?php if($aData) {
					foreach ($aData as $prod) {
							foreach($aCate as $cat){
					?>
						<option value="<?php if($prod['category'] == $cat['id']) echo $cat['id']; ?>" <?php if($prod['category'] == $cat['id']) echo 'selected';?>><?php if($prod['category'] == $cat['id']) echo $cat['name'];?></option>
					<?php }}} ?>
				</select>
			</div>