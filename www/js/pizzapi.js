$(document).ready(function() {
	
	// change active link in nav bar
	$(".nav li").click(function() {
		$(".nav li").removeClass("active");
		$(this).addClass("active");
		
		if ($(this).attr("id") == "order") {
			$.get("customer.php", function(ajaxresult) {
			$(".content").html(ajaxresult);
			});
		}
		
		if ($(this).attr("id") == "track") {
			$.get("customer-track.php", function(ajaxresult) {
			$(".content").html(ajaxresult);
			});
		}
		
		if ($(this).attr("id") == "dash") {
			$.get("admin.php", function(ajaxresult) {
			$(".content").html(ajaxresult);
			});
		}
		
		if ($(this).attr("id") == "monitor") {
			$.get("monitor.php", function(ajaxresult) {
			$(".content").html(ajaxresult);
			});
		}
		
		if ($(this).attr("id") == "data") {
			$.get("data.php", function(ajaxresult) {
			$(".content").html(ajaxresult);
			});
		}
		
	});
	
	
	// toggle form divs
	$(".content").on("click", "#next", function() {
		$(".form1").hide();
		$(".form2").fadeIn(1000);
	});
	
	$(".content").on("click", "#prev", function() {
		$(".form2").hide();
		$(".form1").fadeIn(1000);
	});
	
	
	
	$('.content').on ('click', '#gps', function() {
		var orderid = $(this).attr('data-id');
		$.get("maps-display.php", {orderid: orderid}, function(ajaxresult) {
			var coords = ajaxresult;		
			coords = coords.split(" ");
			var lat = parseFloat(coords[0]);
			var lng = parseFloat(coords[1]);
			console.log(lat);
			console.log(lng);
			loadMap(lat,lng);
			
		});
	  });
	  
	  // customer.php form submission
	  
	  $('.content').on("click", "#customer-submit", function() {
	  	
	  	var fname = $('#fname').val();
	  	var lname = $('#lname').val();
	  	var address = $('#address').val();
	  	var city = $('#city').val();
	  	var state = $('#state').val();
	  	var zip = $('#zip').val();
	  	var phone = $('#phone').val();
	  	var email = $('#email').val();
	  	var size = $('#size').val();
	  	var crust = $('#crust').val();
	  	var sauce = $('#sauce').val();
	  	var cheese = $('#cheese').val();
	  	var tops = document.querySelectorAll('#toppings');
	  	var notes = $('#notes').val();
	  	
	  	// Loop through tops list
	  	var toppings = [];
		for (var i in tops) {
			if (tops[i].checked == true) {
				toppings.push(tops[i].value);
			}
		}
	  	
	  	$.post("customer.php", {fname: fname, lname: lname, address: address, city:city, state:state, zip:zip, phone:phone, email:email, size:size, crust:crust, sauce:sauce, cheese:cheese, 'toppings[]':toppings, notes:notes }, function(ajaxresult) {
	  		$('#customer-status').html(ajaxresult);
	  		console.log(ajaxresult);
	  	});
	  	
	  });
	  
	  
	  // customer.php track order link
	  
	  $('.content').on('click', '.link', function() {
	  	confirm = $(this).attr("data-confirm");
	  	$.post("customer-track.php", {confirm: confirm}, function(ajaxresult) {
			$(".content").html(ajaxresult);
	 	 });
	  
	  });
	  
	  
	  
	  // customer-track.php form submission
	  
	  $('.content').on("click", "#ctrack-submit", function() {
	  	var confirm = $('#ordernum').val();
	  	$.post("customer-track.php", { confirm:confirm }, function(ajaxresult) {
	  		$('.content').html(ajaxresult);
	  		console.log(ajaxresult);
	  	});
	  	
	  });
	
	
	
	
	
	// fix phone number
	/*
	 var format = [{"mask": "(###) ###-####"}];
	$("#phone").inputmask({
		mask: format,
		greedy: false,
		definitions: { '#': {validator: "[0-9]", cardinality: 1}}
	});
	
	*/
});	