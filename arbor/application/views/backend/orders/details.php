<?php //pr($aRows); ?>


<div class="container">

  <div class="row" style="background-color: #fff;">
        <div class="col-md-12">
            <div class="panel">

                <div class="container-fluid">


                    <div class="row">
                        <div class="col-xs-12">
                            <div class="" style="padding: 21px;">
                                <!--<h2 class="pull-left">Invoice</h2>--><!-- <h3 class="pull-right">Order # <?= $orderInfo['customer_trans_order_id']; ?> </h3> -->
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-xs-6">
                                    <?php if(isset($orderInfo['billing_name']) && ''!=$orderInfo['billing_name']) { ?>
                                    <address>
                                    <strong>Billed To:</strong><br>
                                        <?= $orderInfo['billing_name']; ?><br>
                                        <?= $orderInfo['billing_phone']; ?><br>
                                       <?= $orderInfo['billing_address']; ?><br>
                                        <?= $orderInfo['name']; ?> , <?= $orderInfo['billing_postcode']; ?>
                                    </address>
                                    <?php } ?>
                                </div>
                                <div class="col-xs-6 text-right">
                                    <?php 
                                        if (isset($orderInfo['document']) && ''!=$orderInfo['document']) {
                                            echo '<a href="'.base_url('assets/uploads/'.$orderInfo['document']).'" download class="btn btn-primary">Download File </a>';
                                        }
                                    ?>
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
                                      <!--   <strong>Payment Method:</strong><br>
                                       Cash on delivery<br> -->

                                    </address>
                                </div>
                                <div class="col-xs-6 text-right">
                                    <address>
                                        <strong>Order Date:</strong><br>
                                        <?php if(!empty($orderInfo['trans_date'])) { echo  date('M d Y', strtotime($orderInfo['trans_date'])); } ?><br><br>
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
                                                    <th class="text-center"><strong>Size - Quantity</strong></th>
                                                    <th class="text-center"><strong>Total Piece</strong></th>
                                                    <th class="text-center"><strong>Price</strong></th>
                                                    <th class="text-right"><strong>Amount</strong></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- foreach ($order->lineItems as $line) or some such thing here -->
                                            <?php
                                                $total=0;
                                                $totalPiece='';
                                                $subtotal=0;
                                                $gst=0;
                                                
                                                if(isset($orderDetails) && count($orderDetails)>0) {
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
                                                    <td class="thick-line"></td>
                                                    <td class="no-line text-center"><strong>Total</strong></td>
                                                    <td class="no-line text-right"><i class="fa fa-inr"></i> <?=  $total ?></td>
                                                </tr>
                                            <?php } else { ?>    
                                                <tr><td colspan="6">No records found</td></tr>
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
