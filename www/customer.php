<?php
/*
 * PizzaPi Customer front end
 * Order Page
 * Copyright V. Margot Paez, 2015. All rights reserved.
 */
?>
			
			<div class="row">
				<div class="col-md-7 col-md-offset-2">
					<h2>Order Delicious Pizza</h2>
					<div class="well">
						<div class="form1">
							<form>
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
									<label for="state">State</label>
									<select class="form-control" id="state">
										<option>CA</option>
										<option>NY</option>
									</select>
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
									</select>
								</div>
								
								<div class="form-group">
									<label for="crust">Crust</label>
									<select class="form-control" id="crust">
										<option>Regular</option>
										<option>Gluten-free</option>
									</select>
								</div>
								
								<div class="form-group">
									<label for="sauce">Sauce</label>
									<select class="form-control" id="sauce">
										<option>Classic red</option>
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
									<input type="checkbox"> Mushroom
									<input type="checkbox"> Bell pepper
									<input type="checkbox"> Sausage
									<input type="checkbox"> Pepperoni
									<input type="checkbox"> Parmesan
								</div>
							</form>
							
							<button type="submit" class="btn btn-default">Submit</button>
						</div>
						<!-- /form 2 -->
						
					</div>
					<!-- /well form 1 -->
					
					
					
					
				</div>
			</div>
			<!-- /row --