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
    echo "<script>location='../PHP/products.php'</script>";
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
            html{
                height:100vh;
            }
            .productdetails{
                width:clamp(600px,1400px,1600px);
                height:100%;
                margin:auto;
                display:flex;
            }

            .tknameword b{
                font-family:Helvetica;
                font-size:3em;
                position:absolute;
                color:black;
                margin-top: 30px;
                margin-left: 20px;
                text-shadow: 4px 3px 2px rgba(20,20,20,0.1);
                font-family:Raleway;
            }

            .productimg{
                width:500px;
                height:500px;
                margin-top:120px;
                background-color:rgba(240,240,240,0.4);
            }

            .detailsword{
                font-family:Calibri;
                font-size:2.3em;
                margin-top:140px;
                margin-left: 40px;
                width:800px;

            }

            .submit{
                text-align:center;
                margin-top:30px;
                width:100%;
                

            }

            /* CSS */
            .submitbtn {
                background-color: #FFFFFF;
                border: 1px solid rgb(209,213,219);
                border-radius: .5rem;
                box-sizing: border-box;
                color: #111827;
                font-family: "Inter var",ui-sans-serif,system-ui,-apple-system,system-ui,"Segoe UI",Roboto,"Helvetica Neue",Arial,"Noto Sans",sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol","Noto Color Emoji";
                font-size: .875rem;
                font-weight: 600;
                line-height: 1.25rem;
                padding: .75rem 1rem;
                text-align: center;
                text-decoration: none #D1D5DB solid;
                text-decoration-thickness: auto;
                box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
                cursor: pointer;
                user-select: none;
                -webkit-user-select: none;
                touch-action: manipulation;
                margin-top: 40px;
                width:800px;
            }

            .submitbtn:hover {
                background-color: rgb(249,250,251);
            }

            .submitbtn:focus {
                outline: 2px solid transparent;
                outline-offset: 2px;
            }

            .submitbtn:focus-visible {
                box-shadow: none;
            }

            .qtyInput{
                width:800px;
                margin-left: 40px;
                display:flex;
                align-items: left;
            }
            .qtyInput b{
                font-family:Calibri;
                font-size:2.3em;
            }
            .qtyInput input{
                text-align: center;
                background-color:rgba(240,240,240,0.4);
                border:2px solid rgba(200,200,200,0.8);
            }

        </style>

    </head>

    <body>

        <?php
        include('../PHP/header.php');
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
        
        <img src='https://tarumtbucket2305835.s3.amazonaws.com/{$imagename[$y][$i]}' class='productimg' id='pdimg'/>
        <div class='innerContainer'>    
        <div class='detailsword' style='padding:10px;'>
        <div class='cat' style='margin-bottom:25px;' id='catname'><b>Product Categories : </b><span style='margin-left:20px;'> {$catname[$y][$i]}</span></div>
        <div class='price' style='margin-bottom:5px;' ><b>Price<span style='margin-left:213px;'> :</span> </b><span style='margin-left:20px;'>RM {$ticketprice[$y][$i]}</span></div>
        <div class='details' style='margin-bottom:5px;margin-top:20px;line-height:80px;' id='details'><b>Details :</b> <br/>&nbsp - {$ticketdetails[$y][$i]} <br/>
        </div>
        </div>
        <form action='' method='post' class='submit'>
        <input type='hidden' value='{$productid[$y][$i]}' name='hiddenID' />
        <div class='qtyInput'>
        <b>&nbsp Quantity: &nbsp;</b>
        <input type='number' id='qty' name='qty' value='1' min='1' max='100' style='width:100px;font-size:1.6em;margin-right:30px;'/>
        <br/>
        </div>
        <button type='submit' onclick='return addtocart()' id='submitbtn' class='submitbtn'>ADD TO CART</button>
        </form>
        </div>
        </div>";
        $index = $i;
        $catindex = $y;
        ?>

        <?php
        if (isset($_POST["qty"])) {
            if ($index >= 0) {


                $i = $index;
                $y = $catindex;
                $hiddenID = $_POST["hiddenID"];
                $name = $ticketname[$y][$i];
                $image = $imagename[$y][$i];
                $price = $ticketprice[$y][$i];
                $qty = (int) $_POST["qty"];


                if (!isset($_SESSION["cart"])) {
                    echo " | no session exist,now created";
                    $_SESSION["cart"] = array();
                }
                $newItem = array(
                    "hiddenID" => $hiddenID,
                    "Image" => $image,
                    "Name" => $name,
                    "Price" => $price,
                    "Qty" => $qty,
                    "IndexI" => $i,
                    "IndexY" => $y
                );

                // check if the ticket already exists in the cart
                $found = false;

                // Loop through existing cart items to check if the same ticket for the same date already exists
                foreach ($_SESSION["cart"] as $key => $item) {
                    if ($item["hiddenID"] === $newItem["hiddenID"]) {
                        $_SESSION["cart"][$key]["Qty"] += $newItem["Qty"];
                        $found = true;
                        break;
                    }
                }
                // If the ticket doesn't exist in the cart, add it as a new item
                if (!$found) {
                    $_SESSION["cart"][] = $newItem;
                }

            }
            echo "<script>location='../PHP/cart.php'</script>";
        }
        ?>

    </body>

</html>