<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>ADMIN SELECTION</title>

        <style>
            .wrap{
                width:clamp(600px,100%,1550px);
                margin:auto;
                height:825px;
                background-image:url('/Assignment/IMAGE/selectionbk.jpg');
                background-repeat:no-repeat;
                background-attachment: fixed;
                background-size:100% 100%;
                padding:auto;
                display:flex;
                flex-wrap:wrap;
            }

            .selection{
                background-color:#00014F;
                color:white;
                width:350px;
                height:150px;
                padding:50px;
                margin-left:180px;
                margin-top:52px;
                margin-bottom:70px;
                font-size:2em;
                text-align:center;
            }

            .selection:hover{
                box-shadow: 0px 1px 34px 9px #2D2D2D;
                -webkit-box-shadow: 0px 1px 34px 9px #2D2D2D;
                -moz-box-shadow: 0px 1px 34px 9px #2D2D2D;
                transition:0.3s;
            }
            .directionwrap{
                width: 130px;
                height:130px;
                margin:auto;
                margin-top: -500px;
            }
            .direction{
                font-size:3em;
                margin-left: 7px;
            }

            .number{
                background-color:#39988A;
                border-radius:100px;
                width:40px;
                height:40px;
                padding:auto;
                text-align:center;
                font-size:1.1em;
                margin-left:160px;
                margin-bottom:8px;
            }

            .selectiondes{
                font-size:0.5em;
                margin-top:10px;
            }
        </style>
    </head>
    <body>
        <div class="wrap">
            <?php
            $selection = array(
                "adminfacilities.php" => "🎡 FACILITIES",
                "adminproductsstatus.php" => "PRODUCT STATUS 🎫",
                "adminappeals&approval.php" => "⚙ APPEALLING",
                "adminfeedback.php" => "ADMIN FEEDBACK 👂",
            );
            $selectiondes = array(
                "For Facilities Modification & Add On",
                "For Products Modification & Add On",
                "For Appellation Approval / Cancellation",
                "For Feedback Read"
            );
            $pageclass = array("facilities", "productstatus", "appealling", "adminfeedback");
            $i = 0;
            $x = 1;
            $z = 0;
            foreach ($selection as $pagelocation => $pagename) {
                for ($i = 0; $i < 1; $i++) {
                    echo"<div class='selection'>
                <a href='$pagelocation' style='text-decoration:none;color:white;'><div class='$pageclass[$i]' style='margin-top:-20px;'><br/><div class='number'>$x</div>$pagename<br/><div class='selectiondes'>$selectiondes[$z]</div></div></a>
            </div>";
                }$x++;
                $z++;
            }
            ?></div>

        <script>
            document.addEventListener("keydown", e => {
                if (e.key.toLowerCase() === "1") {

                    location = "adminfacilities.php";
                    alert("Proceed to Facilities Page !");
                } else if (e.key.toLowerCase() === "2") {
                    location = "adminproductsstatus.php";
                    alert("Proceed to Product Status Page !");
                } else if (e.key.toLowerCase() === "3") {
                    location = "adminappeals&approval.php";
                    alert("Proceed to Appealing Page !");
                } else if (e.key.toLowerCase() === "4") {
                    location = "adminfeedback.php";
                    alert("Proceed to Feedback Page !");
                }
            });
        </script>

        <div class="directionwrap">
            <div class="direction">↖️↗️<br/>️️↙️↘️</div>
        </div>
    </body>
</html>