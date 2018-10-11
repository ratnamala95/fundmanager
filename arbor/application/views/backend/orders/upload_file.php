<div class="container">
	<div class="row">
		<div class="header">
		    <h4 class="title" style="float: left;"><?php echo $title; ?></h4>
		</div>		
	</div>

	<div class="content table-responsive">
	    <!--filter data start-->
	    <div class="row">
	    	<form method="post" enctype="multipart/form-data" action="<?php echo getSiteUrl('order/upload_file')?>">  
		        <div class="col-md-6">
		        	<input type="hidden" name="order_id" id="orderId" value="<?php echo $this->uri->segment(4); ?>">
	        		<div class="form-group">
	        			<label>Multiple files upload</label>
	        			<input type="file" name="userfile[]" class="form-control border-input" multiple="multiple" accept=".xlsx,.xls,.doc, .docx,.ppt, .pptx,.txt,.pdf" />
	        		</div>
		        	
		        	<div class="text-left">
						<button type="submit" class="btn btn-primary" style="color: #fff;">Save</button>
					</div>
		        </div>
	        </form>	
	    </div>


	    <!-- document data start here -->
	    <?php if (isset($aRowData) && count($aRowData)>0) { ?>
	    <div class="row">
	        <div class="col-md-10">
	        	<div class="alert alert-success" id="file-remove-msg" style="display: none;">File remove successfully</div>

	        </div>
	        <div class="col-md-10">
	        	<table class="table">
	        		<thead>
	        			<tr>
	        				<th>Name</th>
	        				<th>Download Link</th>
	        				<th>Action</th>
	        			</tr>
	        		</thead>
	        		<tbody>
	        		<?php 	        		
						$count=0;
						$aryResponse['status']=1;
						foreach ($aRowData as $resultData) {
							++$count;
							$filename = preg_replace('/\\.[^.\\s]{3,4}$/', '', $resultData['doc_name']);
	        		?>

	        			<tr class="<?php echo  $resultData['doc_id']; ?>">
	        				<td><?php echo $filename ?></td>
	        				<td><a href="<?php echo base_url('assets/uploads/'.$resultData['doc_name']); ?> " download class="btn btn-primary" style="color:#fff">Download File </a></td>
	        				<td><a href="javascript:void(0)" onclick="removedocument(<?php echo $resultData['doc_id']; ?>)" class="btn btn-primary"><i class="fa fa-trash-o" aria-hidden="true" style="color:#fff"></i></a></td>
	        			</tr>

	        		<?php }
						
					?>	
					</tbody>
				</table>	
	        </div>
	    </div>
	    <!-- document data end here -->
	    <?php } ?>

	</div>
</div>	



<script type="text/javascript">
  	function removedocument(id)
    {
        var data='id='+id;
        $.post('<?php echo getSiteUrl('order/removedocument'); ?>',data, function(response){
            var results = jQuery.parseJSON(response);
            if (results.status==1) {
               $("#file-remove-msg").show(); 
               $("."+id).remove();
            } 
        });
    }    
</script>