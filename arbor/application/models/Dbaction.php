<?php
class Dbaction extends CI_Model {
  
  
  function __construct() 
  {
    parent::__construct();
  }


function encryptFunction($val)
{
	//$this->encrypt->hash($aVals['password'])
	return md5($val);
}



function adminLogin($aVals)
{
	$this->db->select('*');
	$this->db->from('users');
	$this->db->group_start();
	$this->db->where('role',ADMIN_ROLE);
	$this->db->or_where('role',WAREHOUSE_ROLE);
	$this->db->or_where('role',DISTRIBUTOR_ROLE);
	$this->db->group_end();
	$this->db->where('email',$aVals['email']);
	$this->db->where('password',$this->encryptFunction($aVals['password']));
	$this->db->limit(1);	
	$query = $this->db->get();

	//echo $this->db->last_query();

	//die();
	
	if($query->num_rows() == 1)
	{
		return $query->result();
	}
	else
	{
		return false;
	}
}
  
  function adddata($aTbl,$aVals)
  {	
		if($this->db->insert($aTbl,$aVals))
		{
			return $this->db->insert_id();
		}
		return false;
  }
  function deleteData($aTbl,$aCons = array())
  {	
		if($aCons)
		{
			foreach($aCons as $aKey => $aCon)
			{
				$this->db->where($aKey,$aCon);
			}
		}
	   	$this->db->delete($aTbl);
		return true;
  }
  function updateData($aTbl,$aVals,$aCons = array())
  {	
		if($aCons)
		{
			foreach($aCons as $aKey => $aCon)
			{
				$this->db->where($aKey,$aCon);
			}
		}
		
	  $this->db->update($aTbl, $aVals);
	  
	 
		return true;
  }


  

  function getAllData($aTbl,$aSelect = '*',$aCons = array(),$aJoins = array(),$aLImit  = 0,$aOrders = array(),$page = 0)
  {
  		$aVals = array();
  		$this->db->select($aSelect);
		$this->db->from($aTbl);
	
		if($aCons)
		{
			foreach($aCons as $aKey => $aCon)
			{
				$this->db->where($aKey,$aCon);
			}
		}
		
		
		if($aJoins)
		{
			foreach($aJoins as $jKey => $aJoin)
			{
				$this->db->join($jKey,$aJoin);
			}
		}

		if($aOrders)
		{
			foreach($aOrders as $oKey => $aOrder)
			{
				$this->db->order_by($oKey,$aOrder);
			}
		}

	
		if($aLImit > 0)
		{
			/*
			$start = 0;
			if($page > 0)
			{
				$start = ($page-1)*$aLImit;
			}
			*/
			
			$this->db->limit($aLImit,$page);
		}
		
		$query = $this->db->get();

		//echo $this->db->last_query();
		
		if($query->num_rows() > 0)
		{		
			foreach($query->result() as $aKey => $aVal)
			{
				$aVals[$aKey] = (array)$aVal;
			}
		}
		
		return $aVals;	
  }
	
