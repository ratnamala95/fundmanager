<table class="table table-striped" id="change">
	 <thead>
		 <tr>
		<!--	<th>Transaction Id</th>-->
				<th>Warehouse</th>
				<th>User</th>
				<th>Product Code</th>
				<th>Order Id</th>
				<th>Inventory</th>
				<th>Action</th>
				<th>Date</th>
			</tr>
	 </thead> 
	 <tbody>
		<?php foreach($aRows as $aRow){?>
			<tr>
			<!--	<td><?php echo $aRow['trans_id'];?></td>-->
				<td><?php foreach($aWare as $ware){if($ware['id']==$aRow['warehouse_id']) echo $ware['name'];}?></td>
				<td><?php foreach($aWare as $ware){if($ware['id']==$aRow['user_id']) echo $ware['name'];}?></td>
				<td><?php echo $aRow['product_code'];?></td>
				<td><?php echo $aRow['order_id'];?></td>
				<td>
				<?php foreach($aRow['inventory'] as $size => $quantity){

				echo $aSizes[$size].'-'.$quantity.'<br> ';

				}
				?>
				</td>
				<td><?php echo $aRow['flag']==1?'In':'Out';?></td>
				<td><?php echo $aRow['date'];?></td>
			</tr>
		<?php }?>
	 </tbody>
	</table>