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