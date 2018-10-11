


<div class="container">
	<div class="row well" style="margin-top: 10px;">



	<div class="col-md-2">
    	<ul class="nav nav-pills nav-stacked well" id="myTab">
		    <!--<li class="active"><a href="#inbox" data-toggle="tab"><i class="fa fa-home"></i> Dashboard</a></li>-->
		    <li class="<?php if(isset($strpage) && $strpage=="Dashboard") { echo "active"; } ?>" ><a href="<?php echo base_url('dashboard'); ?>"><i class="fa fa-user"></i> Profile</a></a></li>

        <li class="<?php if(isset($strpage) && $strpage=="Orders") { echo "active"; } ?>" ><a href="<?php echo base_url('dashboard/orders'); ?>"><i class="fa fa-shopping-cart"></i> Orders</a></a></li>

        	<li class="<?php if(isset($strpage) && $strpage=="Change password") { echo "active"; } ?>" ><a href="<?php echo base_url('dashboard/changepassword'); ?>"><i class="fa fa-key"></i> Security</a></a></li>
		    <li><a href="<?php echo base_url('dashboard/logout'); ?>" ><i class="fa fa-sign-out"></i> Logout</a></li>
		</ul>
	</div>