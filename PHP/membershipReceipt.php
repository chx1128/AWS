<?php
session_start();

if (empty($_SESSION["membership"])) {
    echo "<script>location='../PHP/memberships.php'</script>";
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
                width: 350px;
                max-height: 1000px;
                margin: 20px auto;
                padding: 20px;
                border: 1px solid #ccc;
                background-color: white;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
            }

            .receipt-navi{
                width: 350px;
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

            h3 {
                font-size: 1.3em;
                margin-left: 2%;
            }

            p {
                font-size: 1em;
                margin-left: 5%;
                line-height: 1.5;
            }

            .titleDetail{
                margin-left: 1%;
                margin-bottom: 2%;
            }

            .itemDetail{
                margin-left: 1%;
                margin-bottom: 2%;
            }

            td{
                padding: 8px;
                margin-bottom: 5%;
            }

            .price{
                font-size: 1.1em;
                font-weight: bold;
                margin-left: 2%;
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
        include('../PHP/header.php');
        ?>
        <div class="receipt">
            <div class="receipt-navi">
                <img src="https://tarumtbucket2305835.s3.amazonaws.com/Wo'eY Logo(White).png" class="receipt-logo"/>
            </div>
            <h2>Payment Receipt</h2>
            <div class="customer-info">
                <table class="titleDetail">
                    <?php
                    if (isset($_SESSION["membership"])) {
                        $membership_id = $_SESSION["membership"];

                        $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

                        // Prepare SQL statement to retrieve payment details with user information
                        $sql = "SELECT  m.user_id, name, date, time
                                FROM membership m JOIN Client c ON m.user_id = c.user_id
                                WHERE membership_id = ?";
                        $stmt = $con->prepare($sql);
                        $stmt->bind_param('s', $membership_id);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        // Check if payment record exists
                        if ($result->num_rows > 0) {
                            $membership = $result->fetch_assoc();
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
                                ", $membership["user_id"], $membership["name"], $membership["date"], $membership["time"]);
                        } else {
                            echo "Membership record not found.";
                        }

                        // Close database connection
                        $stmt->close();
                        $con->close();
                    } else {
                        echo "Membership ID not set.";
                    }
                    ?>

                </table>
            </div>

            <div class="receipt-content">
                <table class="itemDetail">
                    <h3>Subscription</h3>
                     <p>
                        - Product discount notification <br/>  
                        - ️Get annual mystery gift <br/>
                        - Faster delivery with no extra charged<br/>
                    </p>
                    <div class="price">Total Price: RM 200.00</div>
                </table>
            </div>

            <input type="button" class="btnPrint" value="Print"/>
            <input type="button" class="btnBack" value="Back" onclick="location = '../PHP/home.php'"/>
        </div>
    </body>

    <script>
        // Attach event listener to the print button
        document.querySelector('.btnPrint').addEventListener('click', function () {
            window.print();
        });
    </script>
</html>