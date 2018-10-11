<table class="table table-striped table-responsive">
	 <thead>
		 <tr>
				<th>Code</th>
				<th>Warehouse</th>
				<th>Name</th>
				<th>Image</th>
				<?php foreach($aSizes as $key => $value){
				if($key != ''){
				?>
				<th><?php echo $value;?></th> 
				<?php }}?>
				<th>Action</th>
		 </tr>
	 </thead> 
	 <tbody>
			<?php foreach ($aCodes as $array){
				foreach($aRows as $aRow){ if($aRow['product_name']==$array['id'] && $aRow['code'] == $array['code']){
			?>
			<tr>
				<td><?php echo $array['code'];?></td>
				<td><?php echo $aWare[$aRow['warehouse_id']];?></td>
				<td><?php echo $array['name'];?></td>
				<td>
				<?php if($array && $array['image']) { ?>
				<img src="<?php echo base_url('assets/uploads/'.$array['image']);?>" width="80px;">
				<?php }?>
				</td>
				<?php foreach($aSizes as $key => $value) {	
				if($key != ''){
				?>
				<td><?php $id = $aRow['product_name'];

				if ($aUsr['role']==WAREHOUSE_ROLE && $aUsr['id']==$aRow['warehouse_id']) {
					foreach($aRow['size'] as $size =>$quantity){
						if($key==$size){
							echo $quantity;
						}}
					if(!array_key_exists($key,$aRow['size']))
					{
						echo '-';
					}
				}else if($aUsr['role']==ADMIN_ROLE){
					foreach($aRow['size'] as $size =>$quantity){
						if($key==$size){
							echo $quantity;
						}}
					if(!array_key_exists($key,$aRow['size']))
					{
						echo '-';
					}
				}?></td>
		 <?php }}?>
				<td width="4%;"><!--<a title="Update" style="float: right;" href="<?php echo getSiteUrl('inventory/invent/').$id ;?>"><i class="fa fa-info" aria-hidden="true"></i></a>-->
					<?php if($aUsr['role']==WAREHOUSE_ROLE && $aRow['warehouse_id']==$aUsr['id']){ echo"
					<a title='Update'  style='float: right;' href=".getSiteUrl('inventory/add/').$aRow['id']."><i class='fa fa-edit' aria-hidden='true'></i></a>";} else if($aUsr['role']==ADMIN_ROLE){echo "<a title='Update'  style='float: right;' href=".getSiteUrl('inventory/add/').$aRow['id']."><i class='fa fa-edit' aria-hidden='true'></i></a>" ;}?>
					</td>
			</tr>
	 <?php }}}?>
	 </tbody>
	</table>