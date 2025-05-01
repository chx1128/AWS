<?php

if (isset($_COOKIE['id'])) {
    $id=$_COOKIE['id'];
    //echo"$id";
}
else{
    $id="";
}
session_id($id);
session_start();
// Function to calculate total price
function calculateTotalPrice($cart) {
    $totalPrice = 0;
    foreach ($cart as $item) {
        $totalPrice += $item["Price"] * $item["Qty"];
    }
    return $totalPrice;
}

// Check if the cart session variable is set and not empty
if (isset($_SESSION["cart"]) && !empty($_SESSION["cart"])) {
    // Calculate total price
    $totalPrice = calculateTotalPrice($_SESSION["cart"]);

    // Store total price into session variable
    $_SESSION["totalPrice"] = $totalPrice;
} else {
    // If cart is empty or not set, set total price to 0
    $_SESSION["totalPrice"] = 0;
}
?>
<?php
if (isset($_GET["deleteCartItemName"])) {
    $deleteName = $_GET["deleteCartItemName"];
} else {
    $deleteName = '';
}

if (isset($_GET["deleteCartItemDate"])) {
    $deleteDate = $_GET["deleteCartItemDate"];
} else {
    $deleteDate = '';
}

if (isset($_SESSION["cart"])) {
    foreach ($_SESSION["cart"] as $key => $value) {
        if ($value["Name"] == $deleteName && $value["Date"] == $deleteDate) {
            $deletedItemPrice = $value["Price"] * $value["Qty"];
            unset($_SESSION["cart"][$key]);
            $_SESSION["totalPrice"] -= $deletedItemPrice;
        }
    }
}
?>
<?PHP
global $count1, $count2, $count3;
$count1 = 0;
$count2 = 0;
$count3 = 0;
?>
<!--Retrieve 1st set ticket-->
<?php
require_once("../secret/helper.php");

$con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($con->connect_error) {
    die("DB CONNECTION FAILED" . $con->connect_error);
}

$sql = "SELECT productid,ticketname,imagename,ticketprice,ticketstatus,ticketcat from ticket WHERE ticketcat='SA' AND ticketstatus='A' ORDER BY productid;";
$result = $con->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_object()) {
        $productid1[$count1] = $row->productid;
        $ticketname1[$count1] = $row->ticketname;
        $imagename1[$count1] = $row->imagename;
        $ticketprice1[$count1] = $row->ticketprice;
        $ticketstatus1[$count1] = $row->ticketstatus;
        $ticketcat1[$count1] = $row->ticketcat;
        $count1++;
    }
} else {
    echo"NO RECORD FOUNDED";
}

$result->free();
$con->close();
?>
<!--Retrieve 2nd set ticket-->
<?php
require_once("../secret/helper.php");

$con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($con->connect_error) {
    die("DB CONNECTION FAILED" . $con->connect_error);
}

$sql = "SELECT productid,ticketname,imagename,ticketprice,ticketstatus,ticketcat from ticket WHERE ticketcat='PA' AND ticketstatus='A' ORDER BY productid;";
$result = $con->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_object()) {
        $productid2[$count2] = $row->productid;
        $ticketname2[$count2] = $row->ticketname;
        $imagename2[$count2] = $row->imagename;
        $ticketprice2[$count2] = $row->ticketprice;
        $ticketstatus2[$count2] = $row->ticketstatus;
        $ticketcat2[$count2] = $row->ticketcat;
        $count2++;
    }
} else {
    echo"NO RECORD FOUNDED";
}

$result->free();
$con->close();
?>

<!--Retrieve 3rd set ticket-->
<?php
require_once("../secret/helper.php");

$con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($con->connect_error) {
    die("DB CONNECTION FAILED" . $con->connect_error);
}

