<?php //pr($aRow); ?>
<div class="content table-responsive table-full-width">
<table class="table">
	<tr>
		<th style="border: none;width: 150px;">Product Code</th>
		<td style="border: none;"><?php echo $aRow['card_code']; ?></td>
	</tr>
	<tr>
		<th>Featured</th>
		<td><?php echo $aRow['featured'] ? "Yes" : "No";  ?></td>
	</tr>
	<tr>
		<th>Weight</th>
		<td><?php echo $aRow['weight']; ?></td>
	</tr>
	<tr>
		<th>Size</th>
		<td><?php echo $aRow['size']; ?></td>
	</tr>
	<tr>
		<th>Description</th>
		<td><?php echo $aRow['description']; ?></td>
	</tr>
	<tr>
		<th>Price</th>
		<td><?php echo $aRow['price']; ?></td>
	</tr>
	<tr>
		<th>Video</th>
		<td><?php echo $aRow['video_url']; ?></td>
	</tr>
	<tr>
		<th>Status</th>
		<td><?php echo $aRow['status'] ? "Active" : "Inactive";  ?></td>
	</tr>

</table>
</div>