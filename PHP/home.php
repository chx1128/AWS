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
            html{
                width:1550px;
                margin:auto;
            }
            .promotionMssWrapper{
                width: 100%;
                max-width:1550px;
                background-color:black;
                opacity:0.8;
                overflow:hidden;
                display:flex;
                align-items:center;
                justify-content:center;
                
            }
            
            .promotionMssList1{
                display:flex;
                white-space:nowrap;
                will-change:transform;
                animation:marquee 100s linear infinite;
            }
            
            .promotionMssList2{
                display:flex;
                white-space:nowrap;
                will-change:transform;
                animation:marquee2 100s linear infinite;
            }
            
            .promotionMssList1 .promotionMss a{
                all:unset;
                cursor:pointer;
                display:flex;
                align-items:center;
                justify-content:center;
                background-color:black;
                opacity:0.8;
                width:100%;
            }
            
            .promotionMssList2 .promotionMss a{
                all:unset;
                cursor:pointer;
                
                display:flex;
                align-items:center;
                justify-content:center;
                
                background-color:black;
                opacity:0.8;
                width:100%;
            }
            
            .promotionMss{
                margin-right:500px;
            }
            
            .promotionMss p{
                font-family:"Lucida Console";
                font-size:14px;
                
                opacity:1.0;
                color:white;
            }
            
            .promotionMss i{
                margin-left:10px;
                opacity:1.0;
                color:white;
            }
            
            @keyframes marquee {
                0%{transform:translateX(100%)}
                100%{transform:translateX(-100%)}
            }
            @keyframes marquee2 {
                0%{transform:translateX(200%)}
                100%{transform:translateX(0%)}
            }
            .homeElement{
                display:flex;
                flex-direction:column;
                justify-content:center;
                align-items:center;
                margin-bottom:50px;
            }
            .homeImg{
                width:100%;
                max-width:1550px;
                background-color:#0d0907;
            }
            
            .homeImg img{
                max-width:100%;
                opacity:0.5;
            }
            
            .homeWord{
                margin-top:-175px;
                z-index:100;
                color:#f8f8f4;
                font-family:Georgia;
                text-align: center;
            }
            .wordTitle{
                font-size:60px;
            }
            
            .wordDesc{
                margin-top:0px;
                font-size:18px;
            }
            
            .wordBtn{
                margin-top:7px;
                border:#f8f8f4 solid 2px;
                padding:10px;
                width:180px !important;
            }
            
            a {
                text-decoration:none;
                color:inherit;
                font-size:20px;
            }
            

        

        </style>
    </head>

    <body>
        
        <div class="promotionMssWrapper">
            <div class="promotionMssList1">
                <div class="promotionMss">
                    <a href="../ServletShop">
                        <p>WELCOME TO WO'EY STORE</p>
                    </a>
                </div>
                
                
                <div class="promotionMss">
                    <a href="/GUI/JSP/userSignup.jsp">
                        <p>FREE SHIPPING FOR NEW SIGN UP USER</p>
                    </a>
                </div>
                
                
                <div class="promotionMss">
                    <a href="../ServletShop">
                        <p>FREE SHIPPING FOR ORDER ABOVE RM1000</p>
                    </a>
                </div>
            </div>
            <div class="promotionMssList2">
                <div class="promotionMss">
                    <a href="../ServletShop">
                        <p>WELCOME TO WO'EY STORE</p>
                    </a>
                </div>
                
                
                <div class="promotionMss">
                    <a href="/GUI/JSP/userSignup.jsp">
                        <p>FREE SHIPPING FOR NEW SIGN UP USER</p>
                    </a>
                </div>
                
                
                <div class="promotionMss">
                    <a href="../ServletShop">
                        <p>FREE SHIPPING FOR ORDER ABOVE RM1000</p>
                    </a>
                </div>
            </div>
            </div>
        <?php
        include('../PHP/header.php');
        ?>
            <div class="homeElement"> 
            <div class="homeImg">
                <img src="../Image/homeImg1.1.jpg" alt=""/>
            </div>
            <div class="homeWord">
                <div class="wordTitle">Wo'oi</div>
                <div class="wordDesc">Beli Semua!</div>
                <a href="../ServletShop"><div class="wordBtn">SHOP ALL</div></a>
            </div>
        </div>
        
        <script>
            
            const baudio = new Audio();
            baudio.src = "../soundeffect.mp4";
        </script>
        <?php
        include("../PHP/footer.php");
        ?>
    </body>
    
</html>
