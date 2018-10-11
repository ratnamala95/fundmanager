<div class="form-group">
				<label>Code</label>
				<select required="" name="val[code]" class="form-control border-input">
					<option value="">Select Code</option>
					<?php if($aCode) {
					foreach ($aCode['codes'] as $code) {
						foreach($aAttr as $attr){
					?>
						<option value="<?php if($attr['id']==$code) echo $attr['id']; ?>"><?php if($attr['id']==$code){echo $attr['name'];} ?></option>
					<?php }}} ?>
				</select>
				
			</div>