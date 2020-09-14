//USed for Android Connection to bill through web server and database
//Androidbill.php

<?php
/* Database connection settings */
$servername = "localhost";
$username = "root";		// phpmyadmin username.(default is "root")
$password = "binuka1998";			// phpmyadmin password
$dbname = "NodeMCUlog";
$conn = new mysqli($servername, $username, $password, $dbname);
global $conn;
if ($conn->connect_error) {
        die("Database Connection failed: " . $conn->connect_error);
    }
$response = array();	
$query = "select * from bill";	
$result = mysqli_query($conn, $query);
	if(mysqli_num_rows($result) > 0) {
		$response['success'] = 1;
		$bill = array();
		while ($row = mysqli_fetch_assoc($result)){
			array_push($bill, $row);
		}
		$response['bill'] = $bill;
	}
	else {
		$response['success'] = 0;
		$response['message'] = 'No data';
	}
	echo json_encode($response);
	mysqli_close($conn);	
?>
