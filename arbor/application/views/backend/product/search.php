<table class="table table-striped table-responsive search">
 <thead>
	 <tr>
		 <th>Sr no.</th> 
		 <th>Category</th> 
		 <th>Image</th> 
		 <th>Name</th> 
		 <th>Code</th> 
		 <th>Status</th>
		 <?php if($_SESSION['admin_logged_role_id'] == ADMIN_ROLE || $_SESSION['admin_logged_role_id'] == WAREHOUSE_ROLE ) echo "<th>Action</th>";?>
	 </tr>
 </thead> 
 <tbody>
 
 <?php
 	$cnt=0;
    foreach ($aRows as $key => $aRow) { 
    	++$cnt;
?>
	 <tr>
		 <td><?php echo $cnt; ?></td>
		 <td><?php echo $aRow['category_name']; ?></td> 
		 <td>
		 <?php if($aRow && $aRow['image']) { ?>
		 <img src="<?php echo base_url('assets/uploads/'.$aRow['image']);?>" width="80px;">
		 <?php } ?>
		 </td>
		 <td><?php echo $aRow['name']; ?></td> 
		 <td><?php echo $aRow['code']; ?></td> 
		 <td><?php echo $aRow['status'] ? "Active" : "Inactive"; ?></td>
				<?php if($_SESSION['admin_logged_role_id'] == ADMIN_ROLE || $_SESSION['admin_logged_role_id'] == WAREHOUSE_ROLE ) echo "
		 <td>

		 <a title='Add More Images' href=".getSiteUrl('product/add_image/'.$aRow['id'])."><img src=".base_url('assets/images/89629.png')." style='width:15px;'></a>
		 <a title='Delete' class='classdelete' href='javascript:void(0)' attr=".getSiteUrl('product/delete/'.$aRow['id'])."><i class='fa fa-trash'></i></a>
		 <a title='Edit Product' class='classedit' href='javascript:void(0)' attr=".getSiteUrl('product/add/'.$aRow['id'])."><i class='fa fa-edit'></i></a>
		 <a title='Transactions' href=".getSiteUrl('inventory/trans/'.$aRow['id'])."><i class='fa fa-exchange'></i></a>

		 </td>";?>
	 </tr>
 <?php } ?>
 </tbody>
</table>

<script>
  $( function() {
    $(".classdelete").on('click',function(){
        $( "#dialogDelete" ).dialog();
        $("#dialogDelete .confirm-btn").attr('href',$(this).attr('attr')) ;
    });
    $(".classedit").on('click',function(){
        $( "#dialogEdit" ).dialog();
        $("#dialogEdit .confirm-btn").attr('href',$(this).attr('attr')) ;
    }); 
           
    $(".delete-close-btn").click(function() {
        $("#dialogDelete").dialog("close");
    });
    $(".edit-close-btn").click(function() {
        $("#dialogEdit").dialog("close");
    });
   
  } );
</script>