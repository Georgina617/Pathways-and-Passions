<?php 
$host ="localhost";
$database="phpbeginner";
$user = "root";
$password = "Georgina@24";

//connecting to my sql database
$connection = mysqli_connect($host, $user, $password, $database)or die("Connection failed: " . mysqli_connect_error());