$sql = "SELECT productid,ticketname,imagename,ticketprice,ticketstatus,ticketcat from ticket WHERE ticketcat='IA' AND ticketstatus='A' ORDER BY productid;";
$result = $con->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_object()) {
        $productid3[$count3] = $row->productid;
        $ticketname3[$count3] = $row->ticketname;
        $imagename3[$count3] = $row->imagename;
        $ticketprice3[$count3] = $row->ticketprice;
        $ticketstatus3[$count3] = $row->ticketstatus;
        $ticketcat3[$count3] = $row->ticketcat;
        $count3++;
    }
} else {
    echo"NO RECORD FOUNDED";
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
        <title>PRODUCTS PAGE</title>
        <script src="../JS/jquery-1.9.1.js" type="text/javascript"></script>
        <style>
            /*
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Other/CascadeStyleSheet.css to edit this template
            */
            *{
                margin: 0px;
                padding:0px;
            }
            header {
                background-color: white;
                width: 50px;
                margin-left: 70%;
                margin-top: 2%;
                transition: transform 0.5s ease;
            }
            html{
                max-width: 1550px;
                margin:auto;
            }
            .categories{
                width:100%;
                height:50px;
                border:1px solid transparent;
                margin-top:60px;
                margin-left:-60px;
                margin-bottom:-10px;
                font-family:Raleway;
                font-size:2.5em;
                color:black ;
                transition: transform 0.5s ease;
                text-shadow: 4px 3px 2px rgba(0,0,0,0.16);
            }

            .ticket{
                background-color:white;
                width:90%;
                height:100%;
                display:flex;
                flex-wrap: wrap;
                justify-content:space-around;
                border:1px solid transparent;
                margin:auto;
                margin-top: 20px;
                margin-bottom: 200px;
                transition: transform 0.5s ease;
                font-family:Helvetica,monospace;
            }

            .ticketwrap{
                width:300px;
                height:400px;
                border:2px solid rgba(200,200,200,0.5);
                box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;
                margin-top: 50px;
                border-radius:8px;
                padding-bottom:50px;
            }

            .ticketclass{
                width:300px;
                height:300px;
                margin: 10px 0px;
                margin-top: 0px;
                background-color:rgba(240,240,240,0.4);
            }

            .naviblur{
                width: 1418px;
                height: 90px;
                display: flex;
                background-color:#00032E;
                position:sticky;
                top:7px;
            }

            .ticket .ticketwrap button{
                background-color: #00032E;
                color: white;
                padding: 10px 10px;
                border-radius: 20px;
                margin-top: 10px;
                border: none;
                cursor: pointer;
            }

            .chatbot{
                transition: transform 0.5s;
            }

            .chatbot img{
                position:fixed;
                bottom:0px;
                right:0px;
                width:100px;
                height:100px;
                margin-bottom: 60px;
                margin-right:48px;
                z-index:50;
            }

            .chatbot img:hover{
                transform:scale(1.1);
            }

        </style>
    </head>
    <body>
        <?php
        include('../PHP/header.php');
        ?>

        <div class="ticket">
            <?php
            echo"<div class='categories' style='margin-top:20px'>
            <div class='catclass1'>
            <b style='text-decoration:none;'>GRADUATION SHORTS &nbsp
            </b></div>
            </div>    
            ";
//first cat products
            for ($x = 0; $x < $count1; $x++) {
                echo"<script>";
                echo"
                if($ticketstatus1$x == 'N'){
                    var ticketwrap=document.getElementById('ticketwrap'+$x);
                    ticketwrap.style.display='none';
                }
                
                else if($ticketstatus1$x == 'A'){
                    var ticketwrap=document.getElementById('ticketwrap'+$x);
                    ticketwrap.style.display='block';
                }
                ";
                echo"</script>";

                if ($ticketstatus1[$x] == 'A') {
                    echo"<div class='ticketwrap' id='ticketwrap$x'>
            <form action='../PHP/details.php' method='get'>
            <img src='https://tarumtbucket2305835.s3.amazonaws.com/$imagename1[$x]' class='ticketclass' alt='Product details'/>
            <div class='word'>
            <div class='wordclass'><b>$ticketname1[$x]</b></div>
            <div class='ticketprice' style='margin-top:3px;'>RM $ticketprice1[$x]</div>
            <input type='hidden' name='ticketcat' value='$ticketcat1[$x]'/>
            <input type='hidden' name='index' value='$x'/>
            <button name='submitbtn' type='submit' style='font-size:0.8em;margin-left:100px;' id='submitbtn' onclick='details($x)'>view details</button>
            </form> 
            </div></div>
            ";
                } else if ($ticketstatus1[$x] == 'N') {
                    //display nothing
                }
            }

//second cat products
            echo"<div class='categories'>
            <div class='catclass2'>
            <b style='text-decoration:none;'>GRADUATION JACKET &nbsp
            </b></div>
            </div>    
            ";

            for ($x = 0; $x < $count2; $x++) {
                echo"<script>";
                echo"
                if($ticketstatus2$x == 'N'){
                    var ticketwrap=document.getElementById('ticketwrap'+$x);
                    ticketwrap.style.display='none';
                }
                
                else if($ticketstatus2$x == 'A'){
                    var ticketwrap=document.getElementById('ticketwrap'+$x);
                    ticketwrap.style.display='block';
                }
                ";
                echo"</script>";
                if ($ticketstatus2[$x] == 'A') {
                    echo"<div class='ticketwrap'>
            <form action='../PHP/details.php' method='get'>
            <img src='https://tarumtbucket2305835.s3.amazonaws.com/$imagename2[$x]' class='ticketclass' alt='Product details'/>
            <div class='word'>
            <div class='wordclass'><b>$ticketname2[$x]</b></div>
            <div class='ticketprice' style='margin-top:3px;'>RM $ticketprice2[$x]</div>
            <input type='hidden' name='ticketcat' value='$ticketcat2[$x]'/>
            <input type='hidden' name='index' value='$x'/>
            <button name='submitbtn' type='submit' style='font-size:0.8em;margin-left:100px;' id='submitbtn' onclick='details($x)'>view details</button>
            </form> 
            </div></div>
            ";
                } else if ($ticketstatus1[$x] == 'N') {
                    //display nothing
                }
            }

//third cat products
            echo"<div class='categories'>
            <div class='catclass3'>
            <b style='text-decoration:none;'>GRADUATION TEE &nbsp
            </b></div>
            </div>    
            ";

            for ($x = 0; $x < $count3; $x++) {
                echo"<script>";
                echo"
                if($ticketstatus3$x == 'N'){
                    var ticketwrap=document.getElementById('ticketwrap'+$x);
                    ticketwrap.style.display='none';
                }
                
                else if($ticketstatus3$x == 'A'){
                    var ticketwrap=document.getElementById('ticketwrap'+$x);
                    ticketwrap.style.display='block';
                }
                ";
                echo"</script>";

                if ($ticketstatus3[$x] == 'A') {
                    echo"<div class='ticketwrap'>
            <form action='../PHP/details.php' method='get'>
            <img src='https://tarumtbucket2305835.s3.amazonaws.com/$imagename3[$x]' class='ticketclass' alt='Product details'/>
            <div class='word'>
            <div class='wordclass'><b>$ticketname3[$x]</b></div>
            <div class='ticketprice' style='margin-top:3px;'>RM $ticketprice3[$x]</div>
            <input type='hidden' name='ticketcat' value='$ticketcat3[$x]'/>
            <input type='hidden' name='index' value='$x'/>
            <button name='submitbtn' type='submit' style='font-size:0.8em;margin-left:100px;' id='submitbtn' onclick='details($x)'>view details</button>
            </form> 
            </div></div>
            ";
                }

                if ($ticketstatus3[$x] == 'N') {
                    //display nothing
                }
            }
            ?>


        </div>

        
        <?php
        include("../PHP/footer.php");
        ?>
    </body>


</html>