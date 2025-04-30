<!--GLOBALISE VARIABLE-->
<?php
global $img, $scare, $happy, $image, $word;
global $counter;
$counter=0;
global $facstatus;
global $agecolor;
?>
<!--Retrieve data from DATABASE-->
<?php
require_once("../secret/helper.php");
$con= new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
if($con->connect_error){
    die("DB CONNECTION FAIL".$con->connect_error);
}

$sql="SELECT facimgname,facname,scare,happy,agerestrict,facstatus FROM facility WHERE facstatus='A' ORDER BY facid;";
$result=$con->query($sql);

if($result->num_rows>0){
    while($row=$result->fetch_object()){
        $facimgname[$counter]=$row->facimgname;
        $facname[$counter]=$row->facname;
        $scare[$counter]=$row->scare;
        $happy[$counter]=$row->happy;
        $agerestrict[$counter]=$row->agerestrict;
        $facstatus[$counter]=$row->facstatus;
        $counter++;
    }
}

$result->free();
$con->close();

?>


<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>HOME PAGE</title>

        <style>
            
            *{
                margin: 0px;
                font-family:Roboto,monospace;
            }

            .homeabove{
                width: clamp(600px,1450px,1600px);
                margin:auto;
                height: 470px;
                border: 1px solid transparent;
                margin-top:0px;
            }

            .homeabove img{
                width: clamp(600px,1450px,1600px);
                margin:auto;
                height: 430px;
                padding-top:4px;
                padding-left:3px;
                border-radius:15px;
                -webkit-box-shadow: 0px 31px 300px -60px rgba(148,176,218,1);
                -moz-box-shadow: 0px 31px 300px -60px rgba(148,176,218,1);
                box-shadow: 0px 31px 300px -60px rgba(148,176,218,1);
            }

            .whatsup {
                width:500px;
                height:0;
                margin:auto;
                margin-top: 80px;
                font:sans-serif;
                font-size:4.5em;
            }
            .whatsup b{
                margin-left: -400px;
            }

            .facility{
                background-color:#E7E7E7;
                width: clamp(600px,100%,1550px);
                height:100%;
                margin:auto;
                margin-top:50px;
                display:flex;
                flex-wrap:wrap;
                justify-content:space-around;
            }

            .wrap{
                width:560px;
                height:300px;
                margin-bottom:250px;
                margin-top:0px;
                border-radius:25px;
            }

            .facilities{
                width:560px;
                height:100%;
                margin-bottom:10px;
                margin-right:0px;
                margin-left:0px;
                margin-top:80px;
                border:1px solid transparent;
                border-radius:25px;
            }

            .word{
                display: inline;
                width:0;
                height:0;
                font:Roboto;
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
                margin-left:150px;
                width:250px;
                height:40px;
                border:1px solid transparent;

            }

        

        </style>
    </head>

    <body>
        <?php
        include('header.php');
        ?>
        

        <div class="homeabove">
            <img src="/Assignment/IMAGE/homeabove(1)(1).png"/>
        </div>
        
        <div class="whatsup"><b>What's new? modify from hongxiang</b></div>
        <div class="facility">
            <?php
            for($i=0;$i<$counter;$i++) {
                if($agerestrict[$i]=='U'){
                    $ageword[$i]="Underage";
                    $agecolor="red";
                }
                
                else if($agerestrict[$i]=='O'){
                    $ageword[$i]="Non-Underage";
                    $agecolor="yellow";
                }
                
                
                
                if($facstatus[$i]=='A'){
                
                echo "<div class='wrap'>
                <img src='/Assignment/IMAGE/$facimgname[$i]' class='facilities'/>
                    <div class='word'>
                        <div class='facilitiesword'><b>$facname[$i]</b></div>
                    <div class='rate'><b>😱 $scare[$i]  🥰 $happy[$i]</b></div>
                    <script>changeColor$i();</script>
                    <div class='agerestrict'><b>Age Restriction: </b><span id='ageword$i' style='color='$agecolor''>$ageword[$i]</span></div>
                    </div></div>
                ";
                
                }
                
                else if($facstatus[$i]=='N'){
                    //does not display anything
                }
            }
            ?>


        </div> 


        <div class="chatbot">
            <img src="/Assignment/IMAGE/chatbot.png" onclick="baudio.play()" style="cursor:pointer"/>
            <div class="word" style="
                 color: #B75151;
                 position:fixed;
                 bottom:0px;
                 right:0px;
                 width:150px;
                 height:100px;
                 margin-bottom: -46px;
                 margin-right:22px;
                 z-index:50;
                 ">
                <b style="font-family:Fantasy,Calibri;">Click Me!</b></div>
        </div>
        <script>
            
            const baudio = new Audio();
            baudio.src = "/Assignment/soundeffect.mp4";
        </script>
        <?php
        include("footer.php");
        ?>
    </body>
    
</html>