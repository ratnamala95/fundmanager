<?php

/**
 *
 */
class Fundmanager extends Griglia_Controller
{

  function __construct()
  {
    parent::__construct();
    $this->usr = json_decode(json_encode($_SESSION['user']), True);
  }

  public function index()
  {
    $fundmanagers = $this->Dbaction->getAllData('users','',array('role' => FUNDMANAGER_ROLE,'status' => 1));

    $this->content = 'fundmanager/index';
    $this->title = 'Fundmangers';
    $this->data = array('fundmanagers' => $fundmanagers,'aUsr' => $this->usr);
    $this->layout();
  }

  public function add($id = 0)
  {
    $bEdit = false;
    $aRow = array();
    if($id>0)
    {
      $bEdit = true;
      $aRow = $this->Dbaction->getData('users',array('id' => $id));
      $aRow['projects'] = unserialize($aRow['projects']);
    }

    $projects = $this->Dbaction->set_select_value($this->Dbaction->getAllData("projects",'',array()),"id","project_name");
    unset($projects['']);

    $aValidations = array(
      array(
        'field' => 'val[name]',
        'label' => 'Username',
        'rules' => 'required',
      ),
      array(
        'field' => 'val[email]',
        'label' => 'Email',
        'rules' => 'required|callback_is_custom_unique[users||email||id||'.$id.']'
      ),
      array(
        'field' => 'val[password]',
        'label' => 'Password',
        'rules' => 'min_length[6]|trim'
      )
    );

    $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
    $this->form_validation->set_rules($aValidations);

    if($this->form_validation->run())
    {
      if($this->input->post('val'))
      {
        $aVals = $this->input->post('val');

        if(isset($aVals['id']) && $aVals['id'] > 0)
				{
					$edit_id = $aVals['id'];
					unset($aVals['id']);

          $aVals['projects'] = serialize($aVals['projects']);

					$this->Dbaction->updateData('users',$aVals,array("id" => $edit_id));
					$aMsg = "User updated successfully";
        }else {
          $aVals['role'] = FUNDMANAGER_ROLE;
          $aVals['status'] = 1;

          $aVals['projects'] = serialize($aVals['projects']);
          $aVals['password'] = $this->Dbaction->encryptFunction($aVals['password']);

          $this->Dbaction->adddata('users',$aVals);
          $aMsg = 'User Added!';
        }
        $this->session->set_flashdata('message',array('message' => $aMsg,'class' => 'alert alert-success'));
        redirect(base_url('fundmanager'),'refresh');
      }
    }


    $this->content = 'fundmanager/add';
    $this->title = $bEdit?'Update':'Add';
    $this->data = array('projects' => $projects,'bEdit' => $bEdit,'aRow' => $aRow);
    $this->layout();
  }

  public function view($id = 0)
  {
    $aRows = array();
    if($id>0)
    {
      $aJoins = array(
        'projects' => 'data.project_id = projects.id',
        'users' => 'data.user_id = users.id'
      );
      $aRows = $this->Dbaction->getAllData('data','data.id,data.project_id,projects.project_name as project,projects.duration as duration,users.name as user_name',array('user_id' => $id),$aJoins);
    }

    $this->content = 'fundmanager/list';
    $this->title = 'Project List';
    $this->data = array('aRows' => $aRows,'aUsr' => $this->usr);
    $this->layout();

  }

  public function details($id = 0)
  {
    $aVals['id'] = $id;

    if($id>0)
    {
      $user = $this->Dbaction->getAllData('data','',$aVals);
    }
    $projects = $this->Dbaction->set_select_value($this->Dbaction->getAllData("projects",'',array()),"id","project_name");

    $this->content = 'frontend/form';
    $this->title   = 'Details';
    $this->data    = array('data' => $user,'energy' => $cons,'renovated' => $reno,'yeno' => $yeno,'yea' => $yea,'projects' => $projects);
    $this->layout();
  }

