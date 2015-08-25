<?php
/*
 * PizzaPi Admin back end
 * JSON auth
 * Copyright V. Margot Paez, 2015. All rights reserved.
 */
 
require_once('mysqli_connect-pizzapi.php'); 

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['firstname']) && isset($_POST['lastname'])) {
	// the app sent the driver's first and last name
	
	$first = $_POST['firstname'];
	$last = $_POST['lastname'];
	
	$query = "";
	$row = mysqli_query($dbc,$query);
	
	echo '{"success":1}';
	
	
	
} else {
	echo '{"succes":0,"error_message":"You did not send the driver\'s first and last name. Try again."}';
}
 
  
?>