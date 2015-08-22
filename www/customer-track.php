<?php
/*
 * PizzaPi Customer front end
 * Order Page
 * Copyright V. Margot Paez, 2015. All rights reserved.
 */
?>

		<div class="container-fluid">
			
			<div class="row">
				<div class="col-md-7 col-md-offset-2 order-confirm">
					
					<h2>Track Your Order</h2>
					
					<div class="well" style="padding-top:0">
						<form>
							<div class="form-group">
								<div class="row">
									<div class="col-md-12 col-md-offset-1">
										<br>
										<label for="orderId">Enter your order confirmation number:</label>
									</div>
								</div>
								
								<div class="row">
									<div class="col-md-7 col-md-offset-1">
										<div class="input-group">
										<span class="input-group-addon"><span class="glyphicon glyphicon-hand-right"></span></span>
										<input type="text" class="form-control" id="ordernum" placeholder="38fdf">
										</div>
									</div>
									<div class="col-md-3"><button type="submit" class="btn btn-default">Submit</button></div>
								</div>
							</div>
						</form>	
					</div>
					<!-- /well -->
					
					<div class="well">
						<div class="row">
							<div class="col-md-12">
								<p><h3>Time elapsed: <small>0:25:32</small></h3></p>
								<p><h3>Status: <small>Cooking</small></h3></p>
								<p><h3>Order information:</h3>
									Customer: Jane Hamarabi<br>
									Phone: 213-805-5555<br>
									Pizza: 1x Large Gluten-free crust, Red sauce, Onions, Pepperoni
								</p>
							</div>			
						</div>
					</div>
					<!-- /well -->
					
					<div class="well well-bottom">
						<div class="row">
							<div class="col-md-12">
								<div id="map" style="height:400px"></div>
							    
							</div>
						</div>
					</div>
					<br>
					
				</div>
			</div>
			<!-- /row -->
		
		</div>
		<!-- /container-fluid -->
		
		<script type="text/javascript">
							
			var map;
			function initMap() {
			  map = new google.maps.Map(document.getElementById('map'), {
			    center: {lat: -34.397, lng: 150.644},
			    zoom: 8
			  });
			}
	
	    </script>
	    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCJ-CPpmZ7OEtBGF8o82Ps0V3R1S36kqIw&callback=initMap">
	    </script>
		
		
	</body>
</html>