  public function rating($id = 0,$fund = 0,$change = 0)
  {
    $aRow = array();
    if($fund>0)
    {
      $con['user_id'] = $fund;
    }
    if($id>0)
    {
      $con['project_id'] = $id;
      $aRow = $this->Dbaction->getData('data',$con);
      $update['rating'] = $aRow['rating1']+$aRow['rating2']+$aRow['rating3']+$aRow['rating4']+$aRow['rating5']+$aRow['rating6'];
      $this->Dbaction->updateData('data',$update,array('id' => $id));
      $aRow = $this->Dbaction->getData('data',$con);
    }

    $info['scope'] = array('1'=>'1. Environmental Sustainability','2'=>'2. Background',
    '3'=>'3. Social quality of architectural design','4'=>'4. Housing Offer',
    '5'=>'5. Social and functional Mix','6'=>'6. Project of social management');

    $info['score'] = array('1'=>$aRow['score1'],'2'=>$aRow['score2'],
    '3'=>$aRow['score3'],'4'=>$aRow['score4'],
    '5'=>$aRow['score5'],'6'=>$aRow['score6']);

    $info['rating'] = array('1'=>$aRow['rating1'].'/15','2'=>$aRow['rating2'].'/9',
    '3'=>$aRow['rating3'].'/20','4'=>$aRow['rating4'].'/15',
    '5'=>$aRow['rating5'].'/11','6'=>$aRow['rating6'].'/30','7' => $aRow['rating'].'/100');

    $info['weighing'] = array('1'=>'15%','2'=>'9%',
    '3'=>'20%','4'=>'15%',
    '5'=>'11%','6'=>'30%');

    $projects = $this->Dbaction->set_select_value($this->Dbaction->getAllData("projects",'',array()),"id","project_name");
    unset($projects['']);

    $info['projects'] = $projects;
    $info['aRow'] = $aRow;

    if($change==0)
    {
      $this->content = 'project/rating';
      $this->title = 'Rating';
      $this->data = $info;
      $this->layout();
    }
    else {
      $this->load->view('project/replace',$info);
    }

  }

