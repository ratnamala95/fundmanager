<?php
  /**
   *
   */

  class Dbaction extends CI_Model
  {
    function __construct()
    {
      parent::__construct();
    }

    function encryptFunction($val)
    {
      return md5($val);
    }


    function userLogin($val)
    {
      $this->db->select('*');
      $this->db->from('users');
      $this->db->where('email',$val['email']);
      $this->db->where('password',$this->encryptFunction($val['password']));
      $this->db->limit(1);

      $query = $this->db->get();

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
  		$this->email->from('info@webplanetsoft.com', 'web planet soft');
  		$this->email->to($to);
  		$this->email->subject($subject);
  		$this->email->message($body);
  		$this->email->send();

  		 //print_r($this->email->print_debugger());
  		return true;

  	}

    function set_select_value($aRows,$aKey,$aVal)
   	{
   		$aData = array();
   		if($aRows)
   		{
   			foreach ($aRows as $key => $aRow)
   			{
   				$aData[$aRow[$aKey]] = $aRow[$aVal];
   			}
   		}

   		return $aData;
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

  }


?>
