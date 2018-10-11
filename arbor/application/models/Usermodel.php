<?php
class Usermodel extends CI_Model {
  
  
  	function __construct() 
  	{
   		parent::__construct();
 	}

 	public function registrationdata()
 	{
 		//$data['email'] = $this->input->post('email');


 		$this->db->select('email');
 		$this->db->from('users');
 		$this->db->where(['email'=>$this->input->post('email')]);
 		$query = $this->db->get();

 		//echo "<pre>";
 		//print_r($query->result()); exit();
		$userdata['emailexists'] = $query->result();
 		if (empty($userdata['emailexists'])) {
 			
 			$data['role'] = $this->input->post('role');
  			$data['name'] = $this->input->post('name');
  			$data['email'] = $this->input->post('email');
  			$data['distributor_id'] = trim($this->input->post('distributor_id'));
  			$data['city_id']=$this->input->post('city_id');
  			$data['password'] =md5($this->input->post('password'));
   	
  			$this->db->insert('users',$data);

  			//echo $this->db->last_query();
  			//die();
 		}

 		//print_r()

 		return $userdata['emailexists'];

 		
 	}


 	public function checkverifyemail($userEmailId)
 	{
 		$this->db->select('email');
 		$this->db->from('users');
 		$this->db->where(['md5(email)'=>$userEmailId]);
 		$query = $this->db->get();
 	//echo $this->db->last_query();	
 		$data = $query->row();
		

 		if ($data->email) {
 			
			$this->db->set('status', '1');
			$this->db->where('email', $data->email);
			$this->db->update('users');

			return $data->email;
 		}

 		
 	}


 	public function checklogin($username , $password)
	{
		$this->db->select('*');
		$this->db->from('users');
		$this->db->where(['email'=>$username,'password'=>md5($password),'role'=>4]);
		$this->db->limit(1);	
		$query = $this->db->get();

			
		if($query->num_rows() == 1)
		{
			return $query->row();
		}
		else
		{
			return false;
		}
	}


	public function checkvalidemail($emailId)
	{
		$this->db->select('email');
		$this->db->from('users');
		$this->db->where(['email'=>$emailId]);
		$query = $this->db->get();
	//echo $this->db->last_query();
		return $query->row();

	}

	public function forgotchangepass($emailId,$password)
	{
		$this->db->set('password', md5($password));
		$this->db->where('md5(email)', $emailId);
		$this->db->update('users');

		$query = $this->db->get_where('users',['md5(email)'=>$emailId]);
		return  $query->row();
		
	}


	public function changepass($oldpass, $newpass)
	{

	 	$userId = $this->session->userdata('REATILER_ID');

		$this->db->select('*');
		$this->db->from('users');
		$this->db->where(['password'=>md5($oldpass),'id'=>$userId]);
		$query = $this->db->get();
//echo $this->db->last_query();
		$userdata = $query->row();

		if ($userdata) {

			$this->db->set('password', md5($newpass));
			$this->db->where('id', $userId);
			$this->db->update('users');
		}
		
		return $userdata;

	}


	public function checklogindata($userId)
	{
		
		$this->db->select('*');
		$this->db->from('users');
		$this->db->where(['id'=>$userId]);
		$query = $this->db->get();

		return $query->row();
	}


	public function updateprofile($userId ,$imageName="")
	{
		
		
		if ($this->input->post('name')) {
			$data['name'] = $this->input->post('name');
		}

		if ($this->input->post('city')) {
			$data['city_id'] = $this->input->post('city');
		}


		if ($imageName) {
			$data['image'] = $imageName;
		}



		$this->db->set($data);
		$this->db->where('id',$userId);
		$this->db->update('users');

		//echo $this->db->last_query(); exit();
		//return $data->email;
	}




}


?> 	