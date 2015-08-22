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