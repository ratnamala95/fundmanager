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
    <link href='https://fonts.googleapis.com/css?family=Muli:400,300' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<script type="text/javascript">var baseURL= "<?php echo base_url();?>";</script>
	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script>
      $( function() {
        $(".classdelete").on('click',function(){
            $( "#dialogDelete" ).dialog();
            $("#dialogDelete .confirm-btn").attr('href',$(this).attr('attr')) ;
        });
        $(".classedit").on('click',function(){
            $( "#dialogEdit" ).dialog();
            $("#dialogEdit .confirm-btn").attr('href',$(this).attr('attr')) ;
        }); 
               
        $(".delete-close-btn").click(function() {
            $("#dialogDelete").dialog("close");
        });
        $(".edit-close-btn").click(function() {
            $("#dialogEdit").dialog("close");
        });
       
      } );
    </script>
</head>
	
<body>
<?php if(isset($this->session->userdata['admin_logged_in']) && $this->session->userdata['admin_logged_in'] == 1)   {   ?> 
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
         <?php loadView('template/footer'); ?>
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

<style type="text/css">
   .ui-widget.ui-widget-content {
       
        margin-top: -50% !important;
    }
</style>

<div id="dialogDelete" title="Delete" style="display: none;">
    <p>Are you sure you want to delete?</p>
    <div class="row">
        <div class="col-md-12">
           <a href=""  class="btn btn-success confirm-btn">Confirm</a>
            <button class="btn btn-default delete-close-btn">Close</button>
        </div>
    </div>
</div>
<div id="dialogEdit" title="Edit" style="display: none;">
    <p>Are you sure you want to Edit?</p>
    <div class="row">
        <div class="col-md-12">
           <a href=""  class="btn btn-success confirm-btn">Confirm</a>
           <button class="btn btn-default edit-close-btn">Close</button>
        </div>
    </div>  
</div> 
</body>
<script src="<?php echo base_url('assets/backend/');?>js/jquery-1.10.2.js" type="text/javascript"></script>
<script src="<?php echo base_url('assets/backend/');?>js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo base_url('assets/');?>js/function.js" type="text/javascript"></script>
<script src="<?php echo base_url('assets/backend/');?>js/paper-dashboard.js" type="text/javascript"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</html>
