<?php
/*
 * PizzaPi Admin back end
 * Dashboard
 * Copyright V. Margot Paez, 2015. All rights reserved.
 */
 
 
// connect to database
require_once('mysql_connect-pizzapi.php');
 
$recent = Array();
getNewest($dbc, $recent);
?>
 			<script>
				var map;
				function initMap() {
				  map = new google.maps.Map(document.getElementById('map-all'), {
				    center: {lat: -34.397, lng: 150.644},
				    zoom: 10
				  });
				}
			</script>
			<div class="row">
				<div class="col-md-7 col-md-offset-2">
					<div class="row">
						<div class="col-md-9">
							<div class="panel panel-default">
								  <div class="panel-heading">
								    <h3 class="panel-title">Newest orders</h3>
								  </div>
								  
								  <?php 
								  
								  $count = 0;
								  
								  foreach ($recent as $ordernum => $inner) {
								  	if ($count%2 == 0) { ?>
								  		<div class="panel-body">
									    <?php echo $inner['start']; ?><br>#<?php echo $ordernum; ?> &mdash; Driver: <?php echo $inner['driver']; ?> 
									  </div>
								  <?php	} else { ?>
								  		<div class="panel-body black">
									    <?php echo $inner['start']; ?><br>#<?php echo $ordernum; ?> &mdash; Driver: <?php echo $inner['driver']; ?> 
									  </div>
								  	<?php }
								  	$count = $count + 1;
								  }
								  
								  ?>
								  
								<div class="panel panel-default">
								  <div class="panel-heading">
								    <h3 class="panel-title">Track Deliveries</h3>
								  </div>
								  <div class="panel-body">
								    <div id="map-all" style="height:400px"></div>
								  </div>
								  <div class="panel-footer"></div>
								</div>
						</div>
					</div>
					
				</div>
			</div>
			<script src="https://maps.googleapis.com/maps/api/js?callback=initMap" async defer></script>
 
 <?php
 
 function getNewest($database, &$recent) {
 	// query the database
 	
 	$query = "SELECT piorder.start_time, piorder.ordernum, driver.fname, driver.lname 
 	FROM piorder
 	INNER JOIN driver ON piorder.driver_id = driver.driver_id
 	ORDER BY order_id DESC LIMIT 4;";
	$row = @mysqli_query($database,$query);
	
	if ($row) {
		$format = "M d Y @ h:i:s A";
		while ($row_array = mysqli_fetch_array($row, MYSQLI_ASSOC)) {
			$ordernum = $row_array['ordernum'];
			$recent[$ordernum]['driver'] = $row_array['fname']." ".$row_array['lname'];
			$recent[$ordernum]['start'] = date($format, strtotime($row_array['start_time']));
		}
	} else {
		echo "problem";
	}
	
	
 }
 
 
?>