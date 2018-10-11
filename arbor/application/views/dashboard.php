<?php $strpage="Dashboard";
 include 'include/header.php'; ?>
 
<!-- breadcrumbs -->
  <div class="breadcrumbs">
    <div class="container">
      <div class="col-md-3">
        <ol class="breadcrumb breadcrumb1 animated wow slideInLeft" data-wow-delay=".5s">
          <li><a href="<?= base_url(); ?>"><span class="glyphicon glyphicon-home" aria-hidden="true"></span>Home</a></li>
          <li class="active">Dashboard</li>
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
    
 
<div class="container-fluid">	 
<div class="tab-content">

      
     
    <!-- Profile update panel -->   
      <div class="tab-pane active" id="profile">


     		
      	<h3>&nbsp;</h3>

        <?php 
        if (validation_errors()) {
      ?>
        <div class="alert alert-danger"> 
          <?php echo validation_errors(); ?>
        </div>

      <?php } ?>


      <?php 
        if ($this->session->flashdata('errorupdatemsg')) {
      ?>
        <div class="alert alert-success"><?= $this->session->flashdata('errorupdatemsg'); ?></div>
      <?php 
        }
      ?>

       <?php 
        if ($this->session->flashdata('successupdatemsg')) {
      ?>
        <div class="alert alert-success"><?= $this->session->flashdata('successupdatemsg'); ?></div>
      <?php 
        }
      ?>
<style type="text/css">
  .credit-limit span.label{
    font-size: 18px;
  }
</style>

		    <form action="<?php echo base_url('dashboard/updateprofile'); ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
          <?php
            if(isset($userrow->credit_limit) && ''!=$userrow->credit_limit) {
          ?>
            <div class="form-group credit-limit">
                <label for="" class="control-label col-md-3">Credit Limit</label>
                <div class="col-md-8">
                  <span class="label label-warning"><?php  echo "<i class='fa fa-inr'></i> ".$userrow->credit_limit; ?></span>
                </div>
            </div>
          <?php } ?>  

            <?php $data = $this->Dbaction->getData('users',['id'=>$userrow->distributor_id]) ?>
            <div class="form-group">
                <label for="" class="control-label col-md-3">Distributor Name</label>
                <div class="col-md-8">
                  <input type="text" class="form-control" placeholder="Distributor Name" 
                  value="<?php if(!empty($data)) { echo $data["name"]; }  ?>" disabled required="required">
                </div>
            </div>


            <div class="form-group">
                <label for="" class="control-label col-md-3">Retailer Email</label>
                <div class="col-md-8">
                  <input type="text" class="form-control" placeholder="Email" 
                  value="<?= $userrow->email; ?>" disabled required="required">
                </div>
            </div>


  	    	  <div class="form-group">
		            <label for="name" class="control-label col-md-3">Retailer Name</label>
  	            <div class="col-md-8">
                  <input type="text" class="form-control" name="name" id="name" placeholder="Name" 
                  value="<?= $userrow->name; ?>" required="required">
		            </div>
		        </div>
                 
		    

            <div class="form-group">
                <label for="city" class="control-label col-md-3">Retailer City</label>
                <div class="col-md-8">
                    <select class="form-control" id="city" name="city" required="required">
                      <option value="">Select City</option>
                      <?php
                        if (0<count($citydata)) {

                          foreach ($citydata as $resultCity) {
                          $strSelected=""; 
                          if ($resultCity['id']==$userrow->city_id) {
                            $strSelected="selected='selected'"; 
                          }    
                      ?>
                        <option value="<?= $resultCity['id']; ?>" <?= $strSelected; ?> ><?= $resultCity['name']; ?></option>
                      <?php 
                          }
                        }
                      ?>    
                      
                    </select>                   
                </div>
            </div>



		        <div class="form-group">
                <label for="name" class="control-label col-md-3">Profile Image</label>
                
                <div class="col-md-6">
                  <input type="file" class="form-control" name="userfile" id="imgInp">
                </div>
                <div class="col-md-2 pull-left"><img id="blah" style="width: 39px; height: 36px;" src="<?php if(isset($userrow->image) && ''!=$userrow->image) { echo base_url('assets/uploads/').$userrow->image; } else { echo base_url('assets/images/user-512.png'); } ?>"></div>
            </div>

		       

		        <div class="form-group">

		            <div class="col-md-offset-3 col-md-10">

		                <button type="submit" name="updateprofile" class="btn btn-primary">Update</button>

		            </div>

		        </div>

		    </form>


      </div>
    <!-- profile update panel -->  
 

</div>            
</div>




     	</div>
	</div>   
</div>




<script type="text/javascript">
function readURL(input) {

  if (input.files && input.files[0]) {
    var reader = new FileReader();

    reader.onload = function(e) {
      $('#blah').attr('src', e.target.result);
    }

    reader.readAsDataURL(input.files[0]);
  }
}

$("#imgInp").change(function() {
  readURL(this);
});
</script>

<?php include 'include/footer.php'; ?>