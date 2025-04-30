<?php
echo "<script>
      if (localStorage.verify =='1') {
//     nothing happen;
}else{location='login.php'}
      </script>";

?>
<?php
require_once '../secret/helper.php';
if (isset($_COOKIE['id'])) {
    $user_id = $_COOKIE['id'];
}

function checkSameMembershipID($user_id) {
    // Create connection
    $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
    }

    $users_id = $con->real_escape_string($user_id);

    $sql = "SELECT * FROM Membership WHERE user_id = '$users_id'";

    if ($result = $con->query($sql)) {
        if ($result->num_rows > 0) {
            // Same user_id detected
            echo "<script>
                    alert('You already have a membership.');
                    location='home.php'
                  </script>";
            $result->free();
            $con->close();
            exit; 
        } else {
            // User does not have a membership, proceed
            $result->free();
        }
    }

    $con->close();
}

checkSameMembershipID($user_id);

?>
<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>MEMBERSHIPS</title>
        <style>
            body {
                font-family: sans-serif;
                margin: 0;
                padding: 0;
                background-color: #E7E7E7;
            }

            h1 {
                font-size: 3.5em;
                margin-top: 2%;
                text-align: center;
                color: red;
            }

            .subscription {
                width: 800px;
                margin: 0 auto;
                padding: 20px;
                border-radius: 8px;
                background-color: rgba(238, 238, 238, 0.7);
            }

            h2 {
                margin-left: 3%;
                font-size: 2.2em;
            }

            p {
                font-size: 1.3em;
            }
            
            .detail{
                width: 700px;
                max-height: 500px;
                margin-left: 3%;
                margin-bottom: 5%;
                padding: 20px;
                background-color: rgba(255,255,255,0.2);
                border-radius: 8px; 
            }

            #btnSubscribe {
                padding: 10px;
                margin-left: 3%;
                margin-bottom: 1%;
                background-color: rgba(0, 100, 27, 0.9);
                color: white;
                font-size: 1.2em;
                border: none;
                border-radius: 5px;
                cursor: pointer;
            }

            #btnSubscribe:hover {
                background-color: darkred;
                transition: 0.5s;
            }
        </style>
    </head>
    <body>
        <?php
            include('../PHP/header.php')
        ?>
        <form class="form" action="sub-payment-method.php" method="post" id="form">
            <div class="title">
                <h1>SUBSCRIBE NOW</h1>
            </div>
            <div class="subscription">
                <h2>Subscription</h2>
                <div class="detail">
                    <p>RM 200/year</p>
                    <p>
                        - 🚗Free Parking <br/>  
                        - ️🎫Buy 10 Get 1 Free <br/>
                        - 🛣️Fast Lane Entrance <br/>
                    </p>
                </div>
                <input type="submit" value="Subscribe" name="btnSubscribe" id="btnSubscribe"/>
            </div>
        </form>
        <?php
        // put your code here
        ?>
    </body>
</html>