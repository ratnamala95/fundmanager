<?php //pr($aRows); ?>
<div class="header">
 <h4 class="title" style="float: left;"><?php echo $title; ?></h4>
 <?php if($_SESSION['admin_logged_role_id'] == ADMIN_ROLE || $_SESSION['admin_logged_role_id'] == WAREHOUSE_ROLE ) echo "<a style='float: right;' href=".getSiteUrl('product/add/')." class='btn btn-info btn-fill btn-wd btn-sm'>Add product</a>"; ?>
    <?php if($_SESSION['admin_logged_role_id'] == WAREHOUSE_ROLE ) echo "<a style='float: right;' href=".getSiteUrl('warehouse/request/')." class='btn btn-info btn-fill btn-wd btn-sm btn-space'>Request Product</a>";?>
     <?php if($_SESSION['admin_logged_role_id'] == ADMIN_ROLE) { ?>	
    <a href="<?php echo getSiteUrl('product/createcsvfile'); ?>" class="btn btn-info btn-fill btn-wd btn-sm btn-space pull-right">Export CSV</a>
    <?php } ?>
</div>


<div class="content table-responsive">
 <br><br>

    <div class="row">
	    <div class="col-md-12">
	        <table class="table-responsive" style="border:0px">
    			<tr>
    				<td><input type="text" class="form-control border-input" placeholder="Search by code or name. . " id="sear"></td>
    				<td ><button type="submit" class="btn btn-info btn-fill " onclick="search();" style="margin-left:10px;"><i class="fa fa-search"></i>Search</button></td>
    			</tr>
    		</table>
    		<div class="clearfix"></div>
	    </div>
	</div>	

<table class="table table-striped table-responsive" id="search">
 <thead>
	 <tr>
		<th>Sr no.</th>
		<th>Image</th> 
		<th>product Info.</th> 
		
		<th>Status</th>
		<?php if($_SESSION['admin_logged_role_id'] == ADMIN_ROLE || $_SESSION['admin_logged_role_id'] == WAREHOUSE_ROLE ) echo "<th>Action</th>";?>
	 </tr>
 </thead> 
 <tbody>
 	<?php 
 	if($aRows) { 
 		$count=0; 
 		if (!empty($this->uri->segment(4))) {
 			$count=$this->uri->segment(4); 
 		}
 		foreach ($aRows as $key => $aRow) { 
 			++$count; 
 	?>
	 <tr>
		<td><?php echo $count; ?></td>
		<td>
			 <?php if($aRow && $aRow['image']) { ?>
			 <img src="<?php echo base_url('assets/uploads/'.$aRow['image']);?>" width="80px;">
			 <?php } ?>
		</td>
		
		<td>
			<strong>Name : </strong> <?php echo $aRow['name']; ?><br/>
			<strong>Category : </strong> <?php echo $aRow['category_name']; ?><br />
			<strong>Code : </strong> <a title='Transactions' href="<?php echo getSiteUrl('inventory/tranz/'.$aRow['id']) ?>"><?php echo $aRow['code']; ?></a>
		</td> 
		
		<td><?php echo $aRow['status'] ? "Active" : "Inactive"; ?></td>
		<?php if($_SESSION['admin_logged_role_id'] == ADMIN_ROLE || $_SESSION['admin_logged_role_id'] == WAREHOUSE_ROLE ) 
		echo "
		 <td>

		 <a title='Add More Images' href=".getSiteUrl('product/add_image/'.$aRow['id'])."><img src=".base_url('assets/images/89629.png')." style='width:15px;'></a>

		 <a title='Delete' class='classdelete' href='javascript:void(0)' attr=".getSiteUrl('product/delete/'.$aRow['id'])."><i class='fa fa-trash'></i></a>
		 <a title='Edit Product' class='classedit' href='javascript:void(0)' attr=".getSiteUrl('product/add/'.$aRow['id'])."><i class='fa fa-edit'></i></a>
		 <a title='Transactions' href=".getSiteUrl('inventory/tranz/'.$aRow['id'])."><i class='fa fa-exchange'></i></a>

		 </td>";?>

	 </tr>
 <?php } } else { ?>
 <tr><td colspan="7">No data found</td></tr>
 <?php } ?>
 </tbody>
</table>
 
	
	<div class="col-md-6" style="float:right;" >
		<div style="float:right;">
			<?php echo $this->pagination->create_links('paging');?>
		</div>
	</div>
	
</div>