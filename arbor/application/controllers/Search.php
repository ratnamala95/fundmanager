<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class Search extends Frontend_Controller
{
	
	function __construct()
	{
		parent::__construct();
	}


	public function index()
	{
		$this->session->unset_userdata('filterprobycategory');
		$this->session->unset_userdata('filtersize');
		$this->session->unset_userdata('filterstyle');
		$this->session->unset_userdata('filtercode');
		$this->session->unset_userdata('filterprice');
		$this->session->unset_userdata('startrange');
		$this->session->unset_userdata('endrange');


		//$catSlug = $this->uri->segment(2);
		$filter=array();
		if ($this->session->userdata('REATILER_ID')) {

			$filter['warehouse_id']=$this->session->userdata('WAREHOUSE_ID');
		}
			
		$filter['products.status']=1;
		$filter['products.upcomming']=0;
		$catSlug = $this->uri->segment(2);

		if ($catSlug && $catSlug!='index') {

			$this->session->set_userdata('filtercategory', $catSlug);
			$filter['category.slug']=$catSlug;

			//echo $this->session->userdata('filtercategory');

		}	

	

		$searkbykey = $this->input->post('search');
		if ($searkbykey ) {

			$filter['products.name LIKE ']= "%".$searkbykey."%";

		} elseif ($this->session->userdata('filterbysearchkey')) {
			
			$filter['products.name LIKE ']= "%".$this->session->userdata('filterbysearchkey')."%";
		}


		
		$aOrders=array('timestamp','DESC');
		$aJoins = array(
				'category' => 'products.category = category.id',
				'inventory' => 'products.id = inventory.product_name'
			);

		
		$data['totalrow'] = $this->Dbaction->getAllData("products","products.*,category.name as category_name",$filter,$aJoins,'',$aOrders);

		$strLimit=100;
		$searchpagination = $this->Dbaction->pagination(base_url('search/index'),count($data['totalrow']),$strLimit,base_url('search'));

		//pagination code end here

		

		
		$data['productrowdata'] = $this->Dbaction->getAllData("products","products.*,category.name as category_name,inventory.price AS price, inventory.sale_price AS sale_price,inventory.gst AS GST_PRICE",$filter,$aJoins,$strLimit,$aOrders,$this->uri->segment(3));

		//echo $this->db->last_query();

		//echo "<pre>";
		//print_r(count($data));
		
		$data['categorydata'] = $this->Dbaction->getAllData("category","",['status'=>1]);


		$data['rowsizedata']  = $this->Dbaction->getAllData("attributes",'',array("type" => "size","status" => 1));	

		$data['rowstyledata']  = $this->Dbaction->getAllData("attributes",'',array("type" => "style","status" => 1));

		$data['rowcodedata']  = $this->Dbaction->getAllData("attributes",'',array("type" => "codes","status" => 1));	
			
		$data['totalproductcart'] = $this->productcartcount();
		//$data['catrow'] = $this->Dbaction->getAllData("category","",['status'=>1],"",7);

		$this->load->view('search_view', $data);

	}


	public function filterdataattribute()
	{
		$this->load->view('product_filter_view');
		
	}

	


}

?>