	function getLikeData($aTbl,$aSelect = '*',$aCons = array(),$aJoins = array(),$aLImit  = 0,$aOrders=array(),$aLike = '',$page = 0)
    {
  		$aVals = array();
  		$this->db->select($aSelect);
		$this->db->from($aTbl);
	
		if($aCons)
		{
			foreach($aCons as $aKey => $aCon)
			{
				$this->db->where($aKey,$aCon);
			}
		}
		
		
		
		if($aJoins)
		{
			foreach($aJoins as $jKey => $aJoin)
			{
				$this->db->join($jKey,$aJoin);
			}
		}

		if($aOrders)
		{
			foreach($aOrders as $oKey => $aOrder)
			{
				$this->db->order_by($oKey,$aOrder);
			}
		}

		if($aLike)
		{
			$this->db->like('products.name',$aLike)
					->or_group_start()
                ->like('inventory.code', $aLike)
//					->or_group_end()
        ->group_end();
				
		}

	
		if($aLImit > 0)
		{
			/*
			$start = 0;
			if($page > 0)
			{
				$start = ($page-1)*$aLImit;
			}
			*/
			
			$this->db->limit($aLImit,$page);
		}
		
		$query = $this->db->get();

		//echo $this->db->last_query();
		
		if($query->num_rows() > 0)
		{		
			foreach($query->result() as $aKey => $aVal)
			{
				$aVals[$aKey] = (array)$aVal;
			}
		}
		
		return $aVals;	
    }
	
	
	function getTransData($aTbl,$aSelect = '*',$aCons = array(),$aJoins = array(),$aLImit  = 0,$aLike = '',$aDate = array(),$page = 0)
  {
  		$aVals = array();
  		$this->db->select($aSelect);
		$this->db->from($aTbl);
	
		if($aCons)
		{
			foreach($aCons as $aKey => $aCon)
			{
				$this->db->where($aKey,$aCon);
			}
		}
		
		
		if($aJoins)
		{
			foreach($aJoins as $jKey => $aJoin)
			{
				$this->db->join($jKey,$aJoin);
			}
		}

		if($aLike)
		{
			$this->db->like('product_code',$aLike);
				
		}
		
		if($aDate)
		{
			$this->db->where('date >=', $aDate['fdate']);
			$this->db->where('date <=', $aDate['sdate']);
		}

	
		if($aLImit > 0)
		{
			/*
			$start = 0;
			if($page > 0)
			{
				$start = ($page-1)*$aLImit;
			}
			*/
			
			$this->db->limit($aLImit,$page);
		}
		
		$query = $this->db->get();

		//echo $this->db->last_query();
		
		if($query->num_rows() > 0)
		{		
			foreach($query->result() as $aKey => $aVal)
			{
				$aVals[$aKey] = (array)$aVal;
			}
		}
		
		return $aVals;	
  }
  
  
  function getCustomQuery($aSql)
  {
  	$aVals = array();
  	
  	$query = $this->db->query($aSql);
  	
  	if($query->num_rows() > 0)
	{		
		foreach($query->result() as $aKey => $aVal)
		{
			$aVals[$aKey] = (array)$aVal;
		}
	}
		
	return $aVals;
  }
  
  
  
  function getData($aTbl,$aCons = array())
  {
  	$aVal = array();
  	$this->db->select('*');
	$this->db->from($aTbl);
	if($aCons)
	{
		foreach($aCons as $aKey => $aCon)
		{
			$this->db->where($aKey,$aCon);
		}
	}
	$query = $this->db->get();
	
	if($query->num_rows() > 0)
	{		
		$aVal = (array)$query->row(); 
	}
	
	return $aVal;	
  }

  function getSettingByKey($option_key = "")
  {
  	$option_value = "";
  	$aRow = $this->Dbaction->getData("setting",array("option_key" =>$option_key));	
  	if($aRow)
  	{
  		$option_value = $aRow['option_value'];
  	}
  	return $option_value;
  }

   	function uploadFiles($aImg = "",$allowed_types)
 	{
 		$config['upload_path']          = FCPATH.'assets/uploads/';
        $config['allowed_types']        = $allowed_types;  		
  		$this->load->library('upload', $config);
  		$this->upload->initialize($config);



        if ($this->upload->do_upload($aImg))
        {
                $data = $this->upload->data();
                $file_url = base_url("assets/uploads/".$data['file_name']);          
				$data['file_url'] = $file_url;

			    return $data;
        }  
        return false;
            
 	}


 	function set_select_value($aRows,$aKey,$aVal)
 	{
 		$aData = array("" => "Select");
 		if($aRows)
 		{
 			foreach ($aRows as $key => $aRow)
 			{
 				$aData[$aRow[$aKey]] = $aRow[$aVal];
 			}
 		}

 		return $aData;
 	}
	
	
	

	/** Ratnamala function start */
/** Ratnamala function start */
	function toSimpleArray($aData)
	{
	$attributes = $aData['attributes'] ? unserialize($aData['attributes']) : ""; 

	return $attributes;
	}
	