  public function createXLS($id) {
   // create file name
       $fileName = 'data-'.time().'.xls';
   // load excel library
       $this->load->library('Excel');
       $aRow = $this->Dbaction->getCustomQuery("SELECT data.*, projects.project_name as project FROM data JOIN projects ON data.project_id = projects.id WHERE data.id =  ".$id);
       $aRow = $aRow[0];
       // pr($aRow);die;
       $objPHPExcel = new PHPExcel();
       $objPHPExcel->setActiveSheetIndex(0);
       // set Header
       $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Name of project');
       $objPHPExcel->getActiveSheet()->SetCellValue('A2', 'Complition Period (months)');
       $objPHPExcel->getActiveSheet()->SetCellValue('A3', 'AREAS OF EVALUATION');
       $objPHPExcel->getActiveSheet()->SetCellValue('A4', '1. Environmental Sustainability');
       $objPHPExcel->getActiveSheet()->SetCellValue('A18', '2. Background');
       $objPHPExcel->getActiveSheet()->SetCellValue('A52', '3. Social quality of architectural design');
       $objPHPExcel->getActiveSheet()->SetCellValue('A5', '15%');
       $objPHPExcel->getActiveSheet()->SetCellValue('A19', '9%');
       $objPHPExcel->getActiveSheet()->SetCellValue('A74', '4. Housing Offer');
       $objPHPExcel->getActiveSheet()->SetCellValue('A75', '15%');
       $objPHPExcel->getActiveSheet()->SetCellValue('A94', '5. Social and functional Mix');
       $objPHPExcel->getActiveSheet()->SetCellValue('A95', '11%');
       $objPHPExcel->getActiveSheet()->SetCellValue('A104', '6. Project of social management');
       $objPHPExcel->getActiveSheet()->SetCellValue('A105', '30%');
       $objPHPExcel->getActiveSheet()->SetCellValue('B3', 'CRITERIA');
       $objPHPExcel->getActiveSheet()->SetCellValue('B4', '1. building type');
       $objPHPExcel->getActiveSheet()->SetCellValue('B11', '2. Energy efficiency');
       $objPHPExcel->getActiveSheet()->SetCellValue('B5', '65%');
       $objPHPExcel->getActiveSheet()->SetCellValue('B12', '35%');
       $objPHPExcel->getActiveSheet()->SetCellValue('B18', '1. services, green areas and intended use');
       $objPHPExcel->getActiveSheet()->SetCellValue('B19', '40%');
       $objPHPExcel->getActiveSheet()->SetCellValue('B44', '2. Accessibility and practicability');
       $objPHPExcel->getActiveSheet()->SetCellValue('B45', '60%');
       $objPHPExcel->getActiveSheet()->SetCellValue('B52', '1. Procedure competition in the selection of designers');
       $objPHPExcel->getActiveSheet()->SetCellValue('B53', '10%');
       $objPHPExcel->getActiveSheet()->SetCellValue('B56', '2. physical relationship with the urban context');
       $objPHPExcel->getActiveSheet()->SetCellValue('B57', '15%');
       $objPHPExcel->getActiveSheet()->SetCellValue('B59', '3. Green');
       $objPHPExcel->getActiveSheet()->SetCellValue('B60', '15%');
       $objPHPExcel->getActiveSheet()->SetCellValue('B62', '4. Accommodations');
       $objPHPExcel->getActiveSheet()->SetCellValue('B63', '35%');
       $objPHPExcel->getActiveSheet()->SetCellValue('B69', '5. Lodging Types');
       $objPHPExcel->getActiveSheet()->SetCellValue('B70', '25%');
       $objPHPExcel->getActiveSheet()->SetCellValue('B74', '1. Mix Residential');
       $objPHPExcel->getActiveSheet()->SetCellValue('B75', '100%');
       $objPHPExcel->getActiveSheet()->SetCellValue('B94', '1. Mix typological residential services');
       $objPHPExcel->getActiveSheet()->SetCellValue('B95', '60%');
       $objPHPExcel->getActiveSheet()->SetCellValue('B98', '2. Functional Mix * (over residential)');
       $objPHPExcel->getActiveSheet()->SetCellValue('B99', '40%');
       $objPHPExcel->getActiveSheet()->SetCellValue('B104', '1. Social Management');
       $objPHPExcel->getActiveSheet()->SetCellValue('B105', '20%');
       $objPHPExcel->getActiveSheet()->SetCellValue('B107', '2. Selecting tenants');
       $objPHPExcel->getActiveSheet()->SetCellValue('B108', '40%');
       $objPHPExcel->getActiveSheet()->SetCellValue('B112', '3. tenants Involvement in pre-phase input');
       $objPHPExcel->getActiveSheet()->SetCellValue('B113', '10%');
       $objPHPExcel->getActiveSheet()->SetCellValue('B114', '4. Paths of self-management');
       $objPHPExcel->getActiveSheet()->SetCellValue('B115', '30%');
       $objPHPExcel->getActiveSheet()->SetCellValue('C3', 'INDICATORS');
       $objPHPExcel->getActiveSheet()->SetCellValue('C4', 'Surface rifferimento');
       $objPHPExcel->getActiveSheet()->SetCellValue('C5', 'New construction green field (GF)');
       $objPHPExcel->getActiveSheet()->SetCellValue('C6', 'Recovery unsold (RI)');
       $objPHPExcel->getActiveSheet()->SetCellValue('C7', 'Recovery property with historical or artistic value (RSA)');
       $objPHPExcel->getActiveSheet()->SetCellValue('C9', 'Restructuring individual units (RS)');
       $objPHPExcel->getActiveSheet()->SetCellValue('C10', 'Restructuring building sky land (RCT)');
       $objPHPExcel->getActiveSheet()->SetCellValue('C12', 'In the case of new building');
       $objPHPExcel->getActiveSheet()->SetCellValue('C13', 'In the event of a renovated building');
       $objPHPExcel->getActiveSheet()->SetCellValue('C14', 'Size of new building');
       $objPHPExcel->getActiveSheet()->SetCellValue('C15', 'Surface renovated building');
       $objPHPExcel->getActiveSheet()->SetCellValue('C18', 'Shorter Distance:');
       $objPHPExcel->getActiveSheet()->SetCellValue('C19', 'Business Neighborhood Activities');
       $objPHPExcel->getActiveSheet()->SetCellValue('C20', 'Public parks and neighborhood gardens');
       $objPHPExcel->getActiveSheet()->SetCellValue('C21', 'neighborhood sports centers');
       $objPHPExcel->getActiveSheet()->SetCellValue('C22', 'aggregation services district');
       $objPHPExcel->getActiveSheet()->SetCellValue('C23', 'Schools');
       $objPHPExcel->getActiveSheet()->SetCellValue('C24', 'Places of worship and speakers');
       $objPHPExcel->getActiveSheet()->SetCellValue('C25', 'district health services');
       $objPHPExcel->getActiveSheet()->SetCellValue('C26', 'Libraries');
       $objPHPExcel->getActiveSheet()->SetCellValue('C27', 'Poste');
       $objPHPExcel->getActiveSheet()->SetCellValue('C28', 'High school');
       $objPHPExcel->getActiveSheet()->SetCellValue('C29', 'Points of neighborhood cultural interest');
       $objPHPExcel->getActiveSheet()->SetCellValue('C31', 'Average distance:');
       $objPHPExcel->getActiveSheet()->SetCellValue('C32', 'Points of cultural interest attractors urban');
       $objPHPExcel->getActiveSheet()->SetCellValue('C33', 'Public parks and gardens urban attractors');
       $objPHPExcel->getActiveSheet()->SetCellValue('C34', 'Sporting centers urban attractors');
       $objPHPExcel->getActiveSheet()->SetCellValue('C35', 'Commerce supermarkets');
       $objPHPExcel->getActiveSheet()->SetCellValue('C36', 'University');
       $objPHPExcel->getActiveSheet()->SetCellValue('C37', 'Health Services urban attractors');
       $objPHPExcel->getActiveSheet()->SetCellValue('C39', 'Intended use:');
       $objPHPExcel->getActiveSheet()->SetCellValue('C40', 'Industrial area');
       $objPHPExcel->getActiveSheet()->SetCellValue('C41', 'Directional and commercial areas and services');
       $objPHPExcel->getActiveSheet()->SetCellValue('C42', 'Residential area');
       $objPHPExcel->getActiveSheet()->SetCellValue('C44', 'Existence of the municipality metropolitan');
       $objPHPExcel->getActiveSheet()->SetCellValue('C45', 'Subway');
       $objPHPExcel->getActiveSheet()->SetCellValue('C46', 'Bus line');
       $objPHPExcel->getActiveSheet()->SetCellValue('C47', 'Population');
       $objPHPExcel->getActiveSheet()->SetCellValue('C48', 'Railway station');
       $objPHPExcel->getActiveSheet()->SetCellValue('C49', 'Other public transport (other line of buses, trams, ...)');
       $objPHPExcel->getActiveSheet()->SetCellValue('C56', 'Integration system of pedestrian / bicycle designed with existing ones');
       $objPHPExcel->getActiveSheet()->SetCellValue('C57', 'collective open spaces Planning and varieties open space');
       $objPHPExcel->getActiveSheet()->SetCellValue('C59', 'Design of green spaces');
       $objPHPExcel->getActiveSheet()->SetCellValue('C60', 'Greenery to self-manage (Orti / community garden)');
       $objPHPExcel->getActiveSheet()->SetCellValue('C62', 'More than 50% of the rooms with a balcony or loggia "space" (depth> 1.50 meters) or with private garden');
       $objPHPExcel->getActiveSheet()->SetCellValue('C63', 'Accommodations non mono-facing(Number of housing does not mono-facing)');
       $objPHPExcel->getActiveSheet()->SetCellValue('C64', 'Total number of accommodation');
       $objPHPExcel->getActiveSheet()->SetCellValue('C65', 'Presence of a cellar or storage room for at least 50% of the accommodation');
       $objPHPExcel->getActiveSheet()->SetCellValue('C66', 'Two bathrooms for housing (except for studios and one bedroom apartments)');
       $objPHPExcel->getActiveSheet()->SetCellValue('C67', 'Variety finishes and possibility choice');
       $objPHPExcel->getActiveSheet()->SetCellValue('C69', 'At least 15% of three housing types (in terms of SLP)');
         $objPHPExcel->getActiveSheet()->SetCellValue('C70', 'Variety offer typological (studio apartments, coresidenze, etc)');
       $objPHPExcel->getActiveSheet()->SetCellValue('C71', 'Differentiation distributive accommodation same type (eg. Studios with different plants)');
       $objPHPExcel->getActiveSheet()->SetCellValue('C74', 'Composition of the enjoyment title:');
       $objPHPExcel->getActiveSheet()->SetCellValue('C75', 'social rent Rent');
       $objPHPExcel->getActiveSheet()->SetCellValue('C76', 'Rent-fee calmed 1');
       $objPHPExcel->getActiveSheet()->SetCellValue('C77', 'Rent-fee calmed 2');
       $objPHPExcel->getActiveSheet()->SetCellValue('C78', 'Pact to Buy');
       $objPHPExcel->getActiveSheet()->SetCellValue('C79', 'Sale agreement');
       $objPHPExcel->getActiveSheet()->SetCellValue('C80', 'free Sale');
       $objPHPExcel->getActiveSheet()->SetCellValue('C82', 'Evaluation of the residential and affordability mix:');
       $objPHPExcel->getActiveSheet()->SetCellValue('C83', 'Value of social rent per sqm');
       $objPHPExcel->getActiveSheet()->SetCellValue('C84', 'the fee value calmed 1 per sq.m.');
       $objPHPExcel->getActiveSheet()->SetCellValue('C85', 'the fee value calmed 2 per sq.m.');
       $objPHPExcel->getActiveSheet()->SetCellValue('C86', 'Average rent OMI - State like **');
       $objPHPExcel->getActiveSheet()->SetCellValue('C87', 'Price Pact Futura Sales per square meter');
       $objPHPExcel->getActiveSheet()->SetCellValue('C88', '% Capital share PFV');
       $objPHPExcel->getActiveSheet()->SetCellValue('C89', 'Price per square meter sales agreement');
       $objPHPExcel->getActiveSheet()->SetCellValue('C90', 'Free sale price per square meter');
       $objPHPExcel->getActiveSheet()->SetCellValue('C91', 'Average Sales Value OMI - State like');
       $objPHPExcel->getActiveSheet()->SetCellValue('C94', 'Accommodations first / second / third reception');
       $objPHPExcel->getActiveSheet()->SetCellValue('C95', 'Temporary Accommodation');
       $objPHPExcel->getActiveSheet()->SetCellValue('C96', 'Residential homes or accommodation for families opened reception');
       $objPHPExcel->getActiveSheet()->SetCellValue('C98', 'Supplementary Services Habitat Days ');
       $objPHPExcel->getActiveSheet()->SetCellValue('C99', 'Local Urban Services ');
       $objPHPExcel->getActiveSheet()->SetCellValue('C100', 'public services (schools, kindergarten) ');
       $objPHPExcel->getActiveSheet()->SetCellValue('C101', 'Compatible Functions with Residence');
       $objPHPExcel->getActiveSheet()->SetCellValue('C104', 'Existence of a social management plan');
       $objPHPExcel->getActiveSheet()->SetCellValue('C105', 'How transparent selection of the Manager ');
       $objPHPExcel->getActiveSheet()->SetCellValue('C107', 'Community Profile');
       $objPHPExcel->getActiveSheet()->SetCellValue('C108', 'Cognitive Talks');
       $objPHPExcel->getActiveSheet()->SetCellValue('C109', 'Informational meetings pre-entry');
       $objPHPExcel->getActiveSheet()->SetCellValue('C110', 'Laboratories pre-input');
       $objPHPExcel->getActiveSheet()->SetCellValue('C112', 'Ongoing housing variants when selling');
       $objPHPExcel->getActiveSheet()->SetCellValue('C114', 'Space management (excluding green areas)');
       $objPHPExcel->getActiveSheet()->SetCellValue('C115', 'Creating organs and representation rules');
       $objPHPExcel->getActiveSheet()->SetCellValue('C116', 'Tenants training');
       $objPHPExcel->getActiveSheet()->SetCellValue('D3', 'INPUT');
       $objPHPExcel->getActiveSheet()->SetCellValue('E3', 'SCORE FOR VOICE');
       $objPHPExcel->getActiveSheet()->SetCellValue('F3', 'SCORING CRITERIA');
       $objPHPExcel->getActiveSheet()->SetCellValue('G3', 'SCORE FOR FIELD');

       // foreach ($aRows as $aRow) {
           $objPHPExcel->getActiveSheet()->SetCellValue('B1', $aRow['project']);
           $objPHPExcel->getActiveSheet()->SetCellValue('B2', $aRow['duration']);
           $objPHPExcel->getActiveSheet()->SetCellValue('D5' , $aRow['gf']);
           $objPHPExcel->getActiveSheet()->SetCellValue('D5' , $aRow['ri']);
           $objPHPExcel->getActiveSheet()->SetCellValue('D6' , $aRow['rsa']);
           $objPHPExcel->getActiveSheet()->SetCellValue('D7' , $aRow['bf']);
           $objPHPExcel->getActiveSheet()->SetCellValue('D8' , $aRow['rs']);
           $objPHPExcel->getActiveSheet()->SetCellValue('D9' , $aRow['rct']);
           $objPHPExcel->getActiveSheet()->SetCellValue('D10' , $aRow['gf']);
           $objPHPExcel->getActiveSheet()->SetCellValue('D12' , $aRow['new_building_energy_class']);
           $objPHPExcel->getActiveSheet()->SetCellValue('D13' , $aRow['energy_class_renovated_building']);
           $objPHPExcel->getActiveSheet()->SetCellValue('D14' , $aRow['slpnuovo']);
           $objPHPExcel->getActiveSheet()->SetCellValue('D15' , $aRow['slpristrutturato']);
           $objPHPExcel->getActiveSheet()->SetCellValue('D19' , $aRow['activities']);
           $objPHPExcel->getActiveSheet()->SetCellValue('D20' , $aRow['gardens']);
           $objPHPExcel->getActiveSheet()->SetCellValue('D21' , $aRow['sports_centers']);
           $objPHPExcel->getActiveSheet()->SetCellValue('D22' , $aRow['services_district']);
           $objPHPExcel->getActiveSheet()->SetCellValue('D23' , $aRow['schools']);
           $objPHPExcel->getActiveSheet()->SetCellValue('D24' , $aRow['worship_places']);
           $objPHPExcel->getActiveSheet()->SetCellValue('D25' , $aRow['health_services']);
           $objPHPExcel->getActiveSheet()->SetCellValue('D26' , $aRow['libraries']);
           $objPHPExcel->getActiveSheet()->SetCellValue('D27' , $aRow['poste']);
           $objPHPExcel->getActiveSheet()->SetCellValue('D28' , $aRow['high_school']);
           $objPHPExcel->getActiveSheet()->SetCellValue('D29' , $aRow['cultural_intrest']);
           $objPHPExcel->getActiveSheet()->SetCellValue('D32' , $aRow['cultural_intrest_attractors_urban']);
           $objPHPExcel->getActiveSheet()->SetCellValue('D33' , $aRow['gardens_urban_attractors']);
           $objPHPExcel->getActiveSheet()->SetCellValue('D34' , $aRow['sporting_centers_urban_attractors']);
           $objPHPExcel->getActiveSheet()->SetCellValue('D35' , $aRow['supermarkets']);
           $objPHPExcel->getActiveSheet()->SetCellValue('D36' , $aRow['university']);
           $objPHPExcel->getActiveSheet()->SetCellValue('D37' , $aRow['health_services_urban_attractors']);
           $objPHPExcel->getActiveSheet()->SetCellValue('D40' , $aRow['industrial_area']);
           $objPHPExcel->getActiveSheet()->SetCellValue('D41' , $aRow['commercial_area']);
           $objPHPExcel->getActiveSheet()->SetCellValue('D42' , $aRow['residential_area']);
           $objPHPExcel->getActiveSheet()->SetCellValue('D45' , $aRow['subway']);
           $objPHPExcel->getActiveSheet()->SetCellValue('D46' , $aRow['bus_line']);
           $objPHPExcel->getActiveSheet()->SetCellValue('D47' , $aRow['population']);
           $objPHPExcel->getActiveSheet()->SetCellValue('D48' , $aRow['railway_station']);
           $objPHPExcel->getActiveSheet()->SetCellValue('D49' , $aRow['public_transport']);
           $objPHPExcel->getActiveSheet()->SetCellValue('D52' , $aRow['selection_designers']);
           $objPHPExcel->getActiveSheet()->SetCellValue('D56' , $aRow['pedestrian_bicycle']);
           $objPHPExcel->getActiveSheet()->SetCellValue('D57' , $aRow['open_spaces']);
           $objPHPExcel->getActiveSheet()->SetCellValue('D59' , $aRow['green_space_design']);
           $objPHPExcel->getActiveSheet()->SetCellValue('D60' , $aRow['greenery_manage']);
           $objPHPExcel->getActiveSheet()->SetCellValue('D62' , $aRow['rooms_balcony']);
           $objPHPExcel->getActiveSheet()->SetCellValue('D63' , $aRow['houses_nmf']);
           $objPHPExcel->getActiveSheet()->SetCellValue('D64' , $aRow['total_accomodation']);
           $objPHPExcel->getActiveSheet()->SetCellValue('D65' , $aRow['cellar_storage']);
           $objPHPExcel->getActiveSheet()->SetCellValue('D66' , $aRow['two_bathrooms']);
           $objPHPExcel->getActiveSheet()->SetCellValue('D67' , $aRow['variety_finishes']);
           $objPHPExcel->getActiveSheet()->SetCellValue('D69' , $aRow['three_housing']);
           $objPHPExcel->getActiveSheet()->SetCellValue('D70' , $aRow['offer_typological']);
           $objPHPExcel->getActiveSheet()->SetCellValue('D71' , $aRow['distributive_accomo']);
           $objPHPExcel->getActiveSheet()->SetCellValue('D75' , $aRow['social_housing']);
           $objPHPExcel->getActiveSheet()->SetCellValue('D76' , $aRow['rental_calmed']);
           $objPHPExcel->getActiveSheet()->SetCellValue('D77' , $aRow['ren_regulated']);
           $objPHPExcel->getActiveSheet()->SetCellValue('D78' , $aRow['futura_sale_pact']);
           $objPHPExcel->getActiveSheet()->SetCellValue('D79' , $aRow['agreement_sale']);
           $objPHPExcel->getActiveSheet()->SetCellValue('D80' , $aRow['open_sale']);
           $objPHPExcel->getActiveSheet()->SetCellValue('D83' , $aRow['social_rent']);
           $objPHPExcel->getActiveSheet()->SetCellValue('D84' , $aRow['fv_calmed_1']);
           $objPHPExcel->getActiveSheet()->SetCellValue('D85' , $aRow['fv_calmed_2']);
           $objPHPExcel->getActiveSheet()->SetCellValue('D86' , $aRow['rent_OMI']);
           $objPHPExcel->getActiveSheet()->SetCellValue('D87' , $aRow['price_pact_futura_sale']);
           $objPHPExcel->getActiveSheet()->SetCellValue('D88' , $aRow['capital_share']);
           $objPHPExcel->getActiveSheet()->SetCellValue('D89' , $aRow['sales_agreement']);
           $objPHPExcel->getActiveSheet()->SetCellValue('D90' , $aRow['sale_price']);
           $objPHPExcel->getActiveSheet()->SetCellValue('D91' , $aRow['sales_value_OMI']);
           $objPHPExcel->getActiveSheet()->SetCellValue('D94' , $aRow['reception']);
           $objPHPExcel->getActiveSheet()->SetCellValue('D95' , $aRow['temp_accomodation']);
           $objPHPExcel->getActiveSheet()->SetCellValue('D96' , $aRow['opened_reception']);
           $objPHPExcel->getActiveSheet()->SetCellValue('D98' , $aRow['habitat_days']);
           $objPHPExcel->getActiveSheet()->SetCellValue('D99' , $aRow['local_urban_services']);
           $objPHPExcel->getActiveSheet()->SetCellValue('D100' , $aRow['public_services']);
           $objPHPExcel->getActiveSheet()->SetCellValue('D101' , $aRow['compatible_functions']);
           $objPHPExcel->getActiveSheet()->SetCellValue('D104' , $aRow['social_management_plan']);
           $objPHPExcel->getActiveSheet()->SetCellValue('D105' , $aRow['transparent_selection']);
           $objPHPExcel->getActiveSheet()->SetCellValue('D107' , $aRow['community_profile']);
           $objPHPExcel->getActiveSheet()->SetCellValue('D108' , $aRow['cognitive_talks']);
           $objPHPExcel->getActiveSheet()->SetCellValue('D109' , $aRow['info_meetings']);
           $objPHPExcel->getActiveSheet()->SetCellValue('D110' , $aRow['laboratories']);
           $objPHPExcel->getActiveSheet()->SetCellValue('D112' , $aRow['housing_variants']);
           $objPHPExcel->getActiveSheet()->SetCellValue('D114' , $aRow['space_management']);
           $objPHPExcel->getActiveSheet()->SetCellValue('D115' , $aRow['representation_rules']);
           $objPHPExcel->getActiveSheet()->SetCellValue('D116' , $aRow['tenants_training']);
           $objPHPExcel->getActiveSheet()->SetCellValue('F11' , $aRow['score11']);
           $objPHPExcel->getActiveSheet()->SetCellValue('F16' , $aRow['score12']);
           $objPHPExcel->getActiveSheet()->SetCellValue('F43' , $aRow['score21']);
           $objPHPExcel->getActiveSheet()->SetCellValue('F50' , $aRow['score22']);
           $objPHPExcel->getActiveSheet()->SetCellValue('F53' , $aRow['score31']);
           $objPHPExcel->getActiveSheet()->SetCellValue('F58' , $aRow['score32']);
           $objPHPExcel->getActiveSheet()->SetCellValue('F61' , $aRow['score33']);
           $objPHPExcel->getActiveSheet()->SetCellValue('F68' , $aRow['score34']);
           $objPHPExcel->getActiveSheet()->SetCellValue('F72' , $aRow['score35']);
           $objPHPExcel->getActiveSheet()->SetCellValue('F92' , $aRow['score4']);
           $objPHPExcel->getActiveSheet()->SetCellValue('F97' , $aRow['score51']);
           $objPHPExcel->getActiveSheet()->SetCellValue('F102' , $aRow['score52']);
           $objPHPExcel->getActiveSheet()->SetCellValue('F106' , $aRow['score61']);
           $objPHPExcel->getActiveSheet()->SetCellValue('F111' , $aRow['score62']);
           $objPHPExcel->getActiveSheet()->SetCellValue('F113' , $aRow['score63']);
           $objPHPExcel->getActiveSheet()->SetCellValue('F117' , $aRow['score64']);
           $objPHPExcel->getActiveSheet()->SetCellValue('G17' , $aRow['score1']);
           $objPHPExcel->getActiveSheet()->SetCellValue('G51' , $aRow['score2']);
           $objPHPExcel->getActiveSheet()->SetCellValue('G73' , $aRow['score3']);
           $objPHPExcel->getActiveSheet()->SetCellValue('G93' , $aRow['score4']);
           $objPHPExcel->getActiveSheet()->SetCellValue('G103' , $aRow['score5']);
           $objPHPExcel->getActiveSheet()->SetCellValue('G118' , $aRow['score6']);
       // }


       // download file

       header("Content-Type: application/vnd.ms-excel");
       header('Content-Disposition: attachment;filename='.$fileName);
       header('Cache-Control: max-age=0');

       $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
       $objWriter->save('php://output');
       // unlink($fileName);
   }

  public function overallrating($id = 0)
  {
    $aRows = array();
    $overallrating = 0;
    $sum = 1;
    if($id>0)
    {
      $aJoins = array(
        'projects' => 'data.project_id = projects.id',
      );
      $aRows = $this->Dbaction->getAllData('data','data.*,projects.project_name as project',array('user_id' => $id),$aJoins);

      foreach($aRows as $aRow)
      {
        $sum += $aRow['project_value'];
      }

      foreach($aRows as $aRow)
      {
        $update['rating'] = $aRow['rating1']+$aRow['rating2']+$aRow['rating3']+$aRow['rating4']+$aRow['rating5']+$aRow['rating6'];
        $this->Dbaction->updateData('data',$update,array('id' => $aRow['id']));
        $overallrating += round(($aRow['project_value']/$sum)*$update['rating']);
      }

      $aRows['overallrating'] = $overallrating;
    }

    $this->content = 'project/overallrating';
    $this->title = 'Overall-rating';
    $this->data = array('aRows' => $aRows);
    $this->layout();
  }

}


 ?>
