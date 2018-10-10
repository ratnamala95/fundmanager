<?php

/**
 *
 */
class Dashboard extends Griglia_Controller
{

  function __construct()
  {
    parent::__construct();
  }

  public function index()
  {
    $projects = array();

    $projects = $this->Dbaction->set_select_value($this->Dbaction->getAllData("projects",'',array()),"id","project_name");

    $this->content = 'frontend/dashboard';
    $this->title = 'Dashboard';
    $this->data = array('projects' => $projects);
    $this->layout();
  }
}

 ?>
