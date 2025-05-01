<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Appeals & Approval</title>
        <style>
            .ctn1, .ctn2 {
               width: 250px;
               height: 100px;
               text-align: center;
               padding-top: 60px;
               border: solid 2px;
               border-radius: 10px;
               display: inline-block;
               margin: 80px;
            }

            .ctn1 {
               background-color: yellow;
            }

            .ctn2 {
               background-color: red;
            }

            .button1, .button2 {
               text-decoration: none;
               font-size: 20pt;
               font-family: Arial;
               font-weight: bold;
               color:black;
            }
            
            .button-ctn{
               display: flex;
               justify-content: center;
               width: fit-content;
               margin: 0 auto;
               padding-top: 130px;
            }
        </style>
    </head>
    <body>
        <?php
        include('../PHP/adminheader.php');
        ?>
        
        <div class="button-ctn">
        <div class='ctn1'>
        <a href='../PHP/adminmodification.php' class='button1'>Modification</a>
        </div>
        
        <div class='ctn2'>
        <a href='../PHP/admincancellation.php' class='button2'>Cancellation</a>
        </div>
        </div>
        
        
        
    </body>
</html>