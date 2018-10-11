<?php $strPageTitle="Contact"; include 'include/header.php'; ?>
<!-- breadcrumbs -->
  <div class="breadcrumbs">
    <div class="container">
      <div class="col-md-3">
        <ol class="breadcrumb breadcrumb1 animated wow slideInLeft" data-wow-delay=".5s">
          <li><a href="<?= base_url(); ?>"><span class="glyphicon glyphicon-home" aria-hidden="true"></span>Home</a></li>
          <li class="active">Contact</li>
        </ol>
      </div>
    </div>
  </div>
<!-- //breadcrumbs -->



<div class="container" style="margin-top: 3em;">

<h3 class="text-center" style="margin-bottom: 2em;">Contact us</h3><br />

<div class="row" style="margin-bottom: 2em;">

  <div class="col-md-8">
  	<?php 
		if (validation_errors()) {
	?>
		<div class="alert alert-danger">	
			<?php echo validation_errors(); ?>
		</div>

	<?php } ?>

	<?php if($this->session->flashdata('contactinquiirymsg')) { ?>
		<div class="alert alert-success">	
			<?php echo $this->session->flashdata('contactinquiirymsg'); ?>
		</div>
	<?php } ?>

      <form action="<?php echo base_url('contact/inquiry'); ?>" method="post">
        <input class="form-control" name="name" placeholder="Name..." value="<?php echo set_value('name'); ?>" required="required" /><br />
        <input class="form-control" name="phone" placeholder="Phone..."  value="<?php echo set_value('phone'); ?>" required="required"/><br />
        <input type="email" class="form-control" name="email" placeholder="E-mail..."  value="<?php echo set_value('email'); ?>" required="required"/><br />
 		<textarea class="form-control" required="required" name="text" placeholder="How can we help you?" style="height:150px;"><?php echo set_value('text'); ?></textarea><br />
        <input class="btn btn-primary btn-lg " type="submit" value="Send Inquiry" /><br /><br />
      </form>
  </div>

  <div class="col-md-4">
    <b>Customer service:</b> <br />
    Phone: +1 129 209 291<br />
    E-mail: <a href="webplanetsoft@gmail.com">webplanetsoft@gmail.com</a><br />
    <br /><br />
    
    <b>Headquarter:</b><br />
    113 Kings Tower, 2nd Floor, <br />
    King's Road, Nirman Nagar,<br />
    Jaipur, Rajasthan. 302019 <br />
    Phone: +91 75973 33337<br />
    <a href="mailto:webplanetsoft@gmail.com">webplanetsoft@gmail.com</a><br />


    
  </div>
</div>



</div>



<?php include 'include/footer.php'; ?>