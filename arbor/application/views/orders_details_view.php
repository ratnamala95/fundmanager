<?php $strpage="Orders";
 include 'include/header.php'; ?>

 <style type="text/css">
     .ps-amount-border{
        border-top: 1px solid #ccc;
     }
    @media(max-width: 650) {
        .invoice-title h3{
            
        }
    }
 </style>


<!-- breadcrumbs -->
<div class="breadcrumbs">
    <div class="container">
        <div class="col-md-3">
            <ol class="breadcrumb breadcrumb1 animated wow slideInLeft" data-wow-delay=".5s">
                <li><a href="<?= base_url(); ?>"><span class="glyphicon glyphicon-home" aria-hidden="true"></span>Home</a></li>
                <li class="active">Order Details</li>
            </ol>
        </div>
    </div>
</div>
<!-- //breadcrumbs --> 

<div class="container">
  <div class="row" style="margin-top: 10px;background-color: #fff;">
        <div class="col-md-12">
            <div class="panel">   
                
                <div class="container-fluid">	 
                    
                  
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="invoice-title" style="padding: 21px;">
                                <!--<h2 class="pull-left">Invoice</h2>--><!-- <h3 class="pull-right">Order # <?= $orderInfo['customer_trans_order_id']; ?> </h3> -->
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-xs-6">
                                    <address>
                                    <strong>Billed To:</strong><br>
                                        <?= $orderInfo['billing_name']; ?><br>
                                        <?= $orderInfo['billing_phone']; ?><br>
                                       <?= $orderInfo['billing_address']; ?><br>
                                        <?= $orderInfo['name']; ?> , <?= $orderInfo['billing_postcode']; ?>
                                    </address>
                                </div>
                                <div class="col-xs-6 text-right">
                                     
                                   <!-- <address>
                                    <strong>Shipped To:</strong><br>
                                        Jane Smith<br>
                                        1234 Main<br>
                                        Apt. 4B<br>
                                        Springfield, ST 54321
                                    </address>
                                -->
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-6">
                                    <address>
                                     <!--    <strong>Payment Method:</strong><br>
                                       Cash on delivery<br> -->
                                        
                                    </address>
                                </div>
                                <div class="col-xs-6 text-right">
                                    <address>
                                        <strong>Order Date:</strong><br>
                                        <?php echo  date('M d Y', strtotime($orderInfo['trans_date'])) ?><br><br>
                                    </address>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><strong>Order summary</strong></h3>
                                </div>
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table table-condensed">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">Image</th>
                                                    <th><strong>Item</strong></th>
                                                    
                                                    <th class="text-center"><strong>size - Quantity</strong></th>
                                                    <th class="text-center"><strong>Total Piece</strong></th>                           
                                                    <th class="text-center"><strong>Price</strong></th>                                
                                                    <th class="text-right"><strong>Amount</strong></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- foreach ($order->lineItems as $line) or some such thing here -->
                                            <?php
                                                $total=0;
                                                $totalPiece=0;
                                                $subtotal=0;
                                                $gst=0;
                                           
                                                if (isset($orderDetails) && count($orderDetails)>0) {
                                                foreach ($orderDetails as $orderDetailsResults) {
                                                      
                                                $subtotal+=$orderDetailsResults['od_subtotal'];
                                                $total =$orderDetailsResults['order_total'];
                                                $piecesPerSet=$orderDetailsResults['pieces_per_set'];

                                                $arysize = unserialize($orderDetailsResults['od_size']);                               
                                            ?>    
                                                <tr>
                                                    <td class="text-center ">
                                                        <img src="<?= base_url('assets/uploads/'.$orderDetailsResults['image']); ?>" style="width: 56px;">
                                                    </td>
                                                    <td>
                                                        <?= $orderDetailsResults['od_product_name']; ?>
                                                        <h4>
                                                            <small>Product description</small>    
                                                            <p><small><strong>Code - </strong> 
                                                                <?php echo  $orderDetailsResults['code'];  ?>
                                                            </small></p>
                                                            
                                                            <p><small><strong>Set - </strong> 
                                                                <?php echo  '1 Set = '.$piecesPerSet.' piece';  ?>
                                                            </small></p>
                                                        </h4>        
                                                    </td> 
                                                    <td class="text-center">
                                                     <?php
                                                        $totalPiece=0; 
                                                        foreach ($arysize as $key => $sizeQty) {
                                                            if ($sizeQty>0) { 
                                                            $dataattr = $this->Dbaction->getData('attributes',[ 'id'=>$key ]);
                                                            $amount = ($piecesPerSet*$sizeQty)*$orderDetailsResults['sale_price'];
                                                            $totalPiece += $piecesPerSet*$sizeQty;
                                                    ?>
                                                       
                                                        <?php echo $dataattr['name'] .' - '. $sizeQty.' Set <br />'; ?>
                                                       
                                                    <?php } } ?>
                                                    </td>    
<!-- 
                                                    <td> <strong><?php echo $dataattr['name'];  ?></strong> </td>
                                                    <td class="text-center"><?= $sizeQty.' Set'; ?></td> -->

                                                    <td class="text-center"><?= $totalPiece; ?></td>

                                                    <td class="text-center"><i class="fa fa-inr"></i> <?= $orderDetailsResults['od_product_price'].' / piece <br/ > GST ('.$orderDetailsResults['gst'].'%)'; ?></td>
                                                    
                                                    <td class="text-right"><i class="fa fa-inr"></i> <?= $amount; ?></td>
                                                </tr>
                                            <?php 
                                                  
                                                 }   
                                                    
                                               
                                            ?>    
                                               
                                                <tr class="ps-amount-border">
                                                    <td class="thick-line"></td>
                                                    <td class="thick-line"></td>
                                                    <td class="thick-line"></td>
                                                    <td class="thick-line"></td>
                                                    <td class="thick-line text-center"><strong>Subtotal</strong></td>
                                                    <td class="thick-line text-right"><i class="fa fa-inr"></i> <?= $subtotal; ?></td>
                                                </tr>
                                                <tr class="ps-amount-border">
                                                    <td class="thick-line"></td>
                                                    <td class="thick-line"></td>
                                                    <td class="no-line"></td>
                                                    <td class="thick-line"></td>
                                                    <td class="no-line text-center"><strong>GST</strong></td>
                                                    <td class="no-line text-right"><i class="fa fa-inr"></i> <?php echo $total-$subtotal; ?></td>
                                                </tr>
                                                <tr class="ps-amount-border">
                                                    <td class="thick-line"></td>
                                                    <td class="thick-line"></td>
                                                    <td class="no-line"></td>
                                                    <td class="no-line"></td>
                                                    <td class="no-line text-center"><strong>Total</strong></td>
                                                    <td class="no-line text-right"><i class="fa fa-inr"></i> <?=  $total ?></td>
                                                </tr>
                                    <?php } else { ?>            
                                        <tr><td colspan="6">No Record found</td></tr>
                                    <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                            
                     
                </div>
            </div>
     	</div>
	</div>   
</div>








<?php include 'include/footer.php'; ?>