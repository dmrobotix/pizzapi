<?php
/*
 * PizzaPi Customer front end
 * Order Page
 * Copyright V. Margot Paez, 2015. All rights reserved.
 */
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
		<title>PizzaPi: Place an Order</title>
		<script src="js/jquery-2.1.4.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/pizzapi.js"></script>
		<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="css/pizzapi.css">
	</head>
	
	<body>
		
		<nav class="navbar-inverse navbar-default">
		  <div class="container-fluid">
		    <!-- Brand and toggle get grouped for better mobile display -->
		    <div class="navbar-header">
		      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-options" aria-expanded="false">
		        <span class="sr-only">Toggle navigation</span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		      </button>
		      <a class="navbar-brand" href="#"><strong><span class="logo"><span class="logo-color">Pizza</span>Pi</span></strong></a>
		    </div>
		
		    <!-- Collect the nav links, forms, and other content for toggling -->
		    <div class="collapse navbar-collapse" id="navbar-options">
		      <ul class="nav navbar-nav">
		      	<li id="dash" class="active"><a href="#">Dashboard</a></li>
		        <li id="monitor"><a href="#">All Orders</a></li>
		        <li id="data"><a href="#">Data</a></li>
		      </ul>
		    </div><!-- /.navbar-collapse -->    
		  </div><!-- /.container-fluid -->
		</nav>
		
		<div class="container-fluid">
			<div class="content"></div>
		</div>
		<!-- /container-fluid -->
		
	</body>
</html>