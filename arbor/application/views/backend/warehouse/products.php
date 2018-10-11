<?php //pr($rRows);die;?>


<div class="content table-responsive col-md-12">
<?php if($rProds) { ?>    

<table class="col-sm-12 table table-striped">
    <thead>
        <tr>
<!--            <th>ID</th>        	-->
            <th>Name</th>       	
            <th>Category</th> 
            <th>Size & Quantity</th> 
<!--            <th>Quantity</th> -->
<!--            <th>Style</th> -->
            <th>Code</th> 
            <th>Status</th>
            <th>Check</th>
        </tr>
    </thead>    
    <tbody>
       
        <?php foreach ($rRows as $key => $aRow) { ?>
        <tr>
					<td><?php foreach ($rProds as $pro){ if($pro['id']==$aRow['product_name'])echo $pro['name'];}  ?>
							<input type="hidden" name="val[product_id]" value="<?php echo $aRow['product_name'];?>" >
					</td>    
        	<td><?php foreach ($aCats as $cat){ if($cat['id']==$aRow['category']) echo $cat['name'];}  ?>
						<input type="hidden" name="val[category]" value="<?php echo $aRow['category'];?>" >
					</td>
					<td><?php foreach ($aRow['size'] as $size => $quant){ echo $aSizes[$size].'-'.$quant.'<br>';}  ?>
						<input type="hidden" name="val[category]" value="<?php echo $aRow['category'];?>" >
					</td>  
					<td><?php echo $aRow['code'];  ?>
							<input type="hidden" name="val[code]" value="<?php echo $aRow['code'];?>" >
					</td>    
					<td><?php echo $aRow['status'] ? "Active" : "Inactive";  ?></td>
					<td>
						<button  type="button" class="btn-link mdl" onclick="modal(<?php echo $aRow['id'];?>)"><i class="fa fa-check-square"></i>
                        </button>
					</td>
        </tr>
			
			
       <?php } ?>
    </tbody>
</table>

<button style="display: none;" id="mymodal" type="button" class="btn-link mdl" data-toggle="modal" data-target="#myModal"><i class="fa fa-check-square"></i></button>


	<div class="modal" id="myModal">
    <div class="modal-dialog">
      <div class="modal-content">
      
<!--         Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Make a Request!</h4>
          <button type="button" class="close" data-dismiss="modal" style="margin-top:-27px;">&times;</button>
        </div>
        
<!--         Modal body -->
        <div class="modal-body" id="modalbody">
        </div>
        
<!--         Modal footer -->
        <div class="modal-footer">
<!--          <button type="button" class="btn btn-info" data-dismiss="modal">Request</button>-->
        </div>
        
      </div>
    </div>
  </div>
	
			<div class="text-left">
				<button type="submit" class="btn btn-info btn-fill btn-wd">Confirm</button>
			</div>
 <?php } else { ?>
    <p>No data found</p>
    <?php } ?>
</div>