 function checkInventory($mData,$iData)
	{
	$temp['attributes'] = $iData['size'];	
	$iData['size'] = $this->toSimpleArray($temp);
	$temp['attributes'] = $mData['size'];	
	$mData['size'] = $this->toSimpleArray($temp);
	
	$data = $this->Dbaction->getData("inventory",array('product_name'=> $mData['product_id'],'code'=> $mData['code'],'warehouse_id' => $mData['sender']));
	foreach($mData['size'] as $size => $quant)
	{
	foreach($iData['size'] as $isize => $iquant)
	{
	if($size==$isize && $iquant >= $quant)
	{
	$te[$size] = $iquant - $quant;
	$me[$size] = $quant;
	}
	}
	}
	
	if($data)
	{
		$iData['size'] = serialize(array_replace($iData['size'],$te));

		$temp['attributes'] = $data['size'];	
		$data['size'] = $this->toSimpleArray($temp);
		$tem = array();
		foreach($data['size'] as $size => $value)
		{
			if(array_key_exists($size,$me))
			{
				$tem[$size] = $value + $me[$size];
			}
		}

		$data['size'] = serialize($tem);

		$this->Dbaction->updateData('inventory',$iData,array('id'=>$iData['id']));
		$this->Dbaction->updateData('inventory',$data,array('id'=>$data['id']));

		return true;
	}
	else
	{
	
		$iData['size'] = serialize(array_replace($iData['size'],$te));

		$data['product_name'] = $mData['product_id'];
		$data['warehouse_id'] = $mData['sender'];
		$data['category'] = $mData['category'];
		$data['size'] = serialize($me);
		$data['code'] = $mData['code'];
		$data['price'] = $iData['price'];
		$data['sale_price'] = $iData['sale_price'];
		$data['pieces_per_set'] = $iData['pieces_per_set'];
		$data['gst'] = $iData['gst'];
		$data['status'] = 1;
	
//	pr($data);
//	pr($iData['size']);die;
	$this->Dbaction->updateData('inventory',$iData,array('id'=>$iData['id']));
	$this->Dbaction->adddata('inventory',$data);
	
	return true;
	}
	}
	
	function reject($iData,$mData,$temp)
	{
	$tem['attributes'] = $iData['size'];	
	$iData['size'] = $this->toSimpleArray($tem);
	$tem['attributes'] = $mData['size'];	
	$mData['size'] = $this->toSimpleArray($tem);
	$tem['attributes'] = $temp['size'];	
	$temp['size'] = $this->toSimpleArray($tem);
	
	
	foreach($mData['size'] as $size => $quant)
	{
	foreach($temp['size'] as $isize => $tquant)
	{
		if($size==$isize && $quant >= $tquant)
		{
			$te[$size] = $quant - $tquant;
			$me[$size] = $tquant;
		}
	}
	}
	
	foreach($iData['size'] as $size => $value)
	{
		if(array_key_exists($size,$me))
		{
			$se[$size] = $value + $me[$size];
		}
		else
		{
			$se[$size] = $value;
		}
	
	}
	
	
	$iData['size'] = serialize($se);
	$mData['size'] = serialize(array_replace($mData['size'],$te));
	
	$this->Dbaction->updateData('inventory',$iData,array('id'=>$iData['id']));
	$this->Dbaction->updateData('inventory',$mData,array('id'=>$mData['id']));
	
	return true;
	}
	
	function userializeTrans($aRows)
	{
	$temp = array();
	$row = array();
	foreach($aRows as $aRow)
	{
	$row['trans_id'] = $aRow['trans_id'];
	$row['order_id'] = $aRow['order_id'];
	$row['warehouse_id'] =$aRow['warehouse_id'];
	$row['user_id'] =$aRow['user_id'];
	$row['product_id'] =$aRow['product_id'];
	$row['product_code'] =$aRow['product_code'];
	$row['inventory'] = unserialize($aRow['inventory']);
 $row['flag'] =$aRow['flag'];
	$row['date'] =$aRow['date'];
	array_push($temp,$row);
	}
	return $temp;
	}
	
	function userializeInventory($aRows)
	{
	$temp = array();
	foreach($aRows as $aRow)
	{
	$aRow['size'] = unserialize($aRow['size']);
	
	array_push($temp, $aRow);
	}
	return $temp;
		
	}
		
/***********************************************/
		public function record_count($tbl) {
 
       return $this->db->count_all($tbl);
 
   }
 
 
 
   public function fetch_records($limit, $start,$tbl) {
 
       $this->db->limit($limit, $start);
 
       $query = $this->db->get($tbl);
 
 
 
       if ($query->num_rows() > 0) {
 
           foreach ($query->result() as $row) {
 
               $data[] = $row;
 
           }
 
           return $data;
 
       }
 
       return false;
 
   }

