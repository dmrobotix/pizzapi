<?php
/*
 * PizzaPi Admin back end
 * JSON auth
 * Copyright V. Margot Paez, 2015. All rights reserved.
 */
 
require_once('mysql_connect-pizzapi.php'); 

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['firstname']) && isset($_POST['lastname'])) {
	// the app sent the driver's first and last name
	
	$first = $_POST['firstname'];
	$last = $_POST['lastname'];
	
	$query = "SELECT fname, lname FROM driver WHERE fname = '$first' AND lname = '$last';";
	$row = mysqli_query($dbc,$query);
	
	if (!$row) {
		// error
		echo '{"success":0,"error_message":"Unable to access server."}';
	} {
		if (mysqli_num_rows($row) == 0) {
			// error driver not found
			echo '{"success":0,"error_message":"'.$first.' '.$last.' does not exist in database."}';
		} else {
			// driver found
			// query orders
			$query = "SELECT orders, piorder.ordernum, piorder.start_time, 
			cheese.cheese, crust.crust, sauce.sauce, size.size, status.status, group_toppings.topping_1 as topping1, 
			group_toppings.topping_2 as topping2, group_toppings.topping_3 as topping3, group_toppings.topping_4 as topping4
			FROM driver 
			
			INNER JOIN piorder ON driver.driver_id = piorder.driver_id
			INNER JOIN pizza ON piorder.pizza_id = pizza.pizza_id
			INNER JOIN customer ON piorder.customer_id = customer.customer_id
			INNER JOIN cheese ON pizza.cheese_id = cheese.cheese_id
			INNER JOIN crust ON pizza.crust_id = crust.crust_id
			INNER JOIN group_toppings ON pizza.gtop_id = group_toppings.gtop_id
			INNER JOIN sauce ON pizza.sauce_id = sauce.sauce_id
			INNER JOIN size ON pizza.size_id = size.size_id
			INNER JOIN status ON pizza.status_id = status.status_id
		
			
			WHERE driver.fname = '$first' AND driver.lname = '$last';";
			$row = mysqli_query($dbc,$query);
			if (!$row) {
				// error
					echo '{"success":0,"error_message":"Unable to access the system."}';
			} else {
				// send json data
				
				if (mysqli_num_rows($row) == 0) {
					
					echo '{"success":0,"error_message":"You do not have any orders."}';
				} else {
					// orders
					$cnt = 0;
					while ($row_array = mysqli_fetch_array($row, MYSQLI_ASSOC)) {
						$count = "order $cnt";
						$orders = $row_array['orders'];
						$ordernum = $row_array['ordernum'];
						$allorders['success'] = 1;
						$allorders['orders'] = $row_array['orders'];
						$allorders[$count]['ordernum'] = $ordernum;
						$allorders[$count]['start_time'] = $row_array['start_time'];
						$allorders[$count]['cheese'] = $row_array['cheese'];
						$allorders[$count]['crust'] = $row_array['crust'];
						$allorders[$count]['sauce'] = $row_array['sauce'];
						$allorders[$count]['size'] = $row_array['size'];
						$allorders[$count]['status'] = $row_array['status'];
						
						if (empty($row_array['topping1'])) {
							$allorders[$count]['topping1'] = "none";
						} else {
							$allorders[$count]['topping1'] = $row_array['topping1'];
						}
						
						if (empty($row_array['topping2'])) {
							$allorders[$count]['topping2'] = "none";
						} else {
							$allorders[$count]['topping2'] = $row_array['topping2'];
						}
						
						if (empty($row_array['topping3'])) {
							$allorders[$count]['topping3'] = "none";
						} else {
							$allorders[$count]['topping3'] = $row_array['topping3'];
						}
						
						if (empty($row_array['topping4'])) {
							$allorders[$count]['topping4'] = "none";
						} else {
							$allorders[$count]['topping4'] = $row_array['topping4'];
						}
						
						$cnt = $cnt+1;
					
					}
					$jsonData = json_encode($allorders);
					
					echo $jsonData;
						
						
					
					// 
					
				}
				
			}
					
			
		}
	}
	
	
	
} else {
	echo '{"success":0,"error_message":"You did not send the driver\'s first and last name. Try again."}';
}
 
  
?>