<?php $strPageTitle="Home"; include 'include/header.php'; ?>


	
	<?php include 'include/slider.php'; ?>
	<!-- //top-header and slider -->

	<!-- top-brands -->
	<div class="top-brands">
		<div class="container">
			
		<h2 style="margin-top: 1.1em;" >Top Products</h2>
			<div class="grid_3 grid_5">
				<div class="bs-example bs-example-tabs" role="tabpanel" data-example-id="togglable-tabs">
					<!--<ul id="myTab" class="nav nav-tabs" role="tablist">
						<li role="presentation" class="active"><a href="#expeditions" id="expeditions-tab" role="tab" data-toggle="tab" aria-controls="expeditions" aria-expanded="true">Advertised offers</a></li>
						<li role="presentation"><a href="#tours" role="tab" id="tours-tab" data-toggle="tab" aria-controls="tours">Today Offers</a></li>
					</ul>-->
					<div id="myTabContent" class="tab-content">
						<div role="tabpanel" class="tab-pane fade in active" id="expeditions" aria-labelledby="expeditions-tab">
							
					<?php 
						//echo "<pre>";
						//print_r($productRowData);
						$count=0;
						if (0<count($productRowData)) {
							foreach ($productRowData as $productResults) {

							$count++;
							
							//echo 2*$count;

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
								<!--<img src="<?php echo base_url(); ?>assets/frontend/images/offer.png" alt=" " class="img-responsive" />-->
							</div>
							<div class="agile_top_brand_left_grid1">
								<figure>
									<div class="snipcart-item block" >
										<div class="snipcart-thumb">
											<a href="<?php echo base_url('product/').$productResults['slug']; ?>"><img title=" " alt=" " src="<?php if($productResults['image']) { echo base_url('assets/uploads/').$productResults['image']; } else { echo base_url('assets/images/no_pic.png'); } ?>" style="height: 156px;" class="img img-responsive" />	
											<p class="product-title"><?php echo  $productResults['name']; ?></p></a>
											<!--<div class="stars">
												<i class="fa fa-star blue-star" aria-hidden="true"></i>
												<i class="fa fa-star blue-star" aria-hidden="true"></i>
												<i class="fa fa-star blue-star" aria-hidden="true"></i>
												<i class="fa fa-star blue-star" aria-hidden="true"></i>
												<i class="fa fa-star gray-star" aria-hidden="true"></i>
											</div>-->
											<!--<h4>$20.99 <span>$35.00</span></h4>-->
											<h4><?php echo  '<i class="fa fa-inr" aria-hidden="true"></i>
											'.$salePrice; ?><!-- <span><?php echo  '
											<i class="fa fa-inr" aria-hidden="true"></i>
											 '.$productResults['price']; ?></span> --></h4>
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
					}else {
						echo '<div class="col-md-4 top_brand_left">
									<h4> No Product Found... </h4></div>';
					} 

					?>
					<?php 
						if (count($productRowData)%3!=0) {
							echo '<div class="clearfix"> </div></div>';
						} 
					?>
							
						
					
					</div>
<!-- paginatio code start here -->
					<?php //echo $this->pagination->create_links(); ?>
<!-- paginatio code end here -->
				<!--<nav class="numbering">
					<ul class="pagination paging">
						<li>
							<a href="#" aria-label="Previous">
								<span aria-hidden="true">&laquo;</span>
							</a>
						</li>
						<li class="active"><a href="#">1<span class="sr-only">(current)</span></a></li>
						<li><a href="#">2</a></li>
						<li><a href="#">3</a></li>
						<li><a href="#">4</a></li>
						<li><a href="#">5</a></li>
						<li>
							<a href="#" aria-label="Next">
							<span aria-hidden="true">&raquo;</span>
							</a>
						</li>
					</ul>
				</nav>-->


				</div>
			</div>
		</div>
	</div>
	<br /><br />
<!-- //top-brands -->




</div>

<?php include 'include/footer.php'; ?>