<!--Globalise Variable-->
<?php
global $ticketname, $ticketclass, $catname, $catclass, $imagename, $wordclass, $ticketprice, $ticketqty, $productid;
global $newticketname, $newticketprice, $newtkqty, $newticketimg, $newticketdesc, $newticketcat, $newticketstatus;
global $prodidc, $prodidn, $newprodid;
global $x, $i;
global $editcatcount;
$editcatcount = 0;
$prodidn = 0;
$newidn = 0;
global $adderror, $editerror;
global $editticketstat, $editprodid;
global $l;
$l = 0;
global $selectedID;
global $deleteprodid1, $deleteprodid2, $deleteprodid3;
global $count1, $count2, $count3;
$count1 = 0;
$count2 = 0;
$count3 = 0;
global $productid1, $productid2, $productid3;
global $editcounter1, $editcounter2, $editcounter3;
$editcounter1 = 0;
$editcounter2 = 0;
$editcounter3 = 0;

global $counter1, $counter2, $counter3;
$counter1 = 0;
$counter2 = 0;
$counter3 = 0;

global $ecount;
$ecount = 0;

global $editcounter;
$editcounter = 0;

global $ed;
$ed = 0;

global $chckC1,$chckC2,$chckC3,$chckI1,$chckI2,$chckI3;
$chckI1=0;
$chckI2=0;
$chckI3=0;

global $imguped;
$imguped=0;

global $dltidcount,$dltidd,$dltcount;
$dltidcount=0;
$dltidd=0;
$dltcount=0;

global $detectdltid;
global $dltedtkidcount;
$dltedtkidcount=0;
global $dltexisttkid;
?>

<!--Retrieve Cat 1 Data-->
<?php
require_once("../secret/helper.php");

$con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($con->connect_error) {
    die("DB CONNECTION FAIL!" . $con->connect_error);
}

$sql = "SELECT productid,ticketname,imagename,ticketprice,ticketdesc,ticketcat FROM ticket WHERE ticketcat='SA' ORDER BY productid ;";

$result = $con->query($sql);

//a
if ($result->num_rows > 0) {
    while ($row = $result->fetch_object()) {
        $productid1[$counter1] = $row->productid;
        $ticketname1[$counter1] = $row->ticketname;
        $imagename1[$counter1] = $row->imagename;
        $ticketprice1[$counter1] = $row->ticketprice;
        $ticketdesc1[$counter1]=$row->ticketdesc;
        $ticketcat1[$counter1]=$row->ticketcat;
        $counter1++;
    }
//
} else {
    
}
$result->free();
$con->close();
?>
<!--Retrieve Cat 2 data-->
<?php
require_once("../secret/helper.php");

$con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($con->connect_error) {
    die("DB CONNECTION FAIL" . $con->connect_error);
}

$sql = "SELECT productid,ticketname,imagename,ticketprice,ticketdesc,ticketcat FROM ticket WHERE ticketcat='PA' ORDER BY productid ;";

$result = $con->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_object()) {
        $productid2[$counter2] = $row->productid;
        $ticketname2[$counter2] = $row->ticketname;
        $imagename2[$counter2] = $row->imagename;
        $ticketprice2[$counter2] = $row->ticketprice;
        $ticketdesc2[$counter2]=$row->ticketdesc;
        $ticketcat2[$counter2]=$row->ticketcat;
        $counter2++;
    }
} else {
    
}

$result->free();
$con->close();
?>
<!--Retrieve Cat 3 data-->
<?php
require_once("../secret/helper.php");

$con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($con->connect_error) {
    die("DB CONNECTION ERROR" . $con->connect_error);
}

$sql = "SELECT productid,ticketname,imagename,ticketprice,ticketdesc,ticketcat FROM ticket WHERE ticketcat = 'IA' ORDER BY productid;";

$result = $con->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_object()) {
        $productid3[$counter3] = $row->productid;
        $ticketname3[$counter3] = $row->ticketname;
        $imagename3[$counter3] = $row->imagename;
        $ticketprice3[$counter3] = $row->ticketprice;
        $ticketdesc3[$counter3]=$row->ticketdesc;
        $ticketcat3[$counter3]=$row->ticketcat;
        $counter3++;
    }
} else {
    
}

$result->free();
$con->close();
?>

<!--SA Edit Pop Up-->
<?php
require_once("../secret/helper.php");

$con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($con->connect_error) {
    die("DB CONNECTION FAIL" . $con->connect_error);
}

$sql = "SELECT imagename,productid,ticketname,ticketprice,ticketcat,ticketdesc,ticketstatus FROM ticket WHERE ticketcat='SA' ORDER BY productid;";
$result = $con->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_object()) {
        $editimagename1[$editcounter1] = $row->imagename;
        $editproductid1[$editcounter1] = $row->productid;
        $editticketname1[$editcounter1] = $row->ticketname;
        $editicketprice1[$editcounter1]=$row->ticketprice;
        $editticketcat1[$editcounter1] = $row->ticketcat;
        $editticketdesc1[$editcounter1] = $row->ticketdesc;
        $editticketstatus1[$editcounter1] = $row->ticketstatus;
        $editcounter1++;
        $editcounter++;
    }
} else {
    echo"NO RECORD FOUND!";
}

$result->free();
$con->close();
?>
<!--PA Edit PopUp-->
<?php
require_once("../secret/helper.php");

$con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($con->connect_error) {
    die("DB CONNECTION FAIL" . $con->connect_error);
}

$sql = "SELECT imagename,productid,ticketname,ticketprice,ticketcat,ticketdesc,ticketstatus FROM ticket WHERE ticketcat='PA' ORDER BY productid ;";
$result = $con->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_object()) {
        $editimagename2[$editcounter2] = $row->imagename;
        $editproductid2[$editcounter2] = $row->productid;
        $editticketname2[$editcounter2] = $row->ticketname;
        $editicketprice2[$editcounter2]=$row->ticketprice;
        $editticketcat2[$editcounter2] = $row->ticketcat;
        $editticketdesc2[$editcounter2] = $row->ticketdesc;
        $editticketstatus2[$editcounter2] = $row->ticketstatus;
        $editcounter2++;
        $editcounter++;
    }
} else {
    echo"NO RECORD FOUND!";
}

