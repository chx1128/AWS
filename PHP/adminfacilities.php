<!--GLOBALISE VARIABLE-->
<?php
global $img,$scare,$happy,$image,$word;
global $facilityid;
global $newfacid,$newfacilityimg,$newfacilityname,$newfacilityscary,$newfacilityhappy,$newfacstatus,$newagerestrict;
global $selectFacID,$escaryr,$ehappyr,$facStatus,$facAge;
global $facstatus,$understatus;
global $counter;
global $i,$x;
global $newfacid,$newidn;
$newidn=0;
$counter=0;
global $addError;
global $facimguped;
$facimguped=0;

global $fachpyslt,$facscrslt;
$fachpyslt=0;
$facscrslt=0;

global $dltcount,$dltidd;
$dltcount=0;
$dltidd=0;

global $dltexistfacid;

global $dltedfacidcount,$detectdltid;
$dltedfacidcount=0;
$detectdltid=0;
?>

<!--DISPLAY MAIN-->
<?php
require_once("../secret/helper.php");
$con=new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
if($con->connect_error){
    die("DB OPEN ERROR".$con->connect_error);
}

$sql="SELECT facid,facimgname,facname,scare,happy,agerestrict FROM facility ORDER BY facid;";
$result=$con->query($sql);

if($result->num_rows>0){
    while($row=$result->fetch_object()){
        $facid[$counter]=$row->facid;
        $facimgname[$counter]=$row->facimgname;
        $facname[$counter]=$row->facname;
        $scare[$counter]=$row->scare;
        $happy[$counter]=$row->happy;
        $agerestrict[$counter]=$row->agerestrict;
        $counter++;
    }
}

else{
    echo"NO ROW FOUNDED!";
}

$result->free();
$con->close();

?>

<!--DISPLAY EDIT PAGE-->
<?php
require_once("../secret/helper.php");
$con=new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
if($con->connect_error){
    die("DB OPEN ERROR".$con->connect_error);
}

$sql="SELECT facimgname,facname,scare,happy,facid,facstatus,agerestrict FROM facility ORDER BY facid;";
$result=$con->query($sql);

if($result->num_rows){
    while($row=$result->fetch_object()){
        $facimgname[]=$row->facimgname;
        $facname[]=$row->facname;
        $scare[]=$row->scare;
        $happy[]=$row->happy;
        $facid[]=$row->facid;
        $facstatus[]=$row->facstatus;
        $agerestrict[]=$row->agerestrict;
        
    }
}

else{
    echo"OPEN FILE ERROR";
}

$result->free();
$con->close();

?>

<!--ADD FACILITIES ERROR MSS-->
<?php
function chckaddfac(){
    $addFacError=array();
    
    if($_POST["newfacilityname"]==null){
        $addFacError["newfacilityname"]="! Please Enter Facility Name !";
    }
    
    else if(strlen($_POST["newfacilityname"])<5){
        $addFacError["newfacilityname"]="(Facility Name)<br/>! At Least 5 Characters !";
    }
    
    else if(strlen($_POST["newfacilityname"])>15){
        $addFacError["newfacilityname"]="(Facility Name)<br/>! Exceed 15 Characters !";
    }
    
    else if(!preg_match("/^[A-za-z ]+$/",$_POST["newfacilityname"])){
        $addFacError["newfacilityname"]="(Facility Name)<br/>! Invalid Characters !";
    }
    
    if($_POST["newfacilityscary"]==null){
        $addFacError["newfacilityscary"]="! Please Select Scary Rate !";
    }
    
    if($_POST["newfacilityhappy"]==null){
        $addFacError["newfacilityhappy"]="! Please Select Happy Rate !";
    }
    
    if($_POST["newfacstatus"]==null){
        $addFacError["newfacstatus"]="! Please Select Facility Status !";
    }
    
    if($_POST["newagerestrict"]==null){
        $addFacError["newagerestrict"]="! Please Select Age-Restrict !";
    }
    
    return $addFacError;
    
}
?>

