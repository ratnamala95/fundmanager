<div class="header">
    <h4 class="title" style="float: left;"><?php echo $title; ?></h4>
    
    <div class="clearfix">&nbsp;</div>
</div>

<div class="content">
<form method="post">
	
	<div class="row">
		<?php 
		 if (validation_errors()) {
            ?>
            <div class="col-md-10"> 
                <div class="alert alert-danger">    
                    <?php echo validation_errors(); ?>
                </div>
            </div>    
        <?php } ?>

        <?php if($this->session->flashdata('Review_msg')) { ?>
        <div class="col-md-10"> 
           
            <div class="alert alert-success">   
                <?php echo $this->session->flashdata('Review_msg'); ?>
            </div>
        </div>    
        <?php } ?>

		<div class="col-md-6">
			<div class="form-group">
				<label>Title</label>
				<input type="text" required="required" name="title" class="form-control border-input" placeholder="Title" 
				value="<?php set_value('title'); ?>">
			</div>	
			<div class="form-group">
				<label>Description</label>
				<textarea name="text" class="form-control border-input" placeholder="Description"><?php set_value('text'); ?></textarea>
				
			</div>			
					
			
			<div class="text-left">
				<button type="submit" name="submit_review" name="submit_review" value="1" class="btn btn-info btn-fill btn-wd">Submit review</button>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>    
</form>
</div>