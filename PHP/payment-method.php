<?php
session_start();

if (isset($_POST['checkedItems'])) {
    if (isset($_COOKIE['id'])) {
            $user_id = $_COOKIE['id'];
        }
        else{
            echo "<script>location='../PHP/login.php'</script>";
        }
    $checked = $_POST['checkedItems']; // Array of checkboxID values
    $checkout = [];

    foreach ($_SESSION['cart'] as $item) {
        $itemID = $item['hiddenID'];
        if (in_array($itemID, $checked)) {
            $checkout[] = $item;
        }
    }

    $_SESSION['checkout'] = $checkout;

    // Optional: Debug outpu
} else {
    if(!isset($_POST['btnProceed']))
    echo "<script>location='../PHP/products.php'</script>";
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
        <title>Payment Method</title>

        <style>
            body {
                font-family: sans-serif;
                margin: 0;
                padding: 0;
            }

            #paymentForm {
                display: flex;
                flex-wrap: wrap;
                width: 1400px;
                max-height: 1400px;
                border: 1px solid white;
                border-radius: 5px;
                margin: 9% auto;
                text-align: center;
            }

            .cart, .method {
                padding: 20px;
                text-align: left;
                border: 1px solid #ccc;
                border-radius: 5px;
                margin: 0 auto;
            }

            .cart{
                width: 41%;
                margin-bottom: 2%;
                margin-left: -0.5%; 
            }

            .method{
                width: 30%;
                margin-bottom: 2%;
                margin-right: 1%;
            }

            h1 {
                text-align: center;
            }

            .form-group {
                margin-left: 30px;
                margin-bottom: 20px;
            }

            label {
                margin-left: 5px;
                margin-right: 20px;
                font-size: 1.5em;
            }

            img {
                width: auto;
                height: 25px;
                display: inline-block;
                vertical-align: top;
            }

            h2{
                margin-top: -5px;
            }

            tr {
                background-color: white;
            }

            tr:nth-child(odd){
                background-color: #F2F2F2;
                
            }

            th{
                background-color: #BBBBBB;
                font-size: 1.2em;
            }

            th, td{
                padding: 8px;
            }

            .total{
                font-weight: bold;
                background-color: black !important;
                color: white;
            }

            .btn{
                margin-top: 10%;
                margin-left: 30px;
            }

            .btnProceed, .btnCancel{
                width: 45%;
                padding: 10px;
                background-color: #00032E;
                color: white;
                border: none;
                border-radius: 5px;
                font-size: 1.2em;
                cursor: pointer;
            }

            .btnProceed:hover {
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
        <form id="paymentForm" action="" method="POST">
            <fieldset class="method">
                <h1>Select Payment Method</h1>
                <div class="form-group">
                    <input type="radio" id="creditCard" name="paymentMethod" value="creditCard" checked>
                    <label for="creditCard">Credit/Debit Card</label>
                    <img src="https://tarumtbucket2305835.s3.amazonaws.com/visa-card.jpg" alt="Visa Card"/>
                    <img src="https://tarumtbucket2305835.s3.amazonaws.com/mastercard.jpg" alt="Mastercard"/>
                    <img src="https://tarumtbucket2305835.s3.amazonaws.com/paypal.jpg" alt="Paypal"/>
                </div>
                <br/>
                <div class="form-group">
                    <input type="radio" id="eWallet" name="paymentMethod" value="eWallet">
                    <label for="eWallet">E-Wallet</label>
                    <img src="https://tarumtbucket2305835.s3.amazonaws.com/tng.jpg" alt="TnG"/>
                </div>
                <div class="btn">
                    <input type="submit" value="Proceed" class="btnProceed" name="btnProceed"/>
                    <input type="button" value="Cancel" class="btnCancel" onclick="location = '../PHP/products.php'"/>
                </div>
            </fieldset>
            
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if (isset($_POST["paymentMethod"])) {
                    $selectedPaymentMethod = $_POST["paymentMethod"];

                    // Redirect the user based on the selected payment method
                    if ($selectedPaymentMethod == "creditCard") {
                        echo "<script>location='../PHP/credit-card.php'</script>";
                    } elseif ($selectedPaymentMethod == "eWallet") {
                        echo "<script>location='../PHP/tng.php'</script>";
                    }
                }
            }
            ?>

            <fieldset class="cart">
                <h2>Cart Item</h2>
                <div class="cart-items">
                    <table>
                        <tr>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Price (RM)</th>
                            <th>Sub-total Price (RM)</th>
                        </tr>
                        <?php
                        // Check if the cart session variable is set and not empty
                        if (isset($_SESSION["checkout"])) {
                            // Loop through each item in the cart
                            $totalPrice  =0;

                            foreach ($_SESSION["checkout"] as $value) {
                                // Retrieve relevant details of the item
                                $image = $value["Image"];
                                $name = $value["Name"];
                                $price = $value["Price"];
                                $qty = $value["Qty"];
                                
                                $subtotalPrice = number_format($price * $qty, 2);
                                $totalPrice += $subtotalPrice;

                                echo "
                                    <tr>
                                        <td >$name</td>
                                        <td style='text-align: right;'>$qty</td>
                                        <td style='text-align: right;'>$price</td>
                                        <td style='text-align: right;'>$subtotalPrice</td>
                                    </tr>";
                            }

                            echo"
                                <tr class='total'>
                                    <td colspan='3'>Total Price: </td>
                                    <td style='text-align: right;'>$totalPrice</td>
                                </tr>";
                        }
                        ?>
                    </table>
                </div>
            </fieldset>
        </form>
    </body>
</html>
