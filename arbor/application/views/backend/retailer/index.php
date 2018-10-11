<?php $aVals = $this->input->get('name'); //pr($aRows); ?>
<div class="header">
    <h4 class="title" style="float: left;"><?php echo $title; ?></h4>
    <a style="float: right;" href="<?php echo getSiteUrl('retailer/add/'); ?>" class="btn btn-info btn-fill btn-wd btn-sm">Add New</a>
    <div class="clearfix">&nbsp;</div>
</div>


<div class="content table-responsive">
     <div class="row">
        <div class="col-md-12">
	        <table style="margin-left: 10px;">
        		<form method="get">
        			<tr>
        				<td style="width: 50%;"><input type="text" name="name" class="form-control border-input" placeholder="Search by name or email. . " value="<?php echo $aVals;?>"></td>
        				<td>
        					<div style="margin-left:10px;">
        						<button type="submit" class="btn btn-info btn-fill"><i class="fa fa-search"></i>Search</button>
        						
        					</div>
        				</td>
        				<td>
        					<div style="margin-left:10px;">
        						
        						<a href="<?php echo getSiteUrl('retailer/res');?>" class="btn btn-info btn-fill"><i class="fa fa-undo"></i>Reset</a>
        					</div>
        				</td>
        			</tr>	
              </form>
		    </table>
		</div>
	</div>	
		

<table class="table table-striped">
    <thead>
        <tr>
            <th>sr no.</th>
        	<th>Name</th>
            <th>Email</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php if($aRows) { $cnt=0; foreach ($aRows as $key => $aRow) {  ++$cnt; ?>
        <tr>
        	<td><?php echo $cnt;  ?></td>
        	<td><?php echo $aRow['name'];  ?></td>
            <td><?php echo $aRow['email'];  ?></td>
            <td><?php if($aRow['status']==1 && $aRow['parent_flag']==1){ echo "Active";}
            else if($aRow['status']==0 && $aRow['parent_flag']==1) {
               echo "<a href=".getSiteUrl('retailer/activate/').$aRow['id']." class='btn-link'>Activate</a>";
             }
             else {
               echo 'parent deactivated!';
             }?></td>
            <td>
                <a title="Delete" class="classdelete" href="javascript:void(0)" attr="<?php echo getSiteUrl('retailer/delete/'.$aRow['id']); ?>"><i class="fa fa-trash"></i></a>
                <a title="Edit Retailer" class="classedit" href="javascript:void(0)" attr="<?php echo getSiteUrl('retailer/add/'.$aRow['id']); ?>"><i class="fa fa-edit"></i></a>
                <a title="Change Password" href="<?php echo getSiteUrl('user/changepassword/'.$aRow['id']); ?>"><i class="fa fa-key"></i></a>

            </td>
        </tr>
       <?php } ?>
        <?php } else { ?>
            <tr><td colspan="5">No data found</td></tr>
        <?php } ?>
    </tbody>
</table>

</div>