<!--Edit Facilities Error Mss-->
<?php
function chckEFac(){
    $eFacError=array();
    
    if($_POST["escaryr"]==null){
        $eFacError["escaryr"]="! Please Select Scary Rate !";
    }
    
    if($_POST["ehappyr"]==null){
        $eFacError["ehappyr"]="! Please Select Happy Rate !";
    }
    
    if($_POST["facStatus"]==null){
        $eFacError["facStatus"]="! Please Select Facility Status !";
    }
    
    if($_POST["facAge"]==null){
        $eFacError["facAge"]="! Please Select Age-Restriction !";
    }
    
    return $eFacError;
}
?>

<!--Delete Facilities Error Mss-->
<?php
function dltFacR(){
    $dltFacEM=array();
    
    if($_POST["dltSelectID"]==null){
        $dltFacEM["dltSelectID"]="! No Facility ID !";
    }
    
    return $dltFacEM;
}
?>

<!--Deleted facilities-->
<?php
require_once("../secret/helper.php");
$con=new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
if($con->connect_error){
    die("DB OPEN ERROR".$con->connect_error);
}

$sql="SELECT deletedfacid FROM deletedfac;";

$result=$con->query($sql);

if($result->num_rows>0){
    while($row=$result->fetch_object()){
        $deletedfacid[$dltcount]=$row->deletedfacid;
        $dltcount++;
    }
}

else{
    //do nothing
}

$result->free();
$con->close();


?>

<!--Deleted Facilities ID Auto Generation-->
<?php
for($dltidcount=0;$dltidcount<$dltcount;$dltidcount++){
    $dltidd++;
}

if($dltidd==0){
    $dltidd++;
}

$dltidd=sprintf("%04d",$dltidd);
$dltid='DF'.$dltidd;

for($dltidcount=0;$dltidcount<$dltcount;$dltidcount++){//avoid from overlaping of id
if(strcmp($dltid,$deletedfacid[$dltidcount])==0){
    $dltidd++;
}
}

$dltidd=sprintf("%04d",$dltidd);
$dltid='DF'.$dltidd;
?>

