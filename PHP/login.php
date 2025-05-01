<?php
require_once ("../secret/helper.php");
setcookie('id', '', time() - 3600, '/');
//if (isset($_COOKIE['count'])) {
// $count=$_COOKIE['count'];
//echo $count;
//}
?>
<?php
$con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($con->connect_error) {
    die("connection failed: " . $con->connect_error);
}
$sName = array();
$sEmail = array();
$sPass = array();
$sPhone = array();
$sql = "select name,user_email,user_pass,phone from client";

$result = $con->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_object()) {
        $sName[] = $row->name;
        $sEmail[] = $row->user_email;
        $sPass[] = $row->user_pass;
        $sPhone[] = $row->phone;
    }
}
$uservalue = "";
$passvalue = "";
$situation = "";
$erroruser = "";
$errorpass = "";
if (isset($_POST["logbtn"])) {

    $uservalue = $_POST["userlog"];
    if (isset($_POST["passlog"])) {
        $passvalue = $_POST["passlog"];
    } else {
        $passvalue = "";
    }
    $hpassvalue = hash('SHA256', $passvalue);
    $erroruser = "";
    $errorpass = "";

    if (!in_array($uservalue, $sEmail)) {
        $erroruser = "Undefined Email";
        $errorpass = "Invalid password";
    } else {
        $erroruser = ""; // Reset error if username matches
        $sqll = "SELECT user_pass FROM client WHERE user_email=?";
        $stmtl = $con->prepare($sqll);
        $stmtl->bind_param("s", $uservalue);
        $stmtl->execute();
        $stmtl->store_result(); // Store the result set to get the number of rows
        if ($stmtl->num_rows > 0) {
            $stmtl->bind_result($matchpass); // Bind the result to a variable
            $stmtl->fetch(); // Fetch the result
        } else {
            echo "No matching user found";
        }
        if ($hpassvalue != $matchpass) {
            $errorpass = "Invalid password";
            $sqlblock = "select block from client where user_email ='$uservalue'";
            $resultblock = $con->query($sqlblock);
            if ($resultblock->num_rows > 0) {
                while ($row = $resultblock->fetch_object()) {
                    $blockInfo = $row->block;
                }
            }
            $blockpart = explode("|", $blockInfo);

            if ($blockpart[1] < 4) {
                $afteradd = $blockpart[1] + 1;

                $time = "00:00:00|";
                $insert = $time . $afteradd;
                $sqladdblock = "update client set block=? where user_email = ?";
                $stmtaddblock = $con->prepare($sqladdblock);
                $stmtaddblock->bind_param("ss", $insert, $uservalue);
                $stmtaddblock->execute();
                $chance = 5 - $blockpart[1];
                $blockvalue = $blockpart[1] + 1;
                //echo "error $blockvalue time, left $chance chance";
            } else if ($blockpart[1] == 4) {
                $currentTime = new dateTime();
                $currentTime2 = $currentTime->format('h:i:s');
                $afteradd = $blockpart[1] + 1;

                $insert = $currentTime2 . "|" . $afteradd;
                $sqladdblock2 = "update client set block=? where user_email = ?";
                $stmtaddblock2 = $con->prepare($sqladdblock2);
                $stmtaddblock2->bind_param("ss", $insert, $uservalue);
                $stmtaddblock2->execute();
                //echo "last chance";
                echo "<script>alert('Detected you are trying to enter various time, you will be block if you wrong again...');</script>";
            } else if ($blockpart[1] == 5) {
                $currentTime = new dateTime();
                $currentTime2 = $currentTime->format('h:i:s');
                $ftime = strtotime($blockpart[0]);

                $fftime = strtotime($currentTime2);
                $timediff = $fftime - $ftime;
                $Itimediff = date('i:s', $timediff);
                $counttime = 180 - $timediff;
                $rcounttime = date('i:s', $counttime);

                $errorpass = "BLOCK <b>$rcounttime<b>";

                list($minutes, $seconds) = explode(':', $rcounttime);
                $totalSeconds = ($minutes * 60) + $seconds;
                if ($totalSeconds <= 0 || $totalSeconds > 180) {

                    echo "<script>location='login.php'</script>";

                    $value1 = "00:00:00|0";
                    $sqlublock = "update client set block=? where user_email=?";
                    $stmtublock = $con->prepare($sqlublock);
                    $stmtublock->bind_param('ss', $value1, $uservalue);
                    $stmtublock->execute();
                }
            }



            //setcookie('count',$count, time() + 7200, "/");
        } else {
            $errorpass = ""; // Reset error if password matches
        }
    }
    if ($errorpass == "" && $erroruser == "") {
        $sqlid = "select user_id from client where user_email='$uservalue' and user_pass ='$hpassvalue'";
        $resultid = $con->query($sqlid);
        $id;
        if ($resultid->num_rows > 0) {
            while ($row = $resultid->fetch_object()) {
                $id = $row->user_id;
            }
        }

        setcookie('id', $id, time() + 7200, "/");
        echo "<script>alert('Login Sucessfull $id!');</script>";
        if ($id[0]=='U') {
            echo "<script>location='products.php'</script>";
        }
        else{
            echo "<script>location='adminsearch.php'</script>";
        }
    }
} else {
    $erroruser = "";
    $errorpass = "";
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
        <title>LOG IN </title>
        <script defer src="https://use.fontawesome.com/releases/v5.15.4/js/all.js" 
                integrity="sha384-rOA1PnstxnOBLzCLMcre8ybwbTmemjzdNlILg8O7z1lUkLXozs4DHonlDtnE7fpc" 
        crossorigin="anonymous"></script>
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Archivo+Black&display=swap');
            .maindiv{
                width:1200px;
                height: 650px;
                margin:auto;
                border:2px solid black;
                display:flex;
                margin-top:30px;
                overflow:hidden;
                box-shadow: 30px 24px 282px 49px rgba(0,0,0,0.24);
            }
            .left{
                width: 850px;
                height: 650px;
                z-index: 2;
            }
            .right{
                width:350px;
                height:650px;
                background-image: url(../IMAGE/rightbackground.png);
            }
            .leftimage{
                width: 857px;
                height:670px;
                filter:blur(5px) brightness(80%);
                z-index: -10;
                position: relative;
                margin-top: -10px;
            }
            .leftform{
                margin-left: 100px;
                z-index: 10;
                margin-top: -520px;
            }
            .logintitle{
                width: 400px;
                border: 1px solid black;
                margin-left: -200px;
                height: 90px;
                border-radius: 50px;
                background-color: rgba(6, 6, 6, 0.79);
                padding-bottom: 15px;
            }
            .logintitle h2{
                font-size: 2.5em;
                color:white;
                float: right;
                padding-right: 40px;
                padding-bottom: 20px;
            }
            .name,.pass{
                clear: both;
                width: 450px;
                height: 50px;
                box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
                padding-left: 20px;
                border: 1px solid black;
                border-radius: 25px;
                margin-bottom: 20px;
                background-color: white;
            }
            .name input,.pass input{
                border: none;
                margin-top: 10px;
                margin-left: 15px;
                font-size: 1.2em;
                width: 400px;
                background-color: white
            }
            input:focus{
                outline: none;
            }
            input[type="text"],input[type="password"]{
                width: 380px;
            }
            input[type="submit"] {
                width: 100px;
                box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
                height: 50px;
                border-radius: 25px;
                background-color: aquamarine;
                border: 2px solid rgb(66, 145, 119);
                font-weight: bold;
                font-size: 1em;
                transition:0.2s;
                margin-top: 0px;
            }
            input[type="submit"]:hover{
                width:105px;
                margin-left:-2px;
            }
            .regbtn{
                transition: 0.5s;
                width: 150px;
                height: 50px;
                box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
                font-size: 1.1em;
                border-radius: 35px;
                background-color: rgb(165, 92, 234);
                border: 2px solid rgb(81, 33, 125);
                letter-spacing: 1px;
                margin-left: 90px;
                margin-top: 100px;
                font-weight: bold;
                color: rgba(220, 217, 217, 0.992);
            }
            .regbtn:hover{
                width: 160px;
                margin-left: 88px;
                color:white;
                background-color:  rgb(161, 86, 231);
                transition: 0.8s;
            }
            .regp1{
                width: 400px;
                text-align: justify;
                margin: auto;
                line-height: 20px;
                font-size: 1.3em;
                color: rgb(225, 223, 223);
                margin-top: 30px;
                margin-left: 30px;
                transition: 0.8s;
                transition-delay: 0.5s;
            }
            .personal{
                text-transform: uppercase;
                font-size: 2.3em;
                line-height: 50px;
                color: orange;
                font-family: 'Archivo Black', sans-serif;
                margin-bottom: -40px;
                margin-top: -20px;
            }
            .rightimg{
                margin-top: -40px;
                width:400px;
                height: 400px;
                margin-left: 50px;
            }
            .errormess{
                color:red;
                font-size:0.8em;
                margin-left: 35px;
                position: absolute;
                margin-top: -1px;
            }
            .forgot{
                position:absolute;
                margin-left: 310px;
                color:white;
                margin-top: 30px;
                letter-spacing: 1px;
            }
            .forgot:active{
                color: grey;
            }

            .remSet
            {
                position: absolute;
                margin-left: 330px;
            }

        </style>
    </head>
    <body>
        <?php
        include('header.php');
        ?>
        <div class="maindiv">
            <div class="left">
                <img src="../IMAGE/rollercoaster.jpg" class="leftimage"/>

                <form action="" method="post" class="leftform" onsubmit="return login(event)">
                    <div class="logintitle"><h2 >LOG IN</h2></div>
                    <div class="name">
                        <i class="fas fa-user"></i>
                        <input type="email" <?php echo $situation; ?> placeholder="&nbsp;Email"  value="<?php echo $uservalue ?>" name="userlog" /><br>
                        <span class="errormess"><?php echo $erroruser; ?></span>
                    </div>
                    <div class="pass" id="passf">
                        <i class="fas fa-lock"></i>
                        <input type="password" id="passwordf" <?php echo $situation; ?> placeholder="&nbsp;Password"  value="<?php echo $passvalue ?>"  name="passlog"/><br>
                        <span class="errormess" id="errorpass1"><?php echo $errorpass; ?></span>

                    </div>

                    <diV class="remSet">
                        <label for="reMe" style="color: white;font-size:1.1em;cursor:pointer;">Remember me</label>
                        <input type="checkbox" name="Remember me" id="reMe" style="cursor:pointer;  "/>
                    </div>
                    <input type="submit" class="btn" value="Log in" name="logbtn"/>
                </form>

            </div>


            <div class="right">
                <a href="signup.php"><button class="regbtn" >Register</button></a>

                <div class="regp1" id="regp1">
                    <h4 class="regp1_1">Enter your <br>
                        <span class="personal"> personal details </span><br>And start journey with us 
                    </h4>
                </div>
                <img src="../IMAGE/Screenshot_2024-03-06_224330-removebg-preview.png" class="rightimg"/>
            </div>
        </div>
        <script>
            var remainingTime = <?php echo $totalSeconds; ?>; // Initialize remaining time from PHP

// Function to update the countdown timer
            function updateTimer() {
                if (remainingTime <= 0) {
                    clearInterval(timer); // Stop the timer when countdown reaches 0
                    document.getElementById('errorpass1').innerHTML = "";
                } else {
                    var minutes = Math.floor(remainingTime / 60); // Calculate minutes
                    var seconds = remainingTime % 60; // Calculate seconds
                    document.getElementById("passwordf").disabled = false;
                    document.getElementById("passf").style.backgroundColor = "white";
                    document.getElementById("passwordf").style.backgroundColor = "white";
                    // Format minutes and seconds to display with leading zeros if necessary
                    var formattedTime = (minutes < 10 ? '0' : '') + minutes + ' : ' + (seconds < 10 ? '0' : '') + seconds;
                    document.getElementById("passwordf").disabled = true;
                    document.getElementById("passwordf").value = "xxx";
                    document.getElementById("passf").style.backgroundColor = "rgb(235,235,228)";
                    document.getElementById("passwordf").style.backgroundColor = "rgb(235,235,228)";
                    document.getElementById('errorpass1').innerHTML = "BLOCK " + "<b> " + formattedTime + "</b>"; // Update HTML element with remaining time
                    remainingTime--; // Decrease remaining time
                }
            }

            updateTimer();

            var timer = setInterval(updateTimer, 1000);

        </script>
    </body>
</html>
