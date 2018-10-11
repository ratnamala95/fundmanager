<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('getSiteUrl'))
{
   function getSiteUrl($aAction = '')
   {
      $ci =& get_instance();
      if($ci->uri->segment(1) == ADMIN_FOLDER)
      {
         $aAction = ADMIN_FOLDER."/".$aAction;
      }
      return site_url($aAction);
   }
} 

if ( ! function_exists('loadView'))
{ 
   function loadView($aView = '' , $aData = array() , $aParam = false)
   {
      $ci =& get_instance();
      if($ci->uri->segment(1) == ADMIN_FOLDER)
      {
         $aView = ADMIN_FOLDER."/".$aView;
      }
      $ci->load->view($aView, $aData , $aParam);
   }
} 


if ( ! function_exists('pr'))
{ 
   function pr($aData = array())
   {
         echo "<pre>";print_r($aData);echo "</pre>";
   }
}  


if ( ! function_exists('set_default_value'))
{ 
   function set_default_value($aField,$aVal = "")
   {
      if($aVal)
      {
         echo set_value($aField,$aVal);
      }
      else
      {
         echo set_value($aField);
      }
   }
}  



if ( ! function_exists('checkvalue'))
{ 
   function checkvalue($aData)
   {
      $return = "";
      if(isset($aData))
      {
         $return = $aData;
      }
      return $return;
   }
}
