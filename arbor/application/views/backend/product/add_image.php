<style type="text/css">
	.more-image{
		margin-top: 2em;
	}
</style>
<div class="header">
	 <a style='float: right;' href="<?php echo getSiteUrl('product'); ?>" class='btn btn-info btn-fill btn-wd btn-sm'>Go Backs</a>
    <h4 class="title"><?php echo $title; ?></h4>
    <p><?php echo $aRow['name'].' / '.$aRow['code']; ?></p>
    
    <div class="clearfix">&nbsp;</div>
</div>

<div class="content">
	<form method="post" enctype="multipart/form-data">
		<input type="hidden" name="val[id]" value="<?php echo $id; ?>">
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label>Select multiple Images</label>
					<input type="file" name="userfile[]" class="form-control border-input" multiple="multiple">
					
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<button type="submit" class="form-contro btn btn-info btn-fill btn-wd more-image">Add Images</button>
				</div>
			</div>		
		</div>
	</form>
	<?php if (isset($aRowImage) && count($aRowImage)>0) { ?>
	<div class="row">
		<div class="col-md-12">
			<div class="table-responsive">			
				<table class="table">
				    <thead>
				      <tr>
				        <th style="text-align: center;">Sr no</th>
				        <th style="text-align: center;" >Image</th>
				        <th style="text-align: center;">product code</th>
				        <th style="text-align: center;">Action</th>
				      </tr>
				    </thead>
				    <tbody>
				    <?php 

				    	if (isset($aRowImage) && count($aRowImage)>0) {
				    		$count=0;
				    		foreach ($aRowImage as $resImage) {
				    			++$count;	
				    			
				    ?>	
				      <tr>
				        <td style="text-align: center;"><?= $count; ?></td>
				        <td style="text-align: center;"><img src="<?php echo base_url('assets/uploads/'.$resImage['img_name']);?>" width="80px;"></td>
				        <td style="text-align: center;"><?php echo $aRow['code']; ?></td>
				        <td style="text-align: center;"><a title='Delete' onclick='return confirm('Are you sure;')' href="<?php echo getSiteUrl('product/deleteimage/'.$resImage['img_id'].'/'.$id); ?>"><i class='fa fa-trash'></i></a></td>
				      </tr>
				    <?php 
				    		}
				    	} else {
				    ?>  
				      <tr>
				        <td colspan="4">No Records found</td>
				       </tr>
				    <?php } ?>  
				    </tbody>
				</table>
			</div>	
		</div>
	</div>
	<?php } ?>
</div>					