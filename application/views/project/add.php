<div class="header">
    <h4 class="title" style="float: left;"><?php echo $title; ?></h4>
</div>
<div class="content">
  <form class="" method="post">
    <div class="clearfix">&nbsp;</div>
    <div class="row">
      <?php if ($bEdit): ?>
        <input type="hidden" name="val[id]" value="<?php echo $aRow['id']; ?>">
      <?php endif; ?>
      <div class="col-md-6">
        <label>Project Name</label>
        <input type="text" name="val[project_name]" value="<?php if($bEdit && $aRow) echo $aRow['project_name']; ?>" class="form-control border-input">
      </div>
      </div>
      <div class="row">
      <div class="col-md-6">
        <label>Description</label>
        <textarea name="val[description]" rows="8" cols="80" class="form-control border-input"><?php if($bEdit && $aRow) echo $aRow['description']; ?></textarea>
      </div>
      </div>
      <div class="row">
        <div class="col-md-6">
          <button type="submit" name="button" class="btn btn-info btn-fill">Submit</button>
        </div>
      </div>
  </form>
</div>
