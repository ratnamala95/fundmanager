<?php $strPageTitle="search"; include 'include/header.php';  ?>

<?= link_tag('assets/frontend/css/search-view.css'); ?>

<!-- breadcrumbs -->
	<div class="breadcrumbs">
		<div class="container">
			<div class="col-md-3">
				<ol class="breadcrumb breadcrumb1 animated wow slideInLeft" data-wow-delay=".5s">
					<li><a href="<?= base_url(); ?>"><span class="glyphicon glyphicon-home" aria-hidden="true"></span>Home</a></li>
					<li class="active">Search</li>
				</ol>
			</div>
		</div>
	</div>
<!-- //breadcrumbs -->


<!-- products -->
	<div class="products">
		<div class="container">
			<?php include 'include/side-filter-bar.php'; ?>
			<div class="col-md-9 products-right">
				<div class="col-sm-12 ps-sort-list">
					<ul>
					  <li class="ps-li-first"><a ><h4>Sort By :</h4> </a></li>
					  <li><a href="javascript:void(0)" onclick="filterbyprice(1,$(this));" >Price (High to Low)</a></li>
					  <li><a href="javascript:void(0)" onclick="filterbyprice(2,$(this));" >Price (Low to High)</a></li>
					  
					</ul>

					<div class="clearfix"></div>
					<hr>
				</div>
				
        		<span id="product-div">
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
												<a href="<?php echo base_url('product/').$productResults['slug'];  ?>"><img title=" " alt=" " src="<?php if($productResults['image']) { echo base_url('assets/uploads/').$productResults['image']; } else { echo base_url('assets/images/no_pic.png'); } ?>" style="height: 122px;" class="img img-responsive" />
														
												<p><?php echo substr($productResults['name'], 0,16); ?></p>
												</a>
												<!--<h4>$35.99 <span>$55.00</span></h4>-->
												
												<h4>
													<?php echo  '<i class="fa fa-inr" aria-hidden="true"></i>'.$salePrice; ?> 
													
 												</h4>
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
			<div class="col-md-8"><h4>No product availabe</h4></div>

		<?php } ?>

		<?php 
			if (count($productrowdata)%3!=0) {
			 	echo '<div class="clearfix"> </div></div>';
			} 
		?>
</span>


<div class="clearfix"> </div>

			<?php  echo $this->pagination->create_links('searchpagination'); ?>


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
			<div class="clearfix"> </div>
		</div>
	</div>
<!-- products -->


<script type = "text/javascript" language = "javascript">
   	
            $.post("result.php", { name: "Zara" },function(data) {
                 $('#stage').html(data);
            });
				
      
</script>




<?php include 'include/footer.php'; ?>