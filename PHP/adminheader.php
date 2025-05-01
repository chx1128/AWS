<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <style>
            *{
                font-family: Arial, sans-serif;
            }
            .adminnavi{
                width: clamp(600px,100%,1600px);
                margin:auto;
                height: 80px;
                display: flex;
                background-color:#E5E5E5;
            }

            .organame {
                background-color:#E5E5E5;
                color:yellow;
                width:300px;
                height:60px;
                margin-top:5px;
                margin-right:0px;
                margin-left:0px;
            }

            .adminnavname{
                background-color:#E5E5E5;
                width: 250px;
                height: 50px;
                margin-left:5px;
                margin-right:5px;
                margin-top:10px;
            }

            .navia{
                height: 55px;
                width:400px;
                text-align: center;
                padding-top: 28px;
                border:2px solid white;
                margin-top:-3px;
            }

            .navia a{
                text-decoration: none;
                font-size: 1.5em;
                color: black;
                margin-left:20px;
                margin-right:20px;
            }

            .navia a:hover {
                transform:scale(1.1);
                color:#6468AF;
            }

        </style>
    </head>
    <body>
        <div class="adminnavi">
            <div class="organame" >
                <img src="../IMAGE/adminnavname.png" class="adminnavname"/>

            </div>
            <div class="navia" ><a href="adminsearch.php"><b>TRANSACTION</b></a></div>
            <div class="navia" ><a href="adminappeals&approval.php"><b>APPEALLING</b></a></div>
            <div class="navia"><a href="adminfeedback.php"><b>FEEDBACK</b></a></div>
            <div class="navia"><a href="admin-memberships.php"><b>MEMBERSHIPS</b></a></div>
            <div class="navia"><a href="#" onclick="confirmLogout()"><b>LOG OUT</b></a></div>
        </div>
        <script>
            function confirmLogout() {
                if (confirm("Are you sure you want to log out?")) {
                    window.location.href = "login.php";
                }
            }
        </script>

    </body>
</html>
