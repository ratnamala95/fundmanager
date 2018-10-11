<?php include 'include/header.php'; ?>


<?= link_tag('assets/frontend/css/product-details.css'); ?>


<?php 
$totalGstPercent = $productResults['gst'];	
$orginalPrice = $productResults['sale_price'];
$gstPrice = ($orginalPrice*$totalGstPercent)/100;	
$salePrice= $orginalPrice+$gstPrice;
$attrArrayList = unserialize($productResults['attributes']); ?>
<!-- breadcrumbs -->
	<div class="breadcrumbs">
		<div class="container">
			<div class="col-md-3">
				<ol class="breadcrumb breadcrumb1 animated wow slideInLeft" data-wow-delay=".5s">
					<li><a href="<?= base_url(); ?>"><span class="glyphicon glyphicon-home" aria-hidden="true"></span>Home</a></li>
					<li class="active">Product Details</li>
				</ol>
			</div>
		</div>
	</div>
<!-- //breadcrumbs -->


<form method="post" id="cartform">

	<input type="hidden" name="cart_pro_id" id="cart_pro_id" value="<?= $productResults['id']; ?>">
    <input type="hidden" name="cart_pro_name" value="<?= $productResults['name']; ?>">
    <input type="hidden" name="cart_pro_slug" value="<?= $productResults['slug']; ?>">
    <input type="hidden" name="cart_pro_code" value="<?= $productResults['code']; ?>">
    <input type="hidden" name="cart_pro_price" value="<?= $productResults['sale_price']; ?>">  
    <input type="hidden" name="cart_pro_image" value="<?= $productResults['image']; ?>">

