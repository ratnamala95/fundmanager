<div class="header">
    <h4 class="title" style="float: left;"><?php echo $title; ?></h4>
		<a style='float: right;' href="<?php echo getSiteUrl('warehouse/add/').$aRow['id'];?>" class='btn btn-info btn-fill btn-wd btn-sm'>Update</a>
</div>

<div class="content">
	<div class="row">
		<div class="pull-image">
			<?php if($aRow && $aRow['image']) { ?>
				<img src="<?php echo base_url('assets/uploads/'.$aRow['image']);?>" class="img-responsive img-rounded" width="100%;">
			<?php } else{?>
				<img src="<?php echo base_url('assets/images/user-512.png');?>" width="100%;">
			<?php }?>
		</div>
		<div class="pull-container">
			<div>
				<label>Name:	<?php echo $aRow['name'];?>
				</label>
			</div><br>

			<div>
				<label>Email:	<?php echo $aRow['email'];?>
				</label>
			</div><br>

			<div>
				<label>Role:	<?php echo $aRow['role'] == WAREHOUSE_ROLE? 'Warehouse':'Distributor';?>
				</label>
			</div><br>
      <div>
        <a href="<?php echo getSiteUrl('warehouse/change/').$aRow['id']; ?>" class="btn-link">Change Password</a>
      </div>
		</div>
	</div>
</div>
