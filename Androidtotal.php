
//Used for Android connection to Mysql Database to display total
//Androidtotal.php

<?php
/* Database connection settings */
	$servername = "localhost";
    $username = "root";		// phpmyadmin username.(default is "root")
    $password = "*****";	// phpmyadmin password 
    $dbname = "NodeMCUlog";
	$conn = new mysqli($servername, $username, $password, $dbname);
	global $conn;
	if ($conn->connect_error) {
        die("Database Connection failed: " . $conn->connect_error);
    }
	$query1="select SUM(Price) as 'sums' from bill";
	$res=mysqli_query($conn,$query1);
	$data1=mysqli_fetch_assoc($res);
	$sum=$data1['sums'];
	if($query1)
	{
		$data[]['sums'] = $sum;
		$result1 = array("total" => $data);
		echo json_encode($result1);
	}
	mysqli_close($conn);
?>
