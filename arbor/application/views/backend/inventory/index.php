<?php $aVals = $this->input->get('sel');//pr($aWare);?>
<div class="header">
 <h4 class="title" style="float: left;"><?php echo $title; ?></h4>
	<a style="float:right;" class="btn btn-info btn-wd btn-fill" href="<?php echo getSiteUrl('inventory/add/');?>">New Entry</a>
 <div class="clearfix">&nbsp;</div>
</div>

<div class="content table-responsive">
	<form method="get">
		<table>
			<div>
				<tr>
					<td>
						<div class="form-group marg">
							<select class="form-control border-input whouse" name="sel[warehouse_id]" style="width:172px; padding-left:5px; margin-left:10px;" value="<?php /*if($this->input->get('sel')) */echo $aVals['code'];?>">
								<option value="">Filter by Warehouse</option>
								<?php if(isset($aWare)){foreach($aWare as $id => $ware){if($id != ''){?>
								<option value="<?php echo $id; ?>" <?php if($aVals['warehouse_id'] ==$id) echo "selected"; ?>><?php echo $ware;?></option>
                                <?php }}}?>
							</select>
						</div>
					</td>
					<td>
						<div class="form-group">
							<input type="text" class="form-control border-input" name="sel[code]" style="width:172px; padding-left:5px; margin-left:10px;" placeholder="Filter by code or name" value="<?php echo $aVals['code'];?>">

						</div>
					</td>

                    <td>
                        <div class="form-group marg">
                            <select class="form-control border-input whouse" name="sel[orderby]" style="width:172px; padding-left:5px; margin-left:10px;" value="<?php echo $aVals['code'];?>">
                                <option value="">Filter Data</option>
                                <option value="1">Latest Update</option>
                                <option value="2">Order by Ascending</option>
                                <option value="3">Order by Descending</option>

                            </select>
                        </div>
                    </td>
<!--
					<td>
						<div class="form-group">
							<select class="form-control border-input" name="sel[product_name]" style="width:140px; padding-left:5px; margin-left:10px;">
								<option value="">Filter by Name</option>
								<?php foreach($aCodes as $code){?>
									<option value="<?php echo $code['id'];?>"><?php echo $code['name'];?></option>
								<?php }?>
							</select>
						</div>
					</td>
-->
					<td>
						<div class="form-group" style="margin-left:10px;">
							<button type="submit" class="btn btn-info btn-fill" name="submitform"><i class="fa fa-search"></i>Search</button>
						</div>
					</td>
					<td>
					   <div class="form-group" style="margin-left:10px;">
							<a href="<?php echo getSiteUrl('inventory/resetIndex');?>" class="btn btn-info btn-fill"><i class="fa fa-undo"></i>Reset</a>
						</div>
					</td>
				</tr>
			</div>
		</table>
	</form>
	<?php $id =''; if($aRows) { ?>
	<table class="table table-striped table-responsive" id="change">
	    <thead>
        	 <tr>
    			<th>Sr no.</th>
                <th>Image</th>
    			<th>Code</th>
    			<th>Warehouse</th>
    			<th>Name</th>
        		<?php
                if(isset($aSizes)) {
                    foreach($aSizes as $key => $value){
        			    if($key != ''){
        		?>
          	        <th><?php echo $value;?></th>
                <?php
                        }
                    }
                } ?>
        		<th>Action</th>
        	 </tr>
	    </thead>
    	 <tbody>
    			<?php



                if(isset($aCodes)){
                    $count=0;
                    if (!empty($this->uri->segment(4))) {
                        $count=$this->uri->segment(4);
                    }
        			foreach($aRows as $aRow) {

                        ++$count;
                        foreach ($aCodes as $array){
                            if($aRow['product_name']==$array['id'] && $aRow['code'] == $array['code']){
    			?>
    			<tr>
    			<td><?php echo $count; ?></td>
                <td>
                    <?php if($array && $array['image']) { ?>
                        <img src="<?php echo base_url('assets/uploads/'.$array['image']);?>" width="80px;">
                    <?php }?>
                </td>
    			<td><?php echo $array['code'];?></td>
    			<td><?php if(array_key_exists($aRow['warehouse_id'],$aWare)){echo $aWare[$aRow['warehouse_id']];}else {
            echo 'warehouse deactivated';
          }?></td>
    			<td><?php echo $array['name'];?></td>

    			<?php foreach($aSizes as $key => $value) {
    			if($key != ''){
    			?>
    			<td><?php $id = $aRow['product_name'];

    			if ($aUsr['role']==WAREHOUSE_ROLE && isset($aRow['size']) ) {
    				foreach($aRow['size'] as $size =>$quantity){
    					if($key==$size){
    						echo $quantity;
    					}}
    				if(!array_key_exists($key,$aRow['size']))
    				{
    					echo '-';
    				}
    			}else if($aUsr['role']==ADMIN_ROLE && isset($aRow['size'])){
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
    				<?php $_SESSION['ret'] = $this->uri->segment(4);if($aUsr['role']==WAREHOUSE_ROLE && $aRow['warehouse_id']==$aUsr['id']){ echo"


    				<a title='Update' href='javascript:void(0)'  style='float: right;' attr=".getSiteUrl('inventory/add/').$aRow['id']."><i class='fa fa-edit' aria-hidden='true'></i></a>";} else if($aUsr['role']==ADMIN_ROLE){echo "<a title='Update' class='classedit'  style='float: right;' href='javascript:void(0)' attr=".getSiteUrl('inventory/add/').$aRow['id']."><i class='fa fa-edit' aria-hidden='true'></i></a>";
                    }
                ?>
    				</td>
    			</tr>
    	<?php }}}}?>
    	<?php } else { ?>
           <tr><td colspan="12"> <p style="margin-left:30px;">No data found</p></td></tr>
        <?php } ?>
    	 </tbody>
	</table>


	<div class="col-md-6" style="float:right;" >
		<div style="float:right;">
			<?php echo $this->pagination->create_links('paging');?>
		</div>
	</div>
</div>
