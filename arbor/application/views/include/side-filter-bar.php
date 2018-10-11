
<style type="text/css">
	.ps-search-h3 {
		font-size: 1.2em;
		color: rgb(254,145,38);
		text-transform: uppercase;
		margin-bottom: 1em;
		font-family: "Times New Roman", Times, serif;
	}
	.nav .cate {
		
		padding: 0.5em;
	    margin-left: 12px;

	}
</style>
<div class="col-md-3 products-left">
	<div class="sidebar">
		<div class="side">
			<div class="range">
				<p class="ps-search-h3">Price range</p>
				<hr>
				<form id="rangeform" method="post">
				<ul class="dropdown-menu6">					
					<li>
						<div id="slider-range"></div>
						<input type="text" id="amount" style="border: 0; color: #ffffff; font-weight: normal;"/>
					</li>					
				</ul>

				<input type="button" id="filter_range" name="filter_range" class="range-btn" value="Filter" >
				</form>
			</div>
		</div>
	</div>	



    <!-- category -->
	<div class="categories">
		<p class="ps-search-h3" style="margin-top: 1.3em;margin-left: 1.2em;margin-bottom: 1em;">Categories</p>
		<hr  style="width: 82%;">
	
	
		<nav>
		    <ul class="nav cate">
		    	<?php 
					if (0<count($categorydata)) {

						foreach ($categorydata as $categoryresults) 
						{
							$strclass='class="cat-cls"';
							if ($this->session->userdata('filtercategory')==$categoryresults["slug"]) {
								$strclass='class="cat-cls active"';
							}
							
							echo '<li><a href="javascript:void(0)"  onclick="filterbycat(\''.$categoryresults["slug"].'\',$(this) )" '.$strclass.' >'.$categoryresults["name"].'</a></li>';
						}
					}
				?>	
		      		   	
		  	</ul>
		</nav>
		

		
		<!--<nav>
		    <ul class="nav cate">
		      	<li><a href="javascript:void(0)">Link 1</a></li>
		   		<li><a href="javascript:void(0)" id="btn-1" data-toggle="collapse" data-target="#submenu1" aria-expanded="false">Link 2 (toggle) <i class="fa fa-plus" aria-hidden="true"></i></a>
		          	<ul class="nav collapse" id="submenu1" role="menu" aria-labelledby="btn-1">
			        	<li><a href="javascript:void(0)">Link 2.1</a></li>
			        	<li><a href="javascript:void(0)">Link 2.2</a></li>
			        	<li><a href="javascript:void(0)">Link 2.3</a></li>
			      	</ul>
		   		</li>

		   		<li><a href="javascript:void(0)" id="btn-1" data-toggle="collapse" data-target="#submenu2" aria-expanded="false">Link 2.6 (toggle) <i class="fa fa-plus" aria-hidden="true"></i></a>
		          	<ul class="nav collapse" id="submenu2" role="menu" aria-labelledby="btn-1">
			        	<li><a href="javascript:void(0)">Link 2.7</a></li>
			        	<li><a href="javascript:void(0)">Link 2.8</a></li>
			        	<li><a href="javascript:void(0)">Link 2.9</a></li>
			      	</ul>
		   		</li>

		    	<li><a href="javascript:void(0)">Link 3</a></li>
		    	<li><a href="javascript:void(0)">Link 4</a></li>
		  	</ul>
		</nav>-->

	</div>																																												

<br />

		<div class="sidebar">
			<div class="side">
				<p class="ps-search-h3">Size</p>
				<hr/>
				<div class="size-wrap">
					<p class="size-desc">
						<?php 
							if (0<count($rowsizedata)) {

								foreach ($rowsizedata as $resultsizedata) 
								{
									$strSeleted='';
									if ($this->session->userdata('filtersize') && $this->session->userdata('filtersize')== $resultsizedata['id'] ) {

										$strSeleted='selected="selected"';
									}
									
									echo '<a href="javascript:void(0)" onclick="filterbysize('.$resultsizedata['id'].',$(this) )" class="size size-1"><span>'. $resultsizedata['name'] .'</span></a>';
								}

							}

						?>	
						
					</p>
				</div>
			</div>
		</div>

	


		<div class="related-row">
			<p class="ps-search-h3">Style</p>

			<hr/>
			<ul>
					<?php 
						if (0<count($rowstyledata)) {
							foreach ($rowstyledata as $resultstyledata) {
								
								$strSeleted='';
								if ($this->session->userdata('filterstyle') && $this->session->userdata('filterstyle') == $resultstyledata['id'] )
								{
									$strSeleted='selected="selected"';
								}

								echo '<li><a href="javascript:void(0)" onclick="filterbystyle('.$resultstyledata['id'].',$(this) )" class="style-cls" >'.$resultstyledata['name'].'</a></li>';
							}
						}
					?>		
				
			</ul>
		</div>



	</div>

	

	

<script type="text/javascript">


	function filterbycat(slug , obj) {
		$(".cat-cls").removeClass('active');
		obj.addClass('active');

		
		var datastring='categoryslug='+slug;
		$.post("<?php echo base_url('ajax/filterbyattribute'); ?>",datastring ,function(response) {
			$("#product-div").html(response);
		});	

	}
	


	
	$("#filter_range").click(function(){
		
		var str = $("#amount").val();
		//var formdata = str.replace(/[^a-zA-Z0-9 ]/g,"")
		var formdata = str.split("-");

		var startrange = formdata[0].replace(/[^a-zA-Z0-9 ]/g,"");
		var endrange = formdata[1].replace(/[^a-zA-Z0-9 ]/g,"");
		var catslug = "<?php echo $this->session->userdata('filtercategory'); ?>";
		var datastring='startrange='+startrange.trim()+'&endrange='+endrange.trim()+'&catslug='+catslug;
		//alert(datastring);
		$.post("<?php echo base_url('ajax/filterbyattribute'); ?>",datastring ,function(response) {
			$("#product-div").html(response);
		});	


	});




	function filterbysize(id,obj) {

		$(".size-1").removeClass('active');
		obj.addClass('active');
		
		var catslug = "<?php echo $this->session->userdata('filtercategory'); ?>";
		var datastring='sizeId='+id+'&catslug='+catslug;
		$.post("<?php echo base_url('ajax/filterbyattribute'); ?>",datastring ,function(response) {
			$("#product-div").html(response);
		});	

	}
	

	function filterbystyle(id, obj) {
		
		$(".style-cls").removeClass('active');
		obj.addClass('active');

		var catslug = "<?php echo $this->session->userdata('filtercategory'); ?>";
		var datastring='styleId='+id+'&catslug='+catslug;
		$.post("<?php echo base_url('ajax/filterbyattribute'); ?>",datastring ,function(response) {
			$("#product-div").html(response);
		});	

	}


	function filterbycode(obj) {

		var catslug = "<?php echo $this->session->userdata('filtercategory'); ?>";
		var datastring='codeId='+obj.val()+'&catslug='+catslug;
		$.post("<?php echo base_url('ajax/filterbyattribute'); ?>",datastring ,function(response) {
			$("#product-div").html(response);
		});	

	}

	function filterbyprice(val,obj) {

		var catslug = "<?php echo $this->session->userdata('filtercategory'); ?>";
		var datastring='filterprice='+val+'&catslug='+catslug;
		//alert(datastring);
		$.post("<?php echo base_url('ajax/filterbyattribute'); ?>",datastring ,function(response) {
			$("#product-div").html(response);
			$(".ps-sort-list li a").removeClass('active');
			obj.addClass('active');

		});	
	}


</script>