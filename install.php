Installing Tables to the database
<?php
 //Connection to database
 $servername = "localhost";
 $username = "root";		//phpmyadmin username.(default is "root")
 $password = "******";			// phpmyadmin password
 $dbname = "";
    
 $conn = new mysqli($servername, $username, $password, $dbname);

 // Create database
 $sql = "CREATE DATABASE NodeMCUlog";
 if ($conn->query($sql) === TRUE) {
	    echo "Database created successfully";
 } else {
	    echo "Error creating database: " . $conn->error;
	 }
 echo "<br>";
 $dbname = "NodeMCUlog";
 $conn = new mysqli($servername, $username, $password, $dbname); 
 
// sql to create table bill
 $sql = "CREATE TABLE IF NOT EXISTS `bill` (
  		`id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  		`CardNumber` double DEFAULT NULL,
  		`Name` varchar(30) DEFAULT NULL,
  		`Price` double NOT NULL,
  		`DateLog` date DEFAULT NULL,
  		`TimeIn` time DEFAULT NULL,
  		PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0";

 if ($conn->query($sql) === TRUE) {
	    echo "Table bill created successfully";
 } else {
	    echo "Error creating table: " . $conn->error;
	 }
// sql to create table prodreg(Product Registration)
 $sql = "CREATE TABLE IF NOT EXISTS ` prodreg ` (
 		`id` int(11) NOT NULL AUTO_INCREMENT,
 		`Product` varchar(100) NOT NULL,
 		`Price` double NOT NULL,
 		`Amount` varchar(100) NOT NULL,
 		`CardID` double NOT NULL,
 		`CardID_select` tinyint(1) NOT NULL,
 		PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0";
 if ($conn->query($sql) === TRUE) {
	    echo "Table prodreg created successfully";
 } else {
	    echo "Error creating table: " . $conn->error;
	 }
			
	$conn->close();
?>
