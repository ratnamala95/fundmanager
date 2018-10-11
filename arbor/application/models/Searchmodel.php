<?php 

/**
* 
*/
class Searchmodel extends CI_Model
{

	public function filterattrdata($filterbycat,$sizeId="",$styleId="",$codeId="")
	{
		
			
		$this->db->select("products.*,category.name as category_name,inventory.price AS price, inventory.sale_price AS sale_price , inventory.size AS size,inventory.gst AS GST_PRICE");
		$this->db->from('products');
		$this->db->join('category','products.category=category.id');
		$this->db->join('inventory','products.id = inventory.product_name');
		$this->db->where(["products.status"=>1,"upcomming"=>0]);

		if ($this->session->userdata('REATILER_ID')) {

			$this->db->where(["warehouse_id"=>$this->session->userdata('WAREHOUSE_ID')]);
		}

		if ($this->session->userdata('filterbysearchkey')) {

			$searkbykey = $this->session->userdata('filterbysearchkey');
			//$filter['products.name LIKE ']= "%".$searkbykey."%";
			$this->db->like('products.name', "%".$searkbykey."%");

		}

		
		if ($this->session->userdata('filterprobycategory') && $this->session->userdata('filterprobycategory')!="result.php" ) 
		{

			$categoryslug = $this->session->userdata('filterprobycategory');
			$this->db->where([ 'category.slug' => $categoryslug ]);

		} elseif ($this->session->userdata('filtercategory') && $this->session->userdata('filtercategory')!="result.php") {
			
			$categoryslug = $this->session->userdata('filtercategory');
			$this->db->where([ 'category.slug' => $categoryslug ]);
		}

		if ($this->session->userdata('startrange') && $this->session->userdata('endrange')) {
			
			$startrange = $this->session->userdata('startrange');
			$endrange = $this->session->userdata('endrange');
		
			$this->db->where('sale_price >=', $startrange);
			$this->db->where('sale_price <=', $endrange);
		}


		if ($this->session->userdata('filtersize')) {

			// serialize data filter using query
			$sizeId = $this->session->userdata('filtersize');
			$sizedata = array(  "attributes REGEXP "=>  '.*"size";a:[0-9]:{.*s:[0-9]+:"'.$sizeId.'".*' );	
			
			$this->db->where($sizedata);
		}

		if ($this->session->userdata('filterstyle')) {
			
			$styleId = $this->session->userdata('filterstyle');
			$styledata = array( " attributes REGEXP "=>  '.*"style";a:[0-9]:{.*s:[0-9]+:"'.$styleId.'".*' );
			
			$this->db->where($styledata);

		}


		if ($this->session->userdata('filtercode')) {

			$codeId = $this->session->userdata('filtercode');
			//$codedata = array(  "attributes REGEXP "=>  '.*"codes";a:[0-9]:{.*s:[0-9]+:"'.$codeId.'".*' );
			//
			$this->db->where(['code'=>$codeId]);
			
		}






		if ($this->session->userdata('filterprice')) {

			if ($this->session->userdata('filterprice')==1) {
				$this->db->order_by('inventory.sale_price', 'DESC');
			} elseif ($this->session->userdata('filterprice')==2) {
				$this->db->order_by('inventory.sale_price', 'ASC');
			}

		}
	



		$query = $this->db->get();

		//echo $this->db->last_query();


		return $data= $query->result_array();

		

		
	}



}

?>