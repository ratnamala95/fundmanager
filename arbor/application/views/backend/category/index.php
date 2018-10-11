<?php //pr($aRows); ?>
<div class="header">
    <h4 class="title" style="float: left;"><?php echo $title; ?></h4>
    <a style="float: right;" href="<?php echo getSiteUrl('category/add/'); ?>" class="btn btn-info btn-fill btn-wd btn-sm">Add Category</a>
    <div class="clearfix">&nbsp;</div>
</div>


<div class="content table-responsive">
<table class="table table-striped">
    <thead>
        <tr>
            <th>Sr no.</th>
        	<th>Name</th>        	
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>    
    <tbody>
        <?php if($aRows) {
            $count=0;
            foreach ($aRows as $key => $aRow) {
                ++$count;
        ?>
        <tr>
        	<td><?php echo $count;  ?></td>
        	<td><?php echo $aRow['name'];  ?></td>    
            <td><?php echo $aRow['status'] ? "Active" : "Inactive";  ?></td>
            <td>
                <a href="javascript:void(0)" class="classdelete" attr="<?php echo getSiteUrl('category/delete/'.$aRow['id']); ?>" ><i class="fa fa-trash"></i></a>
                <a title="Edit Product" href="javascript:void(0)" class="classedit" 
                attr="<?php echo getSiteUrl('category/add/'.$aRow['id']); ?>"><i class="fa fa-edit"></i></a>     
               
            </td>
        </tr>
       <?php }} else { ?>
	    <tr><td colspan="4">No data found</td></tr>
	 <?php } ?>
    </tbody>
</table>
</div>