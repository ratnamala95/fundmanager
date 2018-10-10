$(document).ready(function(){
	$('#ad6').css('display','block');
	$("#btn1").click(function(){
			$("#background").addClass("active");
	});


});


function openCity(evt, cityName) {
		// Declare all variables
		var i, tabcontent, tablinks;

		// Get all elements with class="tabcontent" and hide them
		tabcontent = document.getElementsByClassName("tabcontent");
		for (i = 0; i < tabcontent.length; i++) {
				tabcontent[i].style.display = "none";
		}

		// Get all elements with class="tablinks" and remove the class "active"
		tablinks = document.getElementsByClassName("tablinks");
		for (i = 0; i < tablinks.length; i++) {
				tablinks[i].className = tablinks[i].className.replace(" active", "");
		}

		// Show the current tab, and add an "active" class to the button that opened the tab
		document.getElementById(cityName).style.display = "block";
		evt.currentTarget.className += " active";
}

function en()
{
	var sel4 = $('#sel4 option:selected').val();

	if(sel4==1)
	{
		document.getElementById("at1").disabled = false;
	}
	else {
		document.getElementById("at1").disabled = true;
	}
}

function enviroment(id)
{

	var enviroment = [$('#envi1').val(),
		$('#envi2').val(),
		$('#envi3').val(),
		$('#envi4').val(),
		$('#envi5').val(),
		$('#envi6').val(),
	];

	$.ajax({
		url: baseURL+"griglia/enviroment/"+id,
		type:'POST',
		cache:false,
		data:{enviroment : enviroment},
		success:function(response){

			var res = response;
			efficiency(res,id);
			// alert(response);
		}
	});
}

function efficiency(res,id)
{

	var respo = res;
	var eff = [$('#effi1').val(),
		$('#effi2').val(),
		$('#effi3').val(),
		$('#effi4').val(),
	];

	var efficiency = [eff,respo];
	$.ajax({
		url: baseURL+"griglia/energyeff/"+id,
		type:'POST',
		cache:false,
		data:{efficiency : efficiency},
		success:function(response){
			// alert(response);
			var res = JSON.parse(response);

		 $('#score1').val(res.sc);
		 $('#score2').val(res.score);
		 $('#fin').val(res.finalscore);
		}
	});
}

function energy(id){
	var dis = [$('#sd1').val(),
		$('#sd2').val(),
		$('#sd3').val(),
		$('#sd4').val(),
		$('#sd5').val(),
		$('#sd6').val(),
		$('#sd7').val(),
		$('#sd8').val(),
		$('#sd9').val(),
		$('#sd10').val(),
		$('#sd11').val()
	];

	var avgdis = [$('#ad1').val(),
		$('#ad2').val(),
		$('#ad3').val(),
		$('#ad4').val(),
		$('#ad5').val(),
		$('#ad6').val(),
	];

	var sel1 = $('#sel1 option:selected').val();

	var sel2 = $('#sel2 option:selected').val();
	var sel3 = $('#sel3 option:selected').val();
	var sel4 = $('#sel4 option:selected').val();

	if(sel4==1)
	{
		document.getElementById("at1").disabled = false;
	}
	else {
		document.getElementById("at1").disabled = true;
	}
	var ant = [$('#at1').val(),
		$('#at2').val(),
		$('#at3').val(),
		$('#at4').val(),
		$('#at5').val()
	];

	var val = [dis,avgdis,sel1,sel2,sel3,sel4,ant];

	$.ajax({
		url: baseURL+"griglia/background/"+id,
		type:'POST',
		cache:false,
		data:{val:val},
		success:function(response){
			// alert(response);
			var res = JSON.parse(response);

			$('#score3').val(res.score21);
 		  $('#score4').val(res.score22);
 		  $('#t2sc').val(res.score2);
		}

	});
}

