<?php
// MUST be the very first thing in the file — no output above this

if (isset($_COOKIE['id']) && $_COOKIE['id'] !== '') {
    $id = $_COOKIE['id'];
} else {
    $id = "Guest";
}

// Set session ID BEFORE starting the session
session_id($id);
session_start();

// Check if redirected from a submit
if (!isset($_GET["submitbtn"])) {
    echo "<script>location='products.php'</script>";
    exit;
}

// Define global vars
global $i, $count, $ticketcat, $y;
$i = 0;
$count = 0;
$y = 0;
?>
<!--SA Details page-->
<?php
require_once("../secret/helper.php");

$con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($con->connect_error) {
    die("DB CONNECTION FAILED" . $con->connect_error);
}

$sql = ("SELECT productid,ticketname,imagename,ticketprice,ticketdesc,ticketcat FROM ticket WHERE ticketcat='SA';");
$result = $con->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_object()) {
        $productid[1][] = $row->productid;
        $ticketname[1][] = $row->ticketname;
        $imagename[1][] = $row->imagename;
        $ticketprice[1][] = $row->ticketprice;
        $ticketdetails[1][] = $row->ticketdesc;
        $catname[1][] = $row->ticketcat;
        $count++;
    }
}

$result->free();
$con->close();
?>
<!--PA-->
<?php
require_once("../secret/helper.php");

$con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($con->connect_error) {
    die("DB CONNECTION FAILED" . $con->connect_error);
}

$sql = ("SELECT productid,ticketname,imagename,ticketprice,ticketdesc,ticketcat FROM ticket WHERE ticketcat='PA';");
$result = $con->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_object()) {
        $productid[2][] = $row->productid;
        $ticketname[2][] = $row->ticketname;
        $imagename[2][] = $row->imagename;
        $ticketprice[2][] = $row->ticketprice;
        $ticketdetails[2][] = $row->ticketdesc;
        $catname[2][] = $row->ticketcat;
        $count++;
    }
}

$result->free();
$con->close();
?>
<!--IA-->
<?php
require_once("../secret/helper.php");

$con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($con->connect_error) {
    die("DB CONNECTION FAILED" . $con->connect_error);
}

$sql = ("SELECT productid,ticketname,imagename,ticketprice,ticketdesc,ticketcat FROM ticket WHERE ticketcat='IA';");
$result = $con->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_object()) {
        $productid[3][] = $row->productid;
        $ticketname[3][] = $row->ticketname;
        $imagename[3][] = $row->imagename;
        $ticketprice[3][] = $row->ticketprice;
        $ticketdetails[3][] = $row->ticketdesc;
        $catname[3][] = $row->ticketcat;
        $count++;
    }
}

$result->free();
$con->close();
?>