<div class="container">
	<div class="card">
		<div class="container-fliud">
			<div class="wrapper row">
      
				<div class="preview col-md-4">
						
					<div class="preview-pic tab-content">
					  	<div class="tab-pane active" id="pic-1">
					  		<img class="product-image" src="<?php if($productResults['image']) { echo base_url('assets/uploads/').$productResults['image']; } else { echo base_url('assets/images/no_pic.png'); } ?>" />
					  	</div>
						<?php 
							if (isset($aRowImage) && count($aRowImage)>0) {
								$count=1;
								foreach ($aRowImage as $resImage)
								{ 	
									++$count;
						?>			
							<div class="tab-pane" id="pic-<?php echo $count; ?>"><img src="<?php echo base_url('assets/uploads/'.$resImage['img_name']); ?>" /></div>		
						<?php		
								}								
							}
						?>    	
					</div>
					<?php if (isset($aRowImage) && count($aRowImage)>0) { ?>
					<ul class="preview-thumbnail nav nav-tabs">
					  	<li class="active"><a data-target="#pic-1" data-toggle="tab"><img src="<?php if($productResults['image']) { echo base_url('assets/uploads/').$productResults['image']; } else { echo base_url('assets/images/no_pic.png'); } ?>" /></a></li>
					  	<?php							
							$count=1;
							foreach ($aRowImage as $resImage)
							{ 	
								++$count;
						?>			
							<li><a data-target="#pic-<?php echo $count; ?>" data-toggle="tab"><img src="<?php echo base_url('assets/uploads/'.$resImage['img_name']); ?>" /></a></li>
						<?php }	?>				  
					</ul> 
					<?php } ?>					
				</div>

				<div class="details col-md-8">
					<div class="row">
						<div class="col-md-6">

							<section class="product_title_box">
								<h3><?php echo $productResults['name']; ?></h3>
								<div></div>
								<span>Code : <?php echo $productResults['code']; ?></span><br>
								
							</section>
						
							<div class="col-lg-12 nopadding">

								<span class="minimum-order">Minimum Order : </span>
								<p style="margin-bottom: 15px;">1 Set = <?= $productResults['pieces_per_set']; ?> Piece </p>
																

								<?php if(isset($productResults['description']) && ''!=$productResults['description']) { ?>	
								<h3 class="product_description">Description : </h3>
								<section class="pt_description_contant">
									<p class="product-description"><?php echo substr($productResults['description'], 0,200); ?></p>

									
									<div class="clearfix"></div>
								</section>
							<?php } ?>	
							</div>												
							
						</div>



						<div class="col-md-6">
                            <div class="col-lg-6 contact_saction nopadding">    
    							<div class="payment_saction">
    								<h3>₹ <?php echo number_format($productResults['sale_price'],2); ?> / Piece &nbsp; &nbsp;<br/>
    								<span>Per Piece + GST (<?= $productResults['gst']."%"; ?>)</span>
    								<br/>
    								<span>GST Price ₹ <?= $gstPrice; ?></span>
    								</h3>
    							</div>
    						</div>	
    						<div class="col-lg-6 contact_saction nopadding">    
    							<div class="payment_saction">
    								<h3>₹ <?php echo number_format($salePrice,2); ?> / Piece with GST &nbsp; &nbsp;
    								</h3>
    							</div>
    						</div>	
							


							<table class="col-lg-12 table table-responsive set_qty_table">
							  	<thead>
							    	<tr>
							        	<th scope="col" >Size</th>
							        	<th scope="col" style="text-align: left;">Available</th>
							      		<th scope="col" style="text-align: center;">Quantity</th>
							    	</tr>
							 	</thead>
								<tbody>
									<?php 
										
										$count=0;
										$aryQtyData =unserialize($productResults['size']);
										//print_r($arySizesData);
						             
								    	foreach ($rowattrdata as $rowattrresults) {

						                    if (in_array($rowattrresults['id'], $attrArrayList['size'])) 
						                    {
						                    	$totalPieces = $aryQtyData[$rowattrresults['id']];	
						                    	$piecesPerSet = $productResults['pieces_per_set'];

						                    	
						                    	$availableSet=$totalPieces/$piecesPerSet;
						                    	
						                    	

								    		++$count;		
								    ?>

								    <input type="hidden" placeholder="size" class="productsize" name="cart_pro_size[]" value="<?php echo $rowattrresults['id']; ?>" >
								    	<tr>	
									      	<td ><?php echo $rowattrresults['name'];  ?></td>
									      	<?php if ($aryQtyData[$rowattrresults['id']]>=$productResults['pieces_per_set']) {
									      	?>
									      	<td style="text-align: left;">
						 						<?php echo number_format((int)$availableSet)." Set";  ?>
			      					      	</td>
			      					      	<?php     	
			      					      		} else {
			      					      	?>		
		      					      		<td style="text-align: left;">
								      			<span class="out-of-stock"><strong>Out of Stock</strong></span>
								      		</td>	
									      	<?php } ?>

									      	<td style="text-align: left;">
									      		<div class="col-md-12" style="height: 18px;">
					                                <div class="input-group qty-box qty-box-<?php echo $count; ?>" data-toggle="tooltip" data-placement="top" title="">
					                                    <span class="input-group-btn">
					                                        <button onclick="checkproductquantity(<?= $productResults['id']; ?>,<?php echo $rowattrresults['id']; ?>,$(this),<?php echo $count; ?>)" type="button" class="quantity-left-minus btn btn-number minus<?php echo $count; ?>"  data-type="minus" data-field="">
					                                          <span class="glyphicon glyphicon-minus"></span>
					                                        </button>
					                                    </span>
					                                    <input type="text" value="0" name="quantity[]" class="form-control input-number quantity" min="0" max="100" onkeyUp="checkproductquantitytext(<?= $productResults['id']; ?>,<?php echo $rowattrresults['id']; ?>,$(this),<?php echo $count; ?>)" />
					                                    <span class="input-group-btn plus-span">
					                                        <button onclick="checkproductquantity(<?= $productResults['id']; ?>,<?php echo $rowattrresults['id']; ?>,$(this),<?php echo $count; ?>)" type="button" class="quantity-right-plus btn btn-number plus<?php echo $count; ?>" data-type="plus" data-field="">
					                                            <span class="glyphicon glyphicon-plus"></span>
					                                        </button>
					                                    </span>
					                                </div>
					                        	</div>
					                        </td>
									    </tr>
								    <?php }  } ?>
								   
								</tbody>
							</table>
						
                            <div class="col-lg-12 nopadding">
    								<?php if($this->session->userdata("REATILER_ID")) { ?>
                 						<button onclick="addtocart()" class="add-to-cart btn btn-default btn-block" id="cartbtn" type="button">add to cart</button>
                  						<span id="noqtyspan"></span> 
                  					<?php } else { 
                  						echo '<button onclick="alert(\'Please login\'); window.location.href=\''.base_url('user/login').'\' " class="add-to-cart btn btn-default" id="cartbtn" type="button">add to cart</button>';
    
                  					 } ?>
							</div>
							
						</div>


					</div>
				</div>	

			</div>	
		</div>


 	


