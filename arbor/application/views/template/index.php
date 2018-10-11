<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<meta name="description" content="">
<meta name="author" content="">
<title><?php echo $title; ?></title>
<link href="<?php echo base_url('assets/');?>css/bootstrap.min.css" rel="stylesheet">
<script src="https://use.fontawesome.com/4bf3e7d2ae.js"></script>
<link href='https://fonts.googleapis.com/css?family=Muli:400,300' rel='stylesheet' type='text/css'>
<link href="<?php echo base_url('assets/');?>css/style.css" rel="stylesheet">
</head>
<body id="page-top">
<?php loadView('template/header'); ?>
<?php loadView($view,$data); ?>  
<?php loadView('template/footer'); ?>
<script src="<?php echo base_url('assets/backend/');?>js/jquery-1.10.2.js" type="text/javascript"></script>
<script src="<?php echo base_url('assets/backend/');?>js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo base_url('assets/');?>js/function.js"></script>
</body>
</html>
