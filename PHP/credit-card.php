<?php
session_start();
require_once '../secret/helper.php';

if (isset($_POST["btnSubmit2"])) {
    if (isset($_SESSION["checkout"]) && !empty($_SESSION["checkout"])) {
        $ticketNames = [];
        $quantities = [];
        $subtotalPrices = [];
        
        $totalPrice  =0;
        foreach ($_SESSION["checkout"] as $value) {
            // Retrieve relevant details of the item
            $image = $value["Image"];
            $name = $value["Name"];
            $price = $value["Price"];
            $qty = $value["Qty"];
                                
            $subtotalPrice = number_format($price * $qty, 2);
            $totalPrice += $subtotalPrice;
        }

        //Set the time zone to Malaysia
        date_default_timezone_set('Asia/Kuala_Lumpur');

        // Date in YYYY-MM-DD format
        $buyDate = date("Y-m-d");
        // Time in HH:MM:SS format
        $buyTime = date("H:i:s");


        if (isset($_COOKIE['id'])) {
            $user_id = $_COOKIE['id'];
        }
        else{
            echo "<script>location='../PHP/products.php'</script>";
        }
        //fucntion to select the last payment_id from fatabase
        function getLastPaymentID($con) {
            $sql = "SELECT payment_id FROM payment ORDER BY payment_id DESC LIMIT 1";
            $result = $con->query($sql);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                return $row['payment_id'];
            } else {
                return "P0000";
            }
        }

        //fucntion to select the last order_id from fatabase
        function getLastOrderID($con) {
            $sql = "SELECT order_id FROM payment ORDER BY order_id DESC LIMIT 1";
            $result = $con->query($sql);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                return $row['order_id'];
            } else {
                return "O0000";
            }
        }

        //Create connection between system and DB
        $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        // Calculate next payment ID
        $lastPaymentID = getLastPaymentID($con);
        $lastPNumber = intval(substr($lastPaymentID, 1)); // Extract numeric part
        $nextPNumber = $lastPNumber + 1;
        $nextPaymentID = 'P' . sprintf('%04d', $nextPNumber); // Format with leading zeros
        // Calculate next order ID
        $lastOrderID = getLastPaymentID($con);
        $lastONumber = intval(substr($lastOrderID, 1)); // Extract numeric part
        $nextONumber = $lastONumber + 1;
        $nextOrderID = 'O' . sprintf('%04d', $nextONumber); // Format with leading zeros
        //Sql statement
        $sql = "INSERT INTO payment
           (payment_id, order_id, user_id, ticket_name, ticket_amount, book_date, price, total_price, date, time) 
           VALUES (?,?,?,?,?,?,?,?,?,?)";

        //Process sql
        $stmt = $con->prepare($sql);

        foreach ($_SESSION["checkout"] as $value) {
            // Retrieve relevant details of the item
            $name = $value["Name"];
            $price = $value["Price"];
            $qty = $value["Qty"];

            // Store details in arrays
            $ticketNames[] = $name;
            $quantities[] = $qty;
            $prices[]=$price;
            $subtotalPrices[] = number_format($price * $qty, 2);
        }

        // Combine arrays into single strings separated by '|'
        $combinedNames = implode('|', $ticketNames);
        $combinedDates = "-";
        $combinedQuantities = implode('|', $quantities);
        $combinedSubtotalPrices = implode('|', $prices);

        //Pass in parameter into the "?" inside the sql
        $stmt->bind_param('sssssssdss', $nextPaymentID, $nextOrderID, $user_id, $combinedNames, $combinedQuantities, $combinedDates, $combinedSubtotalPrices, $totalPrice, $buyDate, $buyTime);

