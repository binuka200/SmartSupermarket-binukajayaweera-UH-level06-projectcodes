//Product_Insert.PHP
//Registration API

<?php
session_start(); //Start session
//Connect to database
require 'connectDB.php';

//request method used is post
if ($_SERVER["REQUEST_METHOD"] == "POST"){
	
//If post request of Card 2 is received assignment of variables is described below
   if(isset($_POST['Card2'])) {

      $Prodcut = $_POST['Prodcut'];
      $Price = $_POST['Price'];
      $Amount= $_POST['Amount'];
	  
      //check if there are any selected cards
      $sql = "SELECT CardID FROM prodreg WHERE CardID_select=?";
      $result = mysqli_stmt_init($conn);
      if (!mysqli_stmt_prepare($result, $sql)) {
          header("location: AddProduct.php?error=SQL_Error");
          exit();
      }
      else{
		  
          //Select card and assign
          $card_sel = 1;
          mysqli_stmt_bind_param($result, "i", $card_sel);
          mysqli_stmt_execute($result);
          $resultl = mysqli_stmt_get_result($result);
          if ($row = mysqli_fetch_assoc($resultl)) {
              $sql = "SELECT Price FROM prodreg WHERE Price=?";
              $result = mysqli_stmt_init($conn);
              if (!mysqli_stmt_prepare($result, $sql)) {
                  header("location: AddProduct.php?error=SQL_Error");
                  exit();
              }
              else{
                  mysqli_stmt_bind_param($result, "d", $Number);
                  mysqli_stmt_execute($result);
                  $resultl = mysqli_stmt_get_result($result);
                  if (!$row = mysqli_fetch_assoc($resultl)) {
                      //Add the product into the database
                    $sql = "UPDATE prodreg SET Product=?, Price=?, Amount=? WHERE CardID_select=?";
                    $result = mysqli_stmt_init($conn);
                    if (!mysqli_stmt_prepare($result, $sql)) {
                     header("location: AddProduct.php?error=SQL_Error");
                     exit();
                      }
                      else{
                          $card_sel = 1;
                          mysqli_stmt_bind_param($result, "sdsi", $Prodcut, $Price, $Amount, $card_sel);
                          mysqli_stmt_execute($result);
                          header("location: AddProduct.php?success=registerd");
                          exit();
                      }
                  }
                  //If product already exists
                  else{
                      header("location: AddProduct.php?error=Nu_Exist");
                      exit();
                  }
              }
          }
          //there is no selected card to add
          else{
              header("location: AddProduct.php?error=No_SelID");
              exit();
          }
      }
  }
//If post request of update is received 
  if (isset($_POST['update'])) {
        
      $Prodcut = $_POST['Prodcut'];
      $Price = $_POST['Price'];
      $Amount= $_POST['Amount'];
      
      $sql = "SELECT CardID FROM prodreg WHERE CardID_select=?";
      $result = mysqli_stmt_init($conn);
      if (!mysqli_stmt_prepare($result, $sql)) {
          header("location: AddProduct.php?error=SQL_Error");
          exit();
      }
      else{
          $card_sel = 1;
          mysqli_stmt_bind_param($result, "i", $card_sel);
          mysqli_stmt_execute($result);
          $resultl = mysqli_stmt_get_result($result);
          if ($row = mysqli_fetch_assoc($resultl)) {
              $sql = "SELECT Price FROM prodreg WHERE Price=?";
              $result = mysqli_stmt_init($conn);
              if (!mysqli_stmt_prepare($result, $sql)) {
                  header("location: AddProduct.php?error=SQL_Error");
                  exit();
              }
              else{
                  mysqli_stmt_bind_param($result, "d", $Number);
                  mysqli_stmt_execute($result);
                  $resultl = mysqli_stmt_get_result($result);
                  if (!$row = mysqli_fetch_assoc($resultl)) {
                      //Add the product into the database
                      $sql = "UPDATE prodreg SET Product=?, Price=?, Amount=? WHERE CardID_select=?";
                      $result = mysqli_stmt_init($conn);
                      if (!mysqli_stmt_prepare($result, $sql)) {
                          header("location: AddProduct.php?error=SQL_Error");
                          exit();
                      }
                      else{
                          mysqli_stmt_bind_param($result, "sdsi", $Prodcut, $Price, $Amount, $card_sel);
                          mysqli_stmt_execute($result);
                          header("location: AddProduct.php?success=Updated");
                          exit();
                      }
                  }
                  //If the product already exist
                  else{
                      header("location: AddProduct.php?error=Nu_Exist");
                      exit();
                  }
              }
          }
          else{
              header("location: AddProduct.php?error=No_SelID");
              exit();
          }
      }
  }

//If Post request of delete(del) is received
    if(isset($_POST['del']))  {
        if (!empty($_POST['CardID'])) {
            $CardID = $_POST['CardID'];
            $sql = "SELECT CardID FROM prodreg WHERE CardID=?";
            $result = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($result, $sql)) {
                header("location: AddProduct.php?error=SQL_Error");
                exit();
            }
            else{
                mysqli_stmt_bind_param($result, "s", $CardID);
                mysqli_stmt_execute($result);
                $resultl = mysqli_stmt_get_result($result);
                if ($row = mysqli_fetch_assoc($resultl)) {

                    $sql ="DELETE FROM prodreg WHERE CardID=?";
                    $result = mysqli_stmt_init($conn);
                    if ( !mysqli_stmt_prepare($result, $sql)){
                        header("location: AddProduct.php?error=sqlerror");
                        exit();
                    }
                    else{
                        mysqli_stmt_bind_param($result, "s", $CardID);
                        mysqli_stmt_execute($result);
                        header("location: AddProduct.php?success=deleted");
                        exit();
                    }
                }
                else{
                    header("location: AddProduct.php?error=No_ExID");
                    exit();
                }
            }
        }
        else{
            header("location: AddProduct.php?error=No_SelID");
            exit();
        }
    }

//If Post request of set is received
    if(isset($_POST['set'])) {
        if (!empty($_POST['CardID'])) {         
            $CardID = $_POST['CardID'];
            $sql = "SELECT CardID FROM prodreg WHERE CardID=?";
            $result = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($result, $sql)) {
                header("location: AddProduct.php?error=SQL_Error");
                exit();
            }
            else{
                mysqli_stmt_bind_param($result, "s", $CardID);
                mysqli_stmt_execute($result);
                $resultl = mysqli_stmt_get_result($result);
                if ($row = mysqli_fetch_assoc($resultl)) {
                    $sql = "SELECT CardID_select FROM prodreg WHERE CardID_select=?";
                    $result = mysqli_stmt_init($conn);
                    if (!mysqli_stmt_prepare($result, $sql)) {
                        header("location: AddProduct.php?error=SQL_Error");
                        exit();
                    }
                    else{
                        $card_sel = 1;
                        mysqli_stmt_bind_param($result, "i", $card_sel);
                        mysqli_stmt_execute($result);
                        $resultl = mysqli_stmt_get_result($result);
                        if ($row = mysqli_fetch_assoc($resultl)) {
                            $sql = "UPDATE prodreg SET CardID_select=?";
                            $result = mysqli_stmt_init($conn);
                            if (!mysqli_stmt_prepare($result, $sql)) {
                                header("location: AddProduct.php?error=SQL_Error");
                                exit();
                            }
                            else{
                                $card_sel = 0;
                                mysqli_stmt_bind_param($result, "i", $card_sel);
                                mysqli_stmt_execute($result);
                                $sql = "UPDATE prodreg SET CardID_select=? WHERE CardID=?";
                                $result = mysqli_stmt_init($conn);
                                if (!mysqli_stmt_prepare($result, $sql)) {
                                    header("location: AddProduct.php?error=SQL_Error");
                                    exit();
                                }
                                else{
                                    $card_sel = 1;
                                    mysqli_stmt_bind_param($result, "is", $card_sel, $CardID);
                                    mysqli_stmt_execute($result);
                                    header("location: AddProduct.php?success=Selected");
                                    exit();
                                }
                            }
                        }
                        else{
                            $sql = "UPDATE prodreg SET CardID_select=? WHERE CardID=?";
                            $result = mysqli_stmt_init($conn);
                            if (!mysqli_stmt_prepare($result, $sql)) {
                                header("location: AddProduct.php?error=SQL_Error");
                                exit();
                            }
                            else{
                                $card_sel = 1;
                                mysqli_stmt_bind_param($result, "is", $card_sel, $CardID);
                                mysqli_stmt_execute($result);
                                header("location: AddProduct.php?success=Selected");
                                exit();
                            }
                        }
                    }    
                }
                else{
                    header("location: AddProduct.php?error=No_ExID");
                    exit();
                }
            }
        }
        else{
            header("location: AddProduct.php?error=No_SelID");
            exit();
        }
    }
}
?>
