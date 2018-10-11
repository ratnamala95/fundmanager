<?php $aVals = $this->session->userdata('sel');//pr($aRows);?>
<div class="header">
 <h4 class="title" style="float: left;"><?php echo $title; ?></h4>
 <div class="clearfix">&nbsp;</div>
</div>

<div class="content table-responsive">
	<div class="row">
	    <div class="col-md-12">
		<form method="get">
			<table>
				<div>
					<?php ?>
					<tr>
						<td>
							<div class="form-group marg">
								<select class="form-control border-input whouse" style="width:140px; padding-left:5px; margin-left:10px;" name="sel[warehouse_id]">
									<option value="">Filter by Warehouse</option>
									<?php foreach($aWare as $ware){if($ware['role'] == WAREHOUSE_ROLE){?>
									<option value="<?php echo $ware['id'];?>" <?php if($aVals['warehouse_id'] == $ware['id']) echo 'selected';?>><?php echo $ware['name'];?></option>
									<?php }}?>
								</select>
							</div>
						</td>
						<!--<td>
							<div class="form-group">
								<select class="form-control border-input " style="width:140px; padding-left:5px; margin-left:10px;">
									<option>Filter by Size</option>
									<?php foreach($aSizes as $key => $value){
										if($key != ''){
										?>
									<option value="<?php echo $key;?>"><?php echo $value;?></option>
									<?php }}?>
								</select>
							</div>
						</td>-->
						<td>
							<div class="form-group">
									<?php if(!$bEdit){?>
									<input type="text" name="sel[product_code]" class="form-control border-input" placeholder="Filter by code" style="width:140px; padding-left:5px; margin-left:10px;" value="<?php echo $aVals['product_code'];?>">
									<?php } else{?>
									<?php //$this->session->set_userdata('code',$aRows[0]['product_code']);?>
									<select class="form-control border-input" style="width:140px; padding-left:5px; margin-left:10px;" name="sel[product_code]"> 
									<option value="" selected><?php if($aRows){echo $aRows[0]['product_code'];}else echo 'code';?></option>
									<?php }?>
								</select>
							</div>
						</td>
						<td>
							<div class="form-group">
								<input type="text" placeholder="From date:"  onfocus="(this.type='date')" class="form-control border-input" style="width:140px; padding-left:5px; margin-left:10px;" name="sel[fdate]">
<!--								<select class="form-control border-input" style="width:140px; padding-left:5px; margin-left:10px;" name="sel[date]">-->	
<!--										<option value="<?php echo $date['date'];?>"><?php echo date('d M Y', strtotime($date['date']));?></option>-->
							</div>
						</td>
						<td>
							<div class="form-group">
								<input type="text" placeholder="To date:"  onfocus="(this.type='date')" class="form-control border-input" style="width:140px; padding-left:5px; margin-left:10px;" name="sel[sdate]">
<!--								<select class="form-control border-input" style="width:140px; padding-left:5px; margin-left:10px;" name="sel[date]">-->	
<!--										<option value="<?php echo $date['date'];?>"><?php echo date('d M Y', strtotime($date['date']));?></option>-->
							</div>
						</td>
						<td >
							<button type="submit" class="btn btn-info btn-fill" name="submitform" style="margin-left:10px;margin-top:-12px;"><i class="fa fa-search"></i>Search</button>
						
						</td>
						<td>
						    <a class="btn btn-info btn-fill " href="<?php echo $bEdit?getSiteUrl('inventory/resetTranz'):getSiteUrl('inventory/resetTrans');?>" style="margin-left:10px;margin-top:-12px;"><i class="fa fa-undo"></i>Reset</a>
						</td>
					</tr>
				</div>
			</table>
		</form>
	</div>
	</div>
	
		<table class="table table-striped" id="change">
    		 <thead>
    			 <tr>
					<th>sr no.</th>
					<th>Warehouse</th>
					<th>User</th>
					<th>Product Code</th>
					<th>Order Id</th>
					<th>Inventory</th>
					<th>Action</th>
					<th>Date</th>
					 <?php if($bEdit){?><th></th><?php }?>
				</tr>
		    </thead> 
		    <tbody>
		     	<?php if($aRows) {
		     	$cnt=0; 	
		     	if (!empty($this->uri->segment(4))) {
						$cnt= $this->uri->segment(4);
					}  
				foreach($aRows as $aRow){  
					
					++$cnt; 
				?>
				<tr>
					<td><?php echo $cnt;?></td>
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
						<td><?php echo date('d M Y', strtotime($aRow['date'])); ?></td>
					<?php if($bEdit){?>
					<td><a href="<?php echo getSiteUrl("inventory/editTrans/").$aRow['trans_id'];?>"><i class="fa fa-edit"></i></a></td>
					<?php }?>
				</tr>
				<?php }?>
				<?php } else { ?>
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
</div>