<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <style>
            .productdetails{
                width:clamp(600px,1400px,1600px);
                height:100%;
                margin:auto;
            }

            .tknameword b{
                font-family:Helvetica;
                font-size:3em;
                margin:30px;
                margin-left:535px;
                position:absolute;
                color:#8E1300;
            }

            .productimg{
                width:800px;
                height:240px;
                margin-top:90px;
                margin-left:300px;
            }

            .detailsword{
                font-family:Calibri;
                font-size:2.3em;
                margin-top:20px;
                margin-left:380px;

            }

            .submit{
                text-align:center;
                margin-top:30px;
                width:100%;
                height:100%;

            }

            .submitbtn{
                transition:0.5s linear;
                border-radius:10px;
                cursor:pointer;
                font-size:1.2em;
                height:35px;
                width:150px;
                margin-top: 30px;
            }

            .submitbtn:hover{
                border-radius:25px;
                box-shadow: #EEEEEE 0px 14px 28px, #EEEEEE 0px 10px 10px;
            }

        </style>

    </head>

    <body>

        <?php
        include('header.php');
        ?>

        <?php
        $ticketcat = $_GET["ticketcat"];
        $i = $_GET["index"];

        if ($ticketcat == 'SA') {
            $y = 1;
        } else if ($ticketcat == 'PA') {
            $y = 2;
        } else if ($ticketcat == 'IA') {
            $y = 3;
        }

        if ($catname[$y][$i] == "PA") {
            $catname[$y][$i] = "Package Access";
        } else if ($catname[$y][$i] == "SA") {
            $catname[$y][$i] = "Spot Access";
        } else if ($catname[$y][$i] == "IA") {
            $catname[$y][$i] = "Individual Access";
        }
        echo"<div class='productdetails'>
        <div class='tknameword'><b id='ticketname'>{$ticketname[$y][$i]}</b></div><br/>
        <img src='../IMAGE/{$imagename[$y][$i]}' class='productimg' id='pdimg'/>
        <div class='detailsword' style='padding:10px;'>
        <div class='cat' style='margin-bottom:25px;' id='catname'><b>Product Categories : </b><span style='margin-left:20px;'> {$catname[$y][$i]}</span></div>
        <div class='price' style='margin-bottom:5px;' ><b>Price<span style='margin-left:213px;'> :</span> </b><span style='margin-left:20px;'>RM {$ticketprice[$y][$i]}</span></div>
        <div class='details' style='margin-bottom:5px;margin-top:20px;' id='details'><b>Details</b> <br/>&nbsp - {$ticketdetails[$y][$i]} <br/>
        </div>
        </div>
        <form action='' method='post' class='submit'>
        <input type='hidden' value='{$productid[$y][$i]}' name='hiddenID' />
        Date: 
        <input type='date' id='bookdate' name='bookdate' style='font-size:1.6em;margin-right:30px;'/>
        Quantity: 
        <input type='number' id='qty' name='qty' value='1' min='1' max='100' style='width:100px;font-size:1.6em;margin-right:30px;'/>
        <br/>
        <button type='submit' onclick='return addtocart()' id='submitbtn' class='submitbtn'>ADD TO CART</button>
        </form>
        </div>";
        $index = $i;
        $catindex = $y;
        ?>

        <?php
        if (isset($_POST["bookdate"])) {
            if ($index >= 0) {
                

                $i = $index;
                $y = $catindex;
                $date = $_POST["bookdate"];
                $hiddenID = $_POST["hiddenID"];
                $name = $ticketname[$y][$i];
                $image = $imagename[$y][$i];
                $price = $ticketprice[$y][$i];
                $qty = (int) $_POST["qty"];

                echo $hiddenID;
                echo $date;
                echo $qty;
                echo $price;
                echo "<pre>";
                print_r($_SESSION);
                echo "</pre>";
                if (!isset($_SESSION["cart"])) {
                    echo " | no session exist,now created";
                    $_SESSION["cart"] = array();
                }
                $newItem  = array(
                    "hiddenID" => $hiddenID,
                    "Image" => $image,
                    "Name" => $name,
                    "Price" => $price,
                    "Date" => $date,
                    "Qty" => $qty,
                    "IndexI" => $i,
                    "IndexY" => $y
                );
                
                // check if the ticket already exists in the cart
                $found = false;

                // Loop through existing cart items to check if the same ticket for the same date already exists
                foreach ($_SESSION["cart"] as $key => $item) {
                    if ($item["hiddenID"] === $newItem["hiddenID"]) {
                        if($_SESSION["cart"][$key]["Date"] === $newItem["Date"]){
                            $_SESSION["cart"][$key]["Qty"] += $newItem["Qty"];
                            $found = true;
                            break;
                        }
                    }
                }
                // If the ticket doesn't exist in the cart, add it as a new item
                if (!$found) {
                    $_SESSION["cart"][] = $newItem;
                }
                echo "<pre>";
                print_r($_SESSION);
                echo "</pre>";
 
            }
        }
        ?>

    </body>
    <script>
        function addtocart() {
            var date = document.getElementById("bookdate").value;
            var qty = document.getElementById("qty").value;

            if (date === "") {
                event.preventDefault();
                alert('Please select ticket date !');
                return false;
            } else {
                if (qty > 100) {

                } else {
                    alert('Done Add to Cart');
                }
            }
        }
    </script>
</html>