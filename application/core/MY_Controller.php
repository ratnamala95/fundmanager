<?php
  /**
   *
   */
  class MY_Controller extends CI_Controller
  {

    function __construct()
    {
      parent::__construct();
    }
    function is_custom_unique($value,$otherVal)
  {
      $vals = explode("||", $otherVal);
      $table = $vals[0];
      $name = $vals[1];
      $idField = $vals[2];
      $id = $vals[3];


      $this->db->from($table);
      $this->db->where($name,$value);
      if($id > 0)
      {
        $this->db->where($idField ." != ",$id);
      }

      $query = $this->db->get();
      if($query->num_rows() > 0)
      {
          $this->form_validation->set_message('is_custom_unique',"{$name} alredy in use try another");
          return false;
      }

      return true;
  }

    function layout()
    {
      $this->template['title']  =  isset($this->title) ? $this->title : "Admin";
      $this->template['view']   =  isset($this->content) ? $this->content : "user/login";
      $this->template['data']   =  isset($this->data) ? $this->data : array();
      loadView('frontend/index', $this->template);
    }
  }

  /**
   *
   */
  class Griglia_Controller extends MY_Controller
  {

    function __construct()
    {
      parent::__construct();
    }

    function layout($layoutType = "")
  {

    $action = $this->uri->segment(2);

    if(isset($this->session->userdata['user_logged_in']) && $this->session->userdata['user_logged_in'] == 1)
    {
      if($this->content == "login")
      {
        redirect(base_url('griglia',refresh));
      }

    } else {

      if($layoutType != "login")
      {
        redirect(base_url('users/login'), 'refresh');
      }

    }


    $this->template['title'] = isset($this->title) ? $this->title : "Admin";
    $this->template['view'] = isset($this->content) ? $this->content : "user/login";
    $this->template['data'] = isset($this->data) ? $this->data : array();
    loadView('frontend/index', $this->template);
  }
  }



?>
