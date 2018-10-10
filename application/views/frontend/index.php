<!doctype html>
<html lang="en">
<head>

	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title><?php echo $title; ?> : <?php echo SITE_TITLE; ?></title>
	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />
    <link href="<?php echo base_url('assets/backend/');?>css/bootstrap.min.css" rel="stylesheet" />
    <link href="<?php echo base_url('assets/backend/');?>css/paper-dashboard.css" rel="stylesheet"/>

    <script src="https://use.fontawesome.com/4bf3e7d2ae.js"></script>
    <link href="<?php echo base_url('assets/');?>css/style.css" rel="stylesheet"/>
    <link href="<?php echo base_url('assets/');?>css/styles.css" rel="stylesheet"/>
    <link href='https://fonts.googleapis.com/css?family=Muli:400,300' rel='stylesheet' type='text/css'>
		<script type="text/javascript">var baseURL= "<?php echo base_url();?>";</script>
	  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
		<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script> -->
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
</head>

<body>
<?php if(isset($this->session->userdata['user_logged_in']) && $this->session->userdata['user_logged_in'] == 1)   {   ?>
<div class="wrapper">
<?php loadView('template/left'); ?>
<div class="main-panel">
  <?php loadView('template/header'); ?>
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <?php loadView('template/message'); ?>
          <div class="card">
         <?php loadView($view,$data); ?>
          </div>
        </div>
      </div>
    </div>
  </div>
   <?php //loadView('template/footer'); ?>
</div>
</div>
<?php } else { ?>
<div class="wrapper">
    <div class="main-panel" style="float: none;width: 100%;padding-top: 10%;">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <div class="card">
                       <?php loadView($view,$data); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php } ?>

</body>
<script src="<?php echo base_url('assets/backend/');?>js/jquery-1.10.2.js" type="text/javascript"></script>
<script src="<?php echo base_url('assets/backend/');?>js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo base_url('assets/');?>js/function.js" type="text/javascript"></script>
</html>