<!-- product details start -->





<!-- product details end -->

<?php if(isset($productResults['description']) && ''!=$productResults['description']) { ?>
  <div class="container-fluid">
        <div class="col-md-12">
    	    <div class="content-wrapper">	
    			<div class="collpse tabs">
    				<!--<h3 class="w3ls-title">About this item</h3> -->
    				<div class="panel-group collpse" id="accordion" role="tablist" aria-multiselectable="true">
    					<div class="panel panel-default">
    						<div class="panel-heading" role="tab" id="headingOne">
    							<h4 class="panel-title">
    								<a class="pa_italic collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#" aria-expanded="false" aria-controls="collapseOne">
    									<i class="fa fa-file-text-o fa-icon" aria-hidden="true"></i> Description <span class="fa fa-angle-down fa-arrow" aria-hidden="true"></span> <i class="fa fa-angle-up fa-arrow" aria-hidden="true"></i>
    								</a>
    							</h4>
    						</div>
    						 <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
    							<div class="panel-body">
    								<?php echo $productResults['description']; ?>
    							</div>
    						</div>
    					</div>
    				</div>
    			</div>
    		</div>
    	</div>	
	</div>
<?php } ?>

	</div>
</div>
</form>
<!-- product details page -->

<!-- product listing -->

<?php 
  if (0<count($productrowdata)) {
?>

<div class="products">

  <div class="container">
    <p >
      <h3 style="margin-bottom: 2em;"> Related Products </h3>
    </p>
    <div class="row">
       
      <div class="col-md-12 products-right">
        
        
        <?php 
          //print_r($productrowdata);
          

            $count=0;
            foreach ($productrowdata as $productListResults) {
             ++$count;

            if ($count==1) {
              echo '<div class="agile_top_brands_grids">';
            }

        ?>



    <div class="col-md-3 top_brand_left">
        <div class="hover14 column">
            <div class="agile_top_brand_left_grid">
                <div class="agile_top_brand_left_grid_pos">
                  <!--<img src="images/offer.png" alt=" " class="img-responsive">-->
                </div>
                <div class="agile_top_brand_left_grid1">
                 	<figure>
	                    <div class="snipcart-item block">
	                      	<div class="snipcart-thumb">
	                        

	                        	<a href="<?php echo base_url('product/').$productListResults['slug'];  ?>"><img title=" " alt=" " src="<?php if($productListResults['image']) { echo base_url('assets/uploads/').$productListResults['image']; } else { echo base_url('assets/images/no_pic.png'); } ?>" style="height: 122px;" class="img img-responsive" /><p class="product-title"><?php echo $productListResults['name']; ?></p></a>
	                        	<!--<h4>$35.99 <span>$55.00</span></h4>-->
	                        
	                        	<h4>
	                        		<?php echo  '<i class="fa fa-inr" aria-hidden="true"></i> '.$productListResults['sale_price']; ?> 
	                        		<span><?php echo  '<i class="fa fa-inr" aria-hidden="true"></i> '.$productListResults['price']; ?></span>
	                        	</h4>
	                      	</div>
	                      
	                    </div>
                  	</figure>
                </div>
            </div>
        </div>
    </div>
  
    
    <?php     
        if ($count%4==0) {
          echo '<div class="clearfix"> </div></div><div class="agile_top_brands_grids">';   
        }       

        }
       
    ?>    
     


    <?php 
      if (count($productrowdata)%4!=0) {
        echo '<div class="clearfix"> </div></div>';
      } 
    ?>



      <div class="clearfix"> </div>
      <div class="pull-right">
        <?php  echo $this->pagination->create_links('searchpagination'); ?>
      </div>  

       </div>
        
     </div>
    </div> 
  </div> 
    <?php } ?>


    <div class="clearfix"></div>

</div>  


<!-- added in cart script start -->


<?php include 'include/footer.php'; ?>