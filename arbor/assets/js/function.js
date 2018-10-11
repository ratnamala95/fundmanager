$(document).ready(function(){

	$('select.ware').on('change', warehouse);
	$('select.warehouse').on('change', products);
	$('select.product').on('change',select);
//	$('select.whouse').on('change',whouse);
});


function warehouse(){
		var selectedWarehouse = $('.ware option:selected').val();
		$.ajax({
				url : baseURL+"backend/retailer/replace",
         type: 'POST',
         cache:false,
         data: {warehouse : selectedWarehouse},
         success: function(response) { 
					 
//					 alert(response);
					 
					 $('#dist').html(response);
  
				 }
     });
//	   alert("Warehouse changed! " + selectedWarehouse);    
			console.log(selectedWarehouse);
	}


function products(){
	
	var selectedWarehouse = $('.warehouse option:selected').val();
	$.ajax({
		
		url : baseURL+"backend/warehouse/replace",
		type : 'POST',
		cache:false,
		data: { warehouse : selectedWarehouse},
		success: function(response) { 
					 
//					 alert(response);

			 $('#products').html(response);

		 }
	});
}

function chng(){
	
	if($('.single-checkbox:checked').length > 1) {
				$('input:checkbox:checked').attr('checked', false);
			alert('select only one!');
	}
}

function modal(obj){

	
	$.ajax({
		
		url : baseURL+"backend/warehouse/mod",
		type : 'POST',
		cache:false,
		data: { mdl : obj},
		success: function(response) { 
			
			$('#modalbody').html(response);
			$("#mymodal").trigger("click");
			

		}
	});

	//console.log(temp);

	/*	
	$('.mdl').click(function(){
		var temp = $(this).data('id');
		$.ajax({
		
		url : baseURL+"backend/warehouse/mod",
		type : 'POST',
		cache:false,
		data: { mdl : temp},
		success: function(response) { 
			
			//$("#mymodal").trigger("click");
			$('#modalbody').html(response);

		 }
	});
		
	});
	console.log(temp);
	*/
}

function change(obj){
	
	$("."+obj).removeAttr("disabled");
}


function select(){
	var selectedProduct = $('.product option:selected').val();
	$.ajax({
		url : baseURL+"backend/inventory/selectProduct",
		type : 'POST',
		cache:false,
		data: { product : selectedProduct},
		success: function(response){
//			alert(response);
			$('#size').html(response);
		}
	});
}


function whouse(obj){
	
//	var selectedWare = $('.whouse option:selected').val();
	alert(obj.val());
	$.ajax({
			url : baseURL+"backend/inventory/whouse",
			type : 'POST',
			cache:false,
			data: { wareh : obj.val() },
			success: function(response){
//				alert(response);
				$('#change').html(response);
			}
	});
}function whouse(obj){
	
//	var selectedWare = $('.whouse option:selected').val();
//	alert(obj.val());
	$.ajax({
			url : baseURL+"backend/inventory/whouse",
			type : 'POST',
			cache:false,
			data: { wareh : obj.val() },
			success: function(response){
//				alert(response);
				$('#change').html(response);
			}
	});
}


function size(obj){
	
	alert(obj.val());
	$.ajax({
			url : baseURL+"backend/inventory/whouse",
			type : 'POST',
			cache:false,
			data: { size : obj.val() },
			success: function(response){
//				alert(response);
				$('#change').html(response);
			}
	});
}

function code(obj){
	
//	alert(obj.val());
	$.ajax({
			url : baseURL+"backend/inventory/whouse",
			type : 'POST',
			cache:false,
			data: { code : obj.val() },
			success: function(response){
//				alert(response);
				$('#change').html(response);
			}
	});
}

function cname(obj){
	
//	alert(obj.val());
	$.ajax({
			url : baseURL+"backend/inventory/whouse",
			type : 'POST',
			cache:false,
			data: { name : obj.val() },
			success: function(response){
//				alert(response);
				$('#change').html(response);
			}
	});
}

function transacware(obj)
{
	$.ajax({
		url: baseURL+"backend/inventory/tranware",
		method: 'GET',
		data: {
				 ware : obj.val()
		},
		success: function(response){
	//				alert(response);
					$('#change').html(response);
				}
		});
//	$.ajax({
//		  url : baseURL+"backend/inventory/tranware",
//			type : 'POST',
//			cache:false,
//			data: { ware : obj.val() },
//			success: function(response){
////				alert(response);
//				$('#change').html(response);
//			}
//	});
}

function transaccode(obj)
{
	$.ajax({
		url: baseURL+"backend/inventory/tranware",
		method: 'GET',
		data: {code : obj.val()},
		success: function(response){
	//				alert(response);
					$('#change').html(response);
				}
		});
	
//	$.ajax({
//		  url : baseURL+"backend/inventory/tranware",
//			type : 'POST',
//			cache:false,
//			data: { code : obj.val() },
//			success: function(response){
////				alert(response);
//				$('#change').html(response);
//			}
//	});
}

function transacdate(obj)
{
		$.ajax({
			url: baseURL+"backend/inventory/tranware",
			method: 'GET',
			data: {date : obj.val()},
			success: function(response){
		//				alert(response);
						$('#change').html(response);
					}
			});
//	$.ajax({
//		  url : baseURL+"backend/inventory/tranware",
//			type : 'POST',
//			cache:false,
//			data: { date : obj.val() },
//			success: function(response){
////				alert(response);
//				$('#change').html(response);
//			}
//	});
}

function search()
{
    
	var code = $("#sear").val();
//	alert(code);
	$.ajax({
			url : baseURL+"backend/product/search",
			type : 'POST',
			cache:false,
			data: { name : code},
			success: function(response){
//				alert(response);
				$('#search').html(response);
			}
	});
}