$result->free();
$con->close();
?>
<!--IA Edit PopUp-->
<?php
require_once("../secret/helper.php");

$con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($con->connect_error) {
    die("DB CONNECTION FAIL" . $con->connect_error);
}

$sql = "SELECT imagename,productid,ticketname,ticketprice,ticketcat,ticketdesc,ticketstatus FROM ticket WHERE ticketcat='IA' ORDER BY productid;";
$result = $con->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_object()) {
        $editimagename3[$editcounter3] = $row->imagename;
        $editproductid3[$editcounter3] = $row->productid;
        $editticketname3[$editcounter3] = $row->ticketname;
        $editicketprice3[$editcounter3]=$row->ticketprice;
        $editticketcat3[$editcounter3] = $row->ticketcat;
        $editticketdesc3[$editcounter3] = $row->ticketdesc;
        $editticketstatus3[$editcounter3] = $row->ticketstatus;
        $editcounter3++;
        $editcounter++;
    }
} else {
    echo"NO RECORD FOUND!";
}

$result->free();
$con->close();
?>

<!--Create Product Error Message-->
<?php

function checkAddError() {
    $adderror = array();

    if ($_POST["newticketname"] == null) {
        $adderror["newticketname"] = "&nbsp&nbsp&nbsp&nbsp&nbsp(Ticket Name)<br/>! Please Enter Ticket Name !<br/>";
    } 
    
    else if (strlen($_POST["newticketname"]) < 10) {
        $adderror["newticketname"] = "&nbsp&nbsp&nbsp&nbsp&nbsp(Ticket Name)<br/>! At Least 10 Character !</br>";
    } 
    
    else if (strlen($_POST["newticketname"]) > 18) {
        $adderror["newticketname"] = "&nbsp&nbsp&nbsp&nbsp&nbsp(Ticket Name)<br/>! Exceed 18 Character !</br>";
    }
    
    else if (!preg_match("/^[A-Za-z ]+$/", $_POST["newticketname"])) {
        $adderror["newticketname"] = "&nbsp&nbsp&nbsp&nbsp&nbsp(Ticket Name)<br/>! Invalid Character !<br/>";
    }

    if ($_POST["newticketprice"] == null) {
        $adderror["newticketprice"] = "&nbsp&nbsp&nbsp&nbsp&nbsp(Ticket Price)<br/>! Please Enter Ticket Price !<br/>";
    } 
    
    else if (!preg_match("/^\d+\.\d+$/", $_POST["newticketprice"])) {
        $adderror["newticketprice"] = "&nbsp&nbsp&nbsp&nbsp&nbsp(Ticket Price)<br/>! Format [XX.XX] !<br/>";
    }

    else if($_POST["newticketprice"] == "00.00"){
                $adderror["newticketprice"] = "&nbsp&nbsp&nbsp&nbsp&nbsp(Ticket Price)<br/>! Not Accepted 00.00 !<br/>";

    }
    
    if ($_POST["newticketdesc"] == null) {
        $adderror["newticketdesc"] = "&nbsp&nbsp&nbsp&nbsp&nbsp(Ticket Desc)<br/>! Please Enter Description !<br/>";
    } 
    
    else if (strlen($_POST["newticketdesc"]) < 10) {
        $adderror["newticketdesc"] = "&nbsp&nbsp&nbsp&nbsp&nbsp(Ticket Desc)<br/>! At Least 10 Characters !<br/>";
    }
    
    else if (strlen($_POST["newticketdesc"]) > 50) {
        $adderror["newticketdesc"] = "&nbsp&nbsp&nbsp&nbsp&nbsp(Ticket Desc)<br/>! Exceed 50 Characters !<br/>";
    }

    if ($_POST["newticketcat"] == null) {
        $adderror["newticketcat"] = "! Please Select a Category !";
    }

    if ($_POST["newticketstatus"] == null) {
        $adderror["newticketstatus"] = "! Please Select a Ticket Status !";
    }

    return $adderror;
}
?>

<!--Edit Prod Check Error-->
<?php

function checkEditError() {
    $editerror = array();

    if ($_POST["selectedID"] == null) {
        $editerror["selectedID"] = "! INVALID ID !<br/>";
    }

    if ($_POST["ticketstat"] == null) {
        $editerror["ticketstat"] = "! PLEASE SELECT TICKET STATUS !<br/>";
    } else if ($_POST["ticketstat"] != 'A' && $_POST["ticketstat"] != 'N') {
        $editerror["ticketstat"] = "! INVALID TICKET STATUS !<br/>";
    }

    return $editerror;
}
?>

<!--Check Delete Error1-->
<?php

function checkDeleteError1() {
    $dlterror1 = array();

    if ($_POST["deleteprodid1"] == null) {
        $dlterror1["deleteprodid1"] = "! Invalid Blank Product ID 1 !<br/>";
    }


    return $dlterror1;
}
?>

<!--Check Delete Error2-->
<?php

function checkDeleteError2() {
    $dlterror2 = array();

    if ($_POST["deleteprodid2"] == null) {
        $dlterror2["deleteprodid2"] = "! Invalid Blank Product ID 2 !<br/>";
    }


    return $dlterror2;
}
?>

<!--Check Delete Error3-->
<?php

function checkDeleteError3() {
    $dlterror3 = array();

    if ($_POST["deleteprodid3"] == null) {
        $dlterror3["deleteprodid3"] = "! Invalid Blank Product ID 3 !<br/>";
    }


    return $dlterror3;
}
?>

<!--Deleted products-->
<?php
require_once("../secret/helper.php");
$con=new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
if($con->connect_error){
    die("DB OPEN ERROR".$con->connect_error);
}

$sql="SELECT deletetkid FROM deletedtic;";

$result=$con->query($sql);

if($result->num_rows>0){
    while($row=$result->fetch_object()){
        $deletetkid[$dltcount]=$row->deletetkid;
        $dltcount++;
    }
}

