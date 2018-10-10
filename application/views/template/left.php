<?php
$url = $this->uri->segment(1);
// if($this->uri->segment(3))
// {
//  $url .= "/".$this->uri->segment(3);
// }

$user_role = $this->session->userdata['user_logged_role_id'];
?>
	<div class="sidebar" data-background-color="white" data-active-color="danger">
  	<div class="sidebar-wrapper">
    	<div class="logo">
      	<a href="<?php echo base_url(''); ?>" class="simple-text">
          <?php echo SITE_TITLE; ?>
      	</a>
    	</div>

    	<ul class="nav">

    	<?php if($user_role == ADMIN_ROLE) {?>
        <!-- <li class="<?php echo $url == 'griglia' ? 'active':''; ?>">
        	<a href="<?php echo base_url('griglia'); ?>">
        	<p>Form</p>
        	</a>
      	</li> -->
      	<li class="<?php echo $url == 'project' ? 'active':''; ?>">
        	<a href="<?php echo base_url('project') ?>">
        	<p>Projects</p>
        	</a>
      	</li>
      	<li class="<?php echo $url == 'fundmanager' ? 'active':''; ?>">
        	<a href="<?php echo base_url('fundmanager') ?>">
        	<p>Fundmanager</p>
        	</a>
      	</li>
      	<li class="<?php echo $url == 'moderator' ? 'active':''; ?>">
        	<a href="<?php echo base_url('moderator') ?>">
        	<p>Moderator</p>
        	</a>
      	</li>
      	<?php } ?>
				<?php if ($user_role == MODERATOR_ROLE): ?>
					<li class="<?php echo $url == 'fundmanager' ? 'active':''; ?>">
	        	<a href="<?php echo base_url('fundmanager') ?>">
	        	<p>Fundmanager</p>
	        	</a>
	      	</li>
				<?php endif; ?>
				<?php if ($user_role == FUNDMANAGER_ROLE): ?>
					<li class="<?php echo $url == 'project' ? 'active':''; ?>">
	        	<a href="<?php echo base_url('project') ?>">
	        	<p>Projects</p>
	        	</a>
	      	</li>
					<li class="<?php echo $url == 'griglia' ? 'active':''; ?>">
	        	<a href="<?php echo base_url('griglia/index') ?>">
	        	<p>Form</p>
	        	</a>
	      	</li>
				<?php endif; ?>

    	</ul>
  	</div>
	</div>
