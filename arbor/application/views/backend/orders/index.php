<?php pr($aUsr); ?>
<div class="header">
    <h4 class="title" style="float: left;"><?php echo $title; ?></h4>
    <!--<?php if($_SESSION['admin_logged_role_id'] == ADMIN_ROLE || $_SESSION['admin_logged_role_id'] == WAREHOUSE_ROLE ) echo "<a style='float: right;' href=".getSiteUrl('product/add/')." class='btn btn-info btn-fill btn-wd btn-sm'>Add product</a>"; ?><?php if($_SESSION['admin_logged_role_id'] == ADMIN_ROLE) echo "<a style='float: right;' href=".getSiteUrl('orders/index/')." class='btn btn-info btn-fill btn-wd btn-sm'>View Orders</a>"; ?>
	<?php if($_SESSION['admin_logged_role_id'] == WAREHOUSE_ROLE ) echo "<a style='float: right;' href=".getSiteUrl('warehouse/request/')." class='btn btn-info btn-fill btn-wd btn-sm btn-space'>Request Product</a>";?>-->
    <?php if($_SESSION['admin_logged_role_id'] == ADMIN_ROLE) { ?>
    <a href="<?php echo getSiteUrl('order/createcsvfile'); ?>" class="btn btn-info btn-fill btn-wd btn-sm btn-space pull-right">Export CSV</a>
    <?php } ?>

</div>

<div class="content table-responsive">
    <!--filter data start-->

    <div class="row">
        <div class="col-md-12" style="margin-top:13px;">
            <form method="get">
                <table>
                    <div>
                        <tr>
                          <?php if($aUsr['role']==ADMIN_ROLE) {?>
                            <td>
                                <div class="form-group marg">
                                    <select class="form-control border-input whouse" name="sel[warehouse_id]" style="width:172px; padding-left:5px; margin-left:10px;">
                                        <option value="">Search by Warehouse</option>
                                        <?php
                                            if(isset($aWare)){
                                                foreach($aWare as $id => $ware) {
                                        ?>
                                        <option value="<?php echo $ware['id']; ?>" <?php if(isset($aVals['warehouse_id']) && $aVals['warehouse_id'] ==$ware['id']) echo "selected"; ?> ><?php echo $ware['name'];?></option>
                                        <?php }}?>
                                    </select>
                                </div>
                            </td>
                          <?php } ?>
                          <?php if($aUsr['role']==ADMIN_ROLE) {?>
                            <td>
                                <div class="form-group marg">
                                    <select class="form-control border-input whouse" name="sel[distributor_id]" style="width:172px; padding-left:5px; margin-left:10px;">
                                        <option value="">Search by Distributor</option>
                                        <?php if(isset($aDistributor)){
                                            foreach($aDistributor as $id => $ware){
                                        ?>
                                        <option value="<?php echo $ware['id']; ?>" <?php if(isset($aVals['distributor_id']) && $aVals['distributor_id'] ==$ware['id']) echo "selected"; ?> ><?php echo $ware['name'];?></option>
                                        <?php } } ?>
                                    </select>
                                </div>
                            </td>
                            <?php } ?>

                            <td>
                                <div class="form-group marg">
                                    <select class="form-control border-input whouse" name="sel[retailer_id]" style="width:172px; padding-left:5px; margin-left:10px;">
                                        <option value="">Search by Retailer</option>
                                        <?php if(isset($aRetailer)){
                                            foreach($aRetailer as $id => $ware){
                                        ?>
                                        <option value="<?php echo $ware['id']; ?>" <?php if(isset($aVals['retailer_id']) && $aVals['retailer_id'] ==$ware['id']) echo "selected"; ?> ><?php echo $ware['name'];?></option>
                                        <?php } } ?>
                                    </select>
                                </div>
                            </td>

                            <td>
                                <div class="form-group" style="margin-left:10px;">
                                    <button type="submit" class="btn btn-info btn-fill" name="submitform"><i class="fa fa-search"></i>Search</button>
                                </div>
                            </td>
                            <td>
                               <div class="form-group" style="margin-left:10px;">
                                    <a href="<?php echo getSiteUrl('order');?>" class="btn btn-info btn-fill"><i class="fa fa-undo"></i>Reset</a>
                                </div>
                            </td>
                        </tr>
                    </div>
                </table>
            </form>
        </div>
    </div>
    <!--filter data end-->

<table class="table table-striped">
    <thead>
        <tr>
            <th>Sr no.</th>
            <th>Date</th>
            <th>Customer Info</th>
            <th>Warehouse</th>
            <th>Total</th>
            <th>Order Status</th>
            <th style="text-align: center;">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php if($aRows) {
            $count=0;
         foreach ($aRows as $key => $aRow) {
            ++$count;
        ?>
        <tr>
        	<td><?php echo $count; ?></td>
            <td>
                <?php echo date('d M Y',strtotime($aRow['trans_date'])) .'<br />'.date('h:m:i',strtotime($aRow['trans_date']));  ?>
            </td>

            <td>
                <!-- <strong>Order Id : </strong> <?php echo $aRow['customer_trans_order_id'];  ?> <br /> -->
                <strong>Name : </strong> <?php echo $aRow['customers_name'];  ?> <br />
                <strong>Email : </strong> <?php echo $aRow['customers_email'];  ?> <br />
            </td>
            <td><?php echo $aRow['user_name']; ?></td>

			<td><?php echo $aRow['order_total']; ?></td>

			<?php
                if($_SESSION['admin_logged_role_id'] == DISTRIBUTOR_ROLE || $_SESSION['admin_logged_role_id'] == ADMIN_ROLE) {
                    if($aRow['orders_status']==0) {
                        echo"<td><a href=".getSiteUrl('order/approve/').$aRow['orders_id']." class='btn-link'>Approve</a></td>";
                    }
			        else if($aRow['orders_status']==1){

				        echo "<td><a href=".getSiteUrl('order/disapprove/').$aRow['orders_id'].">Disapprove</a></td>";
			        }else if($aRow['orders_status']==2){
				        echo "<td>Disapproved!</td>";
			        }
                } else {
                    if($aRow['orders_status']==0) {
                        echo"<td>Approve</td>";
                    } else if($aRow['orders_status']==1){
                        echo "<td>Disapprove</td>";
                    }else if($aRow['orders_status']==2){
                        echo "<td>Disapproved!</td>";
                    }
                }
            ?>
            <td style="text-align: center;">
            <!--
                <button type="button" class="btn-link upload-file-btn" data-toggle="modal" data-target="#myModal" attr="<?php echo $aRow['orders_id']; ?>"><i class="fa fa-upload"></i></button> -->
                <a href="<?php echo getSiteUrl('order/upload_file/').$aRow['orders_id'] ?>" class='btn-link'><i class="fa fa-upload"></i></a>
                <a href="<?php echo getSiteUrl('order/details/').$aRow['orders_id'] ?>" class='btn-link'><i class="fa fa-eye"></i></a>
            </td>
        </tr>
       <?php } } else { ?>
        <tr><td colspan="7">No data found</td></tr>
    <?php } ?>
    </tbody>
</table>
</div>