else{
    //do nothing
}

$result->free();
$con->close();


?>

<!--Deleted Products ID Auto Generation-->
<?php
for($dltidcount=0;$dltidcount<$dltcount;$dltidcount++){
    $dltidd++;
}

if($dltidd==0){
    $dltidd++;
}

$dltidd=sprintf("%04d",$dltidd);
$dltid='DT'.$dltidd;

for($dltidcount=0;$dltidcount<$dltcount;$dltidcount++){//avoid from overlaping of id
if(strcmp($dltid,$deletetkid[$dltidcount])==0){
    $dltidd++;
}
}

$dltidd=sprintf("%04d",$dltidd);
$dltid='DT'.$dltidd;

?>

<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>
    <!--CSS-->
    <head>
        <meta charset="UTF-8">
        <title>PRODUCT STATUS</title>
        <link href="../CSS/adminhome.css" rel="stylesheet" type="text/css"/>
        <!--CSS-->
        <style>
            body{
                background-color:white;
            }
            .categories{
                width:1100px;
                height:50px;
                border:1px solid transparent;
                margin-top:20px;
                margin-left:23px;
                margin-bottom:-25px;
                font-family:Helvetica;
                font-size:2.5em;
                color:#EDCE81;
            }
            .ticket{
            background-color:white;
            width:1000px;
            height:100%;
            display:flex;
            flex-wrap: wrap;
            justify-content:space-around;
            border:1px solid transparent;
            margin:auto;
            margin-top: 20px;
            margin-bottom: 200px;
            }
            .ticketwrap{
                width:400px;
                height:225px;
                margin-bottom:0px;
                margin-right:0px;
                margin-left:0px;
                margin-top:10px;
                border:1px solid transparent;
                border-radius:25px;

            }

            .ticketclass{
                width:400px;
                height:120px;
                margin-bottom:10px;
                margin-right:0px;
                margin-left:0px;
                margin-top:10px;
                border:1px solid transparent;
                align-items:center;
            }

            .word{
                display: inline;
                width:0;
                height:0;
                font:Helvetica;
                font-size:1.3em;
                text-align: center;
            }

            .editbtn{
                margin-left:150px;
                margin-top:10px;
            }

            .popup{
                background-color:#EEEEEE;
                width:1000px;
                height:680px;
                text-align:center;
                font-size:1.5em;
                padding-top:100px;
                margin:220px;
                top:-35px;
                border-radius:15px;
                visibility:hidden;
                position:fixed;
                transform:translate(0%,-50%) scale(0.1);
                transition:transform 0.4s, top 0.5s;

            }



            .popup img{
                width:733.33px;
                height:220px;
                margin-bottom:10px;
                margin-right:0px;
                margin-left:-160px;
                margin-top:10px;
                border:1px solid transparent;
            }

            .addingbtn{
                background-color:#EEEEEE;
                width:1000px;
                height:730px;
                text-align:center;
                font-size:1.5em;
                padding-top:40px;
                margin-left:215px;
                top:0px;
                visibility:hidden;
                border-radius:15px;
                position:fixed;
                transform:translate(0%,-50%) scale(0.1);
                transition:transform 0.4s, top 0.5s;
            }


            .open-popup{
                visibility:visible;
                transform:translate(0%,-6%) scale(1);
                margin-top: 50px;
                position:fixed;
            }

            .addinputwrap{
                text-align: left;
                width:850px;
                margin:auto;
                padding-left:80px;
                margin-top: 15px;
            }

            .addinputwrap input{
                position:absolute;
                margin-left: 50px;
            }

            .addingbtnpopup{
                margin-left:-975px;
                position:absolute;
                font-size:1.2em;
                margin-top:2px;
                color:green;
            }

            .addprod{
                margin-left:-1100px  ;
                margin-right:50px;
                position:absolute;
                font-size:1.8em;
                color:green;
            }

            .editclosebtn{
                position:absolute;
                margin-top:-60px;
                margin-left:650px;
            }

            .addclosebtn{
                position:absolute;
                margin-top:-20px;
                margin-left:930px;
            }

            #closeaddbtn{
                position:absolute;
                margin-left:480px;
                margin-top:-15px;
                background-color:red;
                color:white;
                font-size:0.8em;
            }

            .editclosebtnn{
                color:white;
                background-color:red;
                margin-top: 30px;
                font-size:0.8em;
            }

            .adderror{
                position:absolute;
                background-color:white;
                margin-top:-1150px;
                font-size:2.2em;
                width:500px;
                height:300px;
                margin-left:350px;
                padding:100px;
                padding-left:200px;
                border:5px solid darkblue;
                border-radius:25px;

            }

            .editerror{
                position:absolute;
                background-color:white;
                margin-top:-1150px;
                font-size:1.8em;
                width:500px;
                height:300px;
                margin-left:350px;
                padding:100px;
                border:5px solid darkblue;
                border-radius:25px;

            }


            .editinfo{
                position:absolute;
                background-color:white;
                margin-top:-1350px;
                font-size:2.8em;
                width:550px;
                height:100px;
                margin-left:350px;
                padding:100px;
                border:5px solid darkblue;
                border-radius:25px;
                padding-top:120px;
            }

            .dltedprod1{
                position:fixed;
                background-color:white;
                margin-top:-1350px;
                font-size:2.8em;
                width:550px;
                height:100px;
                margin-left:350px;
                padding:100px;
                border:5px solid darkblue;
                border-radius:25px;
                padding-top:120px;
            }

            .dltedprod2{
                position:fixed;
                background-color:white;
                margin-top:auto;
                font-size:2.8em;
                width:550px;
                height:100px;
                margin-left:350px;
                padding:100px;
                border:5px solid darkblue;
                border-radius:25px;
                padding-top:120px;
            }

            .dltedprod3{
                position:fixed;
                background-color:white;
                margin-top:auto;
                font-size:2.8em;
                width:550px;
                height:100px;
                margin-left:350px;
                padding:100px;
                border:5px solid darkblue;
                border-radius:25px;
                padding-top:120px;
            }
        </style>

    </head>
    <body>

    <?php
    include('adminheader.php');
    ?>
        <!--Main Display-->
        <div class="ticket">
    <?php
    $tickc = 0;

    echo"
                <div class='addprod'><b>Add Product: </b></div>
                <button type='button' class='addingbtnpopup' onclick='add()' style='cursor:pointer;margin-left:-920px'><b>+</b></button>
                <br/>
            ";
    echo"<div class='dltedtic' style='position:absolute;margin-top:0px;margin-left:900px;'>";
            echo"<a href='dltedtic.php'><button type='button' class='dltedticbtn' style='width:200px;height:30px;font-size:1.2em;border:1px solid black;border-radius:5px;background-color:red;color:white;font-family:Roboto,monospace;'>Deleted Tickets</button></a>";
            echo"</div>";
    //1st cat
    echo"
            <div class='categories'>
            <div class='catclass1'><b style='text-decoration:none;'>SPOT ACCESS &nbsp
            </b></div>
            </div>    
            ";

    for ($x = 0; $x < $counter1; $x++) {
    echo"<div class='ticketwrap'><form action='' method='post'><img src='https://tarumtbucket2305835.s3.amazonaws.com/$imagename1[$x]' class='ticketclass' name='imagename1'/>
                     <div class='word'>
                     <div class='wordclass' name='ticketname1'>$ticketname1[$x]</div>
                     <div class='ticketprice' style='margin-top:3px;' name='ticketprice1'>RM $ticketprice1[$x]</div>
                     <button type='button' class='editbtn' onclick='Cpopup1$x()' style='cursor:pointer;'>EDIT</button> 
                     <input type='hidden' name='deleteprodid1' value='$productid1[$x]'/>
                     <input type='hidden' name='deletetkname1' value='$ticketname1[$x]'/>
                     <input type='hidden' name='deleteimgname1' value='$imagename1[$x]'/>
                     <input type='hidden' name='deletetkprice1' value='$ticketprice1[$x]'/>
                     <input type='hidden' name='deletetkdesc1' value='$ticketdesc1[$x]'/>
                     <input type='hidden' name='deletetkcat1' value='$ticketcat1[$x]'/>
                     <input type='submit' name='dltprod1' class='dltbtn' onclick='dltproduct()' style='cursor:pointer;' value='Delete'/>
                     </div>
                     </form></div>";
    $ecount++;
    }
    //2nd cat
    echo"
            <div class='categories'>
            <div class='catclass2'><b style='text-decoration:none;'>PACKAGE ACCESS &nbsp
            </b></div>
            </div>    
            ";
    for ($x = 0; $x < $counter2; $x++) {
    echo"<div class='ticketwrap'><form action='' method='post'><img src='https://tarumtbucket2305835.s3.amazonaws.com/$imagename2[$x]' name='imagename2' class='ticketclass'/>
                     <div class='word'>
                     <div class='wordclass' name='ticketname2'>$ticketname2[$x]</div>
                     <div class='ticketprice' style='margin-top:3px;' name='ticketprice2'>RM $ticketprice2[$x]</div>
                     <button type='button' class='editbtn' onclick='Cpopup2$x()' style='cursor:pointer;'>EDIT</button>
                     <input type='hidden' name='deleteprodid2' value='$productid2[$x]'/>
                     <input type='hidden' name='deletetkname2' value='$ticketname2[$x]'/>
                     <input type='hidden' name='deleteimgname2' value='$imagename2[$x]'/>
                     <input type='hidden' name='deletetkprice2' value='$ticketprice2[$x]'/>
                     <input type='hidden' name='deletetkdesc2' value='$ticketdesc2[$x]'/>
                     <input type='hidden' name='deletetkcat2' value='$ticketcat2[$x]'/>
                     <input type='submit'  name='dltprod2' class='dltbtn' onclick='dltproduct()' style='cursor:pointer;' value='Delete'/>
                     </div></div>
                     </form>";
    $ecount++;
    }
    //3rd cat
    echo"
            <div class='categories'>
            <div class='catclass3'><b style='text-decoration:none;'>INDIVIDUAL ACCESS &nbsp
            </b></div>
            </div>    
            ";
    for ($x = 0; $x < $counter3; $x++) {
    echo"<div class='ticketwrap'><form action='' method='post'><img src='https://tarumtbucket2305835.s3.amazonaws.com/$imagename3[$x]' name='imagename3' class='ticketclass'/>
                     <div class='word'>
                     <div class='wordclass' name='ticketname3'>$ticketname3[$x]</div>
                     <div class='ticketprice' style='margin-top:3px;' name='ticketprice3'>RM $ticketprice3[$x]</div>
                     <button type='button' class='editbtn' onclick='Cpopup3$x()' style='cursor:pointer;'>EDIT</button>
                     <input type='hidden' name='deleteprodid3' value='$productid3[$x]'/>
                     <input type='hidden' name='deletetkname3' value='$ticketname3[$x]'/>
                     <input type='hidden' name='deleteimgname3' value='$imagename3[$x]'/>
                     <input type='hidden' name='deletetkprice3' value='$ticketprice3[$x]'/>
                     <input type='hidden' name='deletetkdesc3' value='$ticketdesc3[$x]'/>
                     <input type='hidden' name='deletetkcat3' value='$ticketcat3[$x]'/>
                     <input type='submit'  name='dltprod3' class='dltbtn' onclick='dltproduct()' style='cursor:pointer;' value='Delete'/></div></div>
                     </form>";
    $ecount++;
    }
    ?>
        </div>

        <!--DELETE PROD 1-->
            <?php
            if (isset($_POST["dltprod1"])) {
                $dlterror1 = checkDeleteError1();

                if (empty($dlterror1)) {
                    $deleteprodid1 = $_POST["deleteprodid1"];
                    $deletetkname1=$_POST["deletetkname1"];
                    $deleteimgname1=$_POST["deleteimgname1"];
                    $deletetkprice1=$_POST["deletetkprice1"];
                    $deletetkdesc1=$_POST["deletetkdesc1"];
                    $deletetkcat1=$_POST["deletetkcat1"];
                    
                    require_once("../secret/helper.php");
                    $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                    if ($con->connect_error) {
                        die("DB CONNECTION FAIL" . $con->connect_error);
                    }

                    $sql = "DELETE FROM ticket WHERE productid=?";
                    $sql2="INSERT INTO deletedtic(deletetkid,deletetkname,deleteimgname,deletetkprice,deletetkdesc,deletetkcat,productid)VALUES(?,?,?,?,?,?,?);";

                    $stmt = $con->prepare($sql);
                    $stmt2 = $con->prepare($sql2);
                   
                    $stmt->bind_param("s", $deleteprodid1);
                    $stmt2->bind_param("sssssss",$dltid,$deletetkname1,$deleteimgname1,$deletetkprice1,$deletetkdesc1,$deletetkcat1,$deleteprodid1);

                    $stmt->execute();
                    $stmt2->execute();
                    
                    if ($stmt->affected_rows > 0) {
                         echo "<script>alert('Ticket $deleteprodid1 Deleted');</script>";
                         echo "<script>location='adminproductsstatus.php';</script>";
                    } else {
                        echo "<script>alert('Database Issues! Unable to Delete Record!');</script>";
                         echo "<script>location='adminproductsstatus.php';</script>";
                    }

                    $con->close();

                    $stmt->close();
                }
            } else {//do nothing
            }
            ?>

        <!--DELETE PROD 2-->
        <?php
        if (isset($_POST["dltprod2"])) {
            $dlterror2 = checkDeleteError2();
            if (empty($dlterror2)) {

                $deleteprodid2 = $_POST["deleteprodid2"];
                $deletetkname2=$_POST["deletetkname2"];
                $deleteimgname2=$_POST["deleteimgname2"];
                $deletetkprice2=$_POST["deletetkprice2"];
                $deletetkdesc2=$_POST["deletetkdesc2"];
                $deletetkcat2=$_POST["deletetkcat2"];

                require_once("../secret/helper.php");
                $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                if ($con->connect_error) {
                    die("DB CONNECTION FAIL" . $con->connect_error);
                }

                $sql = "DELETE FROM ticket WHERE productid=?";
                $sql2="INSERT INTO deletedtic(deletetkid,deletetkname,deleteimgname,deletetkprice,deletetkdesc,deletetkcat,productid)VALUES(?,?,?,?,?,?,?);";

                $stmt = $con->prepare($sql);
                $stmt2 = $con->prepare($sql2);

                $stmt->bind_param("s", $deleteprodid2);
                $stmt2->bind_param("sssssss",$dltid,$deletetkname2,$deleteimgname2,$deletetkprice2,$deletetkdesc2,$deletetkcat2,$deleteprodid2);
                
                $stmt->execute();
                $stmt2->execute();

                if ($stmt->affected_rows > 0) {
                    echo "<script>alert('Ticket $deleteprodid2 Deleted')</script>";
                    echo "<script>location='adminproductsstatus.php';</script>";
                } else {
                    echo "<script>alert('Database Issues! Unable to Delete Record!');</script>";
                         echo "<script>location='adminproductsstatus.php';</script>";
                }

                $con->close();

                $stmt->close();
            }
        } else {
            //do nothing   
        }
        ?>

        <!--DELETE PROD 3-->
        <?php
        if (isset($_POST["dltprod3"])) {
            $dlterror3 = checkDeleteError3();
            if (empty($dlterror3)) {

                $deleteprodid3 = $_POST["deleteprodid3"];
                $deletetkname3=$_POST["deletetkname3"];
                $deleteimgname3=$_POST["deleteimgname3"];
                $deletetkprice3=$_POST["deletetkprice3"];
                $deletetkdesc3=$_POST["deletetkdesc3"];
                $deletetkcat3=$_POST["deletetkcat3"];

                require_once("../secret/helper.php");
                $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                if ($con->connect_error) {
                    die("DB CONNECTION FAIL" . $con->connect_error);
                }

                $sql = "DELETE FROM ticket WHERE productid=?";
                $sql2="INSERT INTO deletedtic(deletetkid,deletetkname,deleteimgname,deletetkprice,deletetkdesc,deletetkcat,productid)VALUES(?,?,?,?,?,?,?);";

                $stmt = $con->prepare($sql);
                $stmt2 = $con->prepare($sql2);

                $stmt->bind_param("s", $deleteprodid3);
                $stmt2->bind_param("sssssss",$dltid,$deletetkname3,$deleteimgname3,$deletetkprice3,$deletetkdesc3,$deletetkcat3,$deleteprodid3);

                $stmt->execute();
                $stmt2->execute();

                if ($stmt->affected_rows > 0) {
                 echo "<script>alert('Ticket $deleteprodid3 Deleted')</script>";
                 echo "<script>location='adminproductsstatus.php';</script>";
                    } 
                
                else {
                  echo "<script>alert('Database Issues! Unable to Delete Record!');</script>";
                  echo "<script>location='adminproductsstatus.php';</script>";
                }

                $con->close();

                $stmt->close();
                
            }
        } else {
            //do nothing
        }
        ?>

        <!--edit popup-page-->
        <!-- 1 -->
        <?php
        if (!empty($editproductid1)) {
        $defaultselect;
        for ($i = 0; $i <= $editcounter1; $i++) {
            if (!empty($editticketstatus1[$i])) {
            if ($editticketstatus1[$i] == 'N') {
                $defaultselect = 'selected';
            } else if ($editticketstatus1[$i] == 'A') {
                $defaultselect = '';
            }
                echo"<div class='popup' id='popup1$i'>
                <form action='' method='post' class='ticketclass' style='margin-left:290px;margin-top:-20px;'>
                <div class='editclosebtn'>
                <input type='button' class='editclosebtnn' value='X' onclick='closepopup()'/>
                </div>
                Product Picture : <br/>
                <img src='https://tarumtbucket2305835.s3.amazonaws.com/$editimagename1[$i]' class='ticketclass'/><br/>
                Product ID : <span class='editprodid' name='editprodid'>$editproductid1[$i]</span><br/><br/>
                Product Name : $editticketname1[$i]<br/><br/>
                Product Price : $editicketprice1[$i]<br/><br/>
                Product Description : </br>- $editticketdesc1[$i]<br/><br/>
                Product Category : $editticketcat1[$i]
                <br/><br/>
                <label for='ticketstatus'>Status:</label> 
                <select name='ticketstat' id='ticketstat'>
                <option value='A'>Available</option>
                <option value='N' $defaultselect>Non-Available</option>
                </select>
                <br/>
                <input type='hidden' name='selectedID' value='$editproductid1[$i]'/>
                <button type='submit' name='doneedit' class='donepopup' onclick='donepopup()' style='margin-top:30px;'>DONE</button>
                </form>
                </div>
                ";
        }
        }       
        }
        ?>
        <!-- 2 -->
        <?php
        if (!empty($editproductid2)) {
        $defaultselect;
        for ($i = 0; $i < $editcounter2; $i++) {
            if ($editticketstatus2[$i] == 'N') {
                $defaultselect = 'selected';
            } else if ($editticketstatus2[$i] == 'A') {
                $defaultselect = '';
            }   
                echo"<div class='popup' id='popup2$i'>
                <form action='' method='post' class='ticketclass' style='margin-left:290px;margin-top:-20px;'>
                <div class='editclosebtn'>
                <input type='button' class='editclosebtnn' value='X' onclick='closepopup()'/>
                </div>
                Product Picture : <br/>
                <img src='https://tarumtbucket2305835.s3.amazonaws.com/$editimagename2[$i]' class='ticketclass'/><br/>
                Product ID : <span class='editprodid' name='editprodid'>$editproductid2[$i]</span><br/><br/>
                Product Name : $editticketname2[$i]<br/><br/>
                Product Price : $editicketprice2[$i]<br/><br/>
                Product Description : </br>- $editticketdesc2[$i]<br/><br/>
                Product Category : $editticketcat2[$i]
                <br/><br/>
                <label for='ticketstatus'>Status:</label> 
                <select name='ticketstat' id='ticketstat'>
                <option value='A'>Available</option>
                <option value='N' $defaultselect>Non-Available</option>
                </select>
                <br/>
                <input type='hidden' name='selectedID' value='$editproductid2[$i]'/>
                <button type='submit' name='doneedit' class='donepopup' onclick='donepopup()' style='margin-top:30px;'>DONE</button>
                </form>
                </div>
                ";
        }
        }
        ?>
        <!-- 3 -->
        <?php
        if (!empty($editproductid3)) {
        $defaultselect;
        for ($i = 0; $i < $editcounter3; $i++) {
            if ($editticketstatus3[$i] == 'N') {
                $defaultselect = 'selected';
            } else if ($editticketstatus3[$i] == 'A') {
                $defaultselect = '';
            }
                echo"<div class='popup' id='popup3$i'>
                <form action='' method='post' class='ticketclass' style='margin-left:290px;margin-top:-20px;'>
                <div class='editclosebtn'>
                <input type='button' class='editclosebtnn' value='X' onclick='closepopup()'/>
                </div>
                Product Picture : <br/>
                <img src='https://tarumtbucket2305835.s3.amazonaws.com/$editimagename3[$i]' class='ticketclass'/><br/>
                Product ID : <span class='editprodid' name='editprodid'>$editproductid3[$i]</span><br/><br/>
                Product Name : $editticketname3[$i]<br/><br/>
                Product Price : $editicketprice3[$i]<br/><br/>
                Product Description : </br>- $editticketdesc3[$i]<br/><br/>
                Product Category : $editticketcat3[$i]
                <br/><br/>
                <label for='ticketstatus'>Status:</label> 
                <select name='ticketstat' id='ticketstat'>
                <option value='A'>Available</option>
                <option value='N' $defaultselect>Non-Available</option>
                </select>
                <br/>
                <input type='hidden' name='selectedID' value='$editproductid3[$i]'/>
                <button type='submit' name='doneedit' class='donepopup' onclick='donepopup()' style='margin-top:30px;'>DONE</button>
                </form>
                </div>
                ";
        }
        }
        ?>

        <!--EDIT PRODUCT-->
        <?php
        if (isset($_POST["doneedit"])) {

            $editerror = checkEditError();

            if (empty($editerror)) {
                $selectedID = $_POST["selectedID"];
                $editticketstat = $_POST["ticketstat"];
                require_once("../secret/helper.php");
                $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                if ($con->connect_error) {
                    die("DB CONNECTION FAIL" . $con->connect_error);
                }

                $sql = "UPDATE ticket SET ticketstatus=? WHERE productid=? ;";
                $stmt = $con->prepare($sql);

                $stmt->bind_param("ss", $editticketstat, $selectedID);

                $stmt->execute();

                if ($stmt->affected_rows > 0) {
                    //updated
                    echo "<script>alert('Ticket $selectedID Edited');</script>";
                    echo "<script>location='adminproductsstatus.php';</script>";
                } else {
                    if($editticketstat==$editticketstat){
                        echo "<script>alert('! No Changes Occur !');</script>";
                    echo "<script>location='adminproductsstatus.php';</script>";
                    }
                    
                    else{
                    echo "<script>alert('Database Issues! Unable to Update Record!');</script>";
                    echo "<script>location='adminproductsstatus.php';</script>";}
                }


                $con->close();

                $stmt->close();
            } else {
                echo"<div class='editerror' id='editerror'>";
                echo"<input type='button' value='X' onclick='closeediterror()'/>";
                echo"<h1 style='font-size:1.5em;position:absolute;margin-top:-90px;margin-left:65px;text-decoration:underline;'>Not-Edited</h1>";
                echo"<ul>";
                printf("<li style='list-style-type:none;'>%s</li>", implode("</li><li style='list-style-type:none;'>", $editerror));
                echo"</ul>";
                echo"</div>";
            }
        }
        ?>

        <!--CLOSE EDIT ERROR MSS-->
        <script>
            function closeediterror() {
                var editerror = document.getElementById("editerror");
                editerror.style.display = 'none';
                location="adminproductsstatus.php";
            }

        </script>

        <!--OPEN POP UP-->
        <script>
        <?php
        $i = 0;
        
        for ($i = 0; $i < $editcounter; $i++) {
            echo"let popup1$i = document.getElementById('popup1$i');";
            echo"let popup2$i = document.getElementById('popup2$i');";
            echo"let popup3$i = document.getElementById('popup3$i');";
            
        }
        for ($i = 0; $i < $editcounter; $i++) {
            echo"function Cpopup1$i(){
                    popup1$i.classList.add('open-popup')}";
            echo"function Cpopup2$i(){
                    popup2$i.classList.add('open-popup')}";
            echo"function Cpopup3$i(){
                    popup3$i.classList.add('open-popup')}";
            
        }
        ?>
            function donepopup(){
        <?php
        for ($i = 0; $i < $editcounter; $i++) {
            echo"popup1$i.classList.remove('open-popup');";
            echo"popup2$i.classList.remove('open-popup');";
            echo"popup3$i.classList.remove('open-popup');";
            
        }
        ?>
}

            function closepopup() {
        <?php
        
        for ($i = 0; $i < $editcounter; $i++) {
            echo"popup1$i.classList.remove('open-popup');";
            echo"popup2$i.classList.remove('open-popup');";
            echo"popup3$i.classList.remove('open-popup');";
            
        }
        ?>
            }
        </script>
        
        <?php
        //avoid from product id overlapping from deleted products
        require_once("../secret/helper.php");

        $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ($con->connect_error) {
            die("DB CONNECTION FAIL!" . $con->connect_error);
        }

        $sql = "SELECT productid FROM deletedtic;";

        $result = $con->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_object()) {
                $dltexisttkid[$dltedtkidcount] = $row->productid;
                $dltedtkidcount++;
            }
        }

        $con->close();
        $result->free();
        ?>
        
        <!--Product ID generator-->
        <?php
        for ($i = 0; $i <= $editcounter; $i++) {
        $newidn++;
        }

        $newid = sprintf("%04d", $newidn);//new ticket id into 0000 form 
        
        $newprodid = 'T' . $newid;//concatenate the 'T' with the id serial no
        
        
        //retrieve 1st cat id
        for($olid=0;$olid<$counter1;$olid++){
            if(strcmp($productid1[$olid],$newprodid)==0){
                $newidn++;
                $newid = sprintf("%04d", $newidn);//new ticket id into 0000 form 
                $newprodid = 'T' . $newid;//concatenate the 'T' with the id serial no
               
            }
        }
        
        //retrieve 2nd cat id
        for($olid=0;$olid<$counter2;$olid++){
            if(strcmp($productid2[$olid],$newprodid)==0){
                $newidn++;
                $newid = sprintf("%04d", $newidn);//new ticket id into 0000 form 
                $newprodid = 'T' . $newid;//concatenate the 'T' with the id serial no
                
            }
        }
        
        //retrieve 3rd cat id
        for($olid=0;$olid<$counter3;$olid++){
           if(strcmp($productid3[$olid],$newprodid)==0){
                $newidn++;
                $newid = sprintf("%04d", $newidn);//new ticket id into 0000 form 
                $newprodid = 'T' . $newid;//concatenate the 'T' with the id serial no
                
            }
        }

        for($detectdltid=0;$detectdltid<$dltedtkidcount;$detectdltid++){
        if(strcmp($newprodid,$dltexisttkid[$detectdltid])==0){
            $newidn++;
            $newid = sprintf("%04d", $newidn);//new ticket id into 0000 form 
            $newprodid = 'T' . $newid;//concatenate the 'T' with the id serial no
            
        }
        }
        ?>

        <!--New Product Inserting-->
        <?php
