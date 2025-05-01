 <?php
        require_once ("../secret/helper.php"); 
        ?>
<?php
$continue= "Register";
$webvalue = "";
$signvalue = "";
$usernameerror="";
$emailerror="";
$phoneerror="";
$passerror="";
$cfmpasserror="";
if (isset($_POST['submitbtn'])) 
{
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $pass = $_POST['firstpass'];
    $cfmpass = $_POST['secondpass'];
    $image = "unknownprofile.jpg";

    if (empty($_POST['email'])) {
        $emailerror = "Email is <b>Required</b>";
    }
    if (empty($_POST['username'])) {
        $usernameerror = "Username is <b>Required</b>";
    } elseif (strlen($username) < 3) {
        $usernameerror = "Username <b>must more than 3 character</b>";
    } else if (strlen($username) > 30) {
        $usernameerror = "Username <b>cannot more than 30 character</b>";
    } else if (!preg_match("/^[0-9a-zA-z ]+$/", $username)) {
        $usernameerror = "<b>Only</b> number,space and character allow";
    }if (empty($_POST['phone'])) {
        $phoneerror = "Phone number is <b>required</b>";
    } else if (!preg_match("/^01[0-9]-\d{7,8}$/", $phone)) {
        $phoneerror = "<b>Invalid</b> phone number";
    }if (empty($_POST['firstpass'])) {
        $passerror = "password is <b>required</b>";
    } else if (!preg_match('/^(?=.*\d)(?=.*[A-Z])(?=.*[a-z])(?=.*[@!#$%])[0-9A-Za-z@!#$%]{8,15}$/', $pass)) {
        $passerror = "At least <b> 8-15 chars, 1 num, 1 upper, 1 lower, 1 special character</b>";
    }if (empty($_POST['secondpass'])) {
        $cfmpasserror = "password is <b>required</b>";
    } else if (!preg_match("/^(?=.*\d)(?=.*[A-Z])(?=.*[a-z])(?=.*[@!#$%])[0-9A-Za-z@!#$%]{8,15}$/", $cfmpass)) {
        $cfmpasserror = "At least <b> 8-15 chars, 1 num, 1 upper, 1 lower, 1 special character</b>";
    } else if ($cfmpass != $pass) {
        $cfmpasserror = "<b>Password dint match</b>";
    }
    //connect database
        $con = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
        //check connection
        if ($con->connect_error) {
            die("connection failed: " .$con->connect_error);
        }
        //write query
        $checkEmailSql = "SELECT user_email FROM client WHERE user_email = ?";
        $emailCheckStmt = $con->prepare($checkEmailSql);
        $emailCheckStmt->bind_param("s", $email);
        $emailCheckStmt->execute();
        $emailCheckStmt->store_result();

        if ($emailCheckStmt->num_rows > 0) {
            // Email already exists
            $emailerror = "Error: Email already registered.";
        } else {
            // Step 2: Generate new user_id
            $sql3 = "SELECT user_id FROM client ORDER BY CAST(SUBSTRING(user_id, 2) AS UNSIGNED) DESC LIMIT 1;";
            $result = mysqli_query($con, $sql3);

            if ($row = mysqli_fetch_assoc($result)) {
                $latestUserId = $row['user_id'];
                $number = (int)substr($latestUserId, 1);
                $nextNumber = $number + 1;
                $nextUserId = 'U' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
            } else {
                $nextUserId = "U0001";
            }

            // Step 3: Insert new user
            $sql = "INSERT INTO client (user_id, name, user_email, user_pass, phone, personal_img, register_date) 
                    VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $con->prepare($sql);

            $hpass = hash('sha256', $pass);
            $regisDate = date('Y-m-d');

            $stmt->bind_param("sssssss", $nextUserId, $username, $email, $hpass, $phone, $image, $regisDate);
            $stmt->execute();


            $stmt->close();
        }

        $emailCheckStmt->close();
    if ($usernameerror == "" && $emailerror == "" && $phoneerror == "" && $passerror == "" && $cfmpasserror == "") {
        echo "<script>localStorage.pass='$cfmpass';</script>";
        echo "<script>localStorage.username='$username';</script>";
        echo "<script>localStorage.email='$email';</script>";
        echo "<script>localStorage.phone='$phone';</script>";
        $webvalue = "../PHP/login.php";
        $signvalue="All information is valid,click log in to register your account";
        $continue = "Log in";
        $image="unknownprofile.jpg";
        
    }
} else {
    $webvalue = "";
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
        <script defer src="https://use.fontawesome.com/releases/v5.15.4/js/all.js" 
                integrity="sha384-rOA1PnstxnOBLzCLMcre8ybwbTmemjzdNlILg8O7z1lUkLXozs4DHonlDtnE7fpc" 
        crossorigin="anonymous"></script>
        <title>Sign up</title>
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Archivo+Black&display=swap');
            *{
                margin: 0px;
                padding:0px;
            }
            .maindiv{
                width:1200px;
                height: 650px;
                margin:auto;
                border:1px solid black;
                display:flex;
                margin-top:30px;
                overflow: hidden;
                box-shadow: 30px 24px 282px 49px rgba(0,0,0,0.24);
            }
            .right{
                width: 820px;
                height: 650px;
            }
            .left{
                width:380px;
                height:650px;
                background-image: url(https://tarumtbucket2305835.s3.amazonaws.com/leftbackground.png);
            }
            .leftcontent{
                margin-top:100px;
                margin-left:30px;
            }
            .logtext1{
                width:400px;
                color: white;
                font-size: 1.7em;
                color: rgb(225, 223, 223);
                font-weight:bold;
            }
            .logtexth1{
                text-transform: uppercase;
                font-family: 'Archivo Black', sans-serif;
                margin-top: -40px;
                color: orange;
                font-size: 3.2em;
                margin-top: 10px;
                margin-bottom: 20px;
            }
            .logbtn{
                width:140px;
                height: 50px;
                color:white;
                background-color:  rgb(161, 86, 231);
                border-radius:50px;
                font-weight: bold;
                font-size:1.2em;
                transition: 0.2s;
                margin-left: 160px;
            }
            .logbtn:hover{
                width: 144px;
                height: 54px;
            }
            .rightbackground{
                width: 830px;
                height:670px;
                filter: blur(5px) brightness(80%);
                margin-left: -10px;
                margin-top: -10px;
            }
            .rightform{
                margin-left: 550px;
                position: absolute;
                margin-top: 50px;
            }
            .name,.pass,.phone{
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
            .signtitle h2{
                font-size: 2.7em;
                margin-left: 100px;
                color: white;
                letter-spacing: 3px;
                margin-top: 50px;
                margin-bottom: 30px;
            }
            .name input,.pass input,.phone input{
                border: none;
                margin-top: 10px;
                margin-left: 15px;
                font-size: 1.2em;
                width: 250px;
                background-color: white;
                width:380px;
            }
            .submitbtn{
                width:110px;
                height:40px;
                border-radius:50px;
                background-color: aquamarine;
                transition: 0.2s;
                margin-left: 340px;
            }
            .submitbtn:hover{
                width: 115px;
                height:42px;
            }
            input:focus{
                outline: none;
            }
            .errormess{
                color:red;
                font-size:0.8em;
                margin-left: 35px;
                position: absolute;
                margin-top: -1px;
            }


        </style>
    </head>
    <body>
        <?php
        include('../PHP/header.php');
        ?>
        <div class="maindiv">
            <div class="left">
                <div class="leftcontent">
                    <h4 class="logtext1">Already have <br>
                        <span style="text-transform: uppercase;font-family: 'Archivo Black', sans-serif;color: orange;font-size: 1.5em;">your own</span>
                    </h4><h1 class="logtexth1">Account?</h1>
                    <a href="../PHP/login.php"><button class="logbtn">Log in</button></a>

                </div>
            </div>
            <div class="right"></div>
            <img src="https://tarumtbucket2305835.s3.amazonaws.com/skyworld.webp" class="rightbackground" />
            
            <form action="<?php echo $webvalue ?>" method="post" class="rightform" id="signupForm">
                <div class="signtitle"><h2 >- SIGN UP -</h2></div>
                <div class="name">
                    <i class="fas fa-user"></i>
                    <input type="text" class="ipvalue" id="input1" name="username" value="<?php if(isset($_POST['submitbtn'])) echo $username; ?>" placeholder="&nbsp;Username"/><br>
                    <span class="errormess" id="error1"><?php if(isset($_POST['submitbtn'])) echo $usernameerror; ?></span>
                </div>
                <div class="name">
                    <i class="fa fa-envelope"></i>
                    <input type="email" class="ipvalue"  id="input2" name="email" value="<?php if(isset($_POST['submitbtn'])) echo $email; ?>" placeholder="&nbsp;Email"/><br>
                    <span class="errormess" id="error2"><?php if(isset($_POST['submitbtn'])) echo $emailerror; ?></span>
                </div>
                <div class="phone">
                    <i class="fa fa-phone" id="phoned"></i>
                    <input type="tel" class="ipvalue" id="input3" name="phone" value="<?php if(isset($_POST['submitbtn'])) echo $phone; ?>" placeholder="&nbsp;Phone (e.g.012-3456789)"/><br>
                    <span class="errormess" id="error3"><?php if(isset($_POST['submitbtn'])) echo $phoneerror; ?></span>
                </div>
                <div class="pass">
                    <i class="fas fa-lock"></i>
                    <input type="password" class="ipvalue" id="input4" name="firstpass" value="<?php if(isset($_POST['submitbtn'])) echo $pass; ?>" placeholder="&nbsp;Password (e.g.P@ssW0rd!)"/><br> 
                    <span  class="errormess" id="error4"><?php if(isset($_POST['submitbtn'])) echo $passerror; ?></span>
                </div>
                <div class="pass"> 
                    <i class="fas fa-lock"></i>
                    <input type="password" class="ipvalue" id="input5" name="secondpass" value="<?php if(isset($_POST['submitbtn'])) echo $cfmpass; ?>" placeholder="&nbsp;Confirm Password"/><br>
                    <span  class="errormess" id="error5"><?php if(isset($_POST['submitbtn'])) echo $cfmpasserror; ?></span>
                </div>
                <button type="submit" class="submitbtn" name="submitbtn" id="submitbtn"><?php echo $continue  ?></button><br>
                <span style="color:#90EE90; margin-left: 80px;"><?php echo $signvalue ?></span>
            </form>

        </div>

    </body>

</html>
