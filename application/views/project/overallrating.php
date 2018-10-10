<?php $aUsr = json_decode(json_encode($_SESSION['user']), True);
?>
<div class="header">
  <h4 class="title"><?php echo $title; ?></h4>
  <div class="clearfix">&nbsp;</div>
</div>

<div class="content">
  <div class="row">
    <div class="col-md-12">
      <table class="table table-striped table-responsive">
        <thead>
          <th>Project Name</th>
          <th>Project Value</th>
          <th>Duration</th>
          <th>Rating</th>
        </thead>
        <tbody>
          <?php foreach ($aRows as $aRow) {?>
            <tr>
              <td><?php echo $aRow['project']; ?></td>
              <td><?php echo $aRow['project_value']; ?></td>
              <td><?php echo $aRow['duration']; ?></td>
              <td><?php echo $aRow['rating']; ?></td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
      <div class="col-md-4" style="float:right;">
        <label style="float: right;">Overall Rating:  <?php echo $aRows['overallrating'];?></label>
      </div>
    </div>
  </div>
</div>
