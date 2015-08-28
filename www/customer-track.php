<?php
/*
 * PizzaPi Customer front end
 * Order Page
 * Copyright V. Margot Paez, 2015. All rights reserved.
 */

 // connect to database
 require_once('mysql_connect-pizzapi.php');
 customerForm($dbc); 
 // process the form
 
 function customerForm ($database) {
 	
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		
		if(isset($_POST['confirm'])) {
			$confirm = $_POST['confirm'];
			// query the server and get order information
			
			$query = "SELECT piorder.start_time, status.status, customer.fname, customer.lname, customer.phone, size.size, 
			crust.crust, sauce.sauce, group_toppings.topping_1, group_toppings.topping_2, group_toppings.topping_3, group_toppings.topping_4
			
			FROM piorder
			INNER JOIN customer ON piorder.customer_id = customer.customer_id
			INNER JOIN pizza ON piorder.pizza_id = pizza.pizza_id
			INNER JOIN status ON pizza.status_id = status.status_id
			INNER JOIN size ON pizza.size_id = size.size_id
			INNER JOIN crust ON pizza.crust_id = crust.crust_id
			INNER JOIN sauce ON pizza.sauce_id =sauce.sauce_id
			INNER JOIN group_toppings ON pizza.gtop_id = group_toppings.gtop_id
			
			WHERE piorder.ordernum = '$confirm';";
			$row = @mysqli_query($database,$query);
			
			if (!$row) {
				// error
				?>
			 	<div class="alert alert-danger alert-dismissible" role="alert">
				  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				  <strong>Order failed!</strong> You had the following errors:<br>
				  query: <?php echo $query; ?><br>
				  error: <?php echo mysqli_error($database); ?> 
				</div>
			 	<?php
			 	exit();
			} else if (mysqli_num_rows($row) > 0) {
				// get row
				
				while ($row_array = mysqli_fetch_array($row, MYSQLI_ASSOC)) {
					$start = explode(" ", $row_array['start_time']);
					$status = $row_array['status'];
					$name = $row_array['fname'].' '.$row_array['lname'];
					$phone = $row_array['phone'];
					$size = $row_array['size'];
					$crust = $row_array['crust'];
					$sauce = $row_array['sauce'];
					$toppings[] = $row_array['topping_1'];
					$toppings[] = $row_array['topping_2'];
					$toppings[] = $row_array['topping_3'];
					$toppings[] = $row_array['topping_4'];
			
				} // end while
			} else {
				// no rows
				
				// confirmation number not passed, output landing HTML
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
										<div class="alert alert-danger alert-dismissible" role="alert">
				  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				  <strong>Error: </strong> Order not found. Try again.
				</div>
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
					
				
			
					
				</div>
			</div>
			<!-- /row -->
		
		</div>
		<!-- /container-fluid -->
		
		<?php
		exit();
			}
			
			
			// TODO: need to query for associated GPS coordinates and overlay on gmap
			
			
			// display content
			
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
								<p><h3>Time elapsed: <small><?php echo $start[1]; ?></small></h3></p>
								<p><h3>Status: <small><?php echo $status; ?></small></h3></p>
								<p><h3>Order information:</h3>
									Customer: <?php echo $name; ?><br>
									Phone: <?php echo $phone; ?><br>
									Pizza: 1x <?php echo "$size $crust crust, $sauce"; ?><?php foreach ($toppings as $top) {if (!empty($top)) { echo ", $top"; } } ?>
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
			
			
			
			
			
			
			
			
			
			
			
			
			<?php
		} else {
			// confirmation number not passed, output landing HTML
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
										<div class="alert alert-danger alert-dismissible" role="alert">
				  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				  <strong>Error: </strong> Order confirmation number was not received. Try submitting again.
				</div>
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
					
				
			
					
				</div>
			</div>
			<!-- /row -->
		
		</div>
		<!-- /container-fluid -->
		
		<?php
		}
		
		
	}  else {
		// show landing page
		
		?>				
			<div class="container-fluid">
			
			<div class="row">
				<div class="col-md-7 col-md-offset-2 order-confirm">
					
					<h2>Track Your Order</h2>
					
					<div class="well" style="padding-top:0">
						<form id="customertrack-form">
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
									<div class="col-md-3"><button type="submit" class="btn btn-default" id="ctrack-submit">Submit</button></div>
								</div>
							</div>
						</form>	
					</div>
					<!-- /well -->
					
				
			
					
				</div>
			</div>
			<!-- /row -->
		
		</div>
		<!-- /container-fluid -->
		
		
		
	
		
		<?php
		
	} // end else for if ($_SERVER['REQUEST_METHOD'] == 'POST')
	
 } // end function customerForm 
 
 
?>

		