//LoadProdcuts.php
//Billed products will be sent from the database to the bill web interface

<TABLE id='table'>
<TR>
    <TH>ID.No</TH>
    <TH>Product</TH>
    <TH>CardID</TH>
    <TH>Price</TH>
    <TH>Date</TH>
    <TH>Time In</TH>
    
</TR>
<?php
session_start();
//Connect to database
require'connectDB.php';
$seldate = $_SESSION["exportdata"];
$sql = "SELECT * FROM bill WHERE DateLog='$seldate' ORDER BY id DESC";
$result=mysqli_query($conn,$sql);
if (mysqli_num_rows($result) > 0)
{
  while ($row = mysqli_fetch_assoc($result))
  {
?>
        <TR>
        <TD><?php echo $row['id'];?></TD>
        <TD><?php echo $row['Name'];?></TD>
        <TD><?php echo $row['CardNumber'];?></TD>
        <TD><?php echo $row['Price'];?></TD>
        <TD><?php echo $row['DateLog'];?></TD>
        <TD><?php echo $row['TimeIn'];?></TD>
        </TR>
<?php
  }
}
?>
</TABLE>
<p>
<?php
require'connectDB.php';
$query="select SUM(Price) as 'sums' from bill";
$res=mysqli_query($conn,$query);
$data=mysqli_fetch_array($res);
echo "Total :".$data['sums'];
?>
</p>