function arch(id){
	var t3sb = [$('#t3sb1').val(),
		$('#t3sb2').val(),
		$('#t3sb3').val(),
		$('#t3sb4').val(),
		$('#t3sb5').val(),
		$('#t3sb6').val(),
		$('#t3sb7').val(),
		$('#t3sb8').val(),
		$('#t3sb9').val(),
		$('#t3sb10').val(),
		$('#t3sb11').val(),
		$('#t3sb12').val(),
	];

	var t3ip =[$('#t3ib1').val(),
		$('#t3ib2').val()
		];

	var tb3 = [t3sb,t3ip];

	$.ajax({
		url: baseURL+"griglia/architecture/"+id,
		type:'POST',
		cache:false,
		data:{tb3 : tb3},
		success:function(response){
			// alert(response);
			var res = JSON.parse(response);

			$('#score5').val(res.score31);
 		  $('#score6').val(res.score32);
 		  $('#score7').val(res.score33);
 		  $('#score8').val(res.score34);
 		  $('#score9').val(res.score35);
 		  $('#t3sc').val(res.finalscore);
		}
	});
}

function soci(id){
	var t5ip = [$('#t5ip1').val(),
			$('#t5ip2').val(),
			$('#t5ip3').val(),
			$('#t5ip4').val(),
		];

		var t5sb = [$('#t5sb1').val(),
			$('#t5sb2').val(),
			$('#t5sb3').val(),
		];

		var tb5 = [t5sb,t5ip];
		// alert(tb5);
		$.ajax({
			url: baseURL+"griglia/social/"+id,
			type:'POST',
			cache: false,
			data:{tb5 : tb5},
			success:function(response){
				// alert(response);
				var res = JSON.parse(response);

				$('#score11').val(res.score51);
	 		  $('#score12').val(res.score52);
	 		  $('#t5sc').val(res.finalscore);

				// var txt1 =  document.getElementById('score11');
			  // txt1.value = res[0];
				// var txt2 =  document.getElementById('score12');
			  // txt2.value = res[1];
				// var txt =  document.getElementById('t5sc');
			  // txt.value = res[2];
			}
		});
}

function housing(id){

	var t4ip = [$('#t4ip1').val(),
			$('#t4ip2').val(),
			$('#t4ip3').val(),
			$('#t4ip4').val(),
			$('#t4ip5').val(),
			$('#t4ip6').val(),
			$('#t4ip7').val(),
			$('#t4ip8').val(),
			$('#t4ip9').val(),
			$('#t4ip10').val(),
			$('#t4ip11').val(),
			$('#t4ip12').val(),
			$('#t4ip13').val(),
			$('#t4ip14').val(),
			$('#t4ip15').val(),
		];
		// $('#t4ip16').val(),

	var tb4 = [t4ip];

	$.ajax({
		url:baseURL+"griglia/housing/"+id,
		type:'POST',
		cache:false,
		data:{tb4 : tb4},
		success:function(response){
			// alert(response);

			$('#score17').val(response);
			$('#t4sc').val(response);
		}
	});
}

function project(id){
	var t6sb = [$('#t6sb1').val(),
			$('#t6sb2').val(),
			$('#t6sb3').val(),
			$('#t6sb4').val(),
			$('#t6sb5').val(),
			$('#t6sb6').val(),
			$('#t6sb7').val(),
			$('#t6sb8').val(),
			$('#t6sb9').val(),
			$('#t6sb10').val(),
		];

	var tb6 = [t6sb];

	$.ajax({
		url:baseURL+"griglia/project/"+id,
		type:'POST',
		cache:false,
		data:{tb6 : tb6},
		success:function(response){
			// alert(response);
			var res = JSON.parse(response);

			$('#score13').val(res.score61);
			$('#score14').val(res.score62);
			$('#score15').val(res.score63);
			$('#score16').val(res.score64);
			$('#t6sc').val(res.finalscore);
		}
	});
}

function selectproject(){

	// $('#sus').addClass('active');
	var selectedProject = [$('#selectproject').val(),
				$('#selector').val(),
				$('#duration').val(),
				$('#projectvalue').val(),
			];

	// alert(selectedProject);

	$.ajax({
		url: baseURL+'griglia/form',
		type:	'POST',
		cache: false,
		data: {project: selectedProject},
		success:function(response){
			// alert(response);
			$('#formreplace').html(response);
			// openCity(event, 'tab1');
		}
	});
}

function rating(fund){
	var project = $('#selpro option:selected').val();
	var change = 1;

	$.ajax({
		url:baseURL+('fundmanager/rating/'+project+'/'+fund+'/'+change),
		type:'POST',
		cache:false,
		success:function(response){
			// alert(response);
			$('#replaceproject').html(response);
		}
	});
}
