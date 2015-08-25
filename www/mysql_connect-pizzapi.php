<?php

/*
 * PizzaPi protocol
 * MySQL connect
 * Copyright V. Margot Paez, 2015. All rights reserved.
 */
 

// user info
DEFINE ('DB_USER', 'pizzapi');//
DEFINE ('DB_PASSWORD', 'sc1f1yourp1');
DEFINE ('DB_HOST', 'localhost');
DEFINE ('DB_NAME', 'pizzapi');

// and now actually connecting to database

$dbc = @mysqli_connect (DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) OR die ('Could not connect to MySQL: ' . mysqli_connect_error() );

?>