if ($stmt->execute()) {
    echo "Payment recorded successfully!";
} else {
    echo "Error: " . $stmt->error;
}
        

        $stmt->close();
        $con->close();

        if (isset($_SESSION["payment"])) {
            $_SESSION["payment"] = array();
        }

        $_SESSION["payment"] = $nextPaymentID;

        echo "<script>location='../PHP/productReceipt.php'</script>";
    } else {

        $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        //fucntion to select the last membership_id from fatabase
        function getLastMembershipID($con) {
            $sql = "SELECT membership_id FROM membership ORDER BY membership_id DESC LIMIT 1";
            $result = $con->query($sql);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                return $row['membership_id'];
            } else {
                return "M0000";
            }
        }

        // Calculate next membership ID
        $lastMembershipID = getLastMembershipID($con);
        $lastMNumber = intval(substr($lastMembershipID, 1)); // Extract numeric part
        $nextMNumber = $lastMNumber + 1;
        $nextMembershipID = 'M' . sprintf('%04d', $nextMNumber); // Format with leading zeros


        if (isset($_COOKIE['id'])) {
          $user_id = $_COOKIE['id'];
        }
        //Set the time zone to Malaysia
        date_default_timezone_set('Asia/Kuala_Lumpur');

        $subDate = date("Y-m-d");
        $subTime = date("H:i:s");

        // Date in YYYY-MM-DD format
        $dateToJoin = date("Y-m-d");

        $currentDate = new DateTime();
        $currentDate->modify('+1 year');
        $dateToExp = $currentDate->format('Y-m-d');

        $payment = "200";

        //Sql statement
        $sql = "INSERT INTO membership
           (membership_id, user_id, date_join, date_exp, total_payment, date, time) 
           VALUES (?,?,?,?,?,?,?)";

        //Process sql
        $stmt = $con->prepare($sql);

        $stmt->bind_param('ssssdss', $nextMembershipID, $user_id, $dateToJoin, $dateToExp, $payment, $subDate, $subTime);

        $stmt->execute();

        $stmt->close();
        $con->close();

        if (isset($_SESSION["membership"])) {
            $_SESSION["membership"] = array();
        }

        $_SESSION["membership"] = $nextMembershipID;

        echo "<script>location='../PHP/membershipReceipt.php'</script>";
    }
}
?>
<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Payment</title>

        <style>
            body {
                font-family: sans-serif;
                background-color: #F4F4F4;
                margin: 0;
                padding: 0;
            }

            form {
                width: 380px;
                height: 450px;
                margin: 50px auto;
                padding: 20px;
                background-color: white;
                border-radius: 10px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            }

            .cardDetail{
                width: 380px;
                height: 230px;
                margin: 50px auto;
                padding: 10px;
            }

            h1{
                text-align: center;
                margin-bottom: 30px;
            }

            .cardNumber {
                width: 80%;
                padding: 20px;
            }

            .expDate, .cvv {
                display: inline-block;
                width: 34%;
                padding: 20px;
            }

            #cardNum, #expdate{
                width: 100%;
                padding: 10px;
                border: 1px solid black;
                border-radius: 5px;
            }

            #cvvNum {
                width: 100%;
                padding: 10px;
                border: 1px solid black;
                border-radius: 5px;
            }

            p {
                font-size: 0.8em;
                font-family: courier;
                font-weight: bold;
            }

            img {
                width: auto;
                height: 20px;
                vertical-align: middle;
            }

            .btn{
                margin-left: 30px;
            }

            .btnSubmit, .btnCancel{
                width: 46%;
                padding: 10px;
                margin-top: -20px;
                background-color: #00032E;
                color: white;
                font-size: 1.2em;
                border: none;
                border-radius: 5px;
                cursor: pointer;
            }

            .btnSubmit:hover {
                background-color: darkblue;
                transition: 0.1s;
            }

            .btnCancel:hover {
                background-color: darkred;
                transition: 0.1s;
            }
        </style>
    </head>
    <body>
        <?php 
        include('../PHP/header.php');
        ?>
        <form id="paymentForm" action="" method="post">
            <h1>Credit/Debit Card</h1>
            <div class="cardDetail">

                <div class="cardNumber">
                    Card Number<br/>
                    <input type="text" name="numtxt" id="cardNum" placeholder="0000 0000 0000 0000" maxlength="19" required autofocus
                           pattern="[0-9]{4}[ ][0-9]{4}[ ][0-9]{4}[ ][0-9]{4}" title="Please enter a valid 16-digit card number"/>
                    <p>We are currently accept
                        <img src="https://tarumtbucket2305835.s3.amazonaws.com/visa-card.jpg" alt="Visa Card"/>
                        <img src="https://tarumtbucket2305835.s3.amazonaws.com/mastercard.jpg" alt="Mastercard"/>
                        <img src="https://tarumtbucket2305835.s3.amazonaws.com/paypal.jpg" alt="Paypal"/>
                    </p>
                </div>

                <div class="expDate">
                    <label for="exptxt">Expiry Date</label>
                    <input type="text" name="exptxt" id="expdate" placeholder="MM/YY" maxlength="5" required 
                           pattern="^(0[1-9]|1[0-2])\/\d{2}$" title="Please enter valid expiry date."/>
                </div>

                <div class="cvv">
                    <label for="cvvtxt">CVV</label>
                    <input type="password" name="cvvtxt" id="cvvNum" placeholder="CVV/CVV2" maxlength="3" required 
                           pattern="\d{3}" title="Please enter a valid CVV code"/>
                </div>

            </div>

            <div class="btn">   
                <input type="submit" value="Confirm" name="btnSubmit2" class="btnSubmit"/>
                <input type="button" value="Cancel" name="btnCancel" class="btnCancel" onclick="cancelPayment();"/>
            </div>
        </form>
    </body>

<script>
    //card number format
    document.getElementById('cardNum').addEventListener('input', function (event) {
        let input = event.target.value.replace(/\s/g, ''); // Remove existing spaces
        let formattedInput = '';
        for (let i = 0; i < input.length; i++) {
            if (i > 0 && i % 4 === 0) {
                formattedInput += ' '; // Add space after every fourth character
            }
            formattedInput += input[i];
        }
        event.target.value = formattedInput;
    });

    //expiry date format
    document.getElementById('expdate').addEventListener('input', function (event) {
        let input = event.target.value.replace(/\//g, ''); // Remove existing slashes
        let formattedInput = '';
        for (let i = 0; i < input.length; i++) {
            if (i == 2 && input.length > 2) {
                formattedInput += '/'; // Add slash after second character
            }
            formattedInput += input[i];
        }
        event.target.value = formattedInput;
    });

    function cancelPayment() {
        <?php
            if (isset($_SESSION["cart"]) && !empty($_SESSION["cart"])) {
                echo "location.href='../PHP/payment-method.php';";
            } else {
                echo "location.href='../PHP/sub-payment-method.php';";
            }
        ?>
    }
</script>
</html>