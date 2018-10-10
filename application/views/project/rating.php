<?php $aUsr = json_decode(json_encode($_SESSION['user']), True);
?>
<div class="header">
  <h4 class="title"><?php echo $title; ?></h4>
  <!-- <a style="float: right;margin-top: -26px;" href="<?php echo base_url('fundmanager/createXLS/').$aRow['id']; ?>" class="btn btn-fill btn-info">Export</a> -->
  <div class="clearfix">&nbsp;</div>
</div>

<div class="content">
  <div class="row" id="replaceproject">
    <div class="col-md-12">
      <div class="col-md-5">
        <label>Project Name:</label>
        <select class="border-input form-control" id="selpro">
          <option value="0">select project</option>
          <?php foreach ($projects as $key => $value): ?>
            <option value="<?php echo $key; ?>" <?php if($aRow['project_id']==$key) echo 'selected'; ?>><?php echo $value; ?></option>
          <?php endforeach; ?>
        </select>
        <br>
        <label>Duration:</label>
        <input type="text" name="" value="<?php if($aRow) echo $aRow['duration']; ?>" class="form-control border-input">
        <a style="margin-top: 15px;" onclick="rating(<?php echo $this->uri->segment(4); ?>)" class="btn btn-fill btn-info">Go</a>
        <a style="margin-top: 15px;" href="<?php echo base_url('fundmanager/createXLS/').$aRow['id']; ?>" class="btn btn-fill btn-info">Export</a>
      </div>
      <div class="col-md-6">
      </div>
      <div class="col-md-8">&nbsp;</div>
      <table class="table table-striped table-bordered">
        <thead>
          <th>Sope</th>
          <th>Score</th>
          <th>Weighting</th>
          <th>Score after Weighting</th>
        </thead>
        <tbody>
          <?php foreach ($scope as $key => $value) {?>
            <tr>
              <td><?php echo $value; ?></td>
              <td><?php echo $score[$key]; ?></td>
              <td><?php echo $weighing[$key]; ?></td>
              <td><?php echo $rating[$key]; ?></td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
      <div class="col-md-4" style="float:right;">
        <label style="float: right;">Rating:  <?php echo $rating[7]; ?></label>
      </div>
    </div>
  </div>
</div>
