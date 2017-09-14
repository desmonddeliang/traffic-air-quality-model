<?php 
	session_start();
	if($_GET["graphopt"]){
		$_SESSION['graphopt'] = $_GET["graphopt"];	
	}
	header('location: ../');