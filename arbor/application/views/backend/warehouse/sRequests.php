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
            <th>Requested To</th>       	
            <th>Product</th> 
            <th>Code</th> 
            <th>Size & Quantity</th> 
            <th>Status</th> 
        </tr>
    </thead>    
    <tbody>
       
        <?php foreach ($aRows as $aRow) { 
								if($aRow['sender']==$aUsr['id']){
					?>
        <tr>
        	<td><?php foreach($aWhouses as $aWare){ if($aWare['id']==$aRow['reciever']) echo $aWare['name'];}?></td>  
        	<td><?php foreach($aProds as $pro){ if($pro['id']==$aRow['product_id']){echo $pro['name'];}}  ?></td>  
					<td><?php echo $aRow['code'] ;?></td>    
					<td><?php 	foreach($aRow['size'] as $si => $quant){ echo $aSizes[$si].'-'.$quant.'<br>';}?></td>   
					<td><?php echo $aRow['status']==1? 'Approved!':"Pending!";?></td>
        </tr>
       <?php }}?>
    </tbody>
</table>
 <?php } else { ?>
    <p>No data found</p>
    <?php } ?>
</div>