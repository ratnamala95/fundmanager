<!-- <?php //pr($projects); ?>
<div class="header">
	<h4 class="title"><?php echo $title; ?></h4>
</div>

<div class="content">
  <div class="row" id="formreplace">
    <div class="col-md-12">
      <div class="col-md-4">
        <label>Projects</label>
        <select class="form-control border-input" name="" id="selectproject" onchange="selectproject();">
					<option value="0">Select Project</option>
          <?php foreach ($projects as $key => $value){ ?>
            <option value="<?php echo $key; ?>"><?php echo $value ?></option>
          <?php }?>
        </select>
      </div>
      <div class="col-md-4">
        <label>Completion Period</label>
        <input type="text" name="" value="" class="form-control border-input">
      </div>
      <div class="col-md-4">
        <button type="submit" name="button" class="btn btn-info btn-fill marg">Go</button>
      </div>
    </div>
  </div>
  <div class="col-md-2">
    &nbsp;
  </div><br>
</div> -->

<div class="content">
   Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
</div>
