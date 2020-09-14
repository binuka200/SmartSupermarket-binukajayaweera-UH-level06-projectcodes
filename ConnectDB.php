//Connection to Database

<?php
	/* Database connection settings */
	$servername = "localhost";
	$username = "root";		//phpmyadmin username.(default is "root")
	$password = "binuka1998";	//phpmyadmin password 
	$dbname = "NodeMCUlog";       //Database Name
    
	$conn = new mysqli($servername, $username, $password, $dbname);  // Connect Database to Server
	
	global $conn;   // Global Variable conn
	
	//If error present display database connection has failed
	if ($conn->connect_error) {                     
            die("Database Connection failed: " . $conn->connect_error); 
        }
?>
