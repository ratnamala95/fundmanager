<?php //pr($aRows);die;?>
<div class="header">
    <h4 class="title" style="float: left;"><?php echo $title; ?></h4>
    <div class="clearfix">&nbsp;</div>
</div>

<div class="content table-responsive">
<?php if($aRows) { ?>    
<table class="table table-striped">
    <thead>
        <tr>
<!--            <th>Message</th>        	-->
            <th>Requested By</th>       	
            <th>Product</th> 
            <th>Size & Quantity</th> 
            <th>Code</th> 
            <th>Status</th> 
            <th>Action</th> 
        </tr>
    </thead>    
    <tbody>
       
        <?php foreach ($aRows as $aRow) { 
								if($aRow['reciever']==$aUsr['id']){
					?>
        <tr>
<!--        	<td><?php echo $aRow['message'];  ?></td>-->
        	<td><?php foreach($aWhouses as $aWare){ if($aWare['id']==$aRow['sender']) echo $aWare['name'];}?></td>  
        	<td><?php foreach($aProds as $pro){ if($pro['id']==$aRow['product_id']){echo $pro['name'];}}  ?></td>  
					<td><?php foreach($aRow['size'] as $key => $value){ echo $aSizes[$key].'-'.$value.'<br>';}?></td>    
					<td><?php echo $aRow['code']; ?></td>    
					<td><?php echo $aRow['status']==1? 'Approved!':'Pending!';?></td>    
					<td><?php echo $aRow['status']==0 ? "<a href=".getSiteUrl('warehouse/requests/').$aRow['id']." class='btn btn-info btn-sm btn-wd'><i class='fa fa-check'></i>&nbsp;Approve</a>":"<a href=".getSiteUrl('warehouse/reject/').$aRow['id']." class='btn btn-danger btn-sm btn-wd'><i class='fa fa-close'></i>&nbsp; Reject</a>" ;?>
					</td>    
        </tr>
       <?php }}?>
    </tbody>
</table>
 <?php } else { ?>
    <p>No data found</p>
    <?php } ?>
</div>