<?php $aUsr = json_decode(json_encode($_SESSION['user']), True); ?>
<div class="header">
  <h4 class="title"><?php echo $title; ?></h4>
  <a style="float: right;margin-top: -26px;" href="<?php echo base_url('project/add'); ?>" class="btn btn-fill btn-info">Add New</a>
  <div class="clearfix">&nbsp;</div>
</div>

<div class="content">
  <div class="row">
    <div class="col-md-12">
      <table class="table table-striped">
        <thead>
          <th>Id</th>
          <th>Project Name</th>
          <th>Description</th>
          <!-- <th>Status</th> -->
          <!-- <th>Duration</th> -->
          <th>Action</th>
        </thead>
        <tbody>
          <?php foreach ($projects as $project) { ?>
            <tr>
              <td><?php echo $project['id']; ?></td>
              <td><?php echo $project['project_name']; ?></td>
              <td style="word-wrap: break-word;max-width: 200px;"><?php echo $project['description']; ?></td>
              <!-- <td><?php echo $project['status']==0?'Inactive':'Active'; ?></td> -->
              <!-- <td><?php echo $project['duration']; ?></td> -->
              <td>
                <?php if($aUsr['role']==ADMIN_ROLE){ ?>
                  <a title="Edit" href="<?php echo base_url('project/add/').$project['id']; ?>"><i class="fa fa-edit"></i></a>
                  <!-- <a title="Delete" href="<?php echo base_url('project/delete/').$project['id']; ?>" onclick="return confirm('Are you sure ?');" ><i class="fa fa-trash"></i></a> -->
                <?php }else{ ?>
                  <a href="<?php echo base_url('griglia/index/').$project['id']; ?>" title="List Details"><i class="fab fa-wpforms"></i></a>
                <?php } ?>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
