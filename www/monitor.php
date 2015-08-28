<?php
/*
 * PizzaPi Admin back end
 * Show all orders
 * Copyright V. Margot Paez, 2015. All rights reserved.
 */
 
// connect to database
require_once('mysql_connect-pizzapi.php');

$orders = Array();
getOrders($dbc, $orders);
?>


			<div class="row">
				<div class="col-md-7 col-md-offset-2">
					<div class="row">
						<div class="col-md-9">
							<div class="panel panel-default">
								  <div class="panel-heading">
								    <h3 class="panel-title">Newest orders</h3>
								  </div>
								  <div class="panel-body" id="map" style="height:300px"></div>
								  
								  <?php
								  $count = 0;
								  foreach ($orders as $ordernum => $inner) {
								  	
									  if ($count%2 == 0) {
									  	?>
									  	<div class="panel-body">
										  	<strong id="order-<?php echo $ordernum; ?>">#<?php echo $ordernum; ?> &mdash; Ordered on: <?php echo $inner['start']; ?></strong><br>
										  	<span id="gps" class="label label-default pointer" data-id="<?php echo $ordernum; ?>" data-toggle="modal" data-target="#mapModal">See GPS location</span><br>
										    Driver: <abbr title="cell: <?php echo $inner['cphone']; ?>"><?php echo $inner['driver']; ?></abbr><br>
										    Customer: <?php echo $inner['customer']; ?><br>
										    Address: <?php echo $inner['location']; ?><br>
										    Order: <?php echo $inner['order']; ?><br>
										    Status: <?php echo $inner['status']; ?><br>
										  </div>
									  	<?php
									  } else {
									  	?>
									  	<div class="panel-body black">
										  	<strong id="order-<?php echo $ordernum; ?>">#<?php echo $ordernum;?> &mdash; Ordered on: <?php echo $inner['start']; ?></strong><br>
										  	<span id="gps" class="label label-default pointer" data-id="45298f" data-toggle="modal" data-target="#mapModal">See GPS location</span><br>
										    Driver: <abbr title="cell: <?php echo $inner['cphone']; ?>"><?php echo $inner['driver']; ?></abbr><br>
										    Customer: <?php echo $inner['customer']; ?><br>
										    Address: <?php echo $inner['location']; ?><br>
										    Order: <?php echo $inner['order']; ?><br>
										    Status: <?php echo $inner['status']; ?><br>
										  </div>
									  	<?php
									  }
									  $count = $count +1;
								  }
								  
								 ?>
								  
								  <div class="panel-footer"></div>
								</div>
						</div>
					</div>
					
				</div>
			</div>
			
			
			<script>
				var map;
				function initMap() {
				  map = new google.maps.Map(document.getElementById('map'), {
				    center: {lat: 34.0493, lng: -118.1358},
				    zoom: 15
				  });
				  
				    // NOTE: This uses cross-domain XHR, and may not work on older browsers.
  map.data.loadGeoJson('test.json');
				}
		
		      function loadMap(lat,lng)
		           {
		               //var location= new google.maps.LatLng(lat: lat, lng: lng, noWrap?:false);
		               map.setCenter({lat: lat, lng: lng});
		               new google.maps.Marker({position: {lat: lat, lng: lng}, map: map});
		           	   console.log("loadMap");
		           	   console.log(lat);
		           	   console.log(lng);
		           }
		
		    </script>
			<script src="https://maps.googleapis.com/maps/api/js?callback=initMap" async defer></script>
<?php
function getOrders($database, &$orders) {
 	// query the database
 	
 	$query = "SELECT piorder.start_time, piorder.ordernum, driver.fname, driver.lname, driver.cphone, customer.fname as cfname, 
 	customer.lname as clname, customer.phone, customer.address, customer.city, customer.zip, customer.state, crust.crust, sauce.sauce, size.size, 
 	group_toppings.topping_1, group_toppings.topping_2, group_toppings.topping_3, group_toppings.topping_4, status.status
 	FROM piorder
 	INNER JOIN driver ON piorder.driver_id = driver.driver_id
 	INNER JOIN customer ON piorder.customer_id = customer.customer_id
 	INNER JOIN pizza ON piorder.pizza_id = pizza.pizza_id
 	INNER JOIN crust ON pizza.crust_id = crust.crust_id
 	INNER JOIN sauce ON pizza.sauce_id = sauce.sauce_id
 	INNER JOIN size ON pizza.size_id = size.size_id
 	INNER JOIN group_toppings ON pizza.gtop_id = group_toppings.gtop_id
 	INNER JOIN status ON pizza.status_id = status.status_id
 	ORDER BY piorder.start_time DESC;";
	$row = @mysqli_query($database,$query);
	
	if ($row) {
		$format = "M d Y @ h:i:sa";
		while ($row_array = mysqli_fetch_array($row, MYSQLI_ASSOC)) {
			$ordernum = $row_array['ordernum'];
			$orders[$ordernum]['driver'] = $row_array['fname']." ".$row_array['lname'];
			$orders[$ordernum]['cphone'] = $row_array['cphone'];
			$orders[$ordernum]['start'] = date($format, strtotime($row_array['start_time']));
			$orders[$ordernum]['location'] = $row_array['address']." ".$row_array['city'].", ".$row_array['state']." ".$row_array['zip'];
			$orders[$ordernum]['customer'] = $row_array['cfname']." ".$row_array['clname'];
			$orders[$ordernum]['status'] = $row_array['status'];
			$toppings = $row_array['topping_1'];
			if (!empty($row_array['topping_2'])) {
				$toppings = $toppings.", ".$row_array['topping_2'];
			}
			if (!empty($row_array['topping_3'])) {
				$toppings = $toppings.", ".$row_array['topping_3'];
			}
			if (!empty($row_array['topping_4'])) {
				$toppings = $toppings.", ".$row_array['topping_4'];
			}
			$orders[$ordernum]['order'] = "1 x ".$row_array['size']." ".$row_array['crust']." Pizza with ".$row_array['sauce'].", ".$toppings;
		}
	} else {
		echo "problem";
	}
	
	
}
?>