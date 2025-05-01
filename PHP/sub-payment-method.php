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
                background-color: #E7E7E7;
                font-family: sans-serif;
                margin: 0;
                padding: 0;
            }

            #paymentForm{
                display: flex;
                flex-wrap: wrap;
                width: 900px;
                margin: 8% auto;
            }

            h1{
                text-align: center;
            }

            .pMethod, .subscription{
                background-color: white;
                padding: 20px;
                text-align: left;
                border: none;
                border-radius: 5px;
                margin-left: 10%
            }

            .pMethod{
                width: 45%;
                margin-bottom: 2%;
                margin-right: 1%;
            }

            .subscription{
                width: 28%;
                margin-bottom: 2%;
                margin-left: -0.5%;
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

            h2 {
                font-size: 2em;
                margin-left: 5%;
            }

            p {
                font-size: 1.3em;
                margin-left: 5%;
            }
        </style>
    </head>
    <body>
        <?php
        include('../PHP/header.php');
        ?>
        <form id="paymentForm" action="" method="POST" id="paymentForm">
            <fieldset class="pMethod">
                <h1>Select Payment Method</h1>
                <div class="form-group">
                    <input type="radio" id="creditCard" name="paymentMethod" value="creditCard" checked>
                    <label for="creditCard">Credit/Debit Card</label>
                    <img src="../IMAGE/visa-card.jpg" alt="Visa Card"/>
                    <img src="../IMAGE/mastercard.jpg" alt="Mastercard"/>
                    <img src="../IMAGE/paypal.jpg" alt="Paypal"/>
                </div>
                <div class="form-group">
                    <input type="radio" id="eWallet" name="paymentMethod" value="eWallet">
                    <label for="eWallet">E-Wallet</label>
                    <img src="../IMAGE/tng.jpg" alt="TnG"/>
                </div>
                <div class="btn">
                    <input type="submit" value="Proceed" class="btnProceed" />
                    <input type="button" value="Cancel" class="btnCancel" onclick="location = '../PHP/memberships.php'"/>
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
            <fieldset class="subscription">
                <h2>Subscription</h2>
                <p>RM 200/year</p>
                <p>
                    - 🚗Free Parking <br/>  
                    - ️🎫Buy 5 Get 1 Free <br/>
                    - 🛣️Fast Lane Entrance <br/>
                </p>
            </fieldset>
        </form>
    </body>
</html>
