<?php $strpage="Change password";
 include 'include/header.php'; ?>


<!-- breadcrumbs -->
    <div class="breadcrumbs">
        <div class="container">
            <div class="col-md-3">
                <ol class="breadcrumb breadcrumb1 animated wow slideInLeft" data-wow-delay=".5s">
                    <li><a href="<?= base_url(); ?>"><span class="glyphicon glyphicon-home" aria-hidden="true"></span>Home</a></li>
                    <li class="active">Change Password</li>
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

        <?php if (validation_errors()) { ?>
			<div class="alert alert-danger">	
				<?php echo validation_errors(); ?>
			</div>
		<?php } ?>

		<?php if($this->session->flashdata('successchangepass')) { ?>
		<div class="alert alert-success"><?= $this->session->flashdata('successchangepass'); ?></div>
		<?php } ?>

		<?php if($this->session->flashdata('errorchangepass')) { ?>
		<div class="alert alert-danger"><?= $this->session->flashdata('errorchangepass'); ?></div>
		<?php } ?>

        <form action="<?= base_url('dashboard/changepassword'); ?>" method="post" class="form-horizontal">


            <div class="form-group">
                <label for="oldpassword" class="control-label col-md-3">Old Password</label>
                <div class="col-md-8">
                    <input type="password" class="form-control" name="oldpassword" id="oldpassword" placeholder="Old Password" value="<?= set_value('oldpassword'); ?>" autocomplete="off" required="required">
                </div>
            </div>
            

            <div class="form-group">
                <label for="password" class="control-label col-md-3">New Password</label>
                <div class="col-md-8">
                    <input type="password" class="form-control" name="password" id="password" placeholder="New Password" value="<?= set_value('password'); ?>" autocomplete="off" required="required">
                </div>
            </div>
            

            <div class="form-group">
                <label for="passconf" class="control-label col-md-3">confirm Password</label>
                <div class="col-md-8">
                    <input type="password" class="form-control" name="passconf" id="passconf" placeholder="confirm Password" value="<?= set_value('passconf'); ?>" autocomplete="off" required="required">
                </div>
            </div>
           

            <div class="form-group">
                <div class="col-md-offset-3 col-md-9">
                    <button type="submit" name="change_password" class="btn btn-primary">Change Password</button>
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