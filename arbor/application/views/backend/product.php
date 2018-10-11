<?php //pr($aRows); ?>

<div class="content table-responsive table-full-width">
<table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
        	<th>Code</th>
        	<th>Featured</th>
        	<th>Weight</th>
        	<th>Size</th>
            <th>Price</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>    
    <tbody>
        <?php if($aRows) { ?>
        <?php foreach ($aRows as $key => $aRow) { ?>
        <tr>
        	<td><?php echo $aRow['id'];  ?></td>
        	<td><?php echo $aRow['card_code'];  ?></td>
        	<td><?php echo $aRow['featured'] ? "Yes" : "No";  ?></td>
        	<td><?php echo $aRow['weight'];  ?></td>
        	<td><?php echo $aRow['size'];  ?></td>
            <td><?php echo $aRow['price'];  ?></td>
            <td><?php echo $aRow['status'] ? "Active" : "Inactive";  ?></td>
            <td>
                <a title="View" href="<?php echo getSiteUrl('product/view/'.$aRow['id']); ?>"><i class="fa fa-eye"></i></a>
                <a title="Edit Product" href="<?php echo getSiteUrl('product/edit/'.$aRow['id']); ?>"><i class="fa fa-edit"></i></a>
                <?php /*if($aRow['status'] == 1) { ?>
                <a title="Deactive" href="<?php echo getSiteUrl('product/status/'.$aRow['id'].'/0'); ?>"><i class="fa fa-thumbs-o-down" onclick="return confirm('Are you sure to delete this item ??');"></i></a>
                <?php } else { ?>
                <a title="Active" href="<?php echo getSiteUrl('product/status/'.$aRow['id'].'/1'); ?>"><i class="fa fa-thumbs-o-up" onclick="return confirm('Are you sure to delete this item ??');"></i></a>
                <?php } */ ?>
            </td>
        </tr>
       <?php }} ?>
    </tbody>
</table>
</div>