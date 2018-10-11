<?php //pr($aWare);?>
						<div class="header">
								<h4 class="title" style="float: left;"><?php echo $title; ?></h4>

								<div class="clearfix">&nbsp;</div>
						</div>


							<div class="content ">
								<form method="post" enctype="multipart/form-data">
									<div class="row">
										<div class="col-md-12">

											<div class="form-group col-md-6">
												<label>Warehouse</label>
												<select id="warehouse" required="" name="val[warehouse_id]" class="form-control border-input warehouse">
													<option value="">Select Warehouse</option>
													<?php foreach ($aWare as $id => $name) {
														if($id!='' && $id!= $aUsr['id']){
													?>
														<option value="<?php echo $id; ?>"><?php echo $name; ?></option>
													<?php }} ?>
												</select>

											</div>

											<div class="content table-responsive" id="products">
											</div>

											<div class="clearfix"></div>
										</div>
									</div>    
								</form>
							</div>