<?php
/*
 * PizzaPi Admin back end
 * Dashboard
 * Copyright V. Margot Paez, 2015. All rights reserved.
 */
?>


			<script>
				var map;
				function initMap() {
				  map = new google.maps.Map(document.getElementById('map-all'), {
				    center: {lat: -34.397, lng: 150.644},
				    zoom: 12
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