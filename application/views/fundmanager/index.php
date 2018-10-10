<?php //pr($aUsr); ?>
<div class="header">
  <h4 class="title"><?php echo $title; ?></h4>
  <a href="<?php echo base_url('fundmanager/add/') ?>" class="btn btn-info btn-fill" style="float:right;margin-top: -28px;">Add New</a>
</div>

<div class="content">
  <div class="row">
    <div class="col-md-12">
      <table class="table table-striped">
        <thead>
          <th>ID</th>
          <th>Name</th>
          <th>Email</th>
          <th>Action</th>
        </thead>
        <tbody>
          <?php foreach ($fundmanagers as $fundmanager){ ?>
          <tr>
            <td><?php echo $fundmanager['id']; ?></td>
            <td><?php echo $fundmanager['name']; ?></td>
            <td><?php echo $fundmanager['email']; ?></td>
            <td>
              <?php if($aUsr['role']==MODERATOR_ROLE): ?>
                <a href="<?php echo base_url('fundmanager/view/').$fundmanager['id']; ?>" title="List Projects"><i class="fa fa-list"></i></a>
                <a href="<?php echo base_url('fundmanager/overallrating/').$fundmanager['id']; ?>" title="Overall Rating"><i class="fa fa-star"></i></a>
              <?php endif; ?>
              <?php if ($aUsr['role']==ADMIN_ROLE): ?>
                <a href="<?php echo base_url('fundmanager/add/').$fundmanager['id']; ?>" title="Edit"><i class="fa fa-edit"></i></a>
                <a href="<?php echo base_url('users/delete/').$fundmanager['id']; ?>" onclick="return confirm('Are you sure ?');" title="Delete"><i class="fa fa-trash"></i></a>
                <a href="<?php echo base_url('fundmanager/view/').$fundmanager['id']; ?>" title="List Projects"><i class="fa fa-list"></i></a>
              <?php endif; ?>
            </td>
          </tr>
        <?php } ?>
        </tbody>
      </table>
    </div>
  </div>

</div>
