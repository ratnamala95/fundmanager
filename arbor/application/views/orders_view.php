<?php $strpage="Orders";
 include 'include/header.php'; ?>
<!-- breadcrumbs -->
    <div class="breadcrumbs">
        <div class="container">
            <div class="col-md-3">
                <ol class="breadcrumb breadcrumb1 animated wow slideInLeft" data-wow-delay=".5s">
                    <li><a href="<?= base_url(); ?>"><span class="glyphicon glyphicon-home" aria-hidden="true"></span>Home</a></li>
                    <li class="active">Order List</li>
                </ol>
            </div>
        </div>
    </div>
<!-- //breadcrumbs -->
 
	

<div class="container">
  <div class="row" style="margin-top: 10px;background-color: #fff;">
        <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <div class="dropdown">
                                <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Select order list  <span class="caret"></span></button>
                                <ul class="dropdown-menu">
                                    <li><a href="javascript:void(0)" onclick="orderlistview(0)">Current Orders</a></li>

                                    <li><a href="javascript:void(0)" onclick="orderlistview(1)">Previous Orders</a></li>   
                                </ul>
                            </div> 
                        </h3>
                    </div>

  
                    <div class="panel-body">

<!-- tabs start -->

  <!-- Nav tabs -->
 

  <!-- Tab panes -->
  <div class="tab-content">
     <!--======================= current orders start ============================-->
    <div role="tabpanel" class="tab-pane active" id="current"> 
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                  <tr>
                    <th class="center" >Sr. no.</th>
                    <th class="center">Date</th>
                   <!--  <th class="center" >Order Id</th>           -->          
                    <th class="center" >Total Amount</th>
                    <th class="center" >order Status</th>
                    <th class="center" >Action</th>
                  </tr>
                </thead>
                <tbody>

                <?php 
                    if ($orderList) {
                        $cnt=0;
                        foreach ($orderList as  $orderResults) { 
                        $cnt++;                 
                        
                ?>    
                  <tr>
                    <td class="center" ><?= $cnt; ?></td>
                    <td class="center" >
                        <?php echo  date('d M Y', strtotime($orderResults['trans_date'])).'<br />'.date('H:i:s', strtotime($orderResults['trans_date'])); ?>
                        
                    </td>
                    <!-- <td class="center" ><?= $orderResults['customer_trans_order_id']; ?></td> -->
                    <td class="center" ><i class="fa fa-inr"></i> <?= $orderResults['order_total']; ?></td>
                    <td class="center" >
                        <?php
                            if ($orderResults['orders_status']==1) {
                                echo '<label class="label label-success">Order Confirmed</label>'; 
                            } else {
                                echo '<label class="label label-danger">processing</label>';
                            }
                        ?>

                    </td>
                    <td class="center" >
                        <button type="button" title="View Documents" class="btn btn-primary view-upload" data-toggle="modal" data-target=".bs-example-modal-sm" attr="<?php echo $orderResults['orders_id']; ?>"><i class="fa fa-file-text-o"></i></button>
                        <a href="<?= base_url('dashboard/orderdetails/').$orderResults['orders_id']; ?>" title="View Details" ><button class="btn btn-primary"><i class="fa fa-eye"></i></button></a>
                    </td>
                  </tr>
                <?php 
                       }
                    }  else { 
                        echo '<tr><td colspan="6"> <h4> No order found... </h4></td></tr>';
                    }  
                 ?> 
                </tbody>
            </table>    
        </div>
    </div>
    <!--======================= current orders ends ============================-->
    
     <!--======================= previous orders start ============================-->
    <div role="tabpanel" class="tab-pane" id="previous">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                  <tr>
                    <th class="center" >Sr. no.</th>
                    <th class="center">Date</th>
                    <th class="center" >Order Id</th>                    
                    <th class="center" >Total Amount</th>
                    <th class="center" >order Status</th>
                    <th class="center" >View</th>
                  </tr>
                </thead>
                <tbody>

                <?php 
                    if ($previousOrderList) {
                        $cnt=0;
                        foreach ($previousOrderList as  $previousOrderResults) { 
                        $cnt++;                 
                        
                ?>    
                  <tr>
                    <td class="center" ><?= $cnt; ?></td>
                    <td class="center" >
                        <?php echo  date('d M Y', strtotime($previousOrderResults['trans_date'])).'<br />'.date('H:i:s', strtotime($previousOrderResults['trans_date'])); ?>
                        
                    </td>
                    <td class="center" ><?= $previousOrderResults['customer_trans_order_id']; ?></td>
                    <td class="center" ><?= $previousOrderResults['order_total']; ?></td>
                    <td class="center" >
                        <?php
                            if ($previousOrderResults['order_delivery_status']==1) {
                                echo '<label class="label label-success">Delivered</label>'; 
                            } else {
                                echo '<label class="label label-danger">processing</label>';
                            }
                        ?>

                    </td>
                    <td class="center" >
                         <button type="button" title="View Documents" class="btn btn-primary view-upload" data-toggle="modal" data-target=".bs-example-modal-sm" attr="<?php echo $previousOrderResults['orders_id']; ?>"><i class="fa fa-file-text-o"></i></button>
                        <a href="<?= base_url('dashboard/orderdetails/').$previousOrderResults['orders_id']; ?>"><button class="btn btn-primary"><i class="fa fa-eye"></i></button></a>
                    </td>
                  </tr>
                <?php 
                       }
                    }  else { 
                        echo '<tr><td colspan="6"> <h4> No order found... </h4></td></tr>';
                    }  
                 ?> 
                </tbody>
            </table>    
        </div>
    </div>
    <!--======================= previous orders ends ============================-->

  </div>


<!-- tabs ends -->



                    </div>
                </div>
            </div>   
        </div>
</div>
<div class="container modal-container">


    <!-- Button trigger modal -->
    <!-- Modal -->
    <div class="modal fade bs-example-modal-sm" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content" style="width: 351px;left: 251px;">
            <span id="uplodad-data-div">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Documents</h4>
                </div> 
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="alert alert-success" id="file-remove-msg" style="display: none;">File remove successfully</div>
                            <div class="alert alert-danger" id="file-error-msg" style="display: none;">No Document found</div>
                        </div>
                        <div class="col-md-12" id="documentData"></div>
                    </div>
                </div>
            </span> 
        </div>
      </div>
    </div>
</div>

<script type="text/javascript">
    $(".view-upload").on('click', function(){
        $("#upload-data-div").hide();
        $("#uplodad-data-div").show();
        var orderId =$(this).attr('attr');
        $('#orderId').val(orderId);
        var data='id='+orderId;
        $.post('<?php echo getSiteUrl('dashboard/documentdata'); ?>',data, function(response){
            var results = jQuery.parseJSON(response);

            if (results.status==1) {
                $("#file-error-msg").hide();
               $('#documentData').html(results.message);
               $('#documentData').show();
            } else {
                $("#file-error-msg").show();
                $('#documentData').hide();
            }
        });

    });
    function orderlistview(obj)
    {
      //  alert(obj);
        if (obj==1) 
        {
            $("#current").removeClass("active");
            $("#previous").addClass("active");
        } else {
            $("#current").addClass("active");
            $("#previous").removeClass("active");
        }    
    }
</script>


<?php include 'include/footer.php'; ?>