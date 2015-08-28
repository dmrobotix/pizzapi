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
		
		/*
		 * validate form
		 * 
		 */
		 
		 // basic customer information
		 
		 if(isset($_POST['fname'])) {
		 	$first = $_POST['fname'];
		 } else { $error[] = "Please enter your first name."; }
		 
		 if(isset($_POST['lname'])) {
		 	$last = $_POST['lname'];
		 } else { $error[] = "Please enter your last name."; }
		 
		 if(isset($_POST['address'])) {
		 	$address = $_POST['address'];
		 } else { $error[] = "Please enter your street address."; }
		
		
		if(isset($_POST['city'])) {
		 	$city = $_POST['city'];
		 } else { $error[] = "Please enter your city."; }
		
		
		if(isset($_POST['state'])) {
		 	$state = $_POST['state'];
		 } else { $error[] = "Please select your state."; }
		
		
		if(isset($_POST['zip'])) {
		 	$zip = $_POST['zip'];
		 } else { $error[] = "Please enter your zip code."; }
		 
		 if(isset($_POST['phone'])) {
		 	$phone = $_POST['phone'];
		 } else { $error[] = "Please enter your phone number."; }
		 
		 if(isset($_POST['email'])) {
		 	$email = $_POST['email'];
		 } else { $error[] = "Please enter your email address."; }
		 
		 
		 // end basic customer information
		 
		 // pizza order
		 
		 if(isset($_POST['size'])) {
		 	$size = $_POST['size'];
		 } else { $error[] = "Please enter the pizza size."; }
		 
		 if(isset($_POST['crust'])) {
		 	$crust = $_POST['crust'];
		 } else { $error[] = "Please enter the type of crust."; }
		 
		 if(isset($_POST['sauce'])) {
		 	$sauce = $_POST['sauce'];
		 } else { $error[] = "Please enter the type of sauce."; }
		 
		 if(isset($_POST['cheese'])) {
		 	$cheese = $_POST['cheese'];
		 } else { $error[] = "Please enter the type of cheese."; }
		 
		 if(isset($_POST['toppings'])) {
		 	$toppings = $_POST['toppings'];
		 } else { $error[] = "Please select at least one topping."; }
		 
		 if(isset($_POST['notes'])) {
		 	$notes = $_POST['notes'];
		 } else { $notes = NULL; }
		 
		 // end pizza order
		 
		 if (isset($error)) {
		 	?>
		 	<div class="alert alert-danger alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Form validation failed!</strong> You had the following errors:<br>
			  <?php foreach ($error as $err) { ?>
			  	<em><?php echo $err; ?></em><br>
			  <?php } ?>
			</div>
		 	<?php
		 	exit();
		 }
		 
		 /*
		  * end form validation
		  * 
		  */
		  
		  /*
		   * send information to server
		   * 
		   */
		   
		   // query the server
		   $query = "INSERT INTO customer (fname, lname, address, city, state, zip, phone, email)  
		   VALUES ('$first', '$last', '$address', '$city', '$state', '$zip', '$phone', '$email')";
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
		   	
		   } else {
		   		// store the id for the customer
				$customer_id = mysqli_insert_id($database);
			   	
			   	// add pizza to database
			   	// query the server
			   	
			   	// add the toppings
			   	$gtoppings = "";
				$params = "";
			   	foreach ($toppings as $cnt => $topping) {
			   		$num = $cnt +1;
			   		if (!empty($topping)) {
			   			if ($cnt == 0) {
			   				$params = $params."topping_$num";
			   				$gtoppings = $gtoppings ."'$topping'";
			   			} else {
			   				$params = $params.", topping_$num";
			   				$gtoppings = $gtoppings .", '$topping'";
			   			}
			   			
			   		}
			   	}
			   	
			   $query = "INSERT INTO group_toppings ($params) VALUES ($gtoppings)";
			   $row = @mysqli_query($database,$query);
			   	
			   	if (!$row) {
			   		//error
			   		?>
			 	<div class="alert alert-danger alert-dismissible" role="alert">
				  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				  <strong>Order failed!</strong> You had the following errors:<br>
				  query: <?php echo $query; ?><br>
				  error: <?php echo mysqli_error($database); ?> 
				</div>
			 	<?php
			 	exit();
			   	}
			   	
			   	// store the id for the group toppings
				$gtop_id = mysqli_insert_id($database);
			   	
				
				// add the pizza 
				$query = "INSERT INTO pizza (cheese_id, crust_id, gtop_id, sauce_id, notes, size_id, status_id)
				SELECT cheese.cheese_id, crust.crust_id, '$gtop_id' AS gtop_id, sauce.sauce_id, '$notes' as notes, size.size_id, '1' AS status_id
				FROM cheese
				CROSS JOIN crust
				CROSS JOIN sauce
				CROSS JOIN size
				
				WHERE cheese.cheese = '$cheese' AND crust.crust = '$crust' AND sauce.sauce = '$sauce' AND size.size = '$size'";
				
			   	$row = @mysqli_query($database,$query);
			   	
			   	if (!$row) {
			   		//error
			   		?>
			 	<div class="alert alert-danger alert-dismissible" role="alert">
				  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				  <strong>Order failed! Form validation failed!</strong> You had the following errors:<br>
				  query: <?php echo $query; ?><br>
				  error: <?php echo mysqli_error($database); ?> 
				</div>
			 	<?php
			 	exit();
			   	}
				// store the id for the pizza
				$pizza_id = mysqli_insert_id($database);
			   	
				// TODO: pull in the drivers and determine which driver has the least orders for now just select the first id
				$driver_id = 1;
				// create unique confrmation number
			   $confirm = substr(str_shuffle(md5(microtime())),0,10);
			   
			   // TODO: create QR code
			   $qrcode = "orders/qrcodes/qrcode.30890529.png";
			   
			   // get the current time
			   $format ="Y-m-d H:i:s";
			   $start = date($format, $_SERVER['REQUEST_TIME']);
				
				// last piece: add the order
				$query = "INSERT INTO piorder (pizza_id, customer_id, QR, ordernum, driver_id, start_time)
				VALUES ('$pizza_id', '$customer_id', '$qrcode', '$confirm', '$driver_id', '$start');";
				
			   	$row = @mysqli_query($database,$query);
			   	
			   	if (!$row) {
			   		//error
			   		?>
				 	<div class="alert alert-danger alert-dismissible" role="alert">
					  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					  <strong>Order failed!</strong> You had the following errors:<br>
					  query: <?php echo $query; ?><br>
					  error: <?php echo mysqli_error($database); ?> 
					</div>
				 	<?php
				 	exit();
			   	} else {
			   			?>
				 	<div class="alert alert-success alert-dismissible" role="alert">
					  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					  <strong>Order success!</strong> Your pizza has been ordered! Your confirmation number is: <?php echo $confirm; ?>. 
					  You can track your order at the <span class="link" id="confirmnum" data-confirm="<?php echo $confirm; ?>">customer track</span> page.
					</div>
				 	<?php
			   	}

		   } // end else for if (!$row)

		
	} else {
		// send to landing page
		?>
					<div class="row">
				<div class="col-md-7 col-md-offset-2">
					<h2>Order Delicious Pizza</h2>
					<div id="customer-status"></div>
					<div class="well">
						<form id="customerorder-form">
							<div class="form1">
								<div class="form-group">
									<label for="firstName">First Name</label>
									<input type="text" class="form-control" id="fname" placeholder="Jane">
								</div>
								
								<div class="form-group">
									<label for="lastName">Last Name</label>
									<input type="text" class="form-control" id="lname" placeholder="Hamarabi">
								</div>
								
								<div class="form-group">
									<label for="address">Address</label>
									<input type="text" class="form-control" id="address" placeholder="789 Manzanita St. Apt. 543">
								</div>
								
								<div class="form-group">
									<label for="city">City</label>
									<input type="text" class="form-control" id="city" placeholder="Los Angeles">
								</div>
								
								<div class="form-group">
									<label for="state">State</label>
									<select class="form-control" id="state">
										<option>CA</option>
										<option>NY</option>
									</select>
								</div>
								
								<div class="form-group">
									<label for="zipCode">Last Name</label>
									<input type="text" class="form-control" id="zip" placeholder="90021">
								</div>
								
								<div class="form-group">
									<label for="phoneNumber">Phone Number</label>
									<input type="tel" class="form-control" id="phone" placeholder="(213) 805-5555">
								</div>
								
								<div class="form-group">
									<label for="eMail">E-mail</label>
									<input type="email" class="form-control" id="email" placeholder="jh1976@lawofland.com">
								</div>
							
							
								<div id="next" class="btn btn-default">Next</div>
							</div>
						
							<div class="form2">
							
								<div class="form-group">
									<label for="size">Pizza size</label>
									<select class="form-control" id="size">
										<option>Small</option>
										<option>Medium</option>
										<option>Large</option>
										<option>Extra Large</option>
									</select>
								</div>
								
								<div class="form-group">
									<label for="crust">Crust</label>
									<select class="form-control" id="crust">
										<option>Regular</option>
										<option>Gluten-free</option>
										<option>Deep Dish</option>
									</select>
								</div>
								
								<div class="form-group">
									<label for="sauce">Sauce</label>
									<select class="form-control" id="sauce">
										<option>Red sauce</option>
										<option>Pesto drizzle</option>
										<option>No sauce</option>
									</select>
								</div>
								
								<div class="form-group">
									<label for="cheese">Cheese</label>
									<select class="form-control" id="cheese">
										<option>Mozarella</option>
										<option>No Cheese</option>/option>
									</select>
								</div>
								
								<div class="form-group">
									<label for="toppings">Toppings (up to four): </label>
									<input type="checkbox" id="toppings" value="Mushrooms"> Mushrooms
									<input type="checkbox" id="toppings" value="Canadian Ham"> Canadian Ham
									<input type="checkbox" id="toppings" value="Pepperoni"> Pepperoni
									<input type="checkbox" id="toppings" value="Pineapple"> Pineapple
									<input type="checkbox" id="toppings" value="Red onions"> Red onions
								</div>
								
								
								<div class="form-group">
									<label for="notes">Order notes: </label>
									<textarea class="form-control" id="notes"></textarea>
									
								</div>
								
							</form>
							
							<div id="prev" class="btn btn-default">Previous</div>&nbsp;<button type="submit" class="btn btn-default" id="customer-submit">Submit</button>
						</div>
						<!-- /form 2 -->
						
					</div>
					<!-- /well form 1 -->
					
					
					
					
				</div>
			</div>
			<!-- /row -->
		
		<?php
	} // end if ($_SERVER['REQUEST_METHOD'] == 'POST')
 	
 }

 
?>
			
