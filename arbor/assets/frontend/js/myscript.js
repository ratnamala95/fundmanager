
// header my account sub menu show hide
$(function(){
	$( ".myaccount" ).mouseover(function() {
		$(".ps-sub_menu").css("visibility","visible");
	 
	});

	$( ".myaccount" ).mouseout(function() {
		$(".ps-sub_menu").css("visibility","hidden");
	});
});




/* ==== only number allow ==== */

function isNumber(evt) {
    //alert(evt);

  	evt = (evt) ? evt : window.event;
  	var charCode = (evt.which) ? evt.which : evt.keyCode;
 	if (charCode > 31 && (charCode < 48 || charCode > 57 )) {
      return false;
  	}
  	return true;
}


/* ==== Billing information validation === */
function billingvalidation() {
		
		if ($("#billing_name").val()=='') 
		{
			
			$("#billing_name").css('border','1px solid #d9534f');			
			$("#billing_name").attr('placeholder','Please enter name');
			$("#billing_name").focus();
			return false;
		} else {
			$("#billing_name").css('border','');			
			$("#billing_name").attr('placeholder','');
			$("#billing_email").focus();
		}


		if ($("#billing_email").val()=='') 
		{
			
			$("#billing_email").css('border','1px solid #d9534f');			
			$("#billing_email").attr('placeholder','Please enter Email');
			$("#billing_email").focus();
			return false;
		} else {

			if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test($("#billing_email").val()))
			{
			   	$("#billing_email").css('border','');			
				$("#billing_email").attr('placeholder','');
				$("#billing_phone").focus();

			} else {

					
				$("#billing_email").css('border','1px solid #d9534f');			
				$("#billing_email").attr('placeholder','Please enter valid Email');
				$("#billing_email").val('');
				$("#billing_email").focus();
				return false;

			}
			
		}


		if ($("#billing_phone").val()=='') 
		{
			
			$("#billing_phone").css('border','1px solid #d9534f');			
			$("#billing_phone").attr('placeholder','Please enter Phone');
			$("#billing_phone").focus();
			return false;
		} else {
			var phone = $("#billing_phone").val();
		  	var phoneno = /^\d{10}$/;

		  	if(phone.match(phoneno))
	        {
	        	$("#billing_phone").css('border','');			
				$("#billing_phone").attr('placeholder','');
				$("#billing_city").focus();
				
	        } else {
	        	
	        	$("#billing_phone").css('border','1px solid #d9534f');			
				$("#billing_phone").attr('placeholder','Please enter valid phone no.');
				$("#billing_phone").val('');
				$("#billing_phone").focus();
				return false;	
	        }

		}


		if ($("#billing_city").val()=='') 
		{
			
			$("#billing_city").css('border','1px solid #d9534f');			
			$("#billing_city").focus();
			return false;
		} else {
			$("#billing_city").css('border','');			
			$("#billing_address").focus();
		}


		if ($("#billing_address").val()=='') 
		{
			
			$("#billing_address").css('border','1px solid #d9534f');			
			$("#billing_address").attr('placeholder','Please enter address');
			$("#billing_address").focus();
			return false;
		} else {
			$("#billing_address").css('border','');			
			$("#billing_address").attr('placeholder','');
			$("#billing_postcode").focus();
		}


		if ($("#billing_postcode").val()=='') 
		{
			
			$("#billing_postcode").css('border','1px solid #d9534f');			
			$("#billing_postcode").attr('placeholder','Please enter postcode');
			$("#billing_postcode").focus();
			return false;
		} else {
			//alert("welcome");
			//$("#paymentnow").trigger('click');
			$("#payment-form").submit();
			return true;
		}

		$("#payment-form").submit();
		
	}



           
/* === quantity check in product details page ==== */

function checkproductquantitytext(productId,productSize,obj,qtyboxNo) {

		var qty = obj.val();
		var datastring = 'proId='+productId+'&proSize='+productSize+'&qty='+qty;
		//alert(datastring);
		$.post(baseUrl+"cart/checkquantityavailable", datastring , function( response ) {

				var results = jQuery.parseJSON(response);
			    if (results.status === 1 ) {	               	
					                 
	                $('.qty-box-'+qtyboxNo).css("border",'');		   
	               	$('.qty-box-'+qtyboxNo).attr("title","Quantity updated successfully");
	               
	            	
	            } else if (results.status === 0 ) {
	            	obj.val(results.totalqtyavailable);
	            	$('.qty-box-'+qtyboxNo).css("border",'1px solid red');
	            	$('.qty-box-'+qtyboxNo).attr("title","Quantity not available");
	                $( "#dialog" ).dialog().html('<p style="margin-top:-12px;">Quantity not available</p>');
	               
	            } 

		});	

	}


	function checkproductquantity(productId,productSize,obj,qtyboxNo) {

		//alert('qty-box-'+qtyboxNo)

		$('.plus'+qtyboxNo).click(function() {
			
			var qty = $(this).parent().parent().find('.quantity').val();
			var datastring = 'proId='+productId+'&proSize='+productSize+'&qty='+qty;
			//alert(qty);
			$.post(baseUrl+"cart/checkquantityavailable", datastring , function( response ) {
				
				var results = jQuery.parseJSON(response);
			    if (results.status === 1 ) {
	               	
					                 
	                $('.qty-box-'+qtyboxNo).css("border",'');		   
	               	$('.qty-box-'+qtyboxNo).attr("title","Quantity updated successfully");
	                
	            
	            } else if (results.status === 0 ) {
	            	obj.parent().parent().parent().find('.quantity').val(results.totalqtyavailable);
	            	$('.plus'+qtyboxNo).attr('disabled','disabled');
	            	$('.qty-box-'+qtyboxNo).css("border",'1px solid red');
	            	$('.qty-box-'+qtyboxNo).attr("title","Quantity not available");
	               	$( "#dialog" ).dialog().html('<p style="margin-top:-12px;">Quantity not available</p>');
	               
	            } 

			});	
		});


		$('.minus'+qtyboxNo).click(function() {
			
			var qty = $(this).parent().parent().find('.quantity').val();
			var datastring = 'proId='+productId+'&proSize='+productSize+'&qty='+qty;
			//alert(datastring);
			$.post(baseUrl+"cart/checkquantityavailable", datastring , function( response ) {
			
				var results = jQuery.parseJSON(response);
		        if (results.status === 1 ) {
	               	
	               	obj.parent().parent().parent().find(".plus"+qtyboxNo).removeAttr('disabled');
	                $('.qty-box-'+qtyboxNo).css("border",'');		    
	               	$('.qty-box-'+qtyboxNo).attr("title","Quantity updated successfully");
	                
	            
	            } else if (results.status === 0 ) {	                
	                
	                $('.qty-box-'+qtyboxNo).css("border",'1px solid red');    
	              	$('.qty-box-'+qtyboxNo).attr("title","Quantity not available");
	                $( "#dialog" ).dialog().html('<p style="margin-top:-12px;">Quantity not available</p>');
	               
	            } 
			});	
		});
	
		

	}


/* ==== Added in cart ==== */

function addtocart() {

	var qtyValue=0;

	$('.quantity').each(function() {
		
		qtyValue += ($(this).parent().parent().find(".quantity").val());

	});


	//alert(qtyValue);
	if (qtyValue>=1) 
   	{
   		var datastring = $("#cartform").serialize();
   		//alert(datastring);
	    $.post(baseUrl+"cart/addcart",datastring ,function(response) {

	    	var results = jQuery.parseJSON(response);
	    	if (results.errorstatus==1) {

	    		$( "#dialog" ).dialog().html('<p style="margin-top:-12px;">Quantity Not available</p>');

	    	} else {

	    		window.location.href = baseUrl+"cart/checkout";
	    	}
	        
	    });

   	} else {

   		//alert("select atleast one quantity");
   		$( "#dialog" ).dialog().html('<p style="margin-top:-12px;">Select atleast one quantity</p>');
   	}	
	    
}




 $(".btn-minus").on("click",function(){
      var now = $(".section > div > input").val();
      if ($.isNumeric(now)){
          if (parseInt(now) -1 > 0){ now--;}
          $(".section > div > input").val(now);
      }else{
          $(".section > div > input").val("1");
      }
  });            
  $(".btn-plus").on("click",function(){
      var now = $(".section > div > input").val();
      if ($.isNumeric(now)){
          $(".section > div > input").val(parseInt(now)+1);
      }else{
          $(".section > div > input").val("1");
      }
});  


$(document).ready(function(){

	var quantitiy=0;
	$('.quantity-right-plus').click(function(e){
	    
	    // Stop acting like a button
	    e.preventDefault();
	    // Get the field name
	          
	    var quantity = parseInt($(this).parent().parent().find(".quantity").val());
	    //var quantity = parseInt($('#quantity').val());
	    
	    // If is not undefined
	        
	        //$('#quantity').val(quantity + 1);
	       $(this).parent().parent().find(".quantity").val(quantity + 1)
	      
	        // Increment
	    
	});

	$('.quantity-left-minus').click(function(e){
	    // Stop acting like a button
	    e.preventDefault();
	    // Get the field name
	           
	    var quantity = parseInt($(this).parent().parent().find(".quantity").val());
	    
	    // If is not undefined
	  
	        // Increment
	        if(quantity>0){
	        $(this).parent().parent().find(".quantity").val(quantity - 1);
	        }
	});

});


