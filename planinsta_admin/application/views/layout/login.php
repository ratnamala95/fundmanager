<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php if($title) echo $title; ?></title>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo site_url('/styles/style.css'); ?>">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
  </head>
  <body>
    <div class="container">
      <div class="row main">
        <div class="panel-heading">
          <div class="panel-title text-center">
            <h3>Login User!</h3>
          </div>
        </div>
        <div class="main-login main-center">
          <?php
          $msg = $this->session->flashdata('message');
          $class = $this->session->flashdata('class');
          if($msg)
          {
            echo "<div class='alert alert-dismissable mt-2 alert-".$class."' id='message_box' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>".$msg."</div>";
          }
          ?>
          <form class="form-horizontal" action="<?php echo site_url('auth/login'); ?>" method="post">
            <div class="form-group col input-group">
              <span class="input-group-addon"><i class="fa fa-user fa" aria-hidden="true"></i></span>
              <input type="text" class="form-control" name="username" value="" placeholder="Enter username">
            </div>
            <div class="form-group col input-group">
              <span class="input-group-addon"><i class="fa fa-lock fa" aria-hidden="true"></i></span>
              <input type="password" class="form-control" name="password" value="" placeholder="Enter password">
            </div>
            <div class="form-group col input-group">
              <input type="submit" class="btn btn-primary btn-flat btn-block login-button" name="" value="Login">
            </div>
            <a href="<?php echo site_url('auth/forgot_password') ?>" style="text-align:left; font-size:11px; margin-left:-14px;">Forgot password</a>
          </form>
        </div>
      </div>
    </div>
  </body>
</html>