   public function paging($url,$totalrow,$perpageproducts,$firsturl)
	{

	//$this->load->library('pagination');

	$config['base_url'] = $url;
	$config['total_rows'] = $totalrow;
	$config['per_page'] = $perpageproducts;
	$config['full_tag_open'] = '<nav class="numbering"> <ul class="pagination paging">';
	$config['full_tag_close'] = '</ul></nav>';
	$config['first_link'] = 'First';
	$config['last_link'] = 'Last';
	$config['first_tag_open'] = '<li class="active">';
	$config['first_tag_close'] = '</li>';
	$config['first_url'] = $firsturl;
	$config['last_tag_open'] = '<li>';
	$config['last_tag_close'] = '</li>';
	$config['next_tag_open'] = '<li>';
	$config['next_tag_close'] = '</li>';
	$config['prev_tag_open'] = '<li>';
	$config['prev_tag_close'] = '</li>';
	$config['cur_tag_open'] = '<li class="active"><a>';
	$config['cur_tag_close'] = '</a></li>';
	$config['num_tag_open'] = '<li>';
	$config['num_tag_close'] = '</li>';
	$config['uri_segment'] = 4;

	$this->pagination->initialize($config);

	}
/***********************************************/
	
	/***** Ratnamala function end *****/





	/******* pavan function start  ***********/
	
	function getSingleData($aTbl,$aSelect = '*',$aCons = array(),$aJoins = array(),$aOrders=array())
  {
  	$aVal = array();
  	$this->db->select($aSelect);
		$this->db->from($aTbl);
		if($aCons)
		{
			foreach($aCons as $aKey => $aCon)
			{
				$this->db->where($aKey,$aCon);
			}
		}

		if($aJoins)
			{
			foreach($aJoins as $jKey => $aJoin)
			{
				$this->db->join($jKey,$aJoin);
			}
		}
		if($aOrders)
		{
			foreach($aOrders as $oKey => $aOrder)
			{
				$this->db->order_by($oKey,$aOrder);
			}
		}

		$query = $this->db->get();

		if($query->num_rows() > 0)
		{		
			$aVal = (array)$query->row(); 
		}

		return $aVal;	
	}
	
	
	function sendEmail($to,$subject,$body)
	{
		$this->load->library('email');

		$config = array(

		 	'protocol' => 'smtp',
		    'smtp_host' => 'ssl://smtp.googlemail.com',
	      	'smtp_port' => 465,
		 	'smtp_user' => 'lizzieasdf@gmail.com',
		 	'smtp_pass' => 'Anushri10ejecs0161',
		 	'mailtype' => 'html',
		 	'charset' => 'utf-8'

		);

		$this->email->initialize($config);
		$this->email->set_mailtype("html");
		$this->email->set_newline("\r\n");
		$this->email->from('info@webplanetssoft.com', 'web plante soft');
		$this->email->to($to);
		$this->email->subject($subject); 
		$this->email->message($body);
		$this->email->send();

		 //print_r($this->email->print_debugger());
		return true;

	}


	function getCountRow($aTbl,$aSelect = '*',$aCons = array(),$aJoins = array(),$aLImit  = 0,$aOrders = array(),$page = 0)
  	{
  		$aVals = array();
  		$this->db->select($aSelect);
		$this->db->from($aTbl);
	
		if($aCons)
		{
			foreach($aCons as $aKey => $aCon)
			{
				$this->db->where($aKey,$aCon);
			}
		}
		
		
		if($aJoins)
		{
			foreach($aJoins as $jKey => $aJoin)
			{
				$this->db->join($jKey,$aJoin);
			}
		}

		if($aOrders)
		{
			foreach($aOrders as $oKey => $aOrder)
			{
				$this->db->order_by($oKey,$aOrder);
			}
		}

	
		if($aLImit > 0)
		{
			/*
			$start = 0;
			if($page > 0)
			{
				$start = ($page-1)*$aLImit;
			}
			*/
			
			$this->db->limit($aLImit,$page);
		}
		
		$query = $this->db->get();

		//echo $this->db->last_query();
		
		if($query->num_rows() > 0)
		{	
			return $query->num_rows();
		}

		
 	}
  



