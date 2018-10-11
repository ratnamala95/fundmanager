<?php include 'include/header.php'; ?>
<!-- breadcrumbs -->
    <div class="breadcrumbs">
        <div class="container">
            <div class="col-md-3">
                <ol class="breadcrumb breadcrumb1 animated wow slideInLeft" data-wow-delay=".5s">
                    <li><a href="<?= base_url(); ?>"><span class="glyphicon glyphicon-home" aria-hidden="true"></span>Home</a></li>
                    <li class="active">Checkout</li>
                </ol>
            </div>
        </div>
    </div>
<!-- //breadcrumbs -->




<div class='container'>
    <div class='row' style='padding-top:25px; padding-bottom:25px;'>
        <div class='col-md-12'>
            <div id='mainContentWrapper'>
                <div class="col-md-8 col-md-offset-2">
                    <h2 style="text-align: center;">
                        Review Your Order & Complete Checkout
                    </h2>
                    <hr/>
                    <a href="<?= base_url('search'); ?>" class="btn btn-info" style="width: 100%;">Add More Products & Services</a>
                    <hr/>

                    <?php if (validation_errors()) {
                                    	echo ' <div class="alert alert-danger"> '. validation_errors() .' </div> ';
                                    } ?>   


                    <div class="shopping_cart">
                        <form class="form-horizontal" role="form" action="<?= base_url('checkout/transaction'); ?>" method="post" id="payment-form">
                            <div class="panel-group" id="accordion">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">Review
                                                Your Order</a>
                                        </h4>
                                    </div>
                                    <div id="collapseOne" class="panel-collapse collapse in">
                                        <div class="panel-body">
                                            <div class="items">
                                            <?php if($cartproduct) { ?>	
                                                <div class="col-md-9">
                                                    <table class="table table-striped">

                                            <?php 
                                                $gstTotalPrice=0;
                                            	$count=0; 
                                                $subTotal=0;
                                                $total=0;
                                            	foreach ($cartproduct as $items): 
                                                
                                                $piecesPerSet = $items['pieces_per_set'];   
                                                
                                                $total = ($piecesPerSet*$items['cart_pro_qty']) * $items['cart_pro_price'];
                                                $subTotal= $subTotal + $total;
                                            	$count++;	
                                                

                                                $gstPrice = ($total*$items['gst'])/100;
                                                $gstTotalPrice = $gstTotalPrice + $gstPrice;
                                            ?>
                                                                                                      	
                                        <tr>
                                            <td colspan="2">
                                                <!--<a class="btn btn-warning btn-sm pull-right"
                                                   href="#"
                                                   title="Remove Item">X</a>-->
                                                <b class="pull-right">
                                                    <i class="fa fa-inr" aria-hidden="true"></i><?php echo " ".number_format($total); ?></b>   
                                                <b><?php echo $count.". ".$items['cart_pro_name']; ?></b>
                                            </td>
                                        </tr>

                                                   

                                        <input type="hidden" name="id[]" value="<?= $items['cart_pro_id'] ?>">

                                        <input type="hidden" name="name[]" value="<?= $items['cart_pro_name'] ?>">
                                        <input type="hidden" name="code[]" value="<?= $items['cart_pro_code'] ?>">
                                        <input type="hidden" name="size[]" value='<?= $items['cart_pro_size'] ?>'>
                                        <input type="hidden" name="qty[]" value="<?= $items['cart_pro_qty'] ?>">
                                        <input type="hidden" name="price[]" value="<?= $items['cart_pro_price'] ?>">
                                        <input type="hidden" name="sub_total[]" value="<?php echo $total; ?>">

                                                     <?php endforeach ?>    	

                                                        <!--<tr>
                                                            <td>
                                                                <ul>
                                                                    <li>One Job Posting Credit</li>
                                                                    <li>Job Distribution*</li>
                                                                    <li>Social Media Distribution</li>
                                                                </ul>
                                                            </td>
                                                            <td>
                                                                <b>$147.00</b>
                                                            </td>
                                                        </tr>-->
                                                    </table>
                                                </div>
                                               <?php //echo $gstTotalPrice; ?> 
                                                <div class="col-md-3">
                                                    <div style="text-align: center;">
                                                        <h3>Order Total</h3>
                                                        <h3><span style="color:green;"> <i class="fa fa-inr" aria-hidden="true"></i>
                                                            <?php  echo number_format(($subTotal+$gstTotalPrice),2).' With GST'; ?> </span></h3>
                                                            <input type="hidden" name="total" value="<?php echo ($subTotal+$gstTotalPrice); ?>">

                                                    </div>
                                                </div>
                                            <?php } ?>    
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">

                                        <div style="text-align: center; width:100%;">
                                            <a style="width:100%;" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" class=" btn btn-success" onclick="$(this).fadeOut(); $('#payInfo').fadeIn();">Continue to Billing Information»</a>
                                        </div>

                                    </h4>
                                </div>
                            </div>
                           
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">Contact
                                            and Billing Information</a>
                                    </h4>
                                </div>
                                <div id="collapseTwo" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <b>Help us keep your account safe and secure, please verify your billing
                                            information.</b>


                                     <br/><br/>       

                                       
                                        <table class="table table-striped" style="font-weight: bold;">
                                            
                                            <tr>
                                                <td>
                                                    <div class="form-group">
                                                        <label for="billing_name" class="control-label col-md-3">name: <span class="required">*</span></label>
                                                        <div class="col-md-8">
                                                            <input class="form-control" id="billing_name" name="billing_name" required="required" type="text" value="<?php if(isset($aBillingAddress['billing_name']) && ''!=$aBillingAddress['billing_name']) { echo $aBillingAddress['billing_name']; } ?>" />
                                                        </div>
                                                    </div>
                                                <td>
                                            </tr>        

                                            <tr>
                                                <td>
                                                    <div class="form-group">
                                                        
                                                        <label for="billing_email" class="control-label col-md-3">Email: <span class="required">*</span></label>
                                                        <div class="col-md-8">
                                                            <input class="form-control" id="billing_email" name="billing_email" required="required" type="text" value="<?php if(isset($aBillingAddress['billing_email']) && ''!=$aBillingAddress['billing_email']) { echo $aBillingAddress['billing_email']; } ?>"/>
                                                        </div>
                                                    </div>
                                                <td> 
                                            </tr>      

                                            <tr>
                                                <td>
                                                    <div class="form-group">
                                                        <label for="billing_phone" class="control-label col-md-3">Phone: <span class="required">*</span></label>
                                                        <div class="col-md-8">
                                                            <input class="form-control" id="billing_phone" name="billing_phone" type="text" required="required" value="<?php if(isset($aBillingAddress['billing_phone']) && ''!=$aBillingAddress['billing_phone']) { echo $aBillingAddress['billing_phone']; } ?>" />
                                                        </div>
                                                    </div>
                                                <td> 
                                            </tr>

                                            </tr>
                                                <td>
                                                    <div class="form-group">                                                 
                                                         <label for="billing_city" class="control-label col-md-3">City:  <span class="required">*</span></label>
                                                        <div class="col-md-8">
                                                            <select class="form-control" id="billing_city" name="billing_city" required="required">
                                                                <option value="">Select city </option>
                                                                <?php 
                                                                    if ($cityrow) {
                                                                        foreach ($cityrow as $cityreults) {
                                                                            $strSelected='';
                                                                            if (isset($aBillingAddress['billing_city']) && ''!=$aBillingAddress['billing_city'] && $aBillingAddress['billing_city']==$cityreults['id'])  {
                                                                               $strSelected="selected='selected'";
                                                                            }

                                                                            echo '<option value="'. $cityreults['id'] .'" '. $strSelected.'>'. $cityreults['name'] .'</option>';
                                                                        }
                                                                    }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                <td>
                                            </tr> 


                                            <tr>
                                                <td>
                                                    <div class="form-group">
                                                        <label for="billing_address" class="control-label col-md-3">Address: <span class="required">*</span></label>
                                                        <div class="col-md-8">
                                                            <input class="form-control" id="billing_address" name="billing_address" required="required" type="text" value="<?php if(isset($aBillingAddress['billing_address']) && ''!=$aBillingAddress['billing_address']) { echo $aBillingAddress['billing_address']; } ?>" />
                                                        </div>
                                                    </div>
                                                <td>   
                                            </tr>            


                                            <tr>
                                                 <td>
                                                    <div class="form-group">
                                                        
                                                        <label for="billing_postcode" class="control-label col-md-3">Postalcode: <span class="required">*</span></label>
                                                        <div class="col-md-8">
                                                           <input class="form-control" id="billing_postcode" name="billing_postcode" required="required" type="text" value="<?php if(isset($aBillingAddress['billing_postcode']) && ''!=$aBillingAddress['billing_postcode']) { echo $aBillingAddress['billing_postcode']; } ?>"/>
                                                          
                                                        </div>
                                                    </div>
                                                <td>                       
                                            </tr>


                                        </table>            
                                    
                                      
                                    </div>
                                </div>
                            </div>

                            

                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <div style="text-align: center;">
											<a data-toggle="collapse" data-parent="#accordion" href="#collapseThree" class=" btn   btn-success" id="payInfo" style="width:100%;display: none;" onclick="return billingvalidation()" > Order Now  »</a>
											<input type="submit" name="paymentnow" id="paymentnow" style="display: none;">
                                        </div>
                                    </h4>
                                </div>
                            </div>
                            
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>



<?php include 'include/footer.php'; ?>