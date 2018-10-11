<?php 
	//print_r($productrowdata);
	if (0<count($productrowdata)) {

		$count=0;
	 	foreach ($productrowdata as $productResults) {

	 	 ++$count;
	 	

	 	if ($count==1) {
	 		echo '<div class="agile_top_brands_grids">';
	 	}

	$totalGstPercent = $productResults['GST_PRICE'];	
	$orginalPrice = $productResults['sale_price'];
	$gstPrice = ($orginalPrice*$totalGstPercent)/100;	
	$salePrice= $orginalPrice+$gstPrice;
?>				

		<div class="col-md-4 top_brand_left">
			<div class="hover14 column">
				<div class="agile_top_brand_left_grid">
					<div class="agile_top_brand_left_grid_pos">
						<!--<img src="images/offer.png" alt=" " class="img-responsive">-->
					</div>
					<div class="agile_top_brand_left_grid1">
						<figure>
							<div class="snipcart-item block">
								<div class="snipcart-thumb">
									<a href="<?php  echo base_url('product/').$productResults['slug'];  ?>"><img title=" " alt=" " src="<?php if($productResults['image']) { echo base_url('assets/uploads/').$productResults['image']; } else { echo base_url('assets/images/no_pic.png'); } ?>" style="height: 122px;" class="img img-responsive" />
											
										<p><?php echo substr($productResults['name'], 0,16); ?></p>
									</a>
									<!--<h4>$35.99 <span>$55.00</span></h4>-->
									
									<h4><i class="fa fa-inr" aria-hidden="true"></i><?php echo  " ".$salePrice; ?> </h4>
								</div>
								<div class="snipcart-details top_brand_home_details">
							
								</div>
							</div>
						</figure>
					</div>
				</div>
			</div>
		</div>
	
		
<?php	 		
		if ($count%3==0) {
	 		echo '<div class="clearfix"> </div></div><div class="agile_top_brands_grids">';		
	 	}		 		

	 	}
	 }  else { 
?>		
	<div class="col-md-8"><h3>No product availabe</h3></div>

<?php } ?>

<?php 
	if (count($productrowdata)%3!=0) {
	 	echo '<div class="clearfix"> </div></div>';
	} 
?>
