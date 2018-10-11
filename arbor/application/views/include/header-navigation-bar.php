<!-- navigation -->

	<div class="navigation-agileits">
		<div class="container">
			<div class="col-md-11 col-md-offset-1">
				<nav class="navbar navbar-default">
					<!-- Brand and toggle get grouped for better mobile display -->
					<div class="navbar-header nav_2">
						<button type="button" class="navbar-toggle collapsed navbar-toggle1" data-toggle="collapse" data-target="#bs-megadropdown-tabs">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
					</div> 

					<div class="collapse navbar-collapse" id="bs-megadropdown-tabs">
						<ul class="nav navbar-nav">
							<li class="<?php if(isset($strPageTitle) && $strPageTitle=="Home") { echo "active"; } ?>">
								<a href="<?= base_url(); ?>" class="act">Home</a>
							</li>
							
							<li class="<?php if(isset($strPageTitle) && $strPageTitle=="About") { echo "active"; } ?>"><a href="<?= base_url('about'); ?>">About</a>
							</li>	
							<li class="<?php if(isset($strPageTitle) && $strPageTitle=="search") { echo "active"; } ?>"><a href="<?= base_url('search'); ?>">shop</a>
							</li>						
							<li class="<?php if(isset($strPageTitle) && $strPageTitle=="Contact") { echo "active"; } ?>"><a href="<?= base_url('contact'); ?>">Contact</a></li>		
							<!-- Mega Menu -->
							

						<!--<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">Groceries<b class="caret"></b></a>
								<ul class="dropdown-menu multi-column columns-3">
									<div class="row">
										<div class="multi-gd-img">
											<ul class="multi-column-dropdown">
												<h6>All Groceries</h6>
												<li><a href="groceries.html">Dals & Pulses</a></li>
												<li><a href="groceries.html">Almonds</a></li>
												<li><a href="groceries.html">Cashews</a></li>
												<li><a href="groceries.html">Dry Fruit</a></li>
												<li><a href="groceries.html"> Mukhwas </a></li>
												<li><a href="groceries.html">Rice & Rice Products</a></li>
											</ul>
										</div>	
										
									</div>
								</ul>
							</li>-->



						</ul>
					</div>
				</nav>
			</div>
		</div>
	</div>
	
<!-- //navigation -->