	public function pagination($url,$totalrow,$perpageproducts,$firsturl)
	{

		//$this->load->library('pagination');

		$config['base_url'] = $url;
		$config['total_rows'] = $totalrow;
		$config['per_page'] = $perpageproducts;
		$config['full_tag_open'] = '<nav class="numbering"> <ul class="pagination paging">';
		$config['full_tag_close'] = '</ul></nav>';
		$config['first_link'] = 'First';
		$config['last_link'] = 'Last';
		$config['first_tag_open'] = '<li class="active">';
		$config['first_tag_close'] = '</li>';
		$config['first_url'] = $firsturl;
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active"><a>';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';

		$this->pagination->initialize($config);

	}




public function emailTemplate($strUserName,$strMessage)
{ 
    
    $strEmailTemplate = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
		<head>

		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

		<!-- Responsive Meta Tag -->
		<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;" />
		<title>Maline</title>

		<style type="text/css">

		body{width:100%;margin:0px;padding:0px;background:#ffffff;text-align:center;}
		html{width: 100%; }
		img {border:0px;text-decoration:none;display:block;}
		a,a:hover{color:#2c8fd6;text-decoration:none;}.ReadMsgBody{width: 100%; background-color: #ffffff;}.ExternalClass{width: 100%; background-color: #ffffff;}
		table { border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt; } 
		.main-bg{ background:#ffffff;}

		@media only screen and (max-width:640px)

		{
			
			.main{width: 440px !important;}
			.inner{width: 400px !important;}
			.column{width: 440px !important;}
			
		}

		@media only screen and (max-width:479px)

		{
			.main{width: 280px !important;}
			.inner{width: 240px !important;}
			.column{width: 240px !important;}
		}


		</style>

		</head>

		<body>

		  <!--  Main Table Start-->

		<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="main-bg" style="background:#f5f5f5;margin-top:10px;">
		 
		  <tr>
		        <td align="center" valign="top" style="padding-bottom:0px;">
		    
		 
		    <!--  Inner Table Start-->
		    
		    <table width="600" border="0" align="center" cellpadding="0" cellspacing="0" class="main" style="margin-top: 5px;">
		     <tr>
		        <td align="left" valign="top">
		        
		        <!--  Banner Start-->
		        <table width="600" border="0" align="center" cellpadding="0" cellspacing="0" class="main">
		          
		          <tr>
		            <td align="left" valign="top"><table width="600" border="0" align="center" cellpadding="0" cellspacing="0" class="main">
		              <tr>
		                <td align="center" valign="top" bgcolor="#fff" style="background:#fff; padding-top:47px; padding-bottom:25px;"><table width="560" border="0" cellspacing="0" cellpadding="0" class="inner">
		                  <tr>
		                    <td align="left" valign="top" style="font:Bold 24px Arial, Helvetica, sans-serif; color:#333; padding-top:2px;">Hi '.$strUserName.',</td>
		                  </tr>

		                  <tr>
		                    <td align="left" valign="top" style="font:Normal 12px Arial, Helvetica, sans-serif; color:#333; line-height:24px; padding:10px 0px 10px 0px;">'.$strMessage.'</td>
		                  </tr>
						  
						   <tr>
		                    <td align="left" valign="top" style="font:Normal 12px Arial, Helvetica, sans-serif; color:#333; line-height:24px; padding:15px 0px 0px 0px;">Thanks,</td>
		                  </tr>
						   <tr>
		                    <td align="left" valign="top" style="font:Normal 12px Arial, Helvetica, sans-serif; color:#333; line-height:24px; padding:0px 0px 20px 0px;">'.SITE_TITLE.'</td>
		                  </tr>
						  <tr>
		                    <td align="left" valign="top" style="font:Normal 12px Arial, Helvetica, sans-serif; color:#333; line-height:24px; padding:0px 0px 20px 0px;"><img src="'.base_url().'images/logo.png"  alt="" style="display:block;width:30% !important; height:auto !important; " /></td>
		                  </tr>
		                 </table></td>
		              </tr>
		             
		            </table></td>
		          </tr>
		        </table>
		        <!--  Banner End-->
		        
		        </td>
		      </tr>
		      </table>
		    
		    <!--  Inner Table End-->
		    
		    </td>
		  </tr>
		  <tr>
		    <td height="100" align="center" valign="middle" style="border-top:#e3e3e3 solid 1px;">
		    
		 
		        
		    <!--  Copyright part Start-->
		    <table width="600" border="0" cellspacing="0" cellpadding="0" class="main">
		      <tr>
		        <td align="center" valign="top" style="font:Normal 12px Arial, Helvetica, sans-serif; color:#363535; line-height:24px;">Change notification settings | Privacy Policy | Contact Support <br /> info@ecommerce.com If you no longer wish to receive emails please <br /></td>
		      </tr>
		      <tr>
		        <td align="center" valign="top" style="font:Bold 14px Arial, Helvetica, sans-serif; color:#363535; padding-top:8px;">Copyright © 2018 <a href="'.base_url().'">'.base_url().'</a></td>
		      </tr>
		    </table>
		    <!--  Copyright part End-->
		    

		    
		    </td>
		  </tr>
		</table>

		  <!--  Main Table End-->


		</body>


		</html>'; 


	return $strEmailTemplate;
}




function sendInvoiceTemplatePlaceOrders($intInsertId)
 { 
 	
 	$rowTransListInfo =  $this->getData('orders','',['orders_id'=>$intInsertId]);
	 
	$strUserTransEmail=$rowTransListInfo['customers_email'];
	$strUserMobile=$rowTransListInfo['billing_phone'];
	$strUserTransName=$rowTransListInfo['customers_name'];
	$strUserTransOrderNumber=$rowTransListInfo['customer_trans_order_id'];
	$strUserTransAmount=$rowTransListInfo['order_total'];
	$subject =' ORDER NO '.$strUserTransOrderNumber.' Has Received';
	$strSenderEmail =' shop '.base_url();
	$to=$strUserTransEmail;
		
							
$headers = "MIME-Version: 1.0\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers .= "From: ".$strSenderEmail. "\r\n";		
$headers.="Return-Path: ".$strSenderEmail."\r\n" ;
$headers.="Reply-To: ".$strSenderEmail."\r\n" ;
$strUserName=$rowTransListInfo['customers_name'];


$strMessage = '
<div style="text-align:center;font-weight:bold;">
<p>'.$rowTransListInfo['customers_name'].'</p>
<p>Phone: +91'.$strUserMobile.'</p>
<p>ORDER #'.$strUserTransOrderNumber.'</p></div>
<table border="1">
                <tr>
				
             
                  <th style="text-align:center;width:5%;" class="name">Sr. No</th>
				  <th style="text-align:center;width:15%;" class="name"> Item</th>
                  <th style="text-align:center;width:10%;" class="name"> Price</th>
                  <th style="text-align:center;width:10%;" class="name"> Quantity</th>				  
                  <th style="text-align:center;width:20%;" class="name">Total</th>    
                </tr>'; 
				$intCounter=0;
				$decTotalAmount=0;
				$totalgst=0;
				$TotalAmount=0;

						$aJoins = array(
				 				
								'products'=>'products.id=orders_details.od_product_id',
								'inventory'=>'inventory.product_name=orders_details.od_product_id'
							);


					$data['orderList'] = $this->getAllData('orders_details','',['od_order_id'=>$rowTransListInfo['orders_id'] ],$aJoins);

				
							if(0<count($data['orderList']))
							{
								foreach($data['orderList']  as $rowOrdersInfo)
								{
									$intCounter++;	
									$decTotalAmount +=	$rowOrdersInfo['od_subtotal'];
									$gstPrice =($rowOrdersInfo['od_subtotal']*$rowOrdersInfo['gst'])/100;
									$totalgst = $totalgst+$gstPrice;


			$strMessage .='<tr>                  
					<td style="text-align:center;">'.$intCounter.'</td>
					<td style="text-align:center;">'.$rowOrdersInfo['od_product_name'].'</td>

					<td style="text-align:center;">'.number_format($rowOrdersInfo['od_product_price'],2).'</td>
					<td style="text-align:center;">'.$rowOrdersInfo['od_product_qty'].' Set </td>
					<td style="text-align:center;">'.number_format($rowOrdersInfo['od_subtotal'],2).'</td>
					</tr>';
						}
					}


					$strMessage .='<tr><td colspan="4" style="text-align:center;font-weight:bold;">Sub Total</td><td style="text-align:center;">'.number_format($decTotalAmount,2).'</td></tr>';

					$strMessage .='<tr><td colspan="4" style="text-align:center;font-weight:bold;">GST</td><td style="text-align:center;">'.number_format($totalgst,2).'</td></tr>';

					$strMessage .='<tr><td colspan="4" style="text-align:center;font-weight:bold;">Delivery Charage</td><td style="text-align:center;">Free</td></tr>';
				
				$strMessage .='<tr><td colspan="4" style="text-align:center;font-weight:bold;">Total</td><td style="text-align:center;font-weight:bold;">'.
				number_format(($decTotalAmount+$totalgst),2).'</td></tr>
					</table>';	

	$strFullMessage = $this->emailTemplate($strUserName,$strMessage);
	
	//echo $strFullMessage; die();
	
	$this->sendEmail($rowTransListInfo['customers_email'],'Order Invoice',$strFullMessage);


	
			
	
}




	/************pavan function end *************/
	
}  
?>  