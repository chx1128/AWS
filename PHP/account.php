<?php
require_once ("../secret/helper.php");
$id = "";
 $cdate[0] = "";
 $cname[0] = "";
 $cqty[0] = "";
 $cprice[0] = ""; 
 $paymentID[0] = "";
?>
<?php
if (empty($_COOKIE['id'])) {
    echo "<script>location='../PHP/login.php';</script>";
}
if (isset($_COOKIE['id'])) {
    $id = $_COOKIE['id'];
    //echo"$id";
}
$con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($con->connect_error) {
    die("connection error :" . $con->connect_error);
}
$sqlaccount = "select * from client where user_id='$id'";
$sqlreset = "update client set block = ? where user_id=?";
$block = "00:00:00|0";
$stmtreset = $con->prepare($sqlreset);
$stmtreset->bind_param("ss", $block, $id);
$stmtreset->execute();
$resultacc = $con->query($sqlaccount);
if ($resultacc->num_rows > 0) {
    while ($row = $resultacc->fetch_object()) {
        $image = $row->personal_img;
        $username = $row->name;
        $useremail = $row->user_email;
        $userphone = $row->phone;
        $userage = $row->age;
        $userDOB = $row->birth_date;
        $userregisDate = $row->register_date;
    }
}
?>
<?php
if (isset($_POST['logout'])) {
    session_id("Guest");
    session_start();
    unset($_SESSION["cart"]);
    unset($_SESSION["checkout"]);

    // Expire the cookie (if you use it for session_id)
    setcookie('id', '', time() - 3600, '/');

    // Destroy session completely (optional)
    session_destroy();

    // Redirect to login page
    header("Location: ../PHP/login.php");
    exit;
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
        <title>Account</title>
        <style>
            html{
                max-width: 1550px;
                margin:auto;
            }
            body {
                justify-content: center;
                align-items: center;
                margin:auto;
            }
            .part1container{
                width:1470px;
                height: 650px;
                display: flex;
                font-weight: bold;
                position: relative;
                justify-content: center;
                background-color:rgb(237, 240, 245);
                margin:auto;
            }
            .part1left{
                width:380px;
                height:430px;
                border: 3px solid black;
                margin-right: 20px;
                margin-top: 80px;
                background-color: white;
                border-radius:20px;
                box-shadow: rgba(17, 12, 46, 0.15) 0px 48px 100px 0px;
            }
            .userimage{
                width: 380px;
                height:430px;
                border-radius:20px;
            }
            .extrabutton{
                width: 100px;
                height: 40px;
                background-color: goldenrod;
                border-radius: 50px;
                margin-left: 360px;
                box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;
                cursor: pointer;
                transition: 0.3s;
                margin-top: 80px;
                position: absolute;
            }
            .extrabutton:hover{
                border-radius: 15px;
            }
            .part1right{
                width: 600px;
                height: 570px;
            }
            .information1{
                width: 500px;
                height: 420px;
                padding-top: 40px;
                padding-bottom: 40px;
                padding-left: 20px;
                margin: auto;
                margin-bottom: 30px;
                margin-top: 40px;
                background-color: rgb(213, 217, 224);
                border-radius:10px;
                box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
            }
            .information1 input{
                border:none;
                font-size: 1.5em;
            }
            .info1{
                position: absolute;
                margin-left:180px;
                margin-top:-45px;
            }
            .gender{
                margin-left: 360px;
                margin-top: -20px;
                position: absolute;
            }
            input{
                padding-left: 20px;
                width:270px;
            }
            .gendertext{
                position: absolute;
                margin-top: -45px;
                margin-left: 70px;
                width: 30px;
            }
            .username{
                height: 40px;
                background-color: transparent;
                color: black;
                margin-left: -10px;
            }
            .info2{
                position: absolute;
                margin-left:180px;
                margin-top:-45px;
            }
            .part2container{
                display: flex;
                clear:both;
                width: 600px;
                height: 100px;
                background-color: #022a60;
                color: white;
                margin: auto;
                border-radius: 20px;
                margin-top: 50px;
                margin-bottom: 40px;
                font-weight:bold;
                box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
            }
            .part2container img{
                width: 60px;
                height: 60px;
                margin-left: 520px;
                position: absolute;
                margin-top: 10px;
            }
            .walletname{
                font-family:Arial;
                font-size: 1.8em;
                font-style: italic;
            }
            .walletname.w1{
                margin-left: 60px;
                margin-top: 20px;
            }
            .walletname.w2{
                margin-left: -50px;
                margin-top: 55px;
                color: #ffde59;
            }
            .balance{
                font-size: 1.2em;
                margin-left: 480px;
                margin-top: 60px;
                position: absolute;
            }
            .topup{
                margin-top:10px;
                margin-left: 135px;
                position:absolute;
                font-size: 0.9em;
                color: white;
            }
            .verticalline{
                height: 80px;
                width: 2px;
                background-color: white;
                margin-left: 180px;
                margin-top: 10px;
            }
            .currentbox{
                display:flex;
            }
            .historytable{
                width: 900px;
                text-align: center;
                border: 1px solid black;
                border-radius:10px;
                margin: auto;
                height: 100%;
            }
            .historybox fieldset{
                width: 900px;
                height:100%;
                margin: auto;
                margin-top: 40px;
                background-color:#d1d7e1;
                border-radius: 10px;
                padding: 20px;
                margin-bottom: 40px;
                box-shadow: rgba(17, 12, 46, 0.15) 0px 48px 100px 0px;
            }
            .currentbox fieldset{
                width: 600px;
                height: 200px;
                margin-left: 270px;
                padding: 20px;
                background-color:#8b9cb3;
                border-radius: 10px;
                box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
            }
            .currentbox fieldset legend,.historybox fieldset legend{
                font-size: 1.8em;
                font-weight: bold;
                margin-left:50px;
                color: black;
                background-color: rgb(237, 240, 245);
                padding: 20px;
                padding-top: 10px;
                padding-bottom: 10px;
            }
            .currentform{
                line-height: 45px;
                font-size: 1.2em;
                font-weight: bold;
                letter-spacing: 1px;
            }
            .currentform input{
                border:none;
                height: 30px;
                margin-left: 20px;
            }
            .currentprice{
                margin-left:500px;
                margin-top: -10px;
            }
            .wrap{
                width: 250px;
                height:250px;
                margin-left: 40px;
                margin-top:25px;
            }
            .currentappeal{
                width: 250px;
                height: 200px;
                border-radius: 10px;
                line-height: 40px;
                background-color:#d1d7e1;
                margin-left: 260px;
                transition:0.5s;
                display:none;
            }
            .currentreason
            {
                width: 250px;
                height: 200px;
                border-radius: 10px;
                line-height: 40px;
                background-color:#d1d7e1;
                margin-left: 1200px;
                margin-top: 10px;
                transition:0.5s;
                position:absolute;
                display:none;
            }
            .currentappeal input{
                width: 100px;
                margin-left: 20px;
            }
            .currentappeal form{
                margin-left: 20px;
                margin-top: 10px;
            }
            #createdate{
                font-weight: 100;
                margin-top: 0px;
            }
            .listdown{
                position:absolute;
                font-size: 0.7em;
                margin-left: 550px;
                margin-top: -70px;
            }
            .first{
                list-style-type: none;
                cursor:pointer;
            }
            .dote{
                font-weight: bold;
                font-size: 1.5em;
            }
            .drop{
                list-style-type:none;
                margin-left: -120px;
                display:none;
            }
            .drop li{
                width:100px;
                background-color: white;
                padding-left: 10px;
                cursor: pointer;
            }
            .drop li:hover{
                background-color:grey;
            }
            .part3{
                margin-bottom: 150px;
            }
            table tr{
                height:50px;
            }
            .currentselect:hover{
                color: rgb(50, 27, 222);
            }
            .currentselect{
                background-color:transparent;
                border:none;
                cursor: pointer;
                text-decoration: underline;
            }
            .appealbtn {
                margin-left: 65px;
                margin-top: 30px;
                align-items: center;
                background-color: #FFE7E7;
                background-position: 0 0;
                border: 1px solid #FEE0E0;
                border-radius: 11px;
                box-sizing: border-box;
                color: #D33A2C;
                cursor: pointer;
                display: flex;
                font-size: 0.8rem;
                font-weight: 700;
                line-height: 33.4929px;
                list-style: outside url(https://www.smashingmagazine.com/images/bullet.svg) none;
                padding: 2px 12px;
                text-align: left;
                text-decoration: none;
                text-shadow: none;
                text-underline-offset: 1px;
                transition: border .2s ease-in-out,box-shadow .2s ease-in-out;
                user-select: none;
                -webkit-user-select: none;
                touch-action: manipulation;
                white-space: nowrap;
                word-break: break-word;
            }


        </style>
    </head>
    <body>
        <?php
        include('../PHP/header.php');
        ?>
        <div class="part1container">
            <div class="part1left">
                <div class="imagewrap">
                    <img src="<?php echo "../uploads/$image"; ?>" class="userimage"/>
                </div>
            </div>
            <div class="part1right">
                <div class="information1">
                    <form action="" method="post">
                        <input type="text" value="<?php echo $username; ?>"  class="username" id="username" disabled/><br><br>
                        <h2>Email account :</h2><input type="text" disabled value="<?php echo $useremail; ?>" class="info1" id="email"/>
                        <h2>Phone number :</h2><input type="text" disabled value="<?php echo $userphone; ?>" class="info1" id="phone"/>
                        <h2>Age :</h2><input type="num" disabled value="<?php echo $userage; ?>" class="info2" id="age"/><br>
                        <h2>Date of birth :</h2><input type="text" disabled value="<?php echo $userDOB; ?>" class="info2" id="date"/><br>
                    </form>
                    <h3>Account create date : </h3><span style="margin-left:0px;" id="createdate"><?php echo $userregisDate; ?></span>
                    <a href="../PHP/editprofile.php" style="margin-left:300px;margin-top: 30px;position:absolute;">Edit profile</a>
                    <form method="post" id="logoutForm">
                        <input type="hidden" name="logout" value="1">
                        <button type="button" class="extrabutton" name="logout" value="logout" onclick="confirmLogout()">Logout</button>
                    </form>
                </div>



            </div>

        </div>
        
        <div class="part3">
            <div class="historybox">
                <fieldset>
                    <legend>Transaction history</legend>

                    <table class="historytable">
                        <?php
                        $counter = 0;
                        echo "<tr style='background-color:rgb(128, 124, 124);height:20px;'>
                                 <th>TransactionId</th><th>Ticket</th><th>PRICE<br>(RM)</th><th>TICKET AMOUNT</th><th>Total PRICE<br>(RM)</th><th>FEEDBACK</th></tr>";

                        $sqlshow = "select payment_id,ticket_name,ticket_amount,book_date,price,total_price from payment where user_id = '$id'" ;
                        $resultshow = $con->query($sqlshow);
                        if ($resultshow->num_rows > 0) {
                            while ($row = $resultshow->fetch_object()) {
                                $ticketname = explode("|", $row->ticket_name);
                                $ticketqty = explode("|", $row->ticket_amount);
                                $price = explode("|", $row->price);
                                $pID=$row->payment_id;
                                for ($i = 0; $i < 100; $i++) {
                                    if (!empty($ticketname[$i])) {
                                        if ($i % 2 == 0) {
                                            $color = "white";
                                        } else {
                                            $color = "rgb(237, 237, 235)";
                                        }
                                     
                                            printf("<tr style='background-color:%s'>
                                   <td>%s</td>
                                       <td>%s</td>
                                       <td>%s</td>
                                       <td>%s</td>
                                      <td>%.2lf</td>
                                      <td><button type='button' class='feedbackbtn' onclick='comment(\"%s,%s\")'>FEEDBACK</button></td>
                                      </tr>", $color
                                                    , $row->payment_id
                                                    , $ticketname[$i]
                                                    , $price[$i]
                                                    , $ticketqty[$i]
                                                    , $price[$i]*$ticketqty[$i]
                                                    , $ticketname[$i],$row->payment_id);
                                            
                                    }
                                }
                            }
                        }
                        $displaydate = $cdate[0];
                        $displayname = $cname[0];
                        $displayqty = $cqty[0];
                        $displayprice = $cprice[0];
                        $displayID =$paymentID[0];
                        for ($x = 0; $x < $counter; $x++) {
                            if (isset($_POST["powerbtn$x"])) {
                                $displaydate = $cdate[$x];
                                $displayname = $cname[$x];
                                $displayqty = $cqty[$x];
                                $displayprice = $cprice[$x];
                                $displayID =$paymentID[$x];
                            }
                        }
                        ?>
                    </table>
                </fieldset>
            </div>
        </div>
        
        <script>

            var drop = document.getElementById("drop");
            var dropStyle = window.getComputedStyle(drop);
            function dropdown() {

                if (dropStyle.display === "none") {
                    drop.style.display = "block";
                } else if (dropStyle.display === "block") {
                    drop.style.display = "none";
                }
            }
            var submitbox = document.getElementById("currentreason");
            var appealbox = document.getElementById("currentappeal");
            function cancel() {
                submitbox.style.display = "block";
                submitbox.style.marginLeft = "915px";
                appealbox.style.marginLeft = "260px";
                appealbox.style.display = "none";
                drop.style.display = "none";
            }
            function appeal() {
                appealbox.style.display = "block";
                appealbox.style.marginLeft = "0px";
                submitbox.style.marginLeft = "1200px";
                submitbox.style.display = "none";
                drop.style.display = "none";

            }
            
        </script>

    </body>
    <script>
        function confirmLogout() {
    if (confirm("Are you sure you want to log out?")) {
        document.getElementById('logoutForm').submit();
    }
}
        function comment(category,id) {
            localStorage.ticket = category;
            location = "../PHP/feedback.php";
        }

    </script>
        <?php
        include("../PHP/footer.php");
        ?>
</html>
