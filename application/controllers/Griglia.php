<?php
defined('BASEPATH') OR exit('No direct script access allowed');
  /**
   *
   */

  class Griglia extends Griglia_Controller
  {
    function __construct()
    {
      parent::__construct();
      $this->aUsr = json_decode(json_encode($_SESSION['user']), True);
    }

    public function index($id = 0)
    {
      $user = array();
      $aVals['user_id'] = $this->aUsr['id'];

      if($id>0)
      {
        $con['id'] = $id;
        $aVals['project_id'] = $id;
        $user = $this->Dbaction->getAllData('data','',$aVals);
        $projectz = $this->Dbaction->set_select_value($this->Dbaction->getAllData("projects",'',$con),"id","project_name");
      }
      $projectz = $this->Dbaction->set_select_value($this->Dbaction->getAllData("projects",''),"id","project_name");


      $this->content = 'frontend/form';
  		$this->title   = 'Griglia';
  		$this->data    = array('data' => $user,'projectz' => $projectz);
  		$this->layout();
    }
    public function form()
    {
      $aVals['user_id'] = $this->aUsr['id'];
      if($_POST!=='' && isset($_POST['project']))
      {
        $temp = $_POST['project'];
        $aVals['project_id'] = $temp[0];

        $info['data'] = $this->Dbaction->getAllData('data','',$aVals);

        $aVals['project_value'] = $temp[3];
        $type = $temp[1];
        $aVals['duration'] = $type==0?$temp[2]*12:$temp[2];
      }

      $info['title'] = 'Griglia';

      if(!$info['data'] && $aVals['project_id']!=0){
        $this->Dbaction->adddata('data',$aVals);
        $info['data'] = $this->Dbaction->getAllData('data','',$aVals);
      }
      else{
        $this->Dbaction->updateData('data',$aVals,array('user_id' => $aVals['user_id'],'project_id' => $aVals['project_id']));
        $info['data'] = $this->Dbaction->getAllData('data','',$aVals);
      }

      $info['projectz'] = $this->Dbaction->set_select_value($this->Dbaction->getAllData("projects",'',array()),"id","project_name");

      $this->load->view('frontend/replace',$info);
    }

    public function enviroment($id = 0)
    {
      $envir = $_POST['enviroment'];
      $sum = 0;
      $add = 0;
      $score = array();
      $data = array();

      foreach($envir as $key => $value)
      {
        if($value!='')
        {
          $sum+=$value;
        }
      }

      $data['gf'] = $envir[0];
      $data['ri'] = $envir[1];
      $data['rsa'] = $envir[2];
      $data['bf'] = $envir[3];
      $data['rs'] = $envir[4];
      $data['rct'] = $envir[5];

      $score[0] = $envir[0]==0? 0: round(($envir[0]/$sum)*30);
      $score[1] = $envir[1]==0? 0: round(($envir[1]/$sum)*70);
      $score[2] = $envir[2]==0? 0: round(($envir[2]/$sum)*70);
      $score[3] = $envir[3]==0? 0: round(($envir[3]/$sum)*80);
      $score[4] = $envir[4]==0? 0: round(($envir[4]/$sum)*80);
      $score[5] = $envir[5]==0? 0: round(($envir[5]/$sum)*100);

      foreach ( $score as $key => $value) {
        $add += $value;
      }

      $data['score11'] = $add;
      print_r(json_encode(array('sum'=>$sum,'sc'=>$add)));
      $this->Dbaction->updateData('data',$data,array('user_id' => $this->aUsr['id'],'project_id' => $id));
    }

    public function energyeff($id = 0)
    {
      $efficiency = $_POST['efficiency'];
      $val = json_decode($efficiency[1],True);
      $efficiency = $efficiency[0];
      $sum = 0;
      $add = 0;
      $score = 0;
      $data = array();
      $aryResponse = array();

      if($efficiency)
      {
        $sum = $val['sum']!=0?$val['sum']:1;
        $sc =  $val['sc']!=0?$val['sc']:1;
        $eff1 = $efficiency[2]!=''?$efficiency[2]:0;
        $eff2 = $efficiency[3]!=''?$efficiency[3]:0;
        $eff3 = $efficiency[0];
        $eff4 = $efficiency[1];

        $data['new_building_energy_class'] = $eff3;
        $data['energy_class_renovated_building'] = $eff4;
        $data['slpnuovo'] = $eff1;
        $data['slpristrutturato'] = $eff2;
        $add = $eff1+$eff2;
        if($add==$sum)
        {
          $add = 0;
          $score = round((($eff3*$eff1)/$sum)+(($eff4*$eff2)/$sum));
        }
        else
        {
          $score = 0;
          $msg = "Errore: La somma delle SLP del nuovo edificio e di quello ristrutturato non è pari alla SLP totale communicata all'ambito 1";
          // print_r($add);
        }
        $aryResponse=array();
        $finalscore = round(($sc*.65)+($score*.35));
        $data['score12'] = $score;
        $data['score1'] = $finalscore;
        $data['rating1'] = round(($finalscore*15)/100);
        $this->Dbaction->updateData('data',$data,array('user_id' => $this->aUsr['id'],'project_id' => $id));

        $aryResponse['sc']=$sc;
        $aryResponse['score']=$score;
        $aryResponse['finalscore']=$finalscore;

        print_r(json_encode($aryResponse));
      }
      // return $finalscore;
    }

    public function background($id = 0)
    {
      $aVals = $_POST['val'];
      $dis = $aVals[0];
      $avgdis = $aVals[1];
      $access = $aVals[6];
      $iUse = array();
      $count = 0;
      $aCount = 0;
      $denom = 1;
      $data = array();
      $aryResponse = array();


      $data['activities'] = $dis[0];
      $data['gardens'] = $dis[1];
      $data['sports_centers'] = $dis[2];
      $data['services_district'] = $dis[3];
      $data['schools'] = $dis[4];
      $data['worship_places'] = $dis[5];
      $data['health_services'] = $dis[6];
      $data['libraries'] = $dis[7];
      $data['poste'] = $dis[8];
      $data['high_school'] = $dis[9];
      $data['cultural_intrest'] = $dis[10];
      $data['cultural_intrest_attractors_urban'] = $avgdis[0];
      $data['gardens_urban_attractors'] = $avgdis[1];
      $data['sporting_centers_urban_attractors'] = $avgdis[2];
      $data['supermarkets'] = $avgdis[3];
      $data['university'] = $avgdis[4];
      $data['health_services_urban_attractors'] = $avgdis[5];

      $data['industrial_area'] = $aVals[2];
      $data['commercial_area'] = $aVals[3];
      $data['residential_area'] =$aVals[4];

      $data['subway'] = $access[0];
      $data['bus_line'] = $access[1];
      $data['railway_station'] = $access[2];
      $data['public_transport'] = $access[3];
      $data['population'] = $access[4];

      foreach($dis as $key => $value)
      {
        switch ($value) {
          case ($value<=300):
            $dis[$key] = 100;
            $count+=100;
            break;
          case 300>$value:
          case $value<=600:
            $dis[$key] = 75;
            $count+=75;
            break;
          case 600>$value:
          case $value<=900:
            $dis[$key] = 50;
            $count+=50;
            break;
          case 900>$value:
          case $value<=1200:
            $dis[$key] = 25;
            $count+=25;
            break;
          case 1200<$value:
            $dis[$key] = 0;
            $count+=0;
            break;

          default:
            $dis[$key] = 0;
            $count+=0;
            break;
        }
      }

      foreach($avgdis as $key => $value)
      {
        switch ($value) {
          case $value<=500:
            $avgdis[$key] = 100;
            $count+=100;
            break;
          case 500>$value:
          case $value<=1000:
            $avgdis[$key] = 75;
            $count+=75;
            break;
          case 1000>$value:
          case $value<=1500:
            $avgdis[$key] = 50;
            $count+=50;
            break;
          case 1500>$value:
          case $value<=2000:
            $avgdis[$key] = 25;
            $count+=25;
            break;
          case 2000<$value:
            $avgdis[$key] = 0;
            $count+=0;
            break;

          default:
            $avgdis[$key] = 0;
            $count+=0;
            break;
        }
      }

      $iUse[0] = $aVals[2]==1? 20 : 0;
      $count+=$iUse[0];
      $iUse[1] = $aVals[3]==1? 40 : 0;
      $count+=$iUse[1];
      $iUse[2] = $aVals[4]==1? 40 : 0;
      $count+=$iUse[2];

      $count = round($count/20);
      // pr($dis);
      // pr($avgdis);

      foreach ($access as $key => $value)
      {
        switch ($value) {
          case $value<=500:
            $access[$key] = 100;
            $aCount+=100;
            break;
          case $value>500:
          case $value<=1000:
            $access[$key] = 75;
            $aCount+=75;
            break;
          case $value>1000:
          case $value<=1500:
            $access[$key] = 50;
            $aCount+=50;
            break;
          case $value>1500:
          case $value<=2000:
            $access[$key] = 25;
            $aCount+=25;
            break;
          case $value>2000:
            $access[$key] = 0;
            $aCount+=0;
            break;

          default:
            $access[$key] = 0;
            $aCount+=0;
            break;
      }
    }

    foreach ($access as $key => $value) {
      if($value !=0 || $value != ''){
        $denom+=1;
      }
    }


      $aCount = $denom!=0?round($aCount/$denom):0;

      $data['score21'] = $count;
      $data['score22'] = $aCount;

      $res = round(($count*.4)+($aCount*.6));

      $data['score2'] = $res;
      $data['rating2'] = round(($res*9)/100);

      $aryResponse['score21'] = $count;
      $aryResponse['score22'] = $aCount;
      $aryResponse['score2'] = $res;
      print_r(json_encode($aryResponse));

      $this->Dbaction->updateData('data',$data,array('user_id' => $this->aUsr['id'],'project_id' => $id));
      die;

  }

  public function architecture($id = 0)
  {
    $aVals = $_POST['tb3'];
    $ipbox = $aVals[1];
    $aVals = $aVals[0];
    $aryResponse = array();
    $score = array();
    $data = array();
    $temp = 0;
    $this->session->set_userdata('acco',$ipbox[1]);


    $data['selection_designers'] = $aVals[0];
    $data['pedestrian_bicycle'] = $aVals[1];
    $data['open_spaces'] = $aVals[2];
    $data['green_space_design'] = $aVals[3];
    $data['greenery_manage'] = $aVals[4];
    $data['rooms_balcony'] = $aVals[5];
    $data['cellar_storage'] = $aVals[6];
    $data['two_bathrooms'] = $aVals[7];
    $data['variety_finishes'] = $aVals[8];
    $data['three_housing'] = $aVals[9];
    $data['offer_typological'] = $aVals[10];
    $data['distributive_accomo'] = $aVals[11];

    $data['houses_nmf'] = $ipbox[0];
    $data['total_accomodation'] = $ipbox[1];
    // pr($z);die;
    if(($ipbox[0] != '' || $ipbox[0] != 0) && ($ipbox[1] != '' || $ipbox[1] != 0))
    {
      $temp = round(($ipbox[0]/$ipbox[1])*100);

      switch ($temp) {
        case $temp<10:
          $temp = 0;
          break;
        case ($temp>=10 && $temp<30):
          $temp = 25;
          break;
        case ($temp>=30 && $temp<50):
          $temp = 50;
          break;
        case ($temp>=50 && $temp<70):
          $temp = 75;
          break;
        case ($temp>=70 && $temp<100):
          $temp = 100;
          break;
        default:
          $temp = 0;
          break;
      }
  }

    $score[0] = $aVals[0];
    $score[1] = ($aVals[1]+$aVals[2])/2;
    $score[2] = (($aVals[3]*.80)+($aVals[4]*.20));
    $score[3] = ($aVals[5]+$aVals[6]+$aVals[8]+$temp)/4;
    $score[4] = round(($aVals[9]+$aVals[10]+$aVals[11])/3);
    // pr($score);
    $data['score31'] = $score[0];
    $data['score32'] = $score[1];
    $data['score33'] = $score[2];
    $data['score34'] = $score[3];
    $data['score35'] = $score[4];

    $finalscore = round(($score[0]*.10)+($score[1]*.15)+($score[2]*.15)+($score[3]*.35)+($score[4]*.25));

    $aryResponse['score31'] = $score[0];
    $aryResponse['score32'] = $score[1];
    $aryResponse['score33'] = $score[2];
    $aryResponse['score34'] = $score[3];
    $aryResponse['score35'] = $score[4];
    $aryResponse['finalscore'] = $finalscore;

    print_r(json_encode($aryResponse));

    $data['score3'] = $finalscore;
    $data['rating3'] = round(($finalscore*20)/100);
    $this->Dbaction->updateData('data',$data,array('user_id' => $this->aUsr['id'],'project_id' => $id));

  }

  public function social($id = 0)
  {
    $aVals = $_POST['tb5'];
    $tbsb = $aVals[0];
    $tbip = $aVals[1];
    $temp = array();
    $data = array();
    $aryResponse = array();
    $count = 0;
    $finalscore = 0;
    $this->session->set_userdata('svsia',$tbip[0]);
    // $this->session->unset_userdata('svsia');


    foreach ($tbsb as $key => $value) {
      if($value!=''){
        $count+= $value;
      }
    }
    $temp[0] = round($count/3);
    $temp[1] = 0 ;

    $data['reception'] = $tbsb[0];
    $data['temp_accomodation'] = $tbsb[1];
    $data['opened_reception'] = $tbsb[2];
    $data['score51'] = $temp[0];

    $data['habitat_days'] = $tbip[0];
    $data['local_urban_services'] = $tbip[1];
    $data['public_services'] = $tbip[2];
    $data['compatible_functions'] = $tbip[3];

    if(isset($_SESSION['acco']) && ($_SESSION['acco'] != 0 || $_SESSION['acco'] != ''))
    {
      /* Conditons for SV SIA*/
      $G64 = $_SESSION['acco'];
      $cons = array();

      switch($G64){
        case 0>=$G64:
        case $G64<50:
          $cons[0] = 0;
          $cons[1] = 0.013;
          $cons[2] = 0.026;
          $cons[3] = 0.039;
          $cons[4] = 0.052;
          $cons[5] = 0.065;
          $cons[6] = 0.078;
          $cons[7] = 100;
          break;
        case 50>=$G64:
        case $G64<100:
          $cons[0] = 0;
          $cons[1] = 0.011;
          $cons[2] = 0.022;
          $cons[3] = 0.033;
          $cons[4] = 0.044;
          $cons[5] = 0.055;
          $cons[6] = 0.066;
          $cons[7] = 100;
          break;
        case 100>=$G64:
        case $G64<200:
          $cons[0] = 0;
          $cons[1] = 0.009;
          $cons[2] = 0.018;
          $cons[3] = 0.027;
          $cons[4] = 0.036;
          $cons[5] = 0.045;
          $cons[6] = 0.054;
          $cons[7] = 100;
          break;
        case 200>=$G64:
        case $G64<300:
          $cons[0] = 0;
          $cons[1] = 0.007;
          $cons[2] = 0.014;
          $cons[3] = 0.021;
          $cons[4] = 0.028;
          $cons[5] = 0.035;
          $cons[6] = 0.042;
          $cons[7] = 100;
          break;
        case 300>=$G64:
          $cons[0] = 0;
          $cons[1] = 0.005;
          $cons[2] = 0.01;
          $cons[3] = 0.015;
          $cons[4] = 0.02;
          $cons[5] = 0.025;
          $cons[6] = 0.03;
          $cons[7] = 100;
          break;

      }
      /**********************/
      // pr($cons);

      if(isset($_SESSION['G80']))
      {
        $G80 = $_SESSION['G80']-$tbip[0];
        if(($G80 != 0 || $G80 != '') && ($tbip[0] != 0 || $tbip[0] != ''))
        {
          $svsia = $tbip[0]/$G80;
          switch ($svsia) {
            case $cons[0]>$svsia:
            case $svsia<$cons[1]:
              $tem[0] = 25;
              break;
            case $cons[1]>=$svsia:
            case $svsia<$cons[2]:
              $tem[0] = 50;
              break;
            case $cons[2]>=$svsia:
            case $svsia<$cons[3]:
              $tem[0] = 75;
              break;
            case $cons[3]>=$svsia:
            case $svsia<$cons[4]:
              $tem[0] = 100;
              break;
            case $cons[4]>=$svsia:
            case $svsia<$cons[5]:
              $tem[0] = 75;
              break;
            case $cons[5]>=$svsia:
            case $svsia<$cons[6]:
              $tem[0] = 50;
              break;
            case $cons[6]>=$svsia:
            case $svsia<$cons[7]:
              $tem[0] = 25;
              break;

            default:
              $tem = 0;
              break;
          }

          $slu[1] = round(($tbip[1]/$G80)*100);
          $slu[2] = round(($tbip[2]/$G80)*100);
          $slu[3] = round(($tbip[3]/$G80)*100);

          foreach ($slu as $key => $value) {
            if($value != 0 && $value != '')
            {
              switch ($value) {
                case 0 > $value:
                case $value< 2:
                $tem[$key] = 25;
                break;
                case 2 >= $value:
                case $value< 4:
                $tem[$key] = 50;
                break;
                case 4 >=$value:
                case $value< 6:
                $tem[$key] = 75;
                break;
                case 6 >=$value:
                case $value< 8:
                $tem[$key] = 100;
                break;
                case 8 >=$value:
                case $value< 49:
                $tem[$key] = 75;
                break;

                default:
                $tem[$key] = 0;
                break;
              }
            }
            else {
              $tem[$key] = 0;
            }
          }

          $counter = 0;
          $svsum = 0;
          foreach($tem as $key => $value)
          {
            $svsum+=$value;
            $counter++;
          }
          $temp[1] = round($svsum/$counter);

        }

        // pr($temp);
        $finalscore = round(($temp[0]*60+$temp[1]*40)/100);
      }

      $data['score52'] = $temp[1];
      $data['score5'] = $finalscore;
      $data['rating5'] = round(($finalscore*11)/100);

      $aryResponse['score51'] = $temp[0];
      $aryResponse['score52'] = $temp[1];
      $aryResponse['finalscore'] = $finalscore;

      print_r(json_encode($aryResponse));
      $this->Dbaction->updateData('data',$data,array('user_id' => $this->aUsr['id'],'project_id' => $id));

    }
  }

  public function housing($id = 0)
  {
    $aVals = $_POST['tb4'];
    $aVals = $aVals[0];
    $res = 0;
    $score = array();
    $data = array();
    $temp = array();
    $aryResponse = array();
    $sess = array('svf'=>$aVals[3],'sva'=>$aVals[4],'svo'=>$aVals[5]);
    $this->session->set_userdata('sess',$sess);
    // pr($aVals);

    $data['social_housing'] = $aVals[0];
    $data['rental_calmed'] = $aVals[1];
    $data['ren_regulated'] = $aVals[2];
    $data['futura_sale_pact'] = $aVals[3];
    $data['agreement_sale'] = $aVals[4];
    $data['open_sale'] = $aVals[5];
    $data['social_rent'] = $aVals[6];
    $data['fv_calmed_1'] = $aVals[7];
    $data['fv_calmed_2'] = $aVals[8];
    $data['rent_OMI'] = $aVals[9];
    $data['price_pact_futura_sale'] = $aVals[10];
    $data['capital_share'] = $aVals[11];
    $data['sales_agreement'] = $aVals[12];
    $data['sale_price'] = $aVals[13];
    $data['sales_value_OMI'] = $aVals[14];

    $sum = ($aVals[0]+$aVals[1]+$aVals[2]+$aVals[3]+$aVals[4]+$aVals[5]);
    $this->session->set_userdata('G80',$sum);

    if($sum != 0)
    {
      if(($aVals[6]!=0 && $aVals[6]!='') && ($aVals[9]!=0 && $aVals[9]!=''))
      {
        $temp[0] = round(($aVals[9]-$aVals[6])/$aVals[9]*100);
      }
      else {
        $temp[0] = 0;
      }
      if(($aVals[7]!=0 && $aVals[7]!='') && ($aVals[9]!=0 && $aVals[9]!=''))
      {
        $temp[1] = round(($aVals[9]-$aVals[7])/$aVals[9]*100);
      }
      else {
        $temp[1] = 0;
      }
      if(($aVals[8]!=0 && $aVals[8]!='') && ($aVals[9]!=0 && $aVals[9]!=''))
      {
        $temp[2] = round(($aVals[9]-$aVals[8])/$aVals[9]*100);
      }else {
        $temp[2] = 0;
      }
      if(($aVals[10]!=0 && $aVals[10]!='') && ($aVals[14]!=0 && $aVals[14]!=''))
      {
        $tem[3] = round(($aVals[14]-$aVals[10])/$aVals[14]*100);
      }else {
        $temp[3] = 0;
      }
      if(($aVals[12]!=0 && $aVals[12]!='') && ($aVals[14]!=0 && $aVals[14]!=''))
      {
        $tem[5] = round(($aVals[14]-$aVals[12])/$aVals[14]*100);
      }
      else {
        $tem[5] = 0;
      }
      if(($aVals[13]!=0 && $aVals[13]!='') && ($aVals[14]!=0 && $aVals[14]!=''))
      {
        $tem[6] = round(($aVals[14]-$aVals[13])/$aVals[14]*100);
      }
      else {
        $tem[6] = 0;
      }
      foreach($temp as $key => $value)
      {
        switch ($value) {
          case ($value>0 && $value<10):
          $temp[$key] = 0;
          break;
          case ($value>=10 && $value<20):
          $temp[$key] = 25;
          break;
          case ($value>=20 && $value<30):
          $temp[$key] = 50;
          break;
          case ($value>=30 && $value<40):
          $temp[$key] = 75;
          break;
          case ($value>=40 && $value<100):
          $temp[$key] = 100;
          break;

          default:
          $temp[$key] = 0;
          break;
        }
      }
      foreach($tem as $key => $value)
      {
        // pr($key."=>".$value."<br />");
        switch ($value) {
          case ($value>0 && $value<6):
          $temp[$key] = 0;
          break;
          case ($value>=6 && $value<12):
          $temp[$key] = 20;
          break;
          case ($value>=12 && $value<18):
          $temp[$key] = 40;
          break;
          case ($value>=18 && $value<24):
          $temp[$key] = 60;
          break;
          case ($value>=24 && $value<100):
          $temp[$key] = 80;
          break;

          default:
          $temp[$key] = 0;
          break;
        }
      }
      $temp[4] = 0;
      if($aVals[11]!=0 && $aVals[11]!='')
      {
        $te[4] = $aVals[11];
        foreach ($te as $key => $value) {
          switch ($value) {
            case ($value>0 && $value<30):
              $temp[$key] = 0;
              break;
            case (30>=$value && $value<40):
              $temp[$key] = 20;
              break;
            case (40>=$value && $value<50):
              $temp[$key] = 40;
              break;
            case (50>=$value && $value<60):
              $temp[$key] = 60;
              break;
            case (60>=$value && $value<100):
              $temp[$key] = 80;
              break;

            default:
              $temp[$key] = 0;
              break;
          }
        }
      }

      if(isset($_SESSION['svsia']))
      {
        $sv = $_SESSION['svsia'];
        $var = round($aVals[0]/($sum-$sv)*100);
        $temp[7] = 0;
      }
      else {
        $temp[7] = 0;
      }

      $score[0] = $temp[0]*$aVals[0]/$sum;
      $score[1] = $temp[7]*$aVals[0]/$sum;
      $score[2] = $temp[1]*$aVals[1]/$sum;
      $score[3] = $temp[2]*$aVals[2]/$sum;
      $score[4] = $temp[3]*($aVals[3]/($sum-$aVals[5]))/2;
      $score[5] = $temp[4]*($aVals[3]/$sum)/2;
      $score[6] = $temp[6]*$aVals[5]/$sum;

      foreach($score as $sc)
      {
        $res+=$sc;
      }
      $res = round($res);
    }

    $data['score4'] = $res;
    $data['rating4'] = round(($res*15)/100);
    $aryResponse['finalscore'] = $res;
    print_r($res);
    $this->Dbaction->updateData('data',$data,array('user_id' => $this->aUsr['id'],'project_id' => $id));
  }

  public function project($id = 0)
  {
    $aVals = $_POST['tb6'];
    $data = array();
    $aryResponse = array();

    $aVals = $aVals[0];

    $data['social_management_plan'] = $aVals[0];
    $data['transparent_selection'] = $aVals[1];
    $data['community_profile'] = $aVals[2];
    $data['cognitive_talks'] = $aVals[3];
    $data['info_meetings'] = $aVals[4];
    $data['laboratories'] = $aVals[5];
    $data['housing_variants'] = $aVals[6];
    $data['space_management'] = $aVals[7];
    $data['representation_rules'] = $aVals[8];
    $data['tenants_training'] = $aVals[9];

    $temp[0] = round(($aVals[0]*.80)+($aVals[1])*.20);
    $temp[1] = round(($aVals[2]+$aVals[3]+$aVals[4]+$aVals[5])/4);
    if(isset($_SESSION['G80']) && isset($_SESSION['sess']))
    {
      $G80 = $_SESSION['G80'];
      $sess = $_SESSION['sess'];
      $con = 0;

      foreach ($sess as $key => $value) {
        if($value>0){
          $con=1;
        }
      }

      if(($G80!=0 && $G80!='') && $con==1)
      {
        $temp[2] = $aVals[6];
      }else {
        $temp[2] = 0;
      }
    }

    $temp[3] = round(($aVals[7]+$aVals[8]+$aVals[9])/3);

    $data['score61'] = $temp[0];
    $data['score62'] = $temp[1];
    $data['score63'] = $temp[2];
    $data['score64'] = $temp[3];

    $aryResponse['score61'] = $temp[0];
    $aryResponse['score62'] = $temp[1];
    $aryResponse['score63'] = $temp[2];
    $aryResponse['score64'] = $temp[3];


    if($temp[2]==0)
    {
      $res = round(($temp[0]*20/90)+($temp[1]*40/90)+($temp[3]*30/90));
    }else {
      $res = round(($temp[0]*.20)+($temp[1]*.40)+($temp[2]*.10)+($temp[3]*.30));
    }

    $data['score6'] = $res;
    $data['rating6'] = round(($res*30)/100);
    $aryResponse['finalscore'] = $res;
    print_r(json_encode($aryResponse));
    $this->Dbaction->updateData('data',$data,array('user_id' => $this->aUsr['id'],'project_id' => $id));
  }

  public function submit($id = 0)
  {
    $data['submit'] = 1;

    $this->Dbaction->updateData('data',$data,array('id' => $id));
    redirect(base_url('griglia'));
  }

}
 ?>
