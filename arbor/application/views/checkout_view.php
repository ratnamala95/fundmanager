<?php include 'include/header.php'; ?>



<?= link_tag('assets/frontend/css/checkout-style.css'); ?>

<!-- breadcrumbs -->
    <div class="breadcrumbs">
        <div class="container">
            <div class="col-md-3">
                <ol class="breadcrumb breadcrumb1 animated wow slideInLeft" data-wow-delay=".5s">
                    <li><a href="<?= base_url(); ?>"><span class="glyphicon glyphicon-home" aria-hidden="true"></span>Home</a></li>
                    <li class="active">Cart</li>
                </ol>
            </div>
        </div>
    </div>
<!-- //breadcrumbs -->


<div class="container">
   <div class="card shopping-cart">
            <div class="card-header bg-dark text-light">
                <span><i class="fa fa-shopping-cart" aria-hidden="true"></i>
                Shipping cart</span>
                <a href="<?= base_url('search'); ?>" class="btn btn-outline-info btn-sm pull-right" style="margin-top: -6px; margin-right: -20px;color: rgb(249,204,46);">Continue shopping</a>
                <div class="clearfix"></div>
            </div>
    <?php if($cartproduct) { ?>            
            <div class="card-body">
    <?php //echo form_open("cart/updatecart",['method'=>'post']); ?>  
    <?php echo form_open("",['method'=>'post','id'=>'formcart']); ?>  

		<?php $i = 1; $subTotal=0; $gstTotalPrice = 0; $grandTotal=0; ?>
		<?php 
        $total=0;
        $cnt=0;
        $count=0;
        foreach ($cartproduct as $items):            
            
            if ( $cnt++ >= 1) {
                //echo "<hr>";
            }

            $arysize = unserialize($items['cart_pro_size']);
            foreach ($arysize as $key => $value) {

                if ($value>0) {   

                $quantity =$value;
                                 
                $dataattr = $this->Dbaction->getData('attributes',[ 'id'=>$key ]); 

                ++$count;

                if (isset($dataattr['name'])) {

                //print_r($arysize);
                $sizeId = $dataattr['id'];
                $sizeName = $dataattr['name'];

            $piecesPerSet = $items['pieces_per_set'];   
            $total= ($piecesPerSet*$quantity) * $items['cart_pro_price'];
            $subTotal= $total + $subTotal;
            
            $gstPrice = ($total*$items['gst'])/100;
            $gstTotalPrice = $gstTotalPrice + $gstPrice;           
        ?>	

			

            <input type="hidden" name="cart_id[]" value="<?php echo $items['cart_id']; ?>">
            <input type="hidden" name="cart_pro_id[]" value="<?php echo $items['cart_pro_id']; ?>">
            <input type="hidden" name="cart_pro_size[]" value='<?php echo $items['cart_pro_size']; ?>'>

			              <!-- PRODUCT -->
                    <div class="row" id="<?= $items['cart_id']; ?>" style="border-bottom: 1px solid rgb(230, 230, 230); padding: 31px;">
                        

                        <div class="col-12 col-sm-12 col-md-1 text-center">
                            <img class="img-responsive" src="<?php echo base_url('assets/uploads/').$items['cart_pro_image']; ?>" alt="prewiew" width="120" height="80">
                        </div>

                        <div class="col-12 text-sm-center col-sm-12 text-md-left col-md-3" style="margin-top: 5px;">
                            
                            <a href="<?php echo base_url('product/'.$items['cart_pro_slug']); ?>"><h4 class="product-name"><strong><?php echo $items['cart_pro_name']; ?></strong></h4></a>
                           
                            <h4>
                                <small>Product description</small>    
                                <p><small><strong>Code - </strong> 
                                    <?php echo  $items['cart_pro_code'];  ?>
                                </small></p>
                                <p><small><strong>Size - </strong> 
                                    <?php echo  $sizeName;  ?>
                                </small></p>
                                <p><small><strong>Set - </strong> 
                                    <?php echo  '1 Set = '.$piecesPerSet.' piece';  ?>
                                </small></p>
                            </h4>    

                        </div>


                        <div class="col-12 col-sm-12 col-md-2 text-left" style="margin-top: 7px;">
                            <span><?php echo '<span class="fa fa-inr"></span> '.$items['cart_pro_price'].' / piece'; ?></span>
                            <p>GST(<?php echo $items['gst'].'%'; ?>)</p>
                            <p>GST Price <strong>₹ <?= $gstPrice; ?></strong></p>
                        </div>




                        <div class="col-12 col-sm-12 text-sm-center col-md-6 text-md-right row" style="margin-top: 10px;">

                            <!--<div class="col-3 col-sm-3 col-md-3 text-md-right gst-price">

                                <span class="gst-price"><?php echo '<span class="fa fa-inr"></span> '.number_format($gstPrice,2).' GST'; ?></span>
                                
                            </div>-->


                            <div class="col-3 col-sm-3 col-md-4 text-md-right ps-product-price">
                                <span class="price"><?php echo '<span class="fa fa-inr"></span> '.number_format($total,2); ?> 
                                </span>
                                
                            </div>




                            <div class="col-4 col-sm-4 col-md-4 text-right ps-product_qty">

                                    <div class="input-group qty-box-<?php echo $count; ?>" data-toggle="tooltip" data-placement="top" title="Update quantity">
                                        <span class="input-group-btn">
                                            <button type="button" onclick="checkquantity(<?php echo $items['cart_id']; ?>,<?php echo $items['cart_pro_id']; ?>,<?php echo $sizeId; ?>,$(this),<?php echo $count; ?>)" class="quantity-left-minus btn btn-number minus<?php echo $count; ?>" data-type="minus" data-field="">
                                              <span class="glyphicon glyphicon-minus"></span>
                                            </button>
                                        </span>
                                        <input type="text" value="<?php echo $quantity; ?>" name="quantity[]" class="form-control input-number quantity" min="1" max="100" onkeyUp="checkquantitytext(<?php echo $items['cart_id']; ?>,<?php echo $items['cart_pro_id']; ?>,<?php echo $sizeId; ?>,$(this),<?php echo $count; ?>)">
                                        <span class="input-group-btn plus">
                                            <button type="button" onclick="checkquantity(<?php echo $items['cart_id']; ?>,<?php echo $items['cart_pro_id']; ?>,<?php echo $sizeId; ?>,$(this),<?php echo $count; ?>)" class="quantity-right-plus btn btn-number plus<?php echo $count; ?>" data-type="plus" data-field="">
                                                <span class="glyphicon glyphicon-plus"></span>
                                            </button>
                                        </span>
                                    </div>
                                                

                            </div>
                            

                          
                            <div class="col-2 col-sm-2 col-md-4 text-right" style="margin-top: -8px;">
                                <button type="button" attr="" onclick="removecart('<?= $items['cart_id']; ?>',<?php echo $sizeId; ?>)" class="btn btn-outline-danger btn-xs delete-cart-items">
                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                </button>
                            </div>

                        </div>

                </div>

                    
                    <!-- END PRODUCT -->
        <?php $i++; ?>            
        <?php } } } endforeach; ?>         

                   
                <!--<div class="pull-right">
                    <button type="button" class="btn btn-outline-secondary pull-right" onclick="updatecart();">Update shopping cart</button>
                </div>-->
	<?php echo form_close(); ?>    
            </div>


            <div class="card-footer" style="margin-top: -21px;">
                <div class="totals">
                    <div class="totals-item">
                      <label>Subtotal</label>
                      <div class="totals-value" id="cart-subtotal"><i class="fa fa-inr" aria-hidden="true"></i> <span id="subtotalprice" ><?php echo number_format($subTotal,2) ; ?></span></div>
                    </div>
                    <div class="totals-item">
                      <label>GST</label>
                      <div class="totals-value total-gst" id="cart-tax"><i class="fa fa-inr" aria-hidden="true"></i> <?php echo number_format($gstTotalPrice,2) ; ?></div>
                    </div>
                    <!--<div class="totals-item">
                      <label>Shipping</label>
                      <div class="totals-value" id="cart-shipping">15.00</div>
                    </div>-->
                    <div class="totals-item totals-item-total">
                      <label>Grand Total</label>
                      <div class="totals-value total-price" id="cart-total"><i class="fa fa-inr" aria-hidden="true"></i> <?php echo number_format(($gstTotalPrice+$subTotal),2) ; ?></div>
                    </div>
                </div>
            </div>

        
            <div class="card-footer">
                <div class="row">
                    <div class="coupon col-md-5 col-sm-5 no-padding-left pull-left">
                       <!--<button type="button" id="clear_shopping_cart" class="btn btn-warning">Clear shopping cart</button>-->
                    </div>
                    <div class="pull-right" style="margin: 10px">

                        <a href="<?php echo base_url('checkout'); ?>" class="btn btn-outline-success pull-right">Checkout</a>
                       
                    </div>
                </div>
               
            </div>

    <?php } else { echo ' <div class="row"><div class="col-sm-12 col-md-12 text-center"><h2>No items in cart</h2></div></div>'; } ?>        

    </div>

</div>

<br/>
 
<?php include 'include/footer.php'; ?>