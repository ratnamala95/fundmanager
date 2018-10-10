<?php //pr($aRows); ?>
<div class="header">
  <h4 class="title"><?php echo $title; ?></h4>
</div>

<div class="content">
  <div class="row">
    <div class="col-md-12">
      <table class="table table-striped">
        <thead>
          <th>User</th>
          <th>Project ID</th>
          <th>Project Name</th>
          <th>Duration</th>
          <th>Action</th>
        </thead>
        <tbody>
          <?php if($aRows){?>
          <?php foreach ($aRows as $aRow){ ?>
          <tr>
            <td><?php echo $aRow['user_name']; ?></td>
            <td><?php echo $aRow['project_id']; ?></td>
            <td><?php echo $aRow['project']; ?></td>
            <td><?php echo $aRow['duration']; ?></td>
            <td>
              <a href="<?php echo base_url('fundmanager/details/').$aRow['id']; ?>" title="List Details"><i class="fab fa-wpforms"></i></a>
              <a href="<?php echo base_url('fundmanager/rating/').$aRow['project_id'].'/'.$this->uri->segment(3); ?>" title="Show Rating"><i class="fa fa-star"></i></a>
              <a href="<?php echo base_url('fundmanager/createXLS/').$aRow['id']; ?>" title="Export Excel file"><i class="fa fa-file-excel-o" aria-hidden="true"></i></a>
            </td>
          </tr>
        <?php }}else{?>
          <tr><td colspan="5">No data found!!</td></tr>
        <?php } ?>
        </tbody>
      </table>
    </div>
  </div>

</div>