function checkquantitytext(cartId,proId,proSize,obj,qtyboxNo) {


	var qty = obj.val();

	if (qty) {

		var datastring = 'cartId='+cartId+'&proId='+proId+'&proSize='+proSize+'&qty='+qty;
		//alert(datastring);
		$.post(baseUrl+"cart/updatecart", datastring , function(response) {
				var results = jQuery.parseJSON(response);
			    if (results.status === 1 ) {
			    	
			    	$(".total-price").html('<span class="fa fa-inr"></span> '+ results.totalprices );
			    	$(".total-gst").html('<span class="fa fa-inr"></span> '+ results.totalgstprice );
			    	obj.parent().parent().parent().parent().find(".gst-price").html('<span class="fa fa-inr"></span> '+ results.gstprice +' GST');
			    	obj.parent().parent().parent().parent().find(".price").html('<span class="fa fa-inr"></span> '+ results.price);
					$("#subtotalprice").replaceWith('<b id="subtotalprice">'+ results.subtotalprice +'</b>');                 
	                $('.qty-box-'+qtyboxNo).css("border",'');		   
	               	$('.qty-box-'+qtyboxNo).attr("title","Quantity updated successfully");
	               
	            	
	            } else if (results.status === 0 ) {
	            	obj.val(results.totalqtyavailable);
	            	$('.qty-box-'+qtyboxNo).css("border",'1px solid red');
	            	$('.qty-box-'+qtyboxNo).attr("title","Quantity not available");
	                $( "#dialog" ).dialog().html('<p style="margin-top:-12px;">Quantity not available</p>');
	               
	            } 

		});	
	}	

}




function checkquantity(cartId,proId,proSize,obj,divboxid) {

		$(".plus"+divboxid).click(function() {			

        	var qty = $(this).parent().parent().find('.quantity').val();
        	var datastring = 'cartId='+cartId+'&proId='+proId+'&proSize='+proSize+'&qty='+qty;
        	//alert(datastring);

        	$.post(baseUrl+"cart/updatecart", datastring , function(response) {
	            var results = jQuery.parseJSON( response );
	            if (results.status === 1 ) {

      				$(".total-price").html('<span class="fa fa-inr"></span> '+ results.totalprices );  	
	            	$(".total-gst").html('<span class="fa fa-inr"></span> '+ results.totalgstprice );
	               	obj.parent().parent().parent().parent().find(".gst-price").html('<span class="fa fa-inr"></span> '+ results.gstprice +' GST');
	               	obj.parent().parent().parent().parent().find(".price").html('<span class="fa fa-inr"></span> '+ results.price);
	                $("#subtotalprice").replaceWith('<b id="subtotalprice">'+ results.subtotalprice +'</b>');
	                obj.parent().parent().parent().find(".input-group").css("border",'1px solid green');    
	               	obj.parent().parent().parent().find(".input-group").attr("title","Quantity updated successfully");
	                
	            
	            } else if (results.status === 0 ) {

	                obj.parent().parent().find('.quantity').val(results.totalqtyavailable);
	                $(".plus"+divboxid).attr('disabled','disabled');	                
	                obj.parent().parent().parent().find(".input-group").css("border",'1px solid red');    
	              	obj.parent().parent().parent().find(".input-group").attr("title","Quantity not available");
	                $( "#dialog" ).dialog().html('<p style="margin-top:-12px;">Quantity not available</p>');
	               
	            } 

	        });

	    });


    $(".minus"+divboxid).click(function() {

    	var qty = $(this).parent().parent().find('.quantity').val();
        var datastring = 'cartId='+cartId+'&proId='+proId+'&proSize='+proSize+'&qty='+qty;
    	//alert(datastring);

    	$.post(baseUrl+"cart/updatecart", datastring , function(response) {

            var results = jQuery.parseJSON( response );
            if (results.status === 1 ) {

            	$(".plus"+divboxid).removeAttr('disabled');
            	$(".total-price").html('<span class="fa fa-inr"></span> '+ results.totalprices );
            	$(".total-gst").html('<span class="fa fa-inr"></span> '+ results.totalgstprice );
            	obj.parent().parent().parent().parent().find(".gst-price").html('<span class="fa fa-inr"></span> '+ results.gstprice +' GST');
               	obj.parent().parent().parent().parent().find(".price").html('<span class="fa fa-inr"></span> '+ results.price);
                $("#subtotalprice").replaceWith('<b id="subtotalprice">'+ results.subtotalprice +'</b>');
                obj.parent().parent().parent().find(".input-group").css("border",'1px solid green');    
               	obj.parent().parent().parent().find(".input-group").attr("title","Quantity updated successfully");
                
            
            } else if (results.status === 0 ) {
                
               	obj.parent().parent().parent().find(".input-group").css("border",'1px solid red');    
                obj.parent().parent().parent().find(".input-group").attr("title","Quantity not available");
                 $( "#dialog" ).dialog().html('<p style="margin-top:-12px;">Quantity not available</p>');
               
            } 

        });

        
    });
       
}


/* ==== Remove orders in cart ==== */

function removecart(id,sizeId) {
		//alert(id);
	var data = 'cart_id='+id+'&sizeId='+sizeId;

	$.post(baseUrl+"cart/removecart",data,function() {
        
       window.location.href = baseUrl+"cart/checkout";

	});
}