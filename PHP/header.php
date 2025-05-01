<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <!--CSS-->
        <style>
            .navi{
        width: clamp(600px,100%,1600px);
        margin:auto;
        height: 90px;
        display: flex;
        background-color:black;
        position:sticky;
        z-index:100;
        top:0px;
        }
        
        .organame {
            background-color:black;
            color:yellow;
            width:350px;
            height:90px;
            margin-top:0px;
            margin-right:0px;
            margin-left:0px;
        }
        
        .organamee{
        width: 250px;
        height: 50px;
        margin-bottom: 10px;
        }
        
        .duckylogo{
        width: 100px;
        height: 80px;
        margin-top: 8px;
        margin-left:55px;
        
        }
        
        .navia{
        
        height: 60px;
        width: 170px;
        text-align: center;
        padding-top: 30px;
        }
        
        .navia a{
        text-decoration: none;
        font-family: sans-serif;
        font-size: 1.5em;
        color: white;
        
        }
        
        .naviahold{
            display:flex;
            width:850px;
            margin-left: 270px;
        }
        
        .navia a:hover {
        transform:scale(1.1);
        color:#6468AF;
        }
/*     for duck icon on bottom   */
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
        .word{
            display: inline;
            width:0;
            height:0;
            font:Helvetica;
            font-size:1.3em;
            text-align: center;
        }
        
        </style>
        <!--FONT AWESOME-->
        <script src="https://kit.fontawesome.com/13a563f8a6.js" crossorigin="anonymous"></script>
    </head>
    <body>
        <div class="navi">
            <div class="organame">
                <img src="https://tarumtbucket2305835.s3.amazonaws.com/Wo'eY Logo(White).png" class="duckylogo" style="width:220px;height:60px;margin-top: 15px;"/>
                
            </div>
            <div class="naviahold">
            <div class="navia" ><a href="../PHP/home.php"><i class="fa-solid fa-house" style="position:absolute;font-size:0.8em;margin-left:-30px;margin-top:3.5px;opacity:75%;"></i>Home</a></div>
            <div class="navia" style="margin-left:2px;"><a href="../PHP/products.php"><i class="fa-solid fa-ticket" style="position:absolute;font-size:0.8em;margin-left:-32px;margin-top:3.5px;opacity:75%;"></i>Products</a></div>
            <div class="navia" style="margin-left:2px;"><a href="../PHP/cart.php"><i class="fa-solid fa-cart-shopping" style="position:absolute;font-size:0.8em;margin-left:-32px;margin-top:3.5px;opacity:75%;"></i>Cart</a></div>
            <div class="navia" style="margin-left:7px;"><a href="../PHP/account.php"><i class="fa-solid fa-circle-user" style="position:absolute;font-size:0.8em;margin-left:-27px;margin-top:3.5px;opacity:75%;"></i>Account</a></div>
            <div class="navia" style="margin-left:32px;"><a href="../PHP/memberships.php"><i class="fa-solid fa-gift" style="position:absolute;font-size:0.8em;margin-left:-28px;margin-top:3.5px;opacity:75%;"></i>Memberships</a></div>
            </div>
        </div>
        
        
<!--              for duck icon on the bottom     -->
                <div class="chatbot">
            <img src="https://tarumtbucket2305835.s3.amazonaws.com/chatbot.png" onclick="baudio.play()" style="cursor:pointer"/>
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
            baudio.src = "../soundeffect.mp4";
        </script>
        
        <?php
        // put your code here
        ?>
    </body>
</html>