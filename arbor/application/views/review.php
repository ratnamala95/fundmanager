<?php $strpage="Review";
 include 'include/header.php'; ?>


<!-- breadcrumbs -->
    <div class="breadcrumbs">
        <div class="container">
            <div class="col-md-3">
                <ol class="breadcrumb breadcrumb1 animated wow slideInLeft" data-wow-delay=".5s">
                    <li><a href="<?= base_url(); ?>"><span class="glyphicon glyphicon-home" aria-hidden="true"></span>Home</a></li>
                    <li class="active">Review</li>
                </ol>
            </div>
        </div>
    </div>
<!-- //breadcrumbs -->


<div class="container">
  <div class="row well" style="margin-top: 10px;background-color: #fff;
border: 1px solid #f5f5f5;">

		<div class="col-md-12">
                <!--<div class="panel">
                    <img class="pic img-circle" src="http://placehold.it/120x120" alt="...">
                    <div class="name"><small>Apple K, India</small></div>
                    <a href="#" class="btn btn-xs btn-primary pull-right" style="margin:10px;"><span class="glyphicon glyphicon-picture"></span> Change cover</a>
                </div>
                
    <br><br><br>-->
    

<div class="tab-content">

    <!-- change password panel -->   
     <div class="tab-pane active" id="security">
        <h3>&nbsp;</h3>

            <?php 
           


                if (validation_errors()) {
            ?>
            <div class="col-md-8 col-md-offset-3"> 
                <div class="alert alert-danger">    
                    <?php echo validation_errors(); ?>
                </div>
            </div>    
            <?php } ?>

        <?php if($this->session->flashdata('Review_msg')) { ?>
        <div class="col-md-8 col-md-offset-3"> 
           
            <div class="alert alert-success">   
                <?php echo $this->session->flashdata('Review_msg'); ?>
            </div>
        </div>    
        <?php } ?>

        <form action="<?= base_url('dashboard/review'); ?>" method="post" class="form-horizontal">

            <div class="form-group">
                <label for="title" class="control-label col-md-3">Title</label>
                <div class="col-md-8">
                    <input type="text" class="form-control" name="title" id="title" placeholder="Title" value="<?= set_value('title'); ?>" required="required" autocomplete="off">
                </div>
            </div>            

            <div class="form-group">
                <label for="password" class="control-label col-md-3">Description</label>
                <div class="col-md-8"> 
                    <textarea class="form-control" name="text" required="required" autocomplete="off" placeholder="Description"><?php if (!empty(set_value('text'))) {  echo set_value('text'); }  ?></textarea>
                    
                </div>
            </div>                 

            <div class="form-group">
                <div class="col-md-offset-3 col-md-9">
                    <button type="submit" name="submit_review" value="1" class="btn btn-primary">Submit Review</button>
                </div>
            </div>

        </form>
     </div>
  <!-- change password panel -->    
  

</div>            
</div>
</div>



</div>
</div>   
</div>







<?php include 'include/footer.php'; ?>