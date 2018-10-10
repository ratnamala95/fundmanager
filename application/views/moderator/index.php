<div class="header">
  <h4 class="title"><?php echo $title; ?></h4>
  <a href="<?php echo base_url('moderator/add/') ?>" class="btn btn-info btn-fill" style="float:right;margin-top: -28px;">Add New</a>
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
          <?php foreach ($moderators as $moderator){ ?>
          <tr>
            <td><?php echo $moderator['id']; ?></td>
            <td><?php echo $moderator['name']; ?></td>
            <td><?php echo $moderator['email']; ?></td>
            <td>
              <a href="<?php echo base_url('moderator/add/').$moderator['id']; ?>" title="Edit"><i class="fa fa-edit"></i></a>
              <a href="<?php echo base_url('users/delete/').$moderator['id']; ?>" onclick="return confirm('Are you sure ?');" title="Delete"><i class="fa fa-trash"></i></a>
            </td>
          </tr>
        <?php } ?>
        </tbody>
      </table>
    </div>
  </div>

</div>
