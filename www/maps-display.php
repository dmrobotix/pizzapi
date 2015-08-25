<?php
/*
 * PizzaPi Admin back end
 * Process map modal display calls
 * Copyright V. Margot Paez, 2015. All rights reserved.
 */
 
 
if (isset($_GET['orderid'])) {
	$orderid = $_GET['orderid'];
	if ($orderid == '45298f') {
		?>-32.397 150.644<?php
	} else {
		?>34.0493300 -118.1358270<?php
	}
	
} else {
	echo "did not work";
}
 
?>