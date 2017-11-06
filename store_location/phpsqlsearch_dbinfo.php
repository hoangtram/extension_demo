<?php
	$host = "127.0.0.1";
	$user = "root";
	$port = 3306;
	$pass = "";
	$db = "store_location";
	$con = mysqli_connect($host, $user, $pass, $db, $port) or die("can't connect database");
	mysqli_set_charset($con, "UTF8");
?>