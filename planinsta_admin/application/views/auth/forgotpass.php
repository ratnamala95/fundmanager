<?php
$login = array(
  'name'  => 'username',
  'id'  => 'login',
    'class' => 'form-control',
    'placeholder' => 'Email',
  'maxlength' => 80,
  'size'  => 30,
    'data-parsley-required'=>'true' ,
    'data-parsley-type'=>'email'
);

?>

<style>
  .btn-google{
        color: #fff;
        border-color: #f44336;
        background-color: #f44336;
        box-shadow: none;
  }
  .btn-linkedin{
        color: #fff;
        border-color: #003f67;
        background-color: #003f67;
        box-shadow: none;
  }
  .btn-facebook{
        color: #fff;
        border-color: #4267b2;
        background-color: #4267b2;
        box-shadow: none;
  }
    .btn-brand i{
      float: left;
      font-size: x-large;
    }
  label{
    font-size: 13px;
    margin-bottom: 0px;
    }

    .form-group{
        margin-bottom: 10px;
    }
</style>


  <!-- Tab panes -->
  <div class="tab-content">
        <div class="form-group text-center">
          <h5 class="auth-form__title text-center mb-4">Login</h5>
        </div>
    </div>
    <div id="altlogin"><br>
      <?php
                $msg = $this->session->flashdata('message');
                $class = $this->session->flashdata('class');
                if($msg)
                {
                  echo "<div class='alert alert-dismissable mt-2 alert-".$class."' id='message_box' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>".$msg."</div>";
                }
              ?>
              <?php if (validation_errors()) { ?><div class="alert alert-danger mt-2 login-alert-box" role="alert"><?php echo validation_errors(); ?></div> <?php }?>
              <?php if(count($this->aauth->get_errors_array()) > 0){ ?>
              <div class=" alert alert-danger mt-2" role="alert"><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button><?php $this->aauth->print_errors(); ?></div>
              <?php } ?>
        <?php echo form_open($this->uri->uri_string(),array('method' => 'post', 'id'=>'login_form', 'data-parsley-validate'=>"")); ?>
          <div class="form-group">
            <label for="login">Email address</label>
            <?php echo form_input($login); ?>
          </div>
          <button type="submit" class="btn btn-pill btn-accent d-table ml-auto">Sign In</button>
          <input type="hidden" name="role" value="3" />
          </div>
        </form>
        <div style="font-size: 12px;" class="auth-form__meta d-flex mt-3">
    </div>
    </div>
  </div>


      </div>
    </div>
