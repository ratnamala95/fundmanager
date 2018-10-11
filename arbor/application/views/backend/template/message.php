<?php
if(($this->session->flashdata('message')))
{
  $message = $this->session->flashdata('message');
?>
<div class="alert <?php echo $message['class']; ?>" id=""><?php echo $message['message']; ?></div>	
<div class="clear"></div>
<?php
}
?>
<?php echo validation_errors(); ?>