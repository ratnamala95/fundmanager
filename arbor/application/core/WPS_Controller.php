<?php defined('BASEPATH') OR exit('No direct script access allowed');


class WPS_Controller extends CI_Controller
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
    loadView('template/index', $this->template);
  }
}

class Backend_Controller extends WPS_Controller
{
 function __construct()
 {
 parent::__construct();

 $controller = $this->uri->segment(2) ? $this->uri->segment(2) : "dashboard";
 $action = $this->uri->segment(3) ? $this->uri->segment(3) : "index";
 $curre_page = $controller.".".$action;


 $aclLists[ADMIN_ROLE] = array("*");
 $aclLists[WAREHOUSE_ROLE] = array("dashboard.index","dashboard.setting","product.index","product.add","product.search","user.index","user.logout","user.login","distributor.index","distributor.add","distributor.res","distributor.delete","warehouse.replace","warehouse.change","warehouse.request","warehouse.requests","warehouse.sRequests","warehouse.profile","order.index","warehouse.reject","warehouse.add","warehouse.mod","inventory.index","inventory.add","inventory.selectProduct","inventory.invent","inventory.resetIndex","retailer.index","retailer.add","retailer.delete","retailer.res","retailer.activate","order.details","order.upload_file","order.removedocument");
 $aclLists[DISTRIBUTOR_ROLE] = array("dashboard.index","dashboard.setting","dashboard.profile","product.index","user.logout","retailer.index","retailer.add","retailer.activate","retailer.delete","order.index","order.details","order.approve","distributor.profile","distributor.change","distributor.add","retailer.res","order.upload_file","order.removedocument","placeorder.index","placeorder.ajxdata","placeorder.ajxqtyfind","placeorder.order","placeorder.ajxpricefind","review.index");

 $admin_logged_role_id = isset($this->session->userdata['admin_logged_role_id']) ? $this->session->userdata['admin_logged_role_id'] : "";

 if($admin_logged_role_id != ADMIN_ROLE && $admin_logged_role_id != "")
 {
 $chkpapge = in_array($curre_page, $aclLists[$admin_logged_role_id]);
 if($chkpapge)
 {

 }
 else
 {
 $this->session->set_flashdata('message', array('message' => 'You are not allowed to acces this page','class' => 'alert-danger'));
 redirect(getSiteUrl('dashboard'), 'refresh');
 }
 }


 }

  function layout($layoutType = "")
  {

    $action = $this->uri->segment(3);

    if(isset($this->session->userdata['admin_logged_in']) && $this->session->userdata['admin_logged_in'] == 1)
    {
      if($this->content == "login")
      {
        redirect(getSiteUrl('dashboard'), 'refresh');
      }

    } else {

      if($layoutType != "login")
      {
        redirect(getSiteUrl('user/login'), 'refresh');
      }

    }


    $this->template['title'] = isset($this->title) ? $this->title : "Admin";
    $this->template['view'] = isset($this->content) ? $this->content : "user/login";
    $this->template['data'] = isset($this->data) ? $this->data : array();
    loadView('template/index', $this->template);
  }

}



class Frontend_Controller extends WPS_Controller
{
  function __construct()
  {

    parent::__construct();
    $data['catrow'] = $this->Dbaction->getAllData("category","",['status'=>1],"",7);

  }


  public function productcartcount()
  {

      if ($this->session->userdata('REATILER_ID')) {
      $aCons= array(
                'cart_retailer_id' => $this->session->userdata('REATILER_ID'),
                'cart_warehouse_id' => $this->session->userdata('WAREHOUSE_ID')
              );
      return $cartItemsData = $this->Dbaction->getCountRow('cart',"",$aCons);

    }

  }




}
