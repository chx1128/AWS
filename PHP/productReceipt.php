<?php
session_start();

unset($_SESSION["cart"]);
session_destroy();
if (empty($_SESSION["payment"])) {
    echo "<script>location='products.php'</script>";
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Receipt</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                margin: 0;
                padding: 0;
                background-color: #f4f4f4;
            }

            .receipt {
                width: 500px;
                max-height: 1000px;
                margin: 20px auto;
                padding: 20px;
                border: 1px solid #ccc;
                background-color: white;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
            }

            .receipt-navi{
                width: 500px;
                height: 100px;
                background-color:#00032E;
                top:0px;
                text-align: center;
            }

            .receipt-logo{
                width: auto;
                height: 80px;
                padding: 10px;
            }

            h2{
                margin-left: 2%;
            }

            .titleDetail{
                margin-left: 1%;
                margin-bottom: 2%;
            }

            .itemDetail{
                margin-left: 1%;
                margin-bottom: 10%;
            }

            .itemDetail tr {
                background-color: white;
            }

            .itemDetail tr:nth-child(odd){
                background-color: #F2F2F2;
            }

            .itemDetail th{
                border: 1px solid white;
                background-color: #BBBBBB;
                font-size: 1.2em;
                padding: 8px;
            }

            .itemDetail td{
                padding: 8px;
                text-align: right;
            }

            td{
                padding: 8px;
                margin-bottom: 5%;
            }

            .total{
                font-weight: bold;
                background-color: black !important;
                color: white;
            }

            .btnPrint{
                width: 30%;
                padding: 10px;
                margin: 2% 2%;
                background-color: darkblue;
                color: #fff;
                font-size: 1.2em;
                border: none;
                border-radius: 5px;
                cursor: pointer;
            }

            .btnBack{
                width: 30%;
                padding: 10px;
                background-color: #00032E;
                color: #fff;
                font-size: 1.2em;
                border: none;
                border-radius: 5px;
                cursor: pointer;
            }

            .btnPrint:hover {
                background-color: #0000CC;
                transition: 0.1s;
            }

            .btnBack:hover {
                background-color: darkred;
                transition: 0.1s;
            }

            /* Print receipt */
            @media print {
                @page{
                    size: A5;
                }

                body {
                    background-color: white;
                    -webkit-print-color-adjust: exact;
                }

                .navi{
                    display: none;
                }

                .receipt {
                    box-shadow: none;
                }

                .btnPrint, .btnBack {
                    display: none;
                }
            }
        </style>
    </head>
    <body>
        <?php
        require_once '../secret/helper.php';
        ?>
        <?php
        include('header.php');
        ?>
        <div class="receipt">
            <div class="receipt-navi">
                <img src="../IMAGE/2ndduckylogo.png" class="receipt-logo"/>
            </div>
            <h2>Payment Receipt</h2>
            <div class="customer-info">
                <table class="titleDetail">
                    <?php
                    if (isset($_SESSION["payment"])) {
                        $payment_id = $_SESSION["payment"];

                        $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

                        // Prepare SQL statement to retrieve payment details with user information
                        $sql = "SELECT  p.user_id, name, date, time
                                FROM payment p join client c on p.user_id = c.user_id
                                WHERE payment_id = ?";
                        $stmt = $con->prepare($sql);
                        $stmt->bind_param('s', $payment_id);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        // Check if payment record exists
                        if ($result->num_rows > 0) {
                            $payment = $result->fetch_assoc();
                            // Display receipt information
                            printf("
                                <tr>
                                    <td>User ID: </td>
                                    <td class='record'>%s</td> 
                                </tr>
                                <tr>
                                    <td>Name: </td>
                                    <td class='record'>%s</td> 
                                </tr>
                                <tr>
                                    <td>Date: </td>
                                    <td class='record'>%s</td> 
                                </tr>
                                <tr>
                                    <td>Time: </td>
                                    <td class='record'>%s</td> 
                                </tr>
                                ", $payment["user_id"], $payment["name"], $payment["date"], $payment["time"]);
                        } else {
                            echo "Payment record not found.";
                        }

                        // Close database connection
                        $stmt->close();
                        $con->close();
                    } else {
                        echo "Payment ID not set.";
                    }
                    ?>

                </table>
            </div>

            <div class="receipt-content">
                <table class="itemDetail">
                    <tr>
                        <th>Ticket Name</th>
                        <th>Quantity</th>
                        <th>Book Date</th>
                        <th>Price (RM)</th>
                    </tr>
                    <?php
                    $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

                    $sql = "SELECT ticket_name, ticket_amount, book_date, price, total_price
                          FROM Payment
                          WHERE payment_id = ?";

                    $stmt = $con->prepare($sql);

                    $stmt->bind_param('s', $payment_id);

                    $stmt->execute();

                    $result = $stmt->get_result();

                    while ($row = $result->fetch_assoc()) {
                        $name = explode("|", $row["ticket_name"]);
                        $qty = explode("|", $row["ticket_amount"]);
                        $book_date = explode("|", $row["book_date"]);
                        $price = explode("|", $row["price"]);
                        $totalPrice = $row["total_price"];

                        for ($i = 0; $i < count($name); $i++) {
                            printf("
                        <tr>
                            <td style='text-align:left;'>%s</td>
                            <td>%s</td>
                            <td>%s</td>
                            <td>%.2f</td>
                        </tr>
                        ", $name[$i], $qty[$i], $book_date[$i], $price[$i]);
                        }
                    }

                    echo"
                        <tr class='total'>
                            <td colspan='3' style='text-align:left;'>Total Price: </td>
                            <td>$totalPrice</td>
                        </tr>";

                    // Close database connection
                    $stmt->close();
                    $con->close();
                    ?>
                </table>
            </div>

            <input type="button" class="btnPrint" value="Print"/>
            <input type="button" class="btnBack" value="Back" onclick="location = 'home.php'"/>
        </div>
    </body>

    <script>
        // Attach event listener to the print button
        document.querySelector('.btnPrint').addEventListener('click', function () {
            window.print();
        });
    </script>
</html>
