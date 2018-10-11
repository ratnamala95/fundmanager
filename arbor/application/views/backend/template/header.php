<?php $aUsr=json_decode(json_encode($_SESSION['admin_user']), True); ?>
<nav class="navbar navbar-default">
<div class="container-fluid">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar bar1"></span>
            <span class="icon-bar bar2"></span>
            <span class="icon-bar bar3"></span>
        </button>
        
    </div>
    <div class="collapse navbar-collapse">
    <ul class="nav navbar-nav navbar-right">                       
        <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><p><?php echo $aUsr['name'];?></p><b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="<?php echo getSiteUrl('dashboard/setting'); ?>">Settings</a></li>
                <li><a href="<?php echo getSiteUrl('user/logout'); ?>">Logout</a></li>   
              </ul>
        </li>
       
    </ul>

    </div>
</div>
</nav>