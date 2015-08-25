<?php
/*
 * PizzaPi Admin back end
 * Show all orders
 * Copyright V. Margot Paez, 2015. All rights reserved.
 */
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
								  <div class="panel-body">
								  	<strong id="order-45298f">#45298f &mdash; Ordered on: August 18, 2015 @ 12:45pm</strong><br>
								  	<span id="gps" class="label label-default pointer" data-id="45298f" data-toggle="modal" data-target="#mapModal">See GPS location</span><br>
								    Driver: <abbr title="cell: 909-432-3458">Joe</abbr><br>
								    Customer: Alice Hamarabi<br>
								    Address: 3123 Main St, Los Angeles, CA 90021<br>
								    Order: 1 x Large Gluten-free Pizza with Red sauce, Onions, Pepperoni<br>
								    Status: En Route<br>
								    
								  </div>
								  <div class="panel-body black">
								    <strong id="order-8987d">#8987d &mdash; Ordered on: August 18, 2015 @ 12:45pm</strong><br>
								    <span id="gps" class="label label-default pointer" data-id="8987d" data-toggle="modal" data-target="#mapModal">See GPS location</span><br>
								    Driver: <abbr title="cell: 909-432-3458">Alice</abbr><br>
								    Customer: Alice Hamarabi<br>
								    Address: 3123 Main St, Los Angeles, CA 90021<br>
								    Order: 1 x Large Regular Pizza with Red sauce, Mushrooms, Onions, Canadian Ham<br>
								    Status: Baking<br>
								  </div>
								  <div class="panel-body">
								    #098sdf &mdash; Driver: Joe
								  </div>
								  <div class="panel-body black">
								    #45298f &mdash; Driver: Joe
								  </div>
								  <div class="panel-footer"></div>
								  <div class="panel-body">
								    #45298f &mdash; Driver: Joe
								  </div>
								  <div class="panel-body black">
								    #8987d &mdash; Driver: Alice
								  </div>
								  <div class="panel-body">
								    #098sdf &mdash; Driver: Joe
								  </div>
								  <div class="panel-body black">
								    #45298f &mdash; Driver: Joe
								  </div>
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
				    zoom: 12
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
	