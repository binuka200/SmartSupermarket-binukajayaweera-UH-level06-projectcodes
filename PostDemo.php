
//PostDemo.php
//Bill API

<?php
    //Connect to database
    require('connectDB.php');
    //Get current date and time
    date_default_timezone_set('Asia/Colombo');
    $d = date("Y-m-d");
    $t = date("H:i:sa");
if(!empty($_GET['CardID'])){
    $Card = $_GET['CardID'];
    $sql = "SELECT * FROM prodreg WHERE CardID=?";
    $result = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($result, $sql)) {
        echo "SQL_Error_Select_card";
        exit();
    }
    else{
        mysqli_stmt_bind_param($result, "s", $Card);
        mysqli_stmt_execute($result);
        $resultl = mysqli_stmt_get_result($result);
        if ($row = mysqli_fetch_assoc($resultl)){ 
            //An existing card has been detected 
            if (!empty($row['Product'])){
                $Prodcut = $row['Product'];
                $Number = $row['Price'];
                $sql = "SELECT * FROM bill WHERE CardNumber=? AND DateLog=CURDATE()";
                $result = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($result, $sql)) {
                    echo "SQL_Error_Select_bill";
                    exit();
                }
                else{
                    mysqli_stmt_bind_param($result, "s", $Card);
                    mysqli_stmt_execute($result);
                    $resultl = mysqli_stmt_get_result($result);
                    //*****************************************************
                        $sql = "INSERT INTO bill (CardNumber, Name, Price, DateLog, TimeIn) VALUES (? ,?, ?, CURDATE(), CURTIME())";
                        $result = mysqli_stmt_init($conn);
                        if (!mysqli_stmt_prepare($result, $sql)) {
                            echo "SQL_Error_Select_login1";
                            exit();
                        }
                        else{
                            mysqli_stmt_bind_param($result, "ssds", $Card, $Prodcut, $Price);
                            mysqli_stmt_execute($result);
                            exit();
                        }
                    }
                        $sql="UPDATE bill SET TimeIn=CURTIME() WHERE CardNumber=? AND DateLog=CURDATE()";
                        $result = mysqli_stmt_init($conn);
                        if (!mysqli_stmt_prepare($result, $sql)) {
                            echo "SQL_Error_insert";
                            exit();
                        }
                        else{
                            mysqli_stmt_bind_param($result, "sd", $Card);
                            mysqli_stmt_execute($result);
                            exit();
                        }
                    }
                }
            }
            //An available card has been detected
            else{
                $sql = "SELECT CardID_select FROM prodreg WHERE CardID_select=?";
                $result = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($result, $sql)) {
                    echo "SQL_Error_Select";
                    exit();
                }
                else{
                    $card_sel = 1;
                    mysqli_stmt_bind_param($result, "i", $card_sel);
                    mysqli_stmt_execute($result);
                    $resultl = mysqli_stmt_get_result($result);
                    if ($row = mysqli_fetch_assoc($resultl)) {
                        $sql="UPDATE prodreg SET CardID_select =?";
                        $result = mysqli_stmt_init($conn);
                        if (!mysqli_stmt_prepare($result, $sql)) {
                            echo "SQL_Error_insert";
                            exit();
                        }
                        else{
                            $card_sel = 0;
                            mysqli_stmt_bind_param($result, "i", $card_sel);
                            mysqli_stmt_execute($result);
                            $sql="UPDATE prodreg SET CardID_select =? WHERE CardID=?";
                            $result = mysqli_stmt_init($conn);
                            if (!mysqli_stmt_prepare($result, $sql)) {
                                echo "SQL_Error_insert_An_available_card";
                                exit();
                            }
                            else{
                                $card_sel = 1;
                                mysqli_stmt_bind_param($result, "is", $card_sel, $Card);
                                mysqli_stmt_execute($result);
                                echo "Cardavailable";
                                exit();
                            }
                        }
                    }
                    else{
                        $sql="UPDATE prodreg SET CardID_select =? WHERE CardID=?";
                        $result = mysqli_stmt_init($conn);
                        if (!mysqli_stmt_prepare($result, $sql)) {
                            echo "SQL_Error_insert_An_available_card";
                            exit();
                        }
                        else{
                            $card_sel = 1;
                            mysqli_stmt_bind_param($result, "is", $card_sel, $Card);
                            mysqli_stmt_execute($result);
                            echo "Cardavailable";
                            exit();
                        }
                    }
                } 
            }
        }
        //New card has been added
        else{
            $Prodcut = "";
            $Price = "";
            $Amount= "";
            $sql = "SELECT CardID_select FROM prodreg WHERE CardID_select=?";
            $result = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($result, $sql)) {
                echo "SQL_Error_Select";
                exit();
            }
            else{
                $card_sel = 1;
                mysqli_stmt_bind_param($result, "i", $card_sel);
                mysqli_stmt_execute($result);
                $resultl = mysqli_stmt_get_result($result);
                if ($row = mysqli_fetch_assoc($resultl)) {
                    $sql="UPDATE prodreg SET CardID_select =?";
                    $result = mysqli_stmt_init($conn);
                    if (!mysqli_stmt_prepare($result, $sql)) {
                        echo "SQL_Error_insert";
                        exit();
                    }
                    else{
                        $card_sel = 0;
                        mysqli_stmt_bind_param($result, "i", $card_sel);
                        mysqli_stmt_execute($result);
                        $sql = "INSERT INTO prodreg (Product , Price, Amount, CardID, CardID_select) VALUES (?, ?, ?, ?, ?)";
                        $result = mysqli_stmt_init($conn);
                        if (!mysqli_stmt_prepare($result, $sql)) {
                            echo "SQL_Error_Select_add";
                            exit();
                        }
                        else{
                            $card_sel = 1;
                            mysqli_stmt_bind_param($result, "sdssi", $Prodcut, $Price, $Amount, $Card, $card_sel);
                            mysqli_stmt_execute($result);
                            echo "succesful";
                            exit();
                        }
                    }
                }
                else{
                    $sql = "INSERT INTO prodreg (Product, Price, Amount, CardID, CardID_select) VALUES (?, ?, ?, ?, ?)";
                    $result = mysqli_stmt_init($conn);
                    if (!mysqli_stmt_prepare($result, $sql)) {
                        echo "SQL_Error_Select_add";
                        exit();
                    }
                    else{
                        $card_sel = 1;
                        mysqli_stmt_bind_param($result, "sdssi", $Prodcut, $Price, $Amount, $Card, $card_sel);
                        mysqli_stmt_execute($result);
                        echo "succesful";
                        exit();
                    }
                }
            } 
        }    
    }
}
//Empty Card ID
else{
    echo "Empty_Card_ID";
    exit();
}
mysqli_stmt_close($result);
mysqli_close($conn);
?>
