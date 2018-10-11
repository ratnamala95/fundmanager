	
<div class="container">
	<div class="row">
		<div class="col-md-10">
			<div class="header">
			    <h4 class="title" style="float: left;"><?php echo $title; ?></h4>
			</div>	
		</div>	
		<div class="clearfix"></div>

		<div class="col-md-6">
			<!-- Nav tabs -->
			<!-- <ul class="nav nav-tabs" role="tablist">
			    <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Place order Himself</a></li>
			    <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Place order for Retailer</a></li>
			</ul>
 -->
			<!-- Tab panes -->
			<div class="tab-content content">
				<!-- Place order Himself -->
			    <div role="tabpanel" class="tab-pane active" id="home">
			    	<div class="row">
			    		<div class="co-md-6 col-md-offset-1">
			    			

			    		<form method="post" action="<?php echo getSiteUrl('placeorder/order') ?>">
			    			<div class="form-group">
								<label>Place order for</label><br>
								<select class="form-control border-input" required="required" name="placeorderfor" id="placeorderfor">
									<option value="">Place order</option>
									<option value="1">Place order for himself</option>
									<option value="2">Place order for Retailer</option>
								</select>
							</div>


							<div class="form-group retailer-div">
								<label>Choose Retailer</label><br>
								<select class="form-control border-input" required="required" id="retailer-id" name="retailerId">
									<option value="">Select Retailer</option>
									<?php 
										if (!empty($aRowRetailer)) {
											foreach ($aRowRetailer as  $resultRetailerData) {
												echo '<option value="'.$resultRetailerData['id'].'">'.$resultRetailerData['name'].'</option>';
											}
										}
									?>
									
								</select>
							</div>


							<div class="form-group">
								<label>Product</label><br>
								<select class="form-control border-input" required="required"  onchange="findRelatedProductData($(this))">
									<option value="">Select Product</option>
									<?php 
									if (isset($aRowProduct) && count($aRowProduct)>0) {
										foreach($aRowProduct as $aResultProduct){
										
									?>
									<option value="<?php echo $aResultProduct['id']; ?>"><?php echo $aResultProduct['name']; ?></option>
									<?php } } ?>	
								</select>
							</div>
						<span id="html-data">
										
							<div class="form-group">
								<label>Product code</label>
								<input type="text" required="" class="form-control border-input" placeholder="Product code" 
								value="" disabled="disabled">
							</div>
							<div class="form-group">
								<label>Pieces per set</label>
								<input type="text" required="" class="form-control border-input" placeholder="Pieces per set" 
								value="" disabled="disabled">
							</div>
							<div class="form-group">
								<label>GST in Percent</label>
								<input type="text" required="" class="form-control border-input" placeholder="GST in percent" value="" disabled="disabled">
							</div>

							<div class="form-group">
								<label>Product price</label>
								<input type="text" required="" class="form-control border-input" placeholder="price" value="" disabled="disabled">
							</div>

							<div class="form-group">
								<label>choose Size</label>
								<select class="form-control border-input" required="required" name="size">
									<option value="">Select Size</option>
								</select>	
							</div>							
						</span>	

						<span id="choose-dty-div">
							<div class="form-group">
								<label>choose Qty</label>
								<select class="form-control border-input" required="required" name="qty">
									<option value="">Select Quantity</option>
								</select>	
								
							</div>
						</span>	


						<span id="price-div">
							<div class="form-group">
								<label>Sub total Price</label>
								<input type="text" required="" class="form-control border-input" placeholder="Sub total" value="" disabled="disabled">
							</div>
							<div class="form-group">
								<label>GST Price</label>
								<input type="text" required="" class="form-control border-input" placeholder="GST Price" value="" disabled="disabled">
							</div>
							<div class="form-group">
								<label>Grand Total Price</label>
								<input type="text" required="" class="form-control border-input" placeholder="Grand Total Price" value="" disabled="disabled">
							</div>
						</span>	





							<div class="form-group">
								<div class="text-left">
									<button type="submit" class="btn btn-info btn-fill btn-wd">Place Order</button>
								</div>
							</div>
						</form>	
			    		</div>
			    	</div>			    	
			    </div>
			    <!-- Place order for Retailer -->
			   
			   
			</div>
		</div>
	</div>
</div>	
<script type="text/javascript">
	function findRelatedProductData(obj) {		
		var inventoryId = obj.val(); 
		var datastring = 'inventoryId='+inventoryId;
		$.post('<?php echo getSiteUrl('placeorder/ajxdata'); ?>', datastring , function( response ) {
			var results = jQuery.parseJSON(response);
            if (results.status==1) {
               $("#html-data").html(results.message);
            } 
		});
	}
	function qtyfind(obj,inventoryId) {
		var sizeId =obj.val(); 
		var datastring = 'sizeId='+sizeId+'&inventoryId='+inventoryId;
		$.post('<?php echo getSiteUrl('placeorder/ajxqtyfind'); ?>', datastring , function( response ) {
			var results = jQuery.parseJSON(response);
            if (results.status==1) {
               $("#choose-dty-div").html(results.message);
            } 
		});
	}

	function findprice(obj,inventoryId) {
		var qty =obj.val(); 
		var datastring = 'qty='+qty+'&inventoryId='+inventoryId;
		$.post('<?php echo getSiteUrl('placeorder/ajxpricefind'); ?>', datastring , function( response ) {
			var results = jQuery.parseJSON(response);
            if (results.status==1) {
               $("#price-div").html(results.message);
            } 
		});
	}

	$(function(){
		$(".retailer-div").hide();
		$("#placeorderfor").change(function(){
			if ($(this).val()==2) {
				$(".retailer-div").show();
				$("#retailer-id").attr('required','required');
			} else {
				$(".retailer-div").hide();
				$("#retailer-id").removeAttr('required');
			}
		});
	});	

</script>