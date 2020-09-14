//Used for Android connection to Mysql Database to delete bill after payment
//Androiddelete.php
<?php
	require 'connectDB.php';
	$query1="DELETE FROM bill";
	mysqli_query($conn,$query1);

?>
