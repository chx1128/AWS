<?php
require_once ("../secret/helper.php");
if (isset($_COOKIE['id'])) {
    $id=$_COOKIE['id'];
}
$con = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
if ($con->connect_error) {
    die("connection failed: " .$con->connect_error);
}
$size="60";
$sName=array();
$sEmail=array();
$sPass=array();
$sPhone=array();
$sql="select name,user_email,user_pass,phone from client";

$result =$con->query($sql);
if ($result->num_rows>0) {
    while ($row= $result->fetch_object()) {
        $sName[]=$row->name;
        $sEmail[]=$row->user_email;
        $sPass[]=$row->user_pass;
        $sPhone[]=$row->phone;
    }
}
$nameerror="";
$userInput="";
if (isset($_POST['updateuserbtn'])) {
    $userInput=$_POST['userInput'];
    if(empty($userInput))
    {
        $nameerror="*Nothing to update";
    }else if (in_array($userInput,$sName)) {
        $nameerror="*Name has been used";
    }else if (strlen($userInput)<3) {
        $nameerror="*Must be more than 3 characters";
    }else if (strlen($userInput)>30) {
        $nameerror="*Must be less than 30 characters";
    }else {
        $nameerror="";
        $sqlname="update client set name=? where user_id = ?";
        
        $stmtname=$con->prepare($sqlname);
        
        $stmtname->bind_param("ss",$userInput,$id);
        
        $stmtname->execute();
        
        if ($stmtname->affected_rows>0) {
            echo "<script>alert('successfully updated name : $userInput')</script>";
        } else {
            echo "<p>fail name</p>";
        }
        $userInput="";
    }

}
$dateerror="";
$updatedate="";
function isDateVali($dateString) {
    // Create DateTime objects for the input date and the date 100 years ago
    $current=date('Y');
    $dateparts =explode("-",$dateString);
    if ($current-$dateparts[0] >= 12 && $current-$dateparts[0] <100) {
        return 1;
    }else{return 0;}
}
if (isset($_POST['updatedatebtn'])) {
    $updatedate =$_POST['updatedate'];
    if (empty($updatedate)) {
        $dateerror="*Nothing to update";
    }else if (!isDateVali($updatedate)) {
        $dateerror= "*AGE RESTRICTION: >12 Years Old, <100 Years Old*";
    }else{
        $dateparts =explode("-",$updatedate);
        $current=date('Y');
        $agecount=$dateparts[0];
        $age=$current-$agecount;
        $dateerror="";
        
        $sqldate="update client set birth_date=? where user_id='$id'";
        $sqlage="update client set age=? where user_id='$id'";
        $stmtdate=$con->prepare($sqldate);
        $stmtage=$con->prepare($sqlage);
        $stmtdate->bind_param('s', $updatedate);
        $stmtage->bind_param('s', $age);
        $stmtdate->execute();
        $stmtage->execute();
        if ($stmtdate->affected_rows>0) {
            echo "<script>alert('successfully updated date : $updatedate')</script>";
        }else{
        echo "<script>alert('successfully updated date : $updatedate')</script>";
        }
        $updatedate=""; 
    }
}
$fpass;
$passerror="";
$updatepass="";
$cfmpass="";
$newpass="";
if (isset($_POST['updatepassbtn'])) {
    $sqlpass="select user_pass from client where user_id='$id'";
    $resultpass=$con->query($sqlpass);
    if ($resultpass->num_rows>0) {
        while ($row=$resultpass->fetch_object()) {
            $fpass=$row->user_pass;
        }
    }
    $updatepass=$_POST['oripass'];
    $newpass=$_POST['newpass'];
    $cfmpass=$_POST['cfmpass'];
    $horipass=hash('SHA256',$updatepass);
    $hnewpass=hash('SHA256',$newpass);
    if (empty($updatepass)) {
        $passerror="*Original password is required";
    }else if (strcmp($horipass,$fpass)!=0) {
        $passerror="*Invalid original password";
    }else if (empty($newpass)) {
        $passerror="*New Password required";
    }else if (!preg_match('/^(?=.*\d)(?=.*[A-Z])(?=.*[a-z])(?=.*[@!#$%])[0-9A-Za-z@!#$%]{8,15}$/',$newpass)) {
        $passerror="*Invalid password format";
    }else if (empty($cfmpass)) {
        $passerror="*Confirm Password required";
    }else if (!preg_match('/^(?=.*\d)(?=.*[A-Z])(?=.*[a-z])(?=.*[@!#$%])[0-9A-Za-z@!#$%]{8,15}$/',$cfmpass)) {
        $passerror="*Invalid password format for confirm password";
    }else if (strcmp($cfmpass,$newpass)!=0) {
        $passerror="*Password dint match";
    }else if(strcmp($newpass,$updatepass)==0){
        $passerror="*You are currently using this password";
    }else{
        $passerror="";
        $updatepass="";
        $cfmpass="";
        $newpass="";
        $sqlpass2="update client set user_pass =? where user_id='$id'";
        $stmtsqlpass2=$con->prepare($sqlpass2);
        $stmtsqlpass2->bind_param('s', $hnewpass);
        $stmtsqlpass2->execute();
        if ($stmtsqlpass2->affected_rows>0) {
            printf("<div>Sucess</div>");
            echo "<script>alert('PassWord has been updated! ')</script>";
        }
    }
}
$emailerror="";
$email="";
if (isset($_POST['updateemailbtn'])) {
    $email=$_POST['updateemail'];
    if (empty($email)) {
        $emailerror="*Nothing updated";
    }
    else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailerror="*Invalid fotmat";
    }else if(in_array($email, $sEmail)){
        $emailerror="*This email have been use";
    }else {
        $emailerror="";
        $sqlemail="update client set user_email=? where user_id ='$id'";
        $stmtphone=$con->prepare($sqlemail);
        $stmtphone->bind_param('s',$email);
        $stmtphone->execute();
        if ($stmtphone->affected_rows>0) {
            echo"<script>alert('success update email')</script>";
        }else{
        echo"<script>alert('fail update email')</script>";
        }
        $email="";
    }
}
$phoneerror="";
$phone="";
if (isset($_POST['updatephonebtn'])) {
    $phone=$_POST['updatephone'];
    if (empty($phone)) {
        $phoneerror="*Nothing updated";
    }else if (!preg_match("/^01[0-9]-\d{7,8}$/", $phone)) {
        $phoneerror = "*Invalid phone number (format : 01X-XXXXXXX )";
    }else if (in_array($phone, $sPhone)) {
        $phoneerror="*This Phone number have been used";
    }else {
        $phoneerror="";
        $sqlphone="update client set phone=? where user_id='$id'";
        $stmtphone=$con->prepare($sqlphone);
        $stmtphone->bind_param('s',$phone);
        $stmtphone->execute();
        if ($stmtphone->affected_rows>0) {
            echo"<script>alert('success update phone number to $phone')</script>";
        }
        else{
            echo"<script>alert('fail update phone number to $phone')</script>";
        }
        $phone="";
        
       
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
        <title>Edit profile</title>
        <style>
            body{width:1600px;margin:auto;height: 800px;}
            .container2{margin-top: 50px;margin-bottom: 200px;}
            fieldset{width: 500px;margin-left: 700px;height:60px;margin-top: 20px;transition: 0.5s;overflow: hidden;font-size: 1.1em;
                     border-radius: 20px;border: 2px solid black;box-shadow: 23px 34px 63px -28px rgba(0,0,0,0.7);}
            legend{font-size: 1.1em;font-weight: bold;margin-left: 20px;}
            fieldset form{margin-top:20px;margin-left: 30px;}
            .arrowbtn{margin-left:530px;font-size: 1.5em;border: none;background-color: white;}
            fieldset input{margin-left: 20px;}
            .container0{width: 350px;height: 350px;border:2px solid black;float:left;margin-left: 230px;margin-top: 100px;box-shadow: 23px 34px 63px -28px rgba(0,0,0,0.7);}
            .container1{width: 300px;height: 350px;}
            .upimage{margin-top: 10px;}
            .container1img{width: 350px;height: 350px;}
            input[type="file"]{display: none;}
            .labelfupimg{display:block;margin-left: 30px;font-size: 1.3em;margin-top: 20px;cursor:pointer;font-weight: bold;
            width: 200px;height: 40px;text-align: center;padding-top: 12px;background-color:#f53131;border-radius:20px;transition: 0.2s;}
            .labelfupimg:hover{background-color:#fa7575;border-radius: 25px;}
            .updatebtn{width:80px;height: 40px;background-color:skyblue;border:none;border-radius: 10px;font-weight: bold;cursor: pointer;transition: 0.5s;box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;}
            .updatebtn:hover{opacity: 0.8;}
            .updateimg{margin-left: 260px;margin-top: -45px;position: absolute;}
            input{width:200px;height:30px;border-radius: 10px;border:1px solid black;padding-left: 20px;}
            input[type="password"]{margin-bottom: 8px;}
            .errormess{color:red;font-size: 0.8em;margin-top: -50px;position:absolute;}
                     
        </style>
    </head>
    
    <body>
        <?php
        include 'header.php';
        ?>
        
        <div class="container0">
            
            <?php 
            $sqlshowimg="select personal_img from client where user_id ='$id'";
            $resultshowimg=$con->query($sqlshowimg);
            if ($resultshowimg->num_rows>0) {
                while ($row=$resultshowimg->fetch_object()) {
                    $showimg=$row->personal_img;
                }
            }
            ?>
            <div class="container1">
                <img src="<?php echo "https://tarumtbucket2305835.s3.amazonaws.com/$showimg";   ?>" class="container1img" id="container1img"/>
            </div>
            <?php
            if (isset($_POST["updatebtn"])) {
                if (isset($_FILES['fupimage'])) {
                    $file = $_FILES['fupimage']; //should be coming out warning on this line, afterward using another isset to solve it
                    if ($file['error'] > 0) {
                        //check error code
                        switch ($file['error']) {
                            case UPLOAD_ERR_NO_FILE: {//code=4(alternative way)
                                    $err = 'No file was selected';
                                    break;
                                }
                            case UPLOAD_ERR_FORM_SIZE: {//CODE =2(alternative way)
                                    $err = 'File uploaded is too large. Maximum 1MD allowed.';
                                    break;
                                }
                            default: {
                                    $err = 'There was an error while uploading the file.';
                                }
                        }
                    } 
                    else if ($file['size'] > 10485760000000) {
                        $err = 'File uploaded is too large. Maximum 1MB allowed';
                    } 
                    else {
                        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
                        if ($ext != 'jpg' &&
                                $ext != 'jpeg' &&
                                $ext != 'gif' &&
                                $ext != 'png') {
                            $err = 'Only JPG,GIF, and PNG format are allowed';
                        } else {
                            $save_as = uniqid(). $id .'.'. $ext;
                            $filePaths = glob("https://tarumtbucket2305835.s3.amazonaws.com/*{$id}.{png,jpg,jpeg,gif}", GLOB_BRACE);
                            if (!empty($filePaths)) {
                                $basename = pathinfo($filePaths[0], PATHINFO_BASENAME);
                                //echo "<script>alert('$basename');</script>";
                                unlink($filePaths[0]);
                            }
                            move_uploaded_file($file['tmp_name'], 'https://tarumtbucket2305835.s3.amazonaws.com/' . $save_as);
                           $sqlimg="update client set personal_img = ? where user_id='$id'";
                           $stmtimg=$con->prepare($sqlimg);
                           $stmtimg->bind_param('s', $save_as);
                           $stmtimg->execute();
                           echo "<script>alert('Sucess update profile img');</script>";
                           echo "<script>location='editprofile.php';</script>";
                           
                           
                        }
                    }
                }
            }
            ?>
            <form action="" method="post" enctype="multipart/form-data">
            <label for="upload-image" class="labelfupimg">Upload Image</label>
            <input type="hidden" name="MAX_FILE_SIZE" value="104857600000000"/>
            <input type="file" id="upload-image" name="fupimage" acceptimage="/jpeg,image/jpg,image/png">
            <button class="updatebtn updateimg" onclick="updateimage()" name="updatebtn">Update</button>
            </form>
            
            
            
            <script>
                
             let original=document.getElementById("container1img");
             let uploadimg=document.getElementById("upload-image");

             uploadimg.onchange=function(){
             original.src=URL.createObjectURL(uploadimg.files[0])
    }
            </script>
        </div> 
        
        <div class="container2">
            <fieldset class="field1" id="field1">
                <legend>Changing username</legend>
                <button class="arrowbtn" id="btn1" onclick="changefield('field1',this)">V</button>
                <form action="" method="post" >
                    <span class="errormess" id="error1"><p><?php echo $nameerror; ?></p></span><br>
                     New Username: <input type="text" placeholder="username" name="userInput" id="userInput" <?php echo "value='$userInput'"?>/><br>
                     <button class="updatebtn" name="updateuserbtn" id="userbtn" type="submit">Update</button>
                </form>
            </fieldset>
            <fieldset class="field2" id="field2">
                <legend>Changing email</legend>
                <button class="arrowbtn" id="btn2" onclick="changefield('field2',this)">V</button>
                <form action="" method="post">
                    <span class="errormess" id="error2"><?php echo "$emailerror"; ?></span><br>
                    New email:<input type="email" placeholder="email" id="emailInput" name="updateemail" <?php echo"value='$email'"; ?>/>
                    <button class="updatebtn" type="submit" name="updateemailbtn">Update</button>
                </form>
                </fieldset>
                <fieldset class="field3" id="field3">
                <legend>Changing Phone number</legend>
                <button class="arrowbtn" id="btn3" onclick="changefield('field3',this)">V</button>
                <form action="" method="post"  >
                    <span class="errormess" id="error3"><?php echo "$phoneerror"; ?></span><br>
                    New Phone number:<input type="tel"placeholder="phone number" id="phoneInput" name="updatephone" <?php echo "value='$phone'";  ?>/><br>
                <button class="updatebtn" type="submit" name="updatephonebtn">Update</button>
                </form>
            </fieldset>
            <fieldset class="field4" id="field4">
                <legend>Changing date of birth</legend>
                <button class="arrowbtn" id="btn4" onclick="changefield('field4',this)">V</button>
                <form action="" method="POST">
                    <span class="errormess" id="error4"><?php echo $dateerror; ?></span><br>
                    update Date of Birth:<input type="date" name="updatedate" placeholder="Date of Birth" id="dateInput"  <?php echo "value='$updatedate'"?> /><br>
                <button class="updatebtn"  name="updatedatebtn">Update</button>
                </form>
            </fieldset>
            <fieldset class="field5" id="field5">
                <legend>Changing password</legend>
                <button class="arrowbtn" id="btn5" onclick="changefield('field5',this)">V</button>
                <form action="" method="post" style="margin-top: -1px;">
                    <span class="errormess" id="error5" style="margin-top: -20px;"><?php echo $passerror; ?></span><br>
                    original password<input type="password" placeholder="original password" id="oripass" name="oripass" <?php echo "value='$updatepass'"?>/><br>
                    New password<input type="password" placeholder="new password" id="newpass" name="newpass" <?php echo "value='$newpass'"?>/><br>
                    Confirm password<input type="password" placeholder="confirm password" id="cfmpass" name="cfmpass" <?php echo "value='$cfmpass'"?>/>
                    <button class="updatebtn"name="updatepassbtn" type="submit">Update</button>
                </form>
            </fieldset>
        </div>
        <script>
            
            function updatephone(event){
                event.preventDefault(); 
                var updatephoneInput =document.getElementById("phoneInput").value;
                var pattern = /^01[0-9]-\d{7,8}$/;
                var error3 = document.getElementById("error3");
                error3.innerHTML = "";
                if (!pattern.test(updatephoneInput)) {
                    error3.innerHTML ="Invalid phone format(01x-xxxxxxx)";
                    return false;
                }else if(updatephoneInput === localStorage.phone){
                    error3.innerHTML ="cannot same with previous number";
                    return false;
                }
                else{alert("please check your email to change your phone number");localStorage.phone=updatephoneInput;return true;}
            }
            function changefield(id,value){
            var fieldset = document.getElementById(id);
            var current =window.getComputedStyle(fieldset).height;
            
            if(current === "200px"){
                fieldset.style.height ="60px";
                value.style.transform="rotate(0deg)";
            }
            else if(current==="60px"){
                fieldset.style.height ="200px";
                value.style.transform="rotate(180deg)";
            }
        }
        
        </script>
       <?php
        include("footer.php");
        ?>
    </body>
</html>
