
//Export.php
// Session exporting billed products from the database to Microsoft Excel

<?php
session_start();
    //Connect to database
    require'connectDB.php';

$output = '';
$outputdata = $_SESSION['exportdata'];

if(isset($_POST["export"])){

    $query = "SELECT * FROM bill WHERE DateLog='$outputdata' ";
    $result = mysqli_query($conn, $query);
    if($result->num_rows > 0){
        $output .= '
                    <table class="table" bordered="1">  
                      <TR>
                        <TH>ID.No</TH>
                        <TH>Name</TH>
                        <TH>CardID</TH>
                        <TH>Price</TH>
                        <TH>Date</TH>
                        <TH>Time In</TH>
                        
                      </TR>';

      while($row=$result->fetch_assoc()) {
          $output .= '
                      <TR> 
                          <TD> '.$row['id'].'</TD>
                          <TD> '.$row['Name'].'</TD>
                          <TD> '.$row['CardNumber'].'</TD>
                          <TD> '.$row['Price'].'</TD>
                          <TD> '.$row['DateLog'].'</TD>
                          <TD> '.$row['TimeIn'].'</TD>
                         
                      </TR>';
      }
      $output .= '</table>';
      header('Content-Type: application/xls');
      header('Content-Disposition: attachment; filename=Sold Products'.$outputdata.'.xls');
      echo $output;
    }
    else{
        header( "location: bill.php" );
    }
}
?>
