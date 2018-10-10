<div class="header">
  <h4 class="title"><?php echo $title;?></h4>
</div>
        <?php $data?$data = $data[0]:'';
              $aUsr = json_decode(json_encode($_SESSION['user']), True);
              $projects = unserialize($aUsr['projects']) ;//pr($projectz);
              $energy = array('100' => 'A+','95' => 'TO','75' => 'B','50' => 'C','25' => 'D','10' => 'IS','0' => 'F','0' => 'G');
              $renovated= array('100' => 'TO','95' => 'B','70' => 'C','50' => 'D','25' => 'IS','10' => 'F','0' => 'G');
              $yeno = array('1' => 'Yes','0' => 'No');
              $yea= array('100' => 'Yes','0' => 'No');
        ?>
           <div class="row" id="formreplace">
             <div class="col-md-2">
               &nbsp;
             </div>
             <div class="col-md-2">&nbsp;</div>
             <!-- <form method="post"> -->
               <div class="col-md-12">
                   <div class="tab">
                    <button class="tablinks active" onclick="openCity(event, 'tab0')" id="start">Start</button>
                    <button class="tablinks" onclick="openCity(event, 'tab1')" id="sus">Sustainability</button>
                    <button class="tablinks" onclick="openCity(event, 'tab2')" id="background">Background</button>
                    <button class="tablinks" onclick="openCity(event, 'tab3')" id="quality">Quality of architectural design</button>
                    <button class="tablinks" onclick="openCity(event, 'tab4')" id="housing">Housing Offer</button>
                    <button class="tablinks" onclick="openCity(event, 'tab5')" id="functional">Social and functional Mix</button>
                    <button class="tablinks" onclick="openCity(event, 'tab6')" id="social">Social management</button>
                   </div>
                   <div class="clearfix">&nbsp;</div>
                   <div class="tabcontent" id="tab0" style="display:block;">
                     <div class="col-md-12">
                       <div class="col-md-2">
                         <label>Project</label>
                         <select class="form-control border-input project" id="selectproject" <?php if($aUsr['role']==MODERATOR_ROLE || $aUsr['role']==ADMIN_ROLE) echo 'disabled'; ?> <?php if($data){if($data['submit']==1) echo 'disabled';} ?>>
                           <option value="0">Select Project</option>
                           <?php foreach ($projects as $key => $value){ ?>
                             <option value="<?php echo $value; ?>" <?php if($data && $data['project_id']==$value) echo 'selected'; ?>><?php echo $projectz[$value]; ?></option>
                           <?php }?>
                         </select>
                       </div>
                       <div class="col-md-2">
                         <label>Duration Period</label>
                         <select class="form-control border-input" <?php if($aUsr['role']==MODERATOR_ROLE || $aUsr['role']==ADMIN_ROLE) echo 'disabled'; ?> <?php if($data){if($data['submit']==1) echo 'disabled';} ?> id="selector">
                           <option value="1">Months</option>
                           <option value="0">Years</option>
                         </select>
                       </div>
                       <div class="col-md-2">
                         <label>Duration</label>
                         <input type="number" class="form-control border-input" <?php if($aUsr['role']==MODERATOR_ROLE || $aUsr['role']==ADMIN_ROLE) echo 'disabled'; ?> <?php if($data){if($data['submit']==1) echo 'disabled';} ?> id="duration" value="<?php if($data) echo $data['duration'];?>">
                       </div>
                       <div class="col-md-2">
                         <label>Project Value</label>
                         <input type="number" class="form-control border-input" <?php if($aUsr['role']==MODERATOR_ROLE || $aUsr['role']==ADMIN_ROLE) echo 'disabled'; ?> <?php if($data){if($data['submit']==1) echo 'disabled';} ?> id="projectvalue" value="<?php if($data) echo $data['project_value'];?>">
                       </div>
                       <div class="col-md-2">
                         <button type="button" name="button" class="btn btn-info btn-fill marg" onclick="selectproject();openCity(event, 'tab1');">Next</button>
                         <!--onblur="selectproject();"  $('#sus').addClass('active')-->
                       </div>
                     </div>
                   </div>
                   <?php if($data){ ?>
                   <div id="tab1" class="tabcontent">
                     <div class="col-md-12 ">
                       <h4>1. Environmental Sustainability</h4><br />
                       <h5>1.1 Building Type</h5><br />
                       <div class="col-md-2">
                         <label>(GF)</label>
                         <input type="number" min="0" name="gf" class="form-control border-input " id="envi1" onblur="enviroment(<?php echo $this->uri->segment(3); ?>);" value="<?php echo $data['gf']; ?>"/ <?php if($data['submit']==1 || $aUsr['role']==MODERATOR_ROLE || $aUsr['role']==ADMIN_ROLE) echo 'readonly';?>> <br />
                       </div>
                       <div class="col-md-2">
                         <label>(RI)</label>
                         <input type="number" min="0" name="" class="form-control border-input" id="envi2" onblur="enviroment(<?php echo $this->uri->segment(3); ?>);" value="<?php echo $data['ri']; ?>" <?php if($data['submit']==1 || $aUsr['role']==MODERATOR_ROLE || $aUsr['role']==ADMIN_ROLE) echo 'readonly';?>/><br />
                       </div>
                       <div class="col-md-2">
                         <label>(RSA)</label>
                         <input type="number" min="0" name="" class="form-control border-input" id="envi3" onblur="enviroment(<?php echo $this->uri->segment(3); ?>);" value="<?php echo $data['rsa']; ?>" <?php if($data['submit']==1 || $aUsr['role']==MODERATOR_ROLE || $aUsr['role']==ADMIN_ROLE) echo 'readonly';?>/><br />
                       </div>
                       <div class="col-md-2">
                         <label>(BF)</label>
                         <input type="number" min="0" name="" class="form-control border-input" id="envi4" onblur="enviroment(<?php echo $this->uri->segment(3); ?>);" value="<?php echo $data['bf']; ?>" <?php if($data['submit']==1 || $aUsr['role']==MODERATOR_ROLE || $aUsr['role']==ADMIN_ROLE) echo 'readonly';?>/><br />
                       </div>
                       <div class="col-md-2">
                         <label>(RS)</label>
                         <input type="number" min="0" name="" class="form-control border-input" id="envi5" onblur="enviroment(<?php echo $this->uri->segment(3); ?>);" value="<?php echo $data['rs']; ?>" <?php if($data['submit']==1 || $aUsr['role']==MODERATOR_ROLE || $aUsr['role']==ADMIN_ROLE) echo 'readonly';?>/><br />
                       </div>
                       <div class="col-md-2">
                         <label>(RCT)</label>
                         <input type="number" min="0" name="" class="form-control border-input" id="envi6" onblur="enviroment(<?php echo $this->uri->segment(3); ?>);" value="<?php echo $data['rct']; ?>" <?php if($data['submit']==1 || $aUsr['role']==MODERATOR_ROLE || $aUsr['role']==ADMIN_ROLE) echo 'readonly';?>/><br />
                       </div>
                       <?php if ($aUsr['role']==MODERATOR_ROLE || $aUsr['role']==ADMIN_ROLE): ?>
                         <div class="col-md-2">
                           <label>Score</label>
                           <input type="text" min="0" name="" class="form-control border-input" id="score1" readonly value="<?php echo $data['score11']; ?>"/><br />
                         </div>
                       <?php endif; ?>
                       <div class="clearfix">

                       </div>

                       <h5>1.2 Energy Efficiency</h5><br />
                       <div class="col-md-3">
                       <label>New building energy class</label>
                         <select class="form-control border-input marg" name="" id="effi1" onchange="enviroment(<?php echo $this->uri->segment(3); ?>);" <?php if($data['submit']==1 || $aUsr['role']==MODERATOR_ROLE || $aUsr['role']==ADMIN_ROLE) echo 'disabled'; ?>>
                          <?php foreach($energy as $key => $value) {?>
                            <option value="<?php echo $key; ?>" <?php if($data['new_building_energy_class']==$key) echo 'selected'; ?>><?php echo $value; ?></option>
                          <?php } ?>
                         </select><br />
                       </div>
                       <div class="col-md-3">
                       <label>Energy Class renovated building</label>
                         <select class="form-control border-input" name="" id="effi2" onchange="enviroment(<?php echo $this->uri->segment(3); ?>);" <?php if($data['submit']==1 || $aUsr['role']==MODERATOR_ROLE || $aUsr['role']==ADMIN_ROLE) echo 'disabled'; ?>>
                           <option value="100" <?php if($data['energy_class_renovated_building']==$key) echo 'selected'; ?>>A+</option>
                           <?php foreach($renovated as $key => $value){ ?>
                             <option value="<?php echo $key; ?>" <?php if($data['energy_class_renovated_building']==$key) echo 'selected'; ?>><?php echo $value; ?></option>
                           <?php } ?>
                         </select><br />
                       </div>
                       <div class="col-md-3">
                         <label>SLP edificio nuovo</label>
                         <input type="number" min="0" name="" class="form-control border-input marg"  id="effi3" onblur="enviroment(<?php echo $this->uri->segment(3); ?>);" value="<?php echo $data['slpnuovo']; ?>" <?php if($data['submit']==1 || $aUsr['role']==MODERATOR_ROLE || $aUsr['role']==ADMIN_ROLE) echo 'readonly';?>/><br />
                       </div>
                       <div class="col-md-3">
                         <label>SLP edificio ristrutturato</label>
                         <input type="number" min="0" name="" class="form-control border-input marg"  id="effi4" onblur="enviroment(<?php echo $this->uri->segment(3); ?>);" value="<?php echo $data['slpristrutturato']; ?>" <?php if($data['submit']==1 || $aUsr['role']==MODERATOR_ROLE || $aUsr['role']==ADMIN_ROLE) echo 'readonly';?>><br /><br />
                       </div>
                       <?php if ($aUsr['role']==MODERATOR_ROLE || $aUsr['role']==ADMIN_ROLE): ?>
                         <div class="col-md-2">
                           <label>Score</label>
                           <input type="text" min="0" name="" class="form-control border-input" id="score2" readonly value="<?php echo $data['score12']; ?>"/><br />
                         </div>
                       <?php endif; ?>
                       <div class="clearfix">

                       </div>
                       <div class="col-md-4">
                         <label>Total Score</label>
                         <input type="text" min="0" class="form-control border-input" id="fin" readonly value="<?php echo $data['score1']; ?>"/><br /><br />
                       </div>
                       <button class="btn btn-fill btn-info butt" type="button" onclick="openCity(event, 'tab2');$('#background').addClass('active');" style="margin-top: 28px;" id="btn1">Continue</button><br />
                       <button class="btn btn-fill btn-info butt" type="button" onclick="openCity(event, 'tab0');$('#start').addClass('active');" style="margin-top: 9px;">Previous</button><br />
                     </div>
                   </div>
                   <div id="tab2" class="tabcontent">
                     <div class="col-md-12">
                       <h4>2. Background</h4>
                       <h5>2.1 services, green areas and intended use</h5>
                       <label>2.1.1 Shorter Distance:</label><br />
                       <div class="col-md-12 ">
                         <div class="col-md-4">
                           <label>Business Neighborhood Activities</label><br />
                           <input type="number" min="0" class="form-control border-input" name="" id="sd1"   onblur="energy(<?php echo $this->uri->segment(3); ?>);" value="<?php echo $data['activities']; ?>" <?php if($data['submit']==1 || $aUsr['role']==MODERATOR_ROLE || $aUsr['role']==ADMIN_ROLE) echo 'readonly';?>/><br />
                         </div>
                         <div class="col-md-4">
                           <label>Public parks and neighborhood gardens</label><br />
                           <input type="number" min="0" class="form-control border-input" name="" id="sd2"   onblur="energy(<?php echo $this->uri->segment(3); ?>);" value="<?php echo $data['gardens']; ?>" <?php if($data['submit']==1 || $aUsr['role']==MODERATOR_ROLE || $aUsr['role']==ADMIN_ROLE) echo 'readonly';?>/><br />
                         </div>
                         <div class="col-md-4">
                           <label>Neighborhood sports centers</label><br />
                           <input type="number" min="0" class="form-control border-input " name="" id="sd3"  onblur="energy(<?php echo $this->uri->segment(3); ?>);" value="<?php echo $data['sports_centers']; ?>" <?php if($data['submit']==1 || $aUsr['role']==MODERATOR_ROLE || $aUsr['role']==ADMIN_ROLE) echo 'readonly';?>/><br />
                         </div>
                         <div class="col-md-4">
                           <label>Aggregation services district</label><br />
                           <input type="number" min="0" class="form-control border-input " name="" id="sd4"   onblur="energy(<?php echo $this->uri->segment(3); ?>);" value="<?php echo $data['services_district']; ?>" <?php if($data['submit']==1 || $aUsr['role']==MODERATOR_ROLE || $aUsr['role']==ADMIN_ROLE) echo 'readonly';?>/><br />
                         </div>
                         <div class="col-md-4">
                           <label>Schools</label><br />
                           <input type="number" min="0" class="form-control border-input " name="" id="sd5"  onblur="energy(<?php echo $this->uri->segment(3); ?>);" value="<?php echo $data['schools']; ?>" <?php if($data['submit']==1 || $aUsr['role']==MODERATOR_ROLE || $aUsr['role']==ADMIN_ROLE) echo 'readonly';?>/><br />
                         </div>
                         <div class="col-md-4">
                           <label>Places of worship and speakers</label><br />
                           <input type="number" min="0" class="form-control border-input " name="" id="sd6"  onblur="energy(<?php echo $this->uri->segment(3); ?>);" value="<?php echo $data['worship_places']; ?>" <?php if($data['submit']==1 || $aUsr['role']==MODERATOR_ROLE || $aUsr['role']==ADMIN_ROLE) echo 'readonly';?>/><br />
                         </div>
                         <div class="col-md-4 ">
                           <label>District health services</label><br />
                           <input type="number" min="0" class="form-control border-input" name="" id="sd7"  onblur="energy(<?php echo $this->uri->segment(3); ?>);" value="<?php echo $data['health_services']; ?>" <?php if($data['submit']==1 || $aUsr['role']==MODERATOR_ROLE || $aUsr['role']==ADMIN_ROLE) echo 'readonly';?>/><br />
                         </div>
                         <div class="col-md-4 ">
                           <label>Libraries </label><br />
                           <input type="number" min="0" class="form-control border-input" name="" id="sd8"  onblur="energy(<?php echo $this->uri->segment(3); ?>);" value="<?php echo $data['libraries']; ?>" <?php if($data['submit']==1 || $aUsr['role']==MODERATOR_ROLE || $aUsr['role']==ADMIN_ROLE) echo 'readonly';?>/><br />
                         </div>
                         <div class="col-md-4 ">
                           <label>Poste</label><br />
                           <input type="number" min="0" class="form-control border-input" name="" id="sd9"  onblur="energy(<?php echo $this->uri->segment(3); ?>);" value="<?php echo $data['poste']; ?>" <?php if($data['submit']==1 || $aUsr['role']==MODERATOR_ROLE || $aUsr['role']==ADMIN_ROLE) echo 'readonly';?>/><br />
                         </div>
                         <div class="col-md-4 ">
                           <label>High school</label><br />
                           <input type="number" min="0" class="form-control border-input" name="" id="sd10"  onblur="energy(<?php echo $this->uri->segment(3); ?>);" value="<?php echo $data['high_school']; ?>" <?php if($data['submit']==1 || $aUsr['role']==MODERATOR_ROLE || $aUsr['role']==ADMIN_ROLE) echo 'readonly';?>/><br />
                         </div>
                         <div class="col-md-4">
                           <label>Points of neighborhood cultural interest</label><br />
                           <input type="number" min="0" class="form-control border-input" name="" id="sd11"   onblur="energy(<?php echo $this->uri->segment(3); ?>);" value="<?php echo $data['cultural_intrest']; ?>" <?php if($data['submit']==1 || $aUsr['role']==MODERATOR_ROLE || $aUsr['role']==ADMIN_ROLE) echo 'readonly';?>/><br /><br />
                         </div><br />
                       </div>

                       <label>2.1.2 Average distance:</label><br />
                       <div class="col-md-12 marg">
                         <div class="col-md-4">
                           <label>Points of cultural interest attractors urban</label><br />
                           <input type="number" min="0" class="form-control border-input" name="" id="ad1" onblur="energy(<?php echo $this->uri->segment(3); ?>);" value="<?php echo $data['cultural_intrest_attractors_urban']; ?>" <?php if($data['submit']==1 || $aUsr['role']==MODERATOR_ROLE || $aUsr['role']==ADMIN_ROLE) echo 'readonly';?>/><br />
                         </div>
                         <div class="col-md-4">
                           <label>Public parks and gardens urban attractors</label><br />
                           <input type="number" min="0" class="form-control border-input" name="" id="ad2" onblur="energy(<?php echo $this->uri->segment(3); ?>);" value="<?php echo $data['gardens_urban_attractors']; ?>" <?php if($data['submit']==1 || $aUsr['role']==MODERATOR_ROLE || $aUsr['role']==ADMIN_ROLE) echo 'readonly';?>/><br />
                         </div>
                         <div class="col-md-4">
                           <label>Sporting centers urban attractors</label><br />
                           <input type="number" min="0" class="form-control border-input marg" name="" id="ad3" onblur="energy(<?php echo $this->uri->segment(3); ?>);" value="<?php echo $data['sporting_centers_urban_attractors']; ?>" <?php if($data['submit']==1 || $aUsr['role']==MODERATOR_ROLE || $aUsr['role']==ADMIN_ROLE) echo 'readonly';?>/><br />
                         </div>
                         <div class="clearfix">

                         </div>
                         <div class="col-md-4">
                           <label>Commerce supermarkets</label><br />
                           <input type="number" min="0" class="form-control border-input" name="" id="ad4"  onblur="energy(<?php echo $this->uri->segment(3); ?>);" value="<?php echo $data['supermarkets']; ?>" <?php if($data['submit']==1 || $aUsr['role']==MODERATOR_ROLE || $aUsr['role']==ADMIN_ROLE) echo 'readonly';?>/><br />
                         </div>
                         <div class="col-md-4">
                           <label>University</label><br />
                           <input type="number" min="0" class="form-control border-input" name="" id="ad5"  onblur="energy(<?php echo $this->uri->segment(3); ?>);" value="<?php echo $data['university']; ?>" <?php if($data['submit']==1 || $aUsr['role']==MODERATOR_ROLE || $aUsr['role']==ADMIN_ROLE) echo 'readonly';?>/><br />
                         </div>
                         <div class="col-md-4">
                           <label>Health Services urban attractors</label><br />
                           <input type="number" min="0" class="form-control border-input" name="" id="ad6"  onblur="energy(<?php echo $this->uri->segment(3); ?>);" value="<?php echo $data['health_services_urban_attractors']; ?>" <?php if($data['submit']==1 || $aUsr['role']==MODERATOR_ROLE || $aUsr['role']==ADMIN_ROLE) echo 'readonly';?>/><br />
                         </div>
                       </div>

                       <label>2.1.3 Intended use</label><br />
                       <div class="col-md-12">
                         <div class="col-md-4">
                           <label>Industrial area</label>
                           <select class="form-control border-input marg" id="sel1" onchange="energy(<?php echo $this->uri->segment(3); ?>);" <?php if($data['submit']==1 || $aUsr['role']==MODERATOR_ROLE || $aUsr['role']==ADMIN_ROLE) echo 'disabled'; ?>>
                             <option value="0">select</option>
                             <?php foreach($yeno as $key => $value){ ?>
                               <option value="<?php echo $key; ?>" <?php if($data['industrial_area']==$key) echo 'selected'; ?>><?php echo $value; ?></option>
                             <?php  }?>
                           </select><br />
                         </div>
                         <div class="col-md-4">
                           <label>Directional and commercial areas and services</label>
                           <select class="form-control border-input" id="sel2" onchange="energy(<?php echo $this->uri->segment(3); ?>);" <?php if($data['submit']==1 || $aUsr['role']==MODERATOR_ROLE || $aUsr['role']==ADMIN_ROLE) echo 'disabled'; ?>>
                             <option value="0">select</option>
                             <?php foreach($yeno as $key => $value){ ?>
                               <option value="<?php echo $key; ?>" <?php if($data['commercial_area']==$key) echo 'selected'; ?>><?php echo $value; ?></option>
                             <?php  }?>
                           </select><br />
                         </div>
                         <div class="col-md-4">
                           <label>Residential area </label>
                           <select class="form-control border-input marg" id="sel3" onchange="energy(<?php echo $this->uri->segment(3); ?>);" <?php if($data['submit']==1 || $aUsr['role']==MODERATOR_ROLE || $aUsr['role']==ADMIN_ROLE) echo 'disabled'; ?>>
                             <option value="0">select</option>
                             <?php foreach($yeno as $key => $value){ ?>
                               <option value="<?php echo $key; ?>" <?php if($data['residential_area']==$key) echo 'selected'; ?>><?php echo $value; ?></option>
                             <?php  }?>
                           </select><br /><br />
                         </div>
                         <?php if ($aUsr['role']==MODERATOR_ROLE || $aUsr['role']==ADMIN_ROLE): ?>
                           <div class="col-md-2">
                             <label>Score</label>
                             <input type="text" min="0" name="" class="form-control border-input" id="score3"  readonly value="<?php echo $data['score21']; ?>"/><br />
                           </div>
                         <?php endif; ?>
                         <div class="clearfix">

                         </div>
                       </div>

                       <h5>2.2 Accessibility and practicability</h5>
                       <div class="col-md-12">
                         <div class="col-md-4">
                           <label> Existence of the municipality metropolitan</label>
                           <select class="form-control border-input" id="sel4" onchange="en()" <?php if($data['submit']==1 || $aUsr['role']==MODERATOR_ROLE || $aUsr['role']==ADMIN_ROLE) echo 'disabled'; ?>>
                             <option value="">Select</option>
                             <option value="1">Yes</option>
                             <option value="0">No</option>
                           </select><br />
                         </div>
                         <div class="col-md-4">
                           <label class="marg">Subway</label>
                           <input type="number" min="0" class="form-control border-input" name="" id="at1" disabled  onblur="energy(<?php echo $this->uri->segment(3); ?>);" value="<?php echo $data['subway']; ?>" <?php if($data['submit']==1 || $aUsr['role']==MODERATOR_ROLE || $aUsr['role']==ADMIN_ROLE) echo 'readonly';?>/><br />
                         </div>
                         <div class="col-md-4">
                           <label class="marg">Bus line</label>
                           <input type="number" min="0" class="form-control border-input" name="" id="at2" onblur="energy(<?php echo $this->uri->segment(3); ?>);" value="<?php echo $data['bus_line']; ?>" <?php if($data['submit']==1 || $aUsr['role']==MODERATOR_ROLE || $aUsr['role']==ADMIN_ROLE) echo 'readonly';?>/><br />
                         </div>
                         <div class="clearfix">

                         </div>
                         <div class="col-md-4">
                           <label>Railway station</label>
                           <input type="number" min="0" class="form-control border-input" name="" id="at3" onblur="energy(<?php echo $this->uri->segment(3); ?>);" value="<?php echo $data['railway_station']; ?>" <?php if($data['submit']==1 || $aUsr['role']==MODERATOR_ROLE || $aUsr['role']==ADMIN_ROLE) echo 'readonly';?>/><br />
                         </div>
                         <div class="col-md-4">
                           <label>Other public transport</label>
                           <input type="number" min="0" class="form-control border-input" name="" id="at4" onblur="energy(<?php echo $this->uri->segment(3); ?>);" value="<?php echo $data['public_transport']; ?>" <?php if($data['submit']==1 || $aUsr['role']==MODERATOR_ROLE || $aUsr['role']==ADMIN_ROLE) echo 'readonly';?>/><br />
                         </div>
                         <div class="col-md-4">
                           <label>Population</label>
                           <input type="number" min="0" class="form-control border-input" name="" id="at5" onblur="energy(<?php echo $this->uri->segment(3); ?>);" value="<?php echo $data['population']; ?>" <?php if($data['submit']==1 || $aUsr['role']==MODERATOR_ROLE || $aUsr['role']==ADMIN_ROLE) echo 'readonly';?>/><br /><br />
                         </div>
                         <div class="clearfix"></div>
                         <?php if ($aUsr['role']==MODERATOR_ROLE || $aUsr['role']==ADMIN_ROLE): ?>
                           <div class="col-md-2">
                             <label>Score</label>
                             <input type="text" min="0" name="" class="form-control border-input" id="score4" readonly value="<?php echo $data['score22']; ?>"/><br />
                           </div>
                         <?php endif; ?>
                         <div class="clearfix">

                         </div>
                         <div class="col-md-4">
                           <label>Total Score</label>
                           <input type="text" min="0" class="form-control border-input" id="t2sc"  onblur="energy(<?php echo $this->uri->segment(3); ?>);" readonly value="<?php echo $data['score2']; ?>"/><br /><br />
                         </div>
                       </div>

                       <button class="btn btn-info btn-fill butt"  onclick="openCity(event, 'tab3');$('#quality').addClass('active');" id="con2">Continue</button><br />
                       <button class="btn btn-info btn-fill butt"  onclick="openCity(event, 'tab1');$('#sus').addClass('active');" id="prev2">Previous</button><br />
                     </div>
                     <div class="col-md-2">
                       &nbsp;
                     </div>
                   </div>
                   <div id="tab3" class="tabcontent">
                     <div class="col-md-12">
                      <h4>3. Social quality of architectural design</h4>
                      <div class="col-md-12">
                        <h5>3.1 Procedure competition in the selection of designers</h5>
                        <div class="col-md-6">
                          <select class="form-control border-input" id="t3sb1" onchange="arch(<?php echo $this->uri->segment(3); ?>);" <?php if($data['submit']==1 || $aUsr['role']==MODERATOR_ROLE || $aUsr['role']==ADMIN_ROLE) echo 'disabled'; ?>>
                            <option value="0">Select</option>
                            <?php foreach($yea as $key => $value){ ?>
                              <option value="<?php echo $key; ?>" <?php if($data['selection_designers']==$key) echo 'selected'; ?>><?php echo $value; ?></option>
                            <?php } ?>
                          </select><br />

                        </div>
                        <div class="clearfix">

                        </div>
                        <?php if ($aUsr['role']==MODERATOR_ROLE || $aUsr['role']==ADMIN_ROLE): ?>
                          <div class="col-md-2">
                            <label>Score</label>
                            <input type="text" min="0" name="" class="form-control border-input" id="score5"  readonly value="<?php echo $data['score31']; ?>"/><br />
                          </div>
                        <?php endif; ?>
                      </div>

                      <div class="col-md-12">
                        <h5>3.2 Physical relationship with the urban context</h5>
                        <div class="col-md-6">
                          <label>3.2.1 Integration system of pedestrian / bicycle designed with existing ones</label>
                          <select class="form-control border-input" id="t3sb2" onchange="arch(<?php echo $this->uri->segment(3); ?>);" <?php if($data['submit']==1 || $aUsr['role']==MODERATOR_ROLE || $aUsr['role']==ADMIN_ROLE) echo 'disabled'; ?>>
                            <option value="0">Select</option>
                            <?php foreach($yea as $key => $value){ ?>
                              <option value="<?php echo $key; ?>" <?php if($data['pedestrian_bicycle']==$key) echo 'selected'; ?>><?php echo $value; ?></option>
                            <?php } ?>
                          </select><br />

                        </div>
                        <div class="col-md-6">
                          <label>3.2.2 collective open spaces Planning and varieties open space</label>
                          <select class="form-control border-input marg" id="t3sb3" onchange="arch(<?php echo $this->uri->segment(3); ?>);" <?php if($data['submit']==1 || $aUsr['role']==MODERATOR_ROLE || $aUsr['role']==ADMIN_ROLE) echo 'disabled'; ?>>
                            <option value="0">Select</option>
                            <?php foreach($yea as $key => $value){ ?>
                              <option value="<?php echo $key; ?>" <?php if($data['open_spaces']==$key) echo 'selected'; ?>><?php echo $value; ?></option>
                            <?php } ?>
                          </select><br />

                        </div>
                        <div class="clearfix">

                        </div>
                        <?php if ($aUsr['role']==MODERATOR_ROLE || $aUsr['role']==ADMIN_ROLE): ?>
                          <div class="col-md-2">
                            <label>Score</label>
                            <input type="text" min="0" name="" class="form-control border-input" id="score6"  readonly value="<?php $data['score32']; ?>"/><br />
                          </div>
                        <?php endif; ?>
                      </div>

                      <div class="col-md-12">
                        <h5>3.3 Green</h5>
                        <div class="col-md-6">
                          <label>3.3.1 Design of green spaces</label>
                          <select class="form-control border-input" id="t3sb4" onchange="arch(<?php echo $this->uri->segment(3); ?>);" <?php if($data['submit']==1 || $aUsr['role']==MODERATOR_ROLE || $aUsr['role']==ADMIN_ROLE) echo 'disabled'; ?>>
                            <option value="0">Select</option>
                            <?php foreach($yea as $key => $value){ ?>
                              <option value="<?php echo $key; ?>" <?php if($data['green_space_design']==$key) echo 'selected'; ?>><?php echo $value; ?></option>
                            <?php } ?>
                          </select><br />

                        </div>
                        <div class="col-md-6">
                          <label>3.3.2 Greenery to self-manage (Orti / community garden)</label>
                          <select class="form-control border-input" id="t3sb5" onchange="arch(<?php echo $this->uri->segment(3); ?>);" <?php if($data['submit']==1 || $aUsr['role']==MODERATOR_ROLE || $aUsr['role']==ADMIN_ROLE) echo 'disabled'; ?>>
                            <option value="0">Select</option>
                            <?php foreach($yea as $key => $value){ ?>
                              <option value="<?php echo $key; ?>" <?php if($data['greenery_manage']==$key) echo 'selected'; ?>><?php echo $value; ?></option>
                            <?php } ?>
                          </select><br />

                        </div>
                        <div class="clearfix">

                        </div>
                        <?php if ($aUsr['role']==MODERATOR_ROLE || $aUsr['role']==ADMIN_ROLE): ?>
                          <div class="col-md-2">
                            <label>Score</label>
                            <input type="text" min="0" name="" class="form-control border-input" id="score7"  readonly value="<?php echo $data['score33']; ?>"/><br />
                          </div>
                        <?php endif; ?>
                      </div>
                      <div class="col-md-12">
                        <h5>3.4 Accommodations</h5>
                        <div class="col-md-12">
                          <!-- <label>3.4.1 More than 50% of the rooms with a balcony</label><br /> -->
                          <div class="col-md-6">
                            <label>3.4.1 More than 50% of the rooms with a balcony or loggia "space" (depth> 1.50 meters) or with private garden</label>
                            <select class="form-control border-input" id="t3sb6" onchange="arch(<?php echo $this->uri->segment(3); ?>);" <?php if($data['submit']==1 || $aUsr['role']==MODERATOR_ROLE || $aUsr['role']==ADMIN_ROLE) echo 'disabled'; ?>>
                              <option value="0">Select</option>
                              <?php foreach($yea as $key => $value){ ?>
                                <option value="<?php echo $key; ?>" <?php if($data['rooms_balcony']==$key) echo 'selected'; ?>><?php echo $value; ?></option>
                              <?php } ?>
                            </select><br />

                          </div>
                          <div class="col-md-6">
                            <label>3.4.2 Presence of a cellar or storage room for at least 50% of the accommodation</label>
                            <select class="form-control border-input" id="t3sb7" onchange="arch(<?php echo $this->uri->segment(3); ?>);" <?php if($data['submit']==1 || $aUsr['role']==MODERATOR_ROLE || $aUsr['role']==ADMIN_ROLE) echo 'disabled'; ?>>
                              <option value="0">Select</option>
                              <?php foreach($yea as $key => $value){ ?>
                                <option value="<?php echo $key; ?>" <?php if($data['cellar_storage']==$key) echo 'selected'; ?>><?php echo $value; ?></option>
                              <?php } ?>
                            </select><br />

                          </div>
                        </div>
                        <div class="col-md-12">
                          <div class="col-md-6">
                            <label>3.4.3 Accommodations non mono-facing</label><br />
                            <label>3.4.3.1 Number of housing not mono-facing</label>
                            <input type="number" min="0" name="" class="form-control border-input" id="t3ib1" onblur="arch(<?php echo $this->uri->segment(3); ?>);" value="<?php echo $data['houses_nmf']; ?>" <?php if($data['submit']==1 || $aUsr['role']==MODERATOR_ROLE || $aUsr['role']==ADMIN_ROLE) echo 'readonly';?>/><br />
                          </div>
                          <div class="col-md-6" style="margin-top: 27px;">
                            <label>3.4.3.2 Total number of accommodation</label>
                            <input type="number" min="0" name="" class="form-control border-input" id="t3ib2" onblur="arch(<?php echo $this->uri->segment(3); ?>);" value="<?php echo $data['total_accomodation']; ?>" <?php if($data['submit']==1 || $aUsr['role']==MODERATOR_ROLE || $aUsr['role']==ADMIN_ROLE) echo 'readonly';?>/><br />
                          </div>
                        </div>
                        <div class="col-md-12">
                          <div class="col-md-6">
                            <label>3.4.4 Two bathrooms for housing (except for studios and one bedroom apartments)</label>
                            <select class="form-control border-input" id="t3sb8" onchange="arch(<?php echo $this->uri->segment(3); ?>);" <?php if($data['submit']==1 || $aUsr['role']==MODERATOR_ROLE || $aUsr['role']==ADMIN_ROLE) echo 'disabled'; ?>>
                              <option value="0">Select</option>
                              <?php foreach($yea as $key => $value){ ?>
                                <option value="<?php echo $key; ?>" <?php if($data['two_bathrooms']==$key) echo 'selected'; ?>><?php echo $value; ?></option>
                              <?php } ?>
                            </select><br />

                          </div>
                          <div class="col-md-6 marg">
                            <label>3.4.5 Variety finishes and possibility choice</label>
                            <select class="form-control border-input" id="t3sb9" onchange="arch(<?php echo $this->uri->segment(3); ?>);" <?php if($data['submit']==1 || $aUsr['role']==MODERATOR_ROLE || $aUsr['role']==ADMIN_ROLE) echo 'disabled'; ?>>
                              <option value="0">Select</option>
                              <?php foreach($yea as $key => $value){ ?>
                                <option value="<?php echo $key; ?>" <?php if($data['variety_finishes']==$key) echo 'selected'; ?>><?php echo $value; ?></option>
                              <?php } ?>
                            </select><br />

                          </div>
                        </div>
                        <div class="clearfix">

                        </div>
                        <?php if ($aUsr['role']==MODERATOR_ROLE || $aUsr['role']==ADMIN_ROLE): ?>
                          <div class="col-md-2">
                            <label>Score</label>
                            <input type="text" min="0" name="" class="form-control border-input" id="score8"  readonly value="<?php echo $data['score34']; ?>"/><br />
                          </div>
                        <?php endif; ?>
                      </div>
                      <div class="col-md-12">
                        <h5>3.5 Lodging Types</h5>
                        <div class="col-md-4">
                          <label>3.5.1 At least 15% of three housing types (in terms of SLP)</label>
                          <select class="form-control border-input marg" id="t3sb10" onchange="arch(<?php echo $this->uri->segment(3); ?>);" <?php if($data['submit']==1 || $aUsr['role']==MODERATOR_ROLE || $aUsr['role']==ADMIN_ROLE) echo 'disabled'; ?>>
                            <option value="0">Select</option>
                            <?php foreach($yea as $key => $value){ ?>
                              <option value="<?php echo $key; ?>" <?php if($data['three_housing']==$key) echo 'selected'; ?>><?php echo $value; ?></option>
                            <?php } ?>
                          </select><br />

                        </div>
                        <div class="col-md-4">
                          <label>3.5.2 Variety offer typological (studio apartments, coresidenze, etc)</label>
                          <select class="form-control border-input marg" id="t3sb11" onchange="arch(<?php echo $this->uri->segment(3); ?>);" <?php if($data['submit']==1 || $aUsr['role']==MODERATOR_ROLE || $aUsr['role']==ADMIN_ROLE) echo 'disabled'; ?>>
                            <option value="0">Select</option>
                            <?php foreach($yea as $key => $value){ ?>
                              <option value="<?php echo $key; ?>" <?php if($data['offer_typological']==$key) echo 'selected'; ?>><?php echo $value; ?></option>
                            <?php } ?>
                          </select><br />

                        </div>
                        <div class="col-md-4">
                          <label>3.5.3 Differentiation distributive accommodation same type (eg. Studios with different plants)</label>
                          <select class="form-control border-input" id="t3sb12" onchange="arch(<?php echo $this->uri->segment(3); ?>);" <?php if($data['submit']==1 || $aUsr['role']==MODERATOR_ROLE || $aUsr['role']==ADMIN_ROLE) echo 'disabled'; ?>>
                            <option value="0">Select</option>
                            <?php foreach($yea as $key => $value){ ?>
                              <option value="<?php echo $key; ?>" <?php if($data['distributive_accomo']==$key) echo 'selected'; ?>><?php echo $value; ?></option>
                            <?php } ?>
                          </select><br /><br />

                        </div>
                        <div class="clearfix">

                        </div>
                        <?php if ($aUsr['role']==MODERATOR_ROLE || $aUsr['role']==ADMIN_ROLE): ?>
                          <div class="col-md-2">
                            <label>Score</label>
                            <input type="text" min="0" name="" class="form-control border-input" id="score9"  readonly value="<?php echo $data['score35']; ?>"/><br />
                          </div>
                        <?php endif; ?>
                      </div>
                      <div class="col-md-4">
                        <label>Total Score</label>
                        <input type="text" min="0" class="form-control border-input" id="t3sc" readonly value="<?php echo $data['score3']; ?>"/><br /><br />
                      </div>

                      <button class="btn btn-info btn-fill butt" onclick="openCity(event, 'tab4');$('#housing').addClass('active');" style="margin-top: 28px;" id="con3">Continue</button>
                      <button class="btn btn-info btn-fill butt" onclick="openCity(event, 'tab2');$('#background').addClass('active');" style="margin-top: 28px;" id="prev3">Previous</button>
                     </div>
                   </div>
                   <div id="tab4" class="tabcontent">
                     <div class="col-md-12">
                       <h4>4. Housing Offer</h4>
                       <h5>4.1 Mix Residential</h5>
                       <label>a. Composition of the enjoyment title</label><br />
                       <div class="col-md-2">
                         <label>SV rent in social housing</label>
                         <input type="number" min="0" name="" class="form-control border-input" id="t4ip1" onblur="housing(<?php echo $this->uri->segment(3); ?>);" value="<?php echo $data['social_housing']; ?>" <?php if($data['submit']==1 || $aUsr['role']==MODERATOR_ROLE || $aUsr['role']==ADMIN_ROLE) echo 'readonly';?>/><br />
                       </div>
                       <div class="col-md-2">
                         <label>SV-fee rental calmed 1</label>
                         <input type="number" min="0" name="" class="form-control border-input" id="t4ip2" onblur="housing(<?php echo $this->uri->segment(3); ?>);" value="<?php echo $data['rental_calmed']; ?>" <?php if($data['submit']==1 || $aUsr['role']==MODERATOR_ROLE || $aUsr['role']==ADMIN_ROLE) echo 'readonly';?>/><br />
                       </div>
                       <div class="col-md-2">
                         <label>SV rent,rent-regulated 2</label>
                         <input type="number" min="0" name="" class="form-control border-input" id="t4ip3" onblur="housing(<?php echo $this->uri->segment(3); ?>);" value="<?php echo $data['ren_regulated']; ?>" <?php if($data['submit']==1 || $aUsr['role']==MODERATOR_ROLE || $aUsr['role']==ADMIN_ROLE) echo 'readonly';?>/><br />
                       </div>
                       <div class="col-md-2">
                         <label>SV Futura Sale Pact</label>
                         <input type="number" min="0" name="" class="form-control border-input" id="t4ip4" onblur="housing(<?php echo $this->uri->segment(3); ?>);" value="<?php echo $data['futura_sale_pact']; ?>" <?php if($data['submit']==1 || $aUsr['role']==MODERATOR_ROLE || $aUsr['role']==ADMIN_ROLE) echo 'readonly';?>/><br />
                       </div>
                       <div class="col-md-2">
                         <label>SV agreement sale</label>
                         <input type="number" min="0" name="" class="form-control border-input marg" id="t4ip5" onblur="housing(<?php echo $this->uri->segment(3); ?>);" value="<?php echo $data['agreement_sale']; ?>" <?php if($data['submit']==1 || $aUsr['role']==MODERATOR_ROLE || $aUsr['role']==ADMIN_ROLE) echo 'readonly';?>/><br />
                       </div>
                       <div class="col-md-2">
                         <label>SV open sale</label>
                         <input type="number" min="0" name="" class="form-control border-input marg" id="t4ip6" onblur="housing(<?php echo $this->uri->segment(3); ?>);" value="<?php echo $data['open_sale']; ?>" <?php if($data['submit']==1 || $aUsr['role']==MODERATOR_ROLE || $aUsr['role']==ADMIN_ROLE) echo 'readonly';?>/><br /><br />
                       </div>
                     </div>
                       <label>b. Evaluation of the residential and affordability mix</label><br />
                       <div class="col-md-4">
                         <label>Value of social rent per sqm</label>
                         <input type="number" min="0" name="" class="form-control border-input" id="t4ip7" onblur="housing(<?php echo $this->uri->segment(3); ?>);" value="<?php echo $data['social_rent']; ?>" <?php if($data['submit']==1 || $aUsr['role']==MODERATOR_ROLE || $aUsr['role']==ADMIN_ROLE) echo 'readonly';?>/><br />
                       </div>
                       <div class="col-md-4">
                         <label>Fee value calmed 1 per sq.m.</label>
                         <input type="number" min="0" name="" class="form-control border-input" id="t4ip8" onblur="housing(<?php echo $this->uri->segment(3); ?>);" value="<?php echo $data['fv_calmed_1']; ?>" <?php if($data['submit']==1 || $aUsr['role']==MODERATOR_ROLE || $aUsr['role']==ADMIN_ROLE) echo 'readonly';?>/><br />
                       </div>
                       <div class="col-md-4">
                         <label>Fee value calmed 2 per sq.m.</label>
                         <input type="number" min="0" name="" class="form-control border-input" id="t4ip9" onblur="housing(<?php echo $this->uri->segment(3); ?>);" value="<?php echo $data['fv_calmed_2']; ?>" <?php if($data['submit']==1 || $aUsr['role']==MODERATOR_ROLE || $aUsr['role']==ADMIN_ROLE) echo 'readonly';?>/><br />
                       </div>
                       <div class="col-md-4">
                         <label>Average rent OMI - State like</label>
                         <input type="number" min="0" name="" class="form-control border-input" id="t4ip10" onblur="housing(<?php echo $this->uri->segment(3); ?>);" value="<?php echo $data['rent_OMI']; ?>" <?php if($data['submit']==1 || $aUsr['role']==MODERATOR_ROLE || $aUsr['role']==ADMIN_ROLE) echo 'readonly';?>/><br />
                       </div>
                       <div class="col-md-4">
                         <label>Price Pact Futura Sales per square meter</label>
                         <input type="number" min="0" name="" class="form-control border-input" id="t4ip11" onblur="housing(<?php echo $this->uri->segment(3); ?>);" value="<?php echo $data['price_pact_futura_sale']; ?>" <?php if($data['submit']==1 || $aUsr['role']==MODERATOR_ROLE || $aUsr['role']==ADMIN_ROLE) echo 'readonly';?>/><br />
                       </div>
                       <div class="col-md-4">
                         <label>% Capital share PFV</label>
                         <input type="number" min="0" name="" class="form-control border-input" id="t4ip12" onblur="housing(<?php echo $this->uri->segment(3); ?>);" value="<?php echo $data['capital_share']; ?>" <?php if($data['submit']==1 || $aUsr['role']==MODERATOR_ROLE || $aUsr['role']==ADMIN_ROLE) echo 'readonly';?>/><br />
                       </div>
                       <div class="col-md-4">
                         <label>Price per square meter sales agreement</label>
                         <input type="number" min="0" name="" class="form-control border-input" id="t4ip13" onblur="housing(<?php echo $this->uri->segment(3); ?>);" value="<?php echo $data['sales_agreement']; ?>" <?php if($data['submit']==1 || $aUsr['role']==MODERATOR_ROLE || $aUsr['role']==ADMIN_ROLE) echo 'readonly';?>/><br />
                       </div>
                       <div class="col-md-4">
                         <label>Free sale price per square meter</label>
                         <input type="number" min="0" name="" class="form-control border-input" id="t4ip14" onblur="housing(<?php echo $this->uri->segment(3); ?>);" value="<?php echo $data['sale_price']; ?>" <?php if($data['submit']==1 || $aUsr['role']==MODERATOR_ROLE || $aUsr['role']==ADMIN_ROLE) echo 'readonly';?>/><br />
                       </div>
                       <div class="col-md-4">
                         <label>Average Sales Value OMI - State like</label>
                         <input type="number" min="0" name="" class="form-control border-input" id="t4ip15" onblur="housing(<?php echo $this->uri->segment(3); ?>);" value="<?php echo $data['sales_value_OMI']; ?>" <?php if($data['submit']==1 || $aUsr['role']==MODERATOR_ROLE || $aUsr['role']==ADMIN_ROLE) echo 'readonly';?>/><br /><br />
                       </div>
                       <div class="clearfix">

                       </div>
                       <?php if ($aUsr['role']==MODERATOR_ROLE || $aUsr['role']==ADMIN_ROLE): ?>
                         <div class="col-md-2">
                           <label>Score</label>
                           <input type="text" min="0" name="" class="form-control border-input" id="score17"  readonly value="<?php echo $data['score4']; ?>"/><br />
                         </div>
                       <?php endif; ?>
                       <div class="clearfix"></div>
                       <div class="col-md-4">
                         <label>Total Score</label>
                         <input type="text" min="0" class="form-control border-input" id="t4sc" readonly value="<?php echo $data['score4']; ?>" /><br /><br />
                       </div>
                       <button class="btn btn-fill btn-info butt" type="button" onclick="openCity(event, 'tab5');$('#functional').addClass('active');" style="margin-top: 28px;" id="con4">Continue</button><br />
                       <button class="btn btn-fill btn-info butt" type="button" onclick="openCity(event, 'tab3');$('#quality').addClass('active');" style="margin-top: 8px;" id="prev4">Previous</button><br />
                     </div>
                   </div>
                   <div id="tab5" class="tabcontent">
                     <div class="col-md-12">
                      <h4>5. Social and functional Mix </h4>
                      <h5>5.1 Mix typological residential services</h5>
                      <div class="col-md-4">
                        <label>5.1.1 Accommodations first / second / third reception</label>
                        <select class="form-control border-input" id="t5sb1" onchange="soci(<?php echo $this->uri->segment(3); ?>);" <?php if($data['submit']==1 || $aUsr['role']==MODERATOR_ROLE || $aUsr['role']==ADMIN_ROLE) echo 'disabled'; ?>>
                          <option value="">Select</option>
                          <?php foreach($yea as $key => $value){ ?>
                            <option value="<?php echo $key; ?>" <?php if($data['reception']==$key) echo 'selected'; ?>><?php echo $value; ?></option>
                          <?php } ?>
                        </select><br />

                      </div>
                      <div class="col-md-4">
                        <label>5.1.2 Temporary Accommodation</label>
                        <select class="form-control border-input marg" id="t5sb2" onchange="soci(<?php echo $this->uri->segment(3); ?>);" <?php if($data['submit']==1 || $aUsr['role']==MODERATOR_ROLE || $aUsr['role']==ADMIN_ROLE) echo 'disabled'; ?>>
                          <option value="">Select</option>
                          <?php foreach($yea as $key => $value){ ?>
                            <option value="<?php echo $key; ?>" <?php if($data['temp_accomodation']==$key) echo 'selected'; ?>><?php echo $value; ?></option>
                          <?php } ?>
                        </select><br />

                      </div>
                      <div class="col-md-4">
                        <label>5.1.3 Residential homes or accommodation for families opened reception</label>
                        <select class="form-control border-input" id="t5sb3" onchange="soci(<?php echo $this->uri->segment(3); ?>);" <?php if($data['submit']==1 || $aUsr['role']==MODERATOR_ROLE || $aUsr['role']==ADMIN_ROLE) echo 'disabled'; ?>>
                          <option value="">Select</option>
                          <?php foreach($yea as $key => $value){ ?>
                            <option value="<?php echo $key; ?>" <?php if($data['opened_reception']==$key) echo 'selected'; ?>><?php echo $value; ?></option>
                          <?php } ?>
                        </select><br />

                      </div>
                      <?php if ($aUsr['role']==MODERATOR_ROLE || $aUsr['role']==ADMIN_ROLE): ?>
                        <div class="col-md-2">
                          <label>Score</label>
                          <input type="text" min="0" name="" class="form-control border-input" id="score11" readonly value="<?php echo $data['score51']; ?>"/><br />
                        </div>
                      <?php endif; ?>
                      <div class="clearfix"></div>
                      <h5>5.2 Functional Mix * (over residential)</h5>
                      <div class="col-md-3">
                        <label>5.2.1 Supplementary Services Habitat Days</label>
                        <input type="number" min="0" value="0" class="form-control border-input" id="t5ip1"  onblur="soci(<?php echo $this->uri->segment(3); ?>);" value="<?php echo $data['habitat_days']; ?>" <?php if($data['submit']==1 || $aUsr['role']==MODERATOR_ROLE || $aUsr['role']==ADMIN_ROLE) echo 'readonly';?>/><br />
                      </div>
                      <div class="col-md-3">
                        <label>5.2.2 Local Urban Services </label>
                        <input type="number" min="0" value="0" class="form-control border-input marg"  id="t5ip2" onblur="soci(<?php echo $this->uri->segment(3); ?>);" value="<?php echo $data['local_urban_services']; ?>" <?php if($data['submit']==1 || $aUsr['role']==MODERATOR_ROLE || $aUsr['role']==ADMIN_ROLE) echo 'readonly';?>/><br />
                      </div>
                      <div class="col-md-3">
                        <label>5.2.3 Public services (schools, kindergarten)</label>
                        <input type="number" min="0" value="0" class="form-control border-input"  id="t5ip3" onblur="soci(<?php echo $this->uri->segment(3); ?>);" value="<?php echo $data['public_services']; ?>" <?php if($data['submit']==1 || $aUsr['role']==MODERATOR_ROLE || $aUsr['role']==ADMIN_ROLE) echo 'readonly';?>/><br />
                      </div>
                      <div class="col-md-3">
                        <label>5.2.4 Compatible Functions with Residence</label>
                        <input type="number" min="0" value="0" class="form-control border-input"  id="t5ip4" onblur="soci(<?php echo $this->uri->segment(3); ?>);" value="<?php echo $data['compatible_functions']; ?>" <?php if($data['submit']==1 || $aUsr['role']==MODERATOR_ROLE || $aUsr['role']==ADMIN_ROLE) echo 'readonly';?>/><br /><br />
                      </div>
                      <div class="clearfix"></div>
                      <?php if ($aUsr['role']==MODERATOR_ROLE || $aUsr['role']==ADMIN_ROLE): ?>
                        <div class="col-md-2">
                          <label>Score</label>
                          <input type="text" min="0" name="" class="form-control border-input" id="score12"  readonly value="<?php echo $data['score52']; ?>"/><br />
                        </div>
                      <?php endif; ?>
                      <div class="clearfix"></div>
                      <div class="col-md-4">
                        <label>Total Score</label>
                        <input type="text" min="0" class="form-control border-input" id="t5sc" readonly value="<?php echo $data['score5']; ?>"/><br /><br />
                      </div>
                      <button class="btn btn-info btn-fill butt " onclick="openCity(event, 'tab6');$('#social').addClass('active');" style="margin-top: 28px;" id="con5">Continue</button>
                      <button class="btn btn-info btn-fill butt " onclick="openCity(event, 'tab4');$('#housing').addClass('active');" style="margin-top: 28px;" id="prev5">Previous</button>
                      <!-- <button class="btn btn-info btn-fill butt " onclick="soci(<?php echo $this->uri->segment(3); ?>)" style="margin-top: 28px;">Save</button> -->

                     </div>
                   </div>
                   <div id="tab6" class="tabcontent">
                     <div class="col-md-12">
                       <h4>6. Project of social management</h4>
                       <h5>6.1 Social Management</h5>
                       <div class="col-md-6">
                         <label>6.1.1 Existence of a social management plan </label>
                         <select class="form-control border-input" id="t6sb1" onchange="project(<?php echo $this->uri->segment(3); ?>);" <?php if($data['submit']==1 || $aUsr['role']==MODERATOR_ROLE || $aUsr['role']==ADMIN_ROLE) echo 'disabled'; ?>>
                           <option value="0">Select</option>
                           <?php foreach($yea as $key => $value){ ?>
                             <option value="<?php echo $key; ?>" <?php if($data['social_management_plan']==$key) echo 'selected'; ?>><?php echo $value; ?></option>
                           <?php } ?>
                         </select><br />

                       </div>
                       <div class="col-md-6">
                         <label>6.1.2 How transparent selection of the Manager</label>
                         <select class="form-control border-input" id="t6sb2" onchange="project(<?php echo $this->uri->segment(3); ?>);" <?php if($data['submit']==1 || $aUsr['role']==MODERATOR_ROLE || $aUsr['role']==ADMIN_ROLE) echo 'disabled'; ?>>
                           <option value="0">Select</option>
                           <?php foreach($yea as $key => $value){ ?>
                             <option value="<?php echo $key; ?>" <?php if($data['transparent_selection']==$key) echo 'selected'; ?>><?php echo $value; ?></option>
                           <?php } ?>
                         </select><br />

                       </div>
                       <div class="clearfix"></div>
                       <?php if ($aUsr['role']==MODERATOR_ROLE || $aUsr['role']==ADMIN_ROLE): ?>
                         <div class="col-md-2">
                           <label>Score</label>
                           <input type="text" min="0" name="" class="form-control border-input" id="score13" onblur="enviroment(<?php echo $this->uri->segment(3); ?>);" readonly value="<?php echo $data['score61']; ?>"/><br />
                         </div>
                       <?php endif; ?>
                       <div class="clearfix"></div>
                       <h5>6.2 Selecting tenants</h5>
                       <div class="col-md-3">
                         <label>6.2.1 Community Profile</label>
                         <select class="form-control border-input marg" id="t6sb3" onchange="project(<?php echo $this->uri->segment(3); ?>);" <?php if($data['submit']==1 || $aUsr['role']==MODERATOR_ROLE || $aUsr['role']==ADMIN_ROLE) echo 'disabled'; ?>>
                           <option value="0">Select</option>
                           <?php foreach($yea as $key => $value){ ?>
                             <option value="<?php echo $key; ?>" <?php if($data['community_profile']==$key) echo 'selected'; ?>><?php echo $value; ?></option>
                           <?php } ?>
                         </select><br />

                       </div>
                       <div class="col-md-3">
                         <label>6.2.2 Cognitive Talks</label>
                         <select class="form-control border-input marg" id="t6sb4" onchange="project(<?php echo $this->uri->segment(3); ?>);" <?php if($data['submit']==1 || $aUsr['role']==MODERATOR_ROLE || $aUsr['role']==ADMIN_ROLE) echo 'disabled'; ?>>
                           <option value="0">Select</option>
                           <?php foreach($yea as $key => $value){ ?>
                             <option value="<?php echo $key; ?>" <?php if($data['cognitive_talks']==$key) echo 'selected'; ?>><?php echo $value; ?></option>
                           <?php } ?>
                         </select><br />

                       </div>
                       <div class="col-md-3">
                         <label>6.2.3 Informational meetings pre-entry</label>
                         <select class="form-control border-input" id="t6sb5" onchange="project(<?php echo $this->uri->segment(3); ?>);" <?php if($data['submit']==1 || $aUsr['role']==MODERATOR_ROLE || $aUsr['role']==ADMIN_ROLE) echo 'disabled'; ?>>
                           <option value="0">Select</option>
                           <?php foreach($yea as $key => $value){ ?>
                             <option value="<?php echo $key; ?>" <?php if($data['info_meetings']==$key) echo 'selected'; ?>><?php echo $value; ?></option>
                           <?php } ?>
                         </select><br />

                       </div>
                       <div class="col-md-3">
                         <label>6.2.4 Laboratories pre-input</label>
                         <select class="form-control border-input marg" id="t6sb6" onchange="project(<?php echo $this->uri->segment(3); ?>);" <?php if($data['submit']==1 || $aUsr['role']==MODERATOR_ROLE || $aUsr['role']==ADMIN_ROLE) echo 'disabled'; ?>>
                           <option value="0">Select</option>
                           <?php foreach($yea as $key => $value){ ?>
                             <option value="<?php echo $key; ?>" <?php if($data['laboratories']==$key) echo 'selected'; ?>><?php echo $value; ?></option>
                           <?php } ?>
                         </select><br /><br />

                       </div>
                       <div class="clearfix"></div>
                       <?php if ($aUsr['role']==MODERATOR_ROLE || $aUsr['role']==ADMIN_ROLE): ?>
                         <div class="col-md-2">
                           <label>Score</label>
                           <input type="text" min="0" name="" class="form-control border-input" id="score14" onblur="enviroment(<?php echo $this->uri->segment(3); ?>);" readonly value="<?php echo $data['score62']; ?>"/><br />
                         </div>
                       <?php endif; ?>
                       <div class="clearfix"></div>
                       <h5>6.3 Tenants' involvement in pre-phase input</h5>
                       <div class="col-md-6">
                         <label>6.3.1 Ongoing housing variants when selling</label>
                         <select class="form-control border-input" name="" id="t6sb7" onchange="project(<?php echo $this->uri->segment(3); ?>);" <?php if($data['submit']==1 || $aUsr['role']==MODERATOR_ROLE || $aUsr['role']==ADMIN_ROLE) echo 'disabled'; ?>>
                           <option value="0">Select</option>
                           <?php foreach($yea as $key => $value){ ?>
                             <option value="<?php echo $key; ?>" <?php if($data['housing_variants']==$key) echo 'selected'; ?>><?php echo $value; ?></option>
                           <?php } ?>
                         </select><br />

                       </div>
                       <div class="clearfix"></div>
                       <?php if ($aUsr['role']==MODERATOR_ROLE || $aUsr['role']==ADMIN_ROLE): ?>
                         <div class="col-md-2">
                           <label>Score</label>
                           <input type="text" min="0" name="" class="form-control border-input" id="score15" onblur="enviroment(<?php echo $this->uri->segment(3); ?>);" readonly value="<?php echo $data['score63']; ?>"/><br />
                         </div>
                       <?php endif; ?>
                       <div class="clearfix"></div>
                       <h5>6.4 Paths of self-management</h5>
                       <div class="col-md-4">
                         <label>6.4.1 Space management (excluding green areas)</label>
                         <select class="form-control border-input" name="" id="t6sb8" onchange="project(<?php echo $this->uri->segment(3); ?>);" <?php if($data['submit']==1 || $aUsr['role']==MODERATOR_ROLE || $aUsr['role']==ADMIN_ROLE) echo 'disabled'; ?>>
                           <option value="0">Select</option>
                           <?php foreach($yea as $key => $value){ ?>
                             <option value="<?php echo $key; ?>" <?php if($data['space_management']==$key) echo 'selected'; ?>><?php echo $value; ?></option>
                           <?php } ?>
                         </select><br />

                       </div>
                       <div class="col-md-4">
                         <label>6.4.2 Creating organs and representation rules</label>
                         <select class="form-control border-input" name="" id="t6sb9" onchange="project(<?php echo $this->uri->segment(3); ?>);" <?php if($data['submit']==1 || $aUsr['role']==MODERATOR_ROLE || $aUsr['role']==ADMIN_ROLE) echo 'disabled'; ?>>
                           <option value="0">Select</option>
                           <?php foreach($yea as $key => $value){ ?>
                             <option value="<?php echo $key; ?>" <?php if($data['representation_rules']==$key) echo 'selected'; ?>><?php echo $value; ?></option>
                           <?php } ?>
                         </select><br />

                       </div>
                       <div class="col-md-4">
                         <label>6.4.3 Tenants training </label>
                         <select class="form-control border-input marg" name="" id="t6sb10" onchange="project(<?php echo $this->uri->segment(3); ?>);" <?php if($data['submit']==1 || $aUsr['role']==MODERATOR_ROLE || $aUsr['role']==ADMIN_ROLE) echo 'disabled'; ?>>
                           <option value="0">Select</option>
                           <?php foreach($yea as $key => $value){ ?>
                             <option value="<?php echo $key; ?>" <?php if($data['tenants_training']==$key) echo 'selected'; ?>><?php echo $value; ?></option>
                           <?php } ?>
                         </select><br /><br />

                       </div>
                       <div class="clearfix"></div>
                       <?php if ($aUsr['role']==MODERATOR_ROLE || $aUsr['role']==ADMIN_ROLE): ?>
                         <div class="col-md-2">
                           <label>Score</label>
                           <input type="text" min="0" name="" class="form-control border-input" id="score16" readonly value="<?php echo $data['score64']; ?>"/><br />
                         </div>
                       <?php endif; ?>
                       <div class="clearfix"></div>
                       <div class="col-md-4">
                         <label>Total Score</label>
                         <input type="text" min="0" class="form-control border-input" id="t6sc" readonly value="<?php echo $data['score6']; ?>"/><br /><br />
                       </div>
                       <?php if ($aUsr['role']!=MODERATOR_ROLE && $aUsr['role']!=ADMIN_ROLE): ?>
                         <a class="btn btn-fill btn-info butt" style="margin-top: 30px;" onclick="return confirm('Are you sure ?');" href="<?php echo base_url('griglia/submit/').$data['id']; ?>">Save & Submit</a><br />
                         <a class="btn btn-fill btn-info butt" style="margin-top: 10px;" onclick="project(<?php echo $this->uri->segment(3); ?>);">Save</a><br />
                       <?php endif; ?>
                     </div>
                   </div>
                 <?php } else{?>
                   <div class="col-md-12">&nbsp;</div>
                   <div class="col-md-12">
                     <div class="col-md-4">
                       Select a Project to make/edit entries!!
                     </div>
                   </div>
                 <?php } ?>
                 </div>
               <!-- </form> -->
               <div class="clearfix">&nbsp;</div>
               <div class="clearfix">&nbsp;</div>

           </div>
         <!-- </div> -->
       </div>
    </div>