if (isset($_POST["doneaddbtnn"])) {
    $adderror = checkAddError();
    if (empty($adderror)) {
        
        $newticketname = strtoupper(($_POST["newticketname"]));
        $newticketprice = ($_POST["newticketprice"]); //ensuring float value stored
        $newticketdesc = ($_POST["newticketdesc"]);
        $newticketcat = ($_POST["newticketcat"]);
        $newticketstatus = ($_POST["newticketstatus"]);
        $save_as="-";
        
        if (isset($_FILES['fupimage'])) {
                    $file = $_FILES['fupimage']; //should be coming out warning on this line, afterward using another isset to solve it
                    if ($file['error'] > 0) {
                        //check error code
                        switch ($file['error']) {
                            case UPLOAD_ERR_NO_FILE: {//code=4(alternative way)
                                    $err = 'No file was selected';
                                    $imguped=0;
                                    break;
                                }
                            case UPLOAD_ERR_FORM_SIZE: {//CODE =2(alternative way)
                                    $err = 'File uploaded is too large. Maximum 0.3089907MB allowed.';
                                    $imguped=2;
                                    break;
                                }
                            default: {
                                    $err = 'There was an error while uploading the file.';
                                }
                        }
                    } 
                    else if ($file['size'] > 162000) {
                        $err = 'File uploaded is too large. Maximum 0.3089907MB allowed';
                        $imguped=2;
                    } 
                    else {
                        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
                        if ($ext != 'jpg' &&$ext != 'jpeg' && $ext != 'gif' && $ext != 'png') {
                            $err = 'Only JPG,GIF, and PNG format are allowed';
                        } 
                        else {
                            $save_as =  uniqid() .$newprodid.'.'. $ext;//concatenate the random id + $newprodid + . + ext
                            //etc:1983919139139T0001.png
                            move_uploaded_file($file['tmp_name'], 'https://tarumtbucket2305835.s3.amazonaws.com/' . $save_as);//upload the image name into file
                            $imguped=1;
                        }
                    }
                }
        
        
        
        if($imguped==1){
        require_once("../secret/helper.php");

        $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ($con->connect_error) {
            die("DB CONNECTION FAIL" . $con->connect_error);
        }

        $sql = "INSERT INTO ticket(productid,imagename,ticketname,ticketprice,ticketstatus,ticketdesc,ticketcat)VALUES(?,?,?,?,?,?,?)";
        $stmt = $con->prepare($sql);

        $stmt->bind_param('sssssss', $newprodid, $save_as, $newticketname, $newticketprice, $newticketstatus, $newticketdesc, $newticketcat);

        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo "<script>alert('Ticket $newprodid Added');</script>";
            echo "<script>location='adminproductsstatus.php';</script>";
        } else {
            echo "<script>alert('Database Issues! Unable to Create Record!');</script>";
            echo "<script>location='adminproductsstatus.php';</script>";
        }
        $stmt->close();
        $con->close();
        }
        
        else{
            if($imguped==0){//to debug the error of no image inserted
                 echo"<script>alert('No Image Chosen');</script>";
            }
            else if($imguped==2){//to debug the error of too large image inserted
                echo"<script>alert('File uploaded is too large. Maximum 0.3089907MB allowed');</script>";
            }
            
            
        }
        
        
    } 
    else {
        echo"<div class='adderror' id='adderror'>";
        echo"<input type='button' value='X' style='position:absolute;margin-top:-80px;margin-left:540px;background-color:red;color:white;' onclick='closeadderror()'/>";
        echo"<h1 style='font-size:1.5em;position:absolute;margin-top:-90px;margin-left:65px;text-decoration:underline;'>Not-Added</h1>";
        echo"<ul>";
        printf("<li style='list-style-type:none;'>%s</li>", implode("</li><li style='list-style-type:none;'>", $adderror));
        echo"</ul>";
        echo"</div>";
    }
} 

        ?>

        <!--Close Add Error Message-->
        <script>
            function closeadderror() {
                var closeerror = document.getElementById('adderror');
                closeerror.style.display = 'none';
                location="adminproductsstatus.php";
            }

        </script>        

        <!--New Product Pop Up-->
        <?php
        echo"<div class='addingbtn' id='addbtn'>
        <form action='' method='post' enctype='multipart/form-data'>
        <input type='button' id='closeaddbtn' value='X' onclick='closeaddpopup()'/>
        Product Image : </br>
        <img src='https://tarumtbucket2305835.s3.amazonaws.com/newpd.jpg' name='newprodimg' class='inputpic' id='inputpic' style='width:720px;height:225px;margin-top:10px;'/><br/>
        <label for='inputbtn' style='background-color:#00032E;color:white;width:130px;height:25px;display:block;padding-top:3px;border-radius:10px;font-size:0.8em;margin-left:435px;margin-bottom:-30px;'>UPLOAD</label><br/>
        <button type='button' class='cropbtn' onclick='firstratio()'>16:9</button>
        <button type='button' class='cropbtn' onclick='secondratio()'>21:9</button>
        <input type='hidden' name='MAX_FILE_SIZE' value='162000'/>
        <input type='file' acceptimage='/jpeg,image/jpg,image/png' id='inputbtn' name='fupimage' style='display:none;'/><br/>
        <div class='addinputwrap'>
        <div class='newproid'>New Product ID: &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
        <b> $newprodid</b></div><br/>
        New Product Name :
        <input type='text' name='newticketname' style='width:300px;height:30px;margin-left:100px;' required/><br/><br/>
        New Product Price (RM) :
        <input type='text' name='newticketprice' style='width:70px;height:30px;' required/><br/><br/>    
        New Product Description :
        <input type='text' name='newticketdesc' style='width:500px;height:30px;margin-left:45px;' required/><br/><br/>
        <div class='newticketcat'>
        <label for='newticketcat'>Category</label>
        <select name='newticketcat' id='newticketcat' style='height:30px;margin-left:219px;font-size:0.8em'>
        <option value='SA'>SPOT ACCESS</option>
        <option value='PA'>PACKAGE ACCESS</option>
        <option value='IA'>INDIVIDUAL ACCESS</option> <!--when inserting data, use if else statement for inserting into the correct cat-->
        </select>
        </div>
        <br/>
        <label for='newticketstatus' >Status:</label> 
        <select name='newticketstatus' id='newticketstatus' style='height:30px;margin-left:242px;font-size:0.8em'>
        <option value='A'>Available</option>
        <option value='N'>Non-Available</option>
        </select>
        <br/><br/></div>
        <button type='submit' name='doneaddbtnn' class='doneaddbtn' onclick='doneaddpopup()' style='position:absolute;margin-top:15px;margin-left:-30px;font-size:0.8em;margin-top:-10px'>DONE</button>
        </form>
        </div>";
        ?>     
        
        <script>
                function firstratio(){//width 720px, height 225px
                    var inputpic=document.getElementById("inputpic");
                    
                    inputpic.style.width=(720*1.05)+'px';
                    inputpic.style.height=(225*1.05)+'px';
                    inputpic.style.marginBottom='11.25px';
                }
                </script>
                        
                <script>
                function secondratio(){//width 720px, height 225px
                    var inputpic=document.getElementById("inputpic");
                    
                    inputpic.style.width=(720*0.8)+'px';
                    inputpic.style.height=(225*0.8)+'px';
                    inputpic.style.marginBottom='45px';
                }
                </script>
        
        <script>
        <?php
        echo"function add(){
                let addbtn = document.getElementById('addbtn');
                 addbtn.classList.add('open-popup');
                     
                 }";
        ?>
        </script>

        <script>
            function doneaddpopup() {
        <?php
        if ($newticketname == null) {
            //to run the required
        } else {
            echo"addbtn.classList.remove('open-popup');";
        }
        ?>
}

        </script>

        <!--CLOSE NEW PROD POPUP-->
        <script>
            function closeaddpopup() {
        <?php
        echo"addbtn.classList.remove('open-popup');";
        ?>
            }
        </script>

        <!--ADD IMAGE-->
        <script>
        <?php
        echo "
                let inputpic = document.getElementById('inputpic');
                let inputbtn = document.getElementById('inputbtn');
                inputbtn.onchange = 
                function() {
                inputpic.src = URL.createObjectURL(inputbtn.files[0]);
                };
            ";
        ?>
        </script>
         


    </body>
</html>