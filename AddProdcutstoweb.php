
//AddProductstoweb.php
//Registered products from database are sent to registration web page

<TABLE  id="table">
  <TR>
    <TH>ID.</TH>
    <TH>Product</TH>
    <TH>Price</TH>
    <TH>Amount</TH>
    <TH>CardID</TH>
  </TR>
<?php 
//Connect to database
require('connectDB.php');
$sql ="SELECT * FROM prodreg ORDER BY id DESC";
$result=mysqli_query($conn,$sql);
if (mysqli_num_rows($result) > 0)
{
  while ($row = mysqli_fetch_assoc($result))
    {
?>
   <TR>
      <TD><?php echo $row['id']?></TD>
      <TD><?php echo $row['Product']?></TD>
      <TD><?php echo $row['Price']?></TD>
      <TD><?php echo $row['Amount']?></TD>
      <TD><?php echo $row['CardID'];
          if ($row['CardID_select'] == 1) {
              echo '<img src="image/che.png" style="margin-right: 60%; float: right;" width="20" height="20" title="The selected Card">';
          }
          else{
              echo '';
          }?>
      </TD>
   </TR>
<?php   
    }
}
?>
</TABLE>

