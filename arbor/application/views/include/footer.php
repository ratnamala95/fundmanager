<!-- //footer -->
<div class="footer">
		<div class="container">
			<div class="w3_footer_grids">
				<div class="col-md-4 w3_footer_grid">
					<h3>Contact</h3>
					
					<ul class="address">
						<li><i class="glyphicon glyphicon-map-marker" aria-hidden="true"></i>113 Kings Tower, Nirman Nagar, <span>Jaipur, Rajasthan.</span></li>
						<li><i class="glyphicon glyphicon-envelope" aria-hidden="true"></i><a href="mailto:info@example.com">info@example.com</a></li>
						<li><i class="glyphicon glyphicon-earphone" aria-hidden="true"></i>+91 75973 33337</li>
					</ul>
				</div>


				<div class="col-md-4 w3_footer_grid">
					<h3>Information</h3>
					<ul class="info"> 
						<li><i class="fa fa-arrow-right" aria-hidden="true"></i><a href="<?= base_url('search'); ?>"> Shop</a></li>
						<li><i class="fa fa-arrow-right" aria-hidden="true"></i><a href="<?= base_url('about'); ?>">About Us</a></li>
						<li><i class="fa fa-arrow-right" aria-hidden="true"></i><a href="<?= base_url('contact'); ?>">Contact Us</a></li>
						<li><i class="fa fa-arrow-right" aria-hidden="true"></i><a href="<?= base_url('user/login'); ?>">Login</a></li>
						<li><i class="fa fa-arrow-right" aria-hidden="true"></i><a href="<?= base_url('user/register'); ?>">Create Account</a></li>						
						
					</ul>
				</div>
				
							
				<div class="col-md-4 w3layouts-foot">
					
					<ul>
						<li><a href="#" class="w3_agile_facebook"><i class="fa fa-facebook" aria-hidden="true" style="margin-top: 6px;"></i></a></li>
						<li><a href="#" class="agile_twitter"><i class="fa fa-twitter" aria-hidden="true" style="margin-top: 6px;"></i></a></li>
						<li><a href="#" class="w3_agile_dribble"><i class="fa fa-dribbble" aria-hidden="true" style="margin-top: 6px;"></i></a></li>
						<li><a href="#" class="w3_agile_vimeo"><i class="fa fa-vimeo" aria-hidden="true" style="margin-top: 6px;"></i></a></li>
					</ul>
				</div>


				<div class="clearfix"> </div>
			</div>
		</div>
		
		<div class="footer-copy">
			
			<div class="container">
				<p>© 2018 <?php echo SITE_TITLE; ?>. All rights reserved | Design by <a href="">Web Planet soft </a></p>
			</div>
		</div>
		
<div id="dialog" title="Message">	
</div>	
	<!--<div class="footer-botm">
			<div class="container">
				<div class="w3layouts-foot">
					<ul>
						<li><a href="#" class="w3_agile_facebook"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
						<li><a href="#" class="agile_twitter"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
						<li><a href="#" class="w3_agile_dribble"><i class="fa fa-dribbble" aria-hidden="true"></i></a></li>
						<li><a href="#" class="w3_agile_vimeo"><i class="fa fa-vimeo" aria-hidden="true"></i></a></li>
					</ul>
				</div>
				<div class="payment-w3ls">	
					<img src=<?php echo base_url("assets/frontend/images/card.png");?> alt=" " class="img-responsive">
				</div>
				<div class="clearfix"> </div>
			</div>
		</div>-->
<!-- //footer -->	
<!-- Bootstrap Core JavaScript -->
<script src="<?= base_url('assets/frontend/js/bootstrap.min.js'); ?>"></script>

<!-- top-header and slider -->
<!-- here stars scrolling icon -->
	<script type="text/javascript">
		$(document).ready(function() {
			/*
				var defaults = {
				containerID: 'toTop', // fading element id
				containerHoverID: 'toTopHover', // fading element hover id
				scrollSpeed: 1200,
				easingType: 'linear' 
				};
			*/
								
			$().UItoTop({ easingType: 'easeOutQuart' });
								
			});
	</script>
<!-- //here ends scrolling icon -->

<!-- main slider-banner -->
<script src="<?= base_url('assets/frontend/js/skdslider.min.js'); ?>"></script>

<?= link_tag('assets/frontend/css/skdslider.css'); ?>

<script type="text/javascript">
		jQuery(document).ready(function(){
			jQuery('#demo1').skdslider({'delay':5000, 'animationSpeed': 2000,'showNextPrev':true,'showPlayButton':true,'autoSlide':true,'animationType':'fading'});
						
			jQuery('#responsive').change(function(){
			  $('#responsive_wrapper').width(jQuery(this).val());
			});
			
		});
</script>	
<!-- //main slider-banner --> 

<!-- Price range js -->
<!--<script src="http://code.jquery.com/jquery-1.7.2.min.js"></script>-->
<!--<script src="http://code.jquery.com/ui/1.8.21/jquery-ui.min.js"></script>-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js"></script>
<script type="text/javascript" src="<?php echo base_url('assets/frontend/js/jquery-ui.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/frontend/js/myscript.js'); ?>"></script>
<script>
	//<![CDATA[ 
	$(window).load(function () {
		$("#slider-range").slider({
			range: true,
			min: 0,
			max: 9000,
			values: [50, 6000],
			slide: function (event, ui) {
				$("#amount").val("₹" + ui.values[0] + " - ₹" + ui.values[1]);
			}
		});
		$("#amount").val("₹" + $("#slider-range").slider("values", 0) + " - ₹" + $("#slider-range").slider("values", 1));

	}); //]]>
</script>
</div>	
</body>
</html>