<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>
    
    <head>
        <meta charset="UTF-8">
        <title>ADMIN Facilities Modification</title>
        <script src="../CROPPER JS/cropper.js" type="text/javascript"></script>
        <link href="../CROPPER JS/cropper.css" rel="stylesheet" type="text/css"/>
        <!--CSS-->
        <style>
            *{
                margin:0px;
            }

        .facility{
            width: 1000px;;
            height:100%;
            display:flex;
            flex-wrap:wrap;
            justify-content:space-around;
            margin:auto;
            margin-bottom: 80px;
        }
        
        .wrap{
            width:410px;
            height:285px;
            margin-bottom:200px;
            
            margin-top:0px;
            border:1px solid transparent;
            border-radius:25px;
        }
        
        .facilities{
            width:410px;
            height:255px;
            margin-bottom:0px;
            margin-right:0px;
            margin-left:0px;
            margin-top:120px;
            border:1px solid transparent;
            border-radius:25px;
            box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;
        }
        
        
        .word{
            display: inline;
            width:0;
            height:0;
            font-size:1.5em;
            text-align: center;
            flex-wrap:wrap;
            
            justify-content:space-around;
        }
        
        
        .chatbot img{
            position:fixed;
            bottom:0px;
            right:0px;
            width:100px;
            height:100px;
            margin-bottom: 60px;
            margin-right:48px;
            z-index:50;
        }
        
        .chatbot img:hover{
            transform:scale(1.1);
        }
        
        .rate{
            margin-top:10px;
            margin-left: 70px;
            font-size: 0.8em;
            letter-spacing:1px;
            width:250px;
            height:40px;
            border:1px solid transparent;
            
        }
        
        .editbtn{
            margin-left:110px;
            width: 80px;
            height:30px;
            letter-spacing:1px;
            margin-top:-10px;
            cursor:pointer;
            border:1px solid black;
            border-radius:10px;
            transition:0.5s;
            box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;
        }
        .editbtn:hover{border-radius: 20px;}
        
        .dltbtn{ 
            width: 80px;
            height:30px;
            letter-spacing:1px;
            margin-top:-10px;
            cursor:pointer;
            border:1px solid black;
            border-radius:10px;
            transition:0.5s;
            box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;
        }
        
        .dltbtn:hover{ 
            border-radius: 20px;
        }
        
        .popup{
            background-color:#EEEEEE;
            width:900px;
            height:650px;
            text-align:center;
            font-size:1.5em;
            padding-top:100px;
            margin-left:250px;
            margin-top:-50px;
            border-radius:15px;
            visibility:hidden;
            position:fixed;
            transform:translate(0%,-50%) scale(0.1);
            transition:transform 0.4s, top 0.5s;
            padding-right:100px;
            
            z-index:100;
        }
        
        .popup img{
            width:560px;
            height:300px;
            margin-bottom:10px;
            margin-right:0px;
            margin-left:-150px;
            margin-top:10px;
            border:1px solid transparent;
        }
        
        .addbtn{
            position:absolute;
            font-size:1.8em;           
            font-weight: bold;
            margin:auto;
            margin-top:50px;
            margin-left: -700px;
            text-shadow: 4px 3px 9px rgba(0, 0, 0, 0.2);
        }
        
        .fcltaddbtn{
            background-color:#EEEEEE;
            width:1000px;
            height:680px;
            text-align:center;
            font-size:1.5em;
            padding-top:40px;
            padding-bottom:20px;
            margin-left:250px;
            top:0px;
            border-radius:15px;
            visibility:hidden;
            position:fixed;
            transform:translate(0%,-50%) scale(0.1);
            transition:transform 0.4s, top 0.5s;
            
        }
        .open-popup{
            visibility:visible;
            top:10%;
            transform:translate(0%,-6%) scale(1);
            position:fixed;
        }
        
        .editword{
            margin-left:-160px;
            margin-bottom:10px;
        }
        
        .editclosebtn{
            position:absolute;
            margin-left:700px;
            margin-top:-20px;
        }
        
        #closeaddbtn{
            position:absolute;
            margin-left:450px;
            margin-top:-15px;
            color:white;
            background-color:red;
            font-size:0.8em;
        }
        
        #editclosebtnn{
            color:white;
            background-color:red;
            font-size:0.8em;
        }
        
        
        .dltFacerror{
                position:absolute;
                background-color:white;
                margin-top:-1550px;
                font-size:2.2em;
                width:500px;
                height:300px;
                margin-left:350px;
                padding:100px;
                padding-left:200px;
                border:5px solid darkblue;
                border-radius:25px;
        }
        
        .editFacerror{
                position:absolute;
                background-color:white;
                margin-top:-1550px;
                font-size:2.2em;
                width:500px;
                height:300px;
                margin-left:350px;
                padding:100px;
                padding-left:200px;
                border:5px solid darkblue;
                border-radius:25px;
        }
        
        .addFacerror{
                position:absolute;
                background-color:white;
                margin-top:-1550px;
                font-size:2.2em;
                width:500px;
                height:300px;
                margin-left:350px;
                padding:100px;
                padding-left:200px;
                border:5px solid darkblue;
                border-radius:25px;
        }
        
        </style>
    </head>
    <body>
        <!--HEADER-->
        <?php 
        include('adminheader.php');
        ?>
        
        <!--Delete Facility-->
        <?php
            if(isset($_POST["dltFacbtn"])){
                
                $dltFacEM=dltFacR();
    
                if(empty($dltFacEM)){
                
            $dltSelectID=$_POST["dltSelectID"];
            $dltfacimg=$_POST["dltfacimg"];
            $dltfacname=$_POST["dltfacname"];
            $dltfacscare=$_POST["dltfacscare"];
            $dltfachappy=$_POST["dltfachappy"];
            $dltage=$_POST["dltage"];
            
            require_once("../secret/helper.php");
            $con = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
                
            if($con->connect_error){
                die("DB CONNECTION FAIL".$con->connect_error);
            }
            
            $sql="DELETE FROM facility WHERE facid=?";
            $sql2="INSERT INTO deletedfac(deletedfacid,deletedfacimgname,deletedfacname,deletedfacscare,deletedfachappy,deletedfacage,facid) VALUES(?,?,?,?,?,?,?);";
            
            $stmt=$con->prepare($sql);
            $stmt2=$con->prepare($sql2);
            
            $stmt->bind_param("s",$dltSelectID);
            $stmt2->bind_param("sssssss",$dltid,$dltfacimg,$dltfacname,$dltfacscare,$dltfachappy,$dltage,$dltSelectID);
            
            $stmt->execute();
            $stmt2->execute();
            
            if($stmt->affected_rows>0){
                echo "<script>alert('Facility $dltSelectID Deleted');</script>";
                echo "<script>location='adminfacilities.php'</script>";
            }
            
            else{
                echo "<script>alert('Database Issues ! Facilities $dltSelectID Not Deleted');</script>";
                echo "<script>location='adminfacilities.php'</script>";
            }
            
            $stmt->close();
            $con->close();
                    
            
            }
            
            else{
                echo"<div class='dltFacerror' id='dltFacerror'>";
                echo"<input type='button' value='X' style='position:absolute;margin-top:-80px;margin-left:-80px;background-color:red;color:white;' onclick='closeFacdlterror()'/>";
                echo"<h1 style='font-size:1.5em;position:absolute;margin-top:-90px;margin-left:65px;text-decoration:underline;'>Not-Deleted</h1>";
                echo"<ul>";
                printf("<li style='list-style-type:none;'>%s</li>",implode("</li><li style='list-style-type:none;'>",$dltFacEM));
                echo"</ul>";
                echo"</div>";
            }
            
            }
            
            else{
                //do nothing
            }
        ?>
        
        <!--CLOSE DLT ERROR MSS-->
        <script>
            function closeFacdlterror() {
                var dltFacerror = document.getElementById("dltFacerror");
                dltFacerror.style.display = 'none';
                location="adminfacilities.php";
            }

        </script>
        
        <!--First Main Display-->
        <div class="facility">
            <?php
            echo"<div class='addbtn'>";
                echo"<span style='color:green'>Add Facilities Option: </span>";
                echo"<button type='button' class='facaddbtn' onclick='facilityadd()' style='width:30px;height:30px;position:absolute;font-size:0.8em;cursor:pointer;margin-left:10px;color:green;'><b>+</b></button>";
                echo"</div>";
            echo"<div class='dltedfac' style='position:absolute;margin-top:50px;margin-left:750px;'>";
            echo"<a href='dltedfac.php'><button type='button' class='dltedfacbtn' style='width:200px;height:30px;font-size:1.2em;border:1px solid black;border-radius:5px;background-color:red;color:white;font-family:Roboto,monospace;'>Deleted Facilities</button></a>";
            echo"</div>";
            
            $i=0;
            for($i=0;$i<$counter;$i++){
            echo "<form action='' method='post'>
                <div class='wrap$i'>
                <div class='facilityclass'>
                <img src='/Assignment/IMAGE/$facimgname[$i]' class='facilities' />
                    </div>
                    <div class='word'>
                    <div class='facilitiesword'><b>$facname[$i]</b></div>
                    <div class='rate'><b>😱 $scare[$i]  🥰 $happy[$i]</b></div>
                    </div>
                    <button type='button' class='editbtn' onclick='Cpopup$i()'>EDIT</button>
                    <input type='hidden' name='dltSelectID' value='$facid[$i]'/>
                    <input type='hidden' name='dltfacimg' value='$facimgname[$i]'/>
                    <input type='hidden' name='dltfacname' value='$facname[$i]'/>
                    <input type='hidden' name='dltfacscare' value='$scare[$i]'/>
                    <input type='hidden' name='dltfachappy' value='$happy[$i]'/>
                    <input type='hidden' name='dltage' value='$agerestrict[$i]'/>
                    <input type='submit' class='dltbtn' name='dltFacbtn' onclick='dltfacility($i)' style='cursor:pointer;' value='DELETE'/>
                    
                    </div>
                    </form>    
                 ";
            
            }
            ?>
        </div>
        
        <!--Not overlapping the from deleted facility-->
        <?php
        require_once("../secret/helper.php");
        $con=new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
        if($con->connect_error){
        die("DB OPEN ERROR".$con->connect_error);
        }
        
        $sql="SELECT facid FROM deletedfac;";
        
        $result=$con->query($sql);
        
        if($result->num_rows>0){
            while($row=$result->fetch_object()){
                $dltexistfacid[$dltedfacidcount]=$row->facid;
                $dltedfacidcount++;
            }
        }
        
        $con->close();
        $result->free();
        
        ?>
        
        <!--Facility ID Generator-->
        <?php
        $x=0;
        $newidn=0;
        for($x=0;$x<($i+1);$x++){
            $newidn++;
        }
        
        $newidn=sprintf("%04d",$newidn);
        
        $newfacid='F'.$newidn;
        for($x=0;$x<count($facid);$x++){
        if(strcmp($newfacid,$facid[$x])==0){//avoid from overlapping id
            $newidn++;
            $newidn=sprintf("%04d",$newidn);
            $newfacid='F'.$newidn;
        }
        }
        
        for($detectdltid=0;$detectdltid<$dltedfacidcount;$detectdltid++){
        if(strcmp($newfacid,$dltexistfacid[$detectdltid])==0){
            $newidn++;
            $newidn=sprintf("%04d",$newidn);
            $newfacid='F'.$newidn;
        }
        }
        
        ?>
        
        <!--Edit Facility-->
        <?php
        if(isset($_POST["doneeditfac"])){
            $eFacError=chckEFac();
            
            if(empty($eFacError)){
            
            global $selectFacID,$escaryr,$ehappyr,$facStatus,$facAge;
            
            $selectFacID=$_POST["selectFacID"];
            $escaryr=$_POST["escaryr"];
            $ehappyr=$_POST["ehappyr"];
            $facStatus=$_POST["facStatus"];
            $facAge=$_POST["facAge"];
            
            require_once("../secret/helper.php");
            $con = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
                
            if($con->connect_error){
                die("DB CONNECTION FAIL".$con->connect_error);
            }
            
            $sql="UPDATE facility SET scare=?,happy=?,facstatus=?,agerestrict=? WHERE facid=? ;";
            $stmt=$con->prepare($sql);
            
            $stmt->bind_param("sssss",$escaryr,$ehappyr,$facStatus,$facAge,$selectFacID);
            
            $stmt->execute();
            
            if($stmt->affected_rows>0){
                echo "<script>alert('Facility $selectFacID Edited');</script>";
                echo "<script>location='adminfacilities.php';</script>";
            }
            
            else{
                echo "<script>alert('Database Issues! Facility $selectFacID Not Edited');</script>";
                echo "<script>location='adminfacilities.php';</script>";
            }
            
            $con->close();
            $stmt->close();
            }
            
            else{
                echo"<div class='editFacerror' id='editFacerror'>";
                echo"<input type='button' value='X' style='position:absolute;margin-top:-80px;margin-left:-80px;background-color:red;color:white;' onclick='closeFacediterror()'/>";
                echo"<h1 style='font-size:1.5em;position:absolute;margin-top:-90px;margin-left:65px;text-decoration:underline;'>Not-Edited</h1>";
                echo"<ul>";
                printf("<li style='list-style-type:none;'>%s</li>",implode("</li><li style='list-style-type:none;'>",$eFacError));
                echo"</ul>";
                echo"</div>";
            }
            
            
        }
        
        else{
            //done nothing
        }
        ?>
        
        <!--CLOSE EDIT ERROR MSS-->
        <script>
            function closeFacediterror() {
                var editFacerror = document.getElementById("editFacerror");
                editFacerror.style.display = 'none';
                location="adminfacilities.php";
            }

        </script>
        
            <!-- popup edit -->
            <?php
            $u=0;
            for($u=0;$u<$counter;$u++){
                //detect facility status based on data retrieve from db
                if($facstatus[$u]=='N'){
                    $facSstatus='selected';
                }
                
                else if($facstatus[$u]=='A'){
                    $facSstatus='';
                }
                //detect facility status based on data retrieve from db
                
                //detect age restrict based on data retrieve from db
                if($agerestrict[$u]=='O'){
                    $understatus='selected';
                }
                
                else if($agerestrict[$u]=='U'){
                    $understatus='';
                }
                //detect age restrict based on data retrieve from db
                
            echo"<div class='popup' id='popup$u' >
            <form action='' method='post' class='facilityclass' style='margin-left:240px;margin-top:-20px;'>
            <div class='editclosebtn'>
            <input type='button' id='editclosebtnn' value='X' onclick='donepopup()'/>
            </div>
            <div class='editword' style='margin-top:-50px;'>
            Facilities Picture : <br/>
            </div>
            <img src='/Assignment/IMAGE/$facimgname[$u]' class='facilityclass'/><br/>
            <div class='editword'>
            Facility ID : $facid[$u]<br/><br/>
            </div>
            <div class='editword'>
            Product Name : $facname[$u]<br/><br/>
                </div>
                <div class='editword'>
            <label for='escaryr'>Scary Rate 😱:</label>
                <select name='escaryr' id='escaryr'/><br/>
                <option value='1.0/5.0'>1.0/5.0</option>
                <option value='1.5/5.0'>1.5/5.0</option>
                <option value='2.0/5.0'>2.0/5.0</option>
                <option value='2.5/5.0'>2.5/5.0</option>
                <option value='3.0/5.0'>3.0/5.0</option>
                <option value='3.5/5.0'>3.5/5.0</option>
                <option value='4.0/5.0'>4.0/5.0</option>
                <option value='4.5/5.0'>4.5/5.0</option>
                <option value='5.0/5.0'>5.0/5.0</option>
                </select>
                <label for='ehappyr'>Happy Rate 🥰:</label>
                <select name='ehappyr' id='ehappyr'/><br/>
                <option value='1.0/5.0'>1.0/5.0</option>
                <option value='1.5/5.0'>1.5/5.0</option>
                <option value='2.0/5.0'>2.0/5.0</option>
                <option value='2.5/5.0'>2.5/5.0</option>
                <option value='3.0/5.0'>3.0/5.0</option>
                <option value='3.5/5.0'>3.5/5.0</option>
                <option value='4.0/5.0'>4.0/5.0</option>
                <option value='4.5/5.0'>4.5/5.0</option>
                <option value='5.0/5.0'>5.0/5.0</option>
                </select>
                </div>
                <div class='editword' style='position:absolute;margin-left:10px;'>
                <br/>
                Status: 
                    <select name='facStatus'>
                    <option value='A' >Available</option>
                    <option value='N' $facSstatus>Non-Available</option>
                    </select>
                </div>
                <div class='editword' style='position:abosolute;margin-left:80px;margin-top:38px;'>
                Age Restriction:
                    <select name='facAge'>
                    <option value='U' >Underage</option>
                    <option value='O' $understatus>Non-Underage</option>
                    </select>
                </div>
            <input type='hidden' value='$facid[$u]' name='selectFacID'/>
            <input type='submit' name='doneeditfac' class='donepopup' onclick='donepopup()' style='margin-top:20px;margin-left:-130px;' value='DONE'/>
            </form>
            </div>
            ";
            }
            ?>
            
            <!--OPEN POP UP-->
            <script>
        <?php
        $u=0;
        for($u=0;$u<$counter;$u++){
            echo"let popup$u = document.getElementById('popup$u');";
                
        }
        
        for($u=0;$u<$counter;$u++){
        echo"function Cpopup$u(){
                    popup$u.classList.add('open-popup')}";
        }
        ?>
            
        <!--CLOSE POP UP-->
        function donepopup() {
        <?php
        $u=0;
        for($u=0;$u<$counter;$u++){
        echo"popup$u.classList.remove('open-popup');";
        }
        ?>
            }
        
        </script>
            
            <!--CREATE NEW FACILITIES-->
            <?php            
            global $newfacid,$newfacilityimg,$newfacilityname,$newfacilityscary,$newfacilityhappy,$newfacstatus,$newagerestrict;
            
            if(isset($_POST["doneaddbtn"])){
                $addFacError=chckaddfac();
                if(empty($addFacError)){
                $newfacilityname=strtoupper($_POST["newfacilityname"]);
                $newfacilityscary=$_POST["newfacilityscary"];
                $newfacilityhappy=$_POST["newfacilityhappy"];
                $newfacstatus=$_POST["newfacstatus"];
                $newagerestrict=$_POST["newagerestrict"];
                
                if (isset($_FILES['fupimage'])) {
                    $file = $_FILES['fupimage']; //should be coming out warning on this line, afterward using another isset to solve it
                    if ($file['error'] > 0) {
                        //check error code
                        switch ($file['error']) {
                            case UPLOAD_ERR_NO_FILE: {//code=4(alternative way)
                                    $err = 'No file was selected';
                                    $facimguped=0;
                                    break;
                                }
                            case UPLOAD_ERR_FORM_SIZE: {//CODE =2(alternative way)
                                    $err = 'File uploaded is too large. Maximum 0.3204348MB allowed.';
                                    $facimguped=2;
                                    break;
                                    
                                }
                            default: {
                                    $err = 'There was an error while uploading the file.';
                                    $facimguped=0;
                                }
                        }
                    } 
                    else if ($file['size'] > 168000) {
                        $err = 'File uploaded is too large. Maximum 0.3204348MB allowed';
                        $facimguped=2;
                    } 
                    else {
                        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
                        if ($ext != 'jpg' &&$ext != 'jpeg' && $ext != 'gif' && $ext != 'png') {
                            $err = 'Only JPG,GIF, and PNG format are allowed';
                        } 
                        else {
                            $save_as =  uniqid() .$newfacid.'.'. $ext;
                            move_uploaded_file($file['tmp_name'], '../IMAGE/' . $save_as);
                            $facimguped=1;
                        }
                        
                    }
                }
                
                if($facimguped==1){
                require_once("../secret/helper.php");
                $con = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
                
                if($con->connect_error){
                    die("DB CONNECTION FAIL".$con->connect_error);
                }
                
                $sql="INSERT INTO facility(facid,facimgname,facname,scare,happy,facstatus,agerestrict) VALUES(?,?,?,?,?,?,?)";
                
                $stmt=$con->prepare($sql);
                $stmt->bind_param("sssssss",$newfacid,$save_as,$newfacilityname,$newfacilityscary,$newfacilityhappy,$newfacstatus,$newagerestrict);
                $stmt->execute();
                
                if($stmt->affected_rows>0){
                    echo "<script>alert('Facilities $newfacid Created');</script>";
                    echo "<script>location='adminfacilities.php'</script>";
                }
                
                else{
                    echo "<script>alert('Database Issues ! Facilities $newfacid Not Created');</script>";
                    echo "<script>location='adminfacilities.php'</script>";
                }
                
                $stmt->close();
                $con->close();
                }
                
                else{
                     if($facimguped==0){
                        echo"<script>alert('No Image Chosen');</script>";//to debug the error ofsize image
                     }
                     
                     else if($facimguped==2){
                        echo"<script>alert('File uploaded is too large. Maximum 0.3204348MB allowed!');</script>";//to debug the error ofsize image
                        
                     }
                }
            }
            
            else{
                echo"<div class='addFacerror' id='addFacerror'>";
                echo"<input type='button' value='X' style='position:absolute;margin-top:-80px;margin-left:540px;background-color:red;color:white;' onclick='closeFACadderror()'/>";
                echo"<h1 style='font-size:1.5em;position:absolute;margin-top:-90px;margin-left:65px;text-decoration:underline;'>Not-Added</h1>";
                echo"<ul>";
                printf("<li style='list-style-type:none;'>%s</li>",implode("</li><li style='list-style-type:none;'>",$addFacError));
                echo"</ul>";
                echo"</div>";
            }
            
            }
            
            else{
                //done nothing
            }
            ?>
        
        <!--CLOSE ADD ERROR MSS-->
        <script>
            function closeFACadderror() {
                var addFacerror = document.getElementById("addFacerror");
                addFacerror.style.display = 'none';
                location="adminfacilities.php";
            }

        </script>
                
            <!--add on pop up-->
                <?php
                echo"<div class='fcltaddbtn' id='fcltaddbtn'>
                <form action='' method='post' enctype='multipart/form-data'>
                <input type='button' id='closeaddbtn' value='X' onclick='closeaddpopup()'/>
                <div class='newfacimg'>
                Facilities Image : </br>
                <img src='/Assignment/IMAGE/newpd.jpg' class='inputpic' id='inputpic' style='width:560px;height:300px;margin-top:10px;border-radius:25px;'/><br/>
                <label for='inputbtn' style='background-color:#00032E;color:white;width:130px;height:25px;display:block;padding-top:3px;border-radius:10px;font-size:0.8em;margin-left:435px;margin-bottom:-30px;'>UPLOAD</label><br/>
                <button type='button' class='cropbtn' onclick='firstratio()'>16:9</button>
                <button type='button' class='cropbtn' onclick='secondratio()'>21:9</button>
                <input type='hidden' name='MAX_FILE_SIZE' value='168000'/>
                <input type='file' accept='image/jpeg,image/jpg,image/png' id='inputbtn' name='fupimage' style='display:none;'/><br/>
                <br/>
                <div class='newfacid' style='margin-left:-240px;'>New Facility ID <span style='margin-left:56px;'>:</span><b> $newfacid</b></div><br/>
                New Facilities Name :
                <input type='text' name='newfacilityname' style='width:300px;height:25px;' required/>
                <br/><br/>
                <label for='newfacilityscary' style='margin-left:-45px;'>Scary Rate 😱:</label>
                <select name='newfacilityscary' id='newfacilityscary'>
                <option value='1.0/5.0'>1.0</option>
                <option value='1.5/5.0'>1.5</option>
                <option value='2.0/5.0'>2.0</option>
                <option value='2.5/5.0'>2.5</option>
                <option value='3.0/5.0'>3.0</option>
                <option value='3.5/5.0'>3.5</option>
                <option value='4.0/5.0'>4.0</option>
                <option value='4.5/5.0'>4.5</option>
                <option value='5.0/5.0'>5.0</option>
                </select>
                <label for='newfacilityhappy' style='margin-left:50px;'>Happy Rate 🥰:</label>
                <select name='newfacilityhappy' id='newfacilityhappy'>
                <option value='1.0/5.0'>1.0</option>
                <option value='1.5/5.0'>1.5</option>
                <option value='2.0/5.0'>2.0</option>
                <option value='2.5/5.0'>2.5</option>
                <option value='3.0/5.0'>3.0</option>
                <option value='3.5/5.0'>3.5</option>
                <option value='4.0/5.0'>4.0</option>
                <option value='4.5/5.0'>4.5</option>
                <option value='5.0/5.0'>5.0</option>
                </select>
                <div class='newfacstat' style='position:absolute;margin-top:20px;margin-left:230px;'>
                <label for='newfacstat'>Status:</label>
                <select name='newfacstatus'>
                <option value='A'>Available</option>
                <option value='N' selected>Non-Available</option>
                </select>
                </div>
                <div class='newunderstat' style='position:absolute;margin-top:20px;margin-left:500px;'>
                <label for='newunderstat'>Age Restriction:</label>
                <select name='newagerestrict' style='margin-left:10px;'>
                <option value='U'>Underage</option>
                <option value='O' selected>Non-Underage</option>
                </select>
                </div>
                <br/><br/><br/>
                <input type='submit' name='doneaddbtn' class='doneaddbtn' onclick='doneaddpopup()' value='DONE'/>
                </form>
                </div>";
        
                ?>
            
                <script>
                function firstratio(){//width 560px, height 300px
                    var inputpic=document.getElementById("inputpic");
                    
                    inputpic.style.width=(560*1.05)+'px';
                    inputpic.style.height=(300*1.05)+'px';
                    inputpic.style.marginBottom='15px';
                }
                </script>
                        
                <script>
                function secondratio(){//width 560px, height 300px
                    var inputpic=document.getElementById("inputpic");
                    
                    inputpic.style.width=(560*0.8)+'px';
                    inputpic.style.height=(300*0.8)+'px';
                    inputpic.style.marginBottom='60px';
                }
                </script>     
                       
                
                <script>
                let fcltaddbtn = document.getElementById("fcltaddbtn");
                
                function facilityadd(){
                    fcltaddbtn.classList.add("open-popup");
                }
                
            
                function doneaddpopup() {
                    if($newfacilityname===null){
                        
                    }
                    
                    else{
                    fcltaddbtn.classList.remove("open-popup");
                }
                }   
                
                function closeaddpopup(){
                    fcltaddbtn.classList.remove("open-popup");
                }
        </script>
        
        <!--TO RETRIEVE IMAGE FROM FOLDER-->
        <script>
        <?php
        $imagename[]=array();
            echo "
                let inputpic = document.getElementById('inputpic');
                let inputbtn = document.getElementById('inputbtn');
                inputbtn.onchange = function () {
                inputpic.src = URL.createObjectURL(inputbtn.files[0]);
            };
            ";
        
        ?>
        </script>
        
        
    </body>
</html> 