<div class="header">
  <h4 class="title"><?php echo $title; ?></h4>
</div>

<div class="content">
  <div class="row">
    <form class="" method="post">
      <div class="col-md-12">
        <?php if ($bEdit): ?>
          <input type="hidden" name="val[id]" value="<?php echo $aRow['id']; ?>">
        <?php endif; ?>
        <div class="col-md-6">
          <label>Name</label>
          <input type="text" name="val[name]" placeholder="Enter Name" class="form-control border-input" value="<?php if($bEdit && $aRow) echo $aRow['name']; ?>">
          <br>
          <!-- </div>
          <div class="col-md-6"> -->
          <label>Email</label>
          <input type="email" name="val[email]" placeholder="Enter Email" class="form-control border-input" value="<?php if($bEdit && $aRow) echo $aRow['email']; ?>">
        </div>
        <div class="col-md-8">&nbsp;</div>
        <!-- <div class="col-md-12">
          <label>Assign Projects</label><br><br>
          <?php //foreach ($projects as $key => $value): ?>
            <div class="col-md-3">
              <label><?php //echo $value; ?></label>
              <input type="checkbox" name="val[projects][]" value="<?php //echo $key; ?>">
            </div>
          <?php //endforeach; ?>
        </div> -->
        <div class="col-md-8">&nbsp;</div>
        <?php if (!$bEdit): ?>
          <div class="col-md-6">
            <label>Password</label>
            <input type="password" name="val[password]" value="" placeholder="Enter Password" class="form-control border-input">
          </div>
        <?php endif; ?>
        <div class="col-md-8">&nbsp;</div>
        <div class="col-md-6">
          <button type="submit" class="btn btn-info btn-fill"><?php echo $title; ?></button>
        </div>
      </div>
    </form>
  </div>
</div>
