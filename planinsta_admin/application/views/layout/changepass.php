<?php $this->load->view('layout/header'); ?>

<div class="alert alert-accent alert-dismissible fade show mb-0" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">×</span>
  </button>
  <i class="fa fa-info mx-2"></i>
  <strong>Logged In!!</strong></div>
<div class="main-content-container container-fluid px-4">
  <!-- Page Header -->
  <div class="page-header row no-gutters py-4 mb-3 border-bottom">
    <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
      <span class="text-uppercase page-subtitle">Settings</span>
      <h3 class="page-title">Change Password</h3>
    </div>
  </div>
  <!-- End Page Header -->
  <div class="row mb-2">
    <div class="col-lg-8 mb-4">
                <div class="card card-small mb-4 h-100">
                  <!-- <div class="card-header border-bottom">
                    <h6 class="m-0">Form Inputs</h6>
                  </div> -->
                  <ul class="list-group list-group-flush">
                    <!--  -->
                    <li class="list-group-item p-3">
                      <div class="row">
                        <div class="col-sm-12 col-md-12">
                          <div class="col-6">
                            <strong class="text-muted d-block mb-2">Forms</strong>
                            <form action="<?php echo site_url('Dashboard/change_pass') ?>" method="post">
                              <div class="form-group">
                                <div class="input-group mb-3">
                                  <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">@</span>
                                  </div>
                                  <input type="email" class="form-control" name="email" placeholder="" aria-label="Username" aria-describedby="basic-addon1" value="<?php echo $admin_data['email']; ?>" disabled> </div>
                                </div>
                                <div class="form-group">
                                  <input type="password" class="form-control" id="inputPassword4" name="passwd" placeholder="Password" value="">
                                </div>
                                <input type="submit" name="" class="btn btn-primary btn-flat" value="Change Password">
                            </form>
                          </div>
                        </div>
                      </div>
                    </li>
                  </ul>
                </div>
              </div>
  </div>
  <div class="row">
  </div>
</div>

<?php $this->load->view('layout/footer'); ?>
