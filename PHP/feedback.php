<?php
require_once ("../secret/helper.php");
if (isset($_COOKIE['id'])) {
    $id=$_COOKIE['id'];
    //echo"$id";
}

    $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
    }

    if(isset($_POST["rating"], $_POST["radio1"], $_POST["radio2"], $_POST["radio3"])) {
        $rating = $_POST["rating"];
        $q1 = $_POST["radio1"];
        $q2 = $_POST["radio2"];
        $q3 = $_POST["radio3"];
        $hidden1= $_POST["hidden1"];
        $hidden2= $_POST["hidden2"];
        $comment = $_POST["comment"];
        $currentdate=new DateTime();
        $formattedDate = $currentdate->format('Y-m-d');
        $sql = "INSERT INTO feedback (star_rating, q1, q2, q3, user_comment,user_id,ticket_name,payment_id,date) VALUES (?, ?, ?, ?, ?,?,?,?,?)";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("iiiisssss", $rating, $q1, $q2, $q3, $comment,$id,$hidden1,$hidden2,$formattedDate);

        if ($stmt->execute()) {
            echo "<script>
                alert('Thank you for your valuable feedback!');
                window.location.href='account.php';
                  </script>";
        } else {
            echo "Error: " . $con->error;
        }

        $stmt->close();
    }

    $con->close();

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Feedback</title>
    <style>
        .typing-animation {
                
                display: inline-block;
                overflow: hidden;
                border-right: 0.1em solid black;
                white-space: nowrap;
                margin: 20px auto;
                letter-spacing: 0.1em;
                animation: typing 3.5s steps(55, end), blink-caret .75s step-end infinite;
            }

            @keyframes typing {
                from {
                    width:0%
                }
                to {
                    width:71%
                }
            }
            @keyframes blink-caret {
                from,
                to {
                    border-color:transparent
                }
                50% {
                    border-color:black
                }
            }
            .part1{
                width:clamp(600px,80%,1600px);
                height: 200px;
                text-align: center;
                margin:auto;
                font-family: courier;
            }
            .colorpart{
                width:100%;
                margin:auto;
                background-color:#fdfd96;
                height:170px;
                padding-top: 10px;
            }
            .rate{
                margin-bottom:-100px;
                margin-top:110px;
                font-size:20px;
            }
            .rating {
                width: 210px;
                height: 40px;
                margin-left: auto;
                margin-right: auto;
                padding-right: 10px;
                padding-left: 10px;
                padding-top: 90px;
                padding-bottom: 10px;
                background: none;
                position: relative;

            }
            .rating label {
                float: right;
                position: relative;
                width: 40px;
                height: 40px;
                cursor: pointer;
            }
            .rating label:not(:first-of-type) {
                padding-right: 2px;
            }
            .rating label:before {
                content: "\2605";
                font-size: 35px;
                color: rgb(56, 46, 46);
                line-height: 1;
            }
            .rating input {
                display: none;
            }
            .rating input:checked ~ label::before,
            .rating:not(:checked) > label:hover:before,
            .rating:not(:checked) > label:hover ~ label:before {
                color: rgb(255, 223, 0);
            }

            .part2{
                margin-top:10px;
            }
            table{
                width:1000px;
                height:400px;
                border-spacing:5px;
                margin:auto;
                font-size: 1.3em;
            }
            td{
                text-align:center;
                background-color:rgb(237, 240, 245);
            }
            th{
                font-weight:100;
                font-size: 16px;
            }
            .part3{
                margin:auto;
                width: 1000px;
                height:300px;
                margin-top: 40px;
            }
            .part3 p{
                margin-left:100px;
                font-weight:bold;
                font-size: 1.3em;
            }
            input[type='radio']:after {
                width: 13px;
                height: 13px;
                border-radius: 15px;
                top: -2px;
                left: -1px;
                position: relative;
                background-color: white;
                content: '';
                display: inline-block;
                visibility: visible;
                border: solid 1px grey;
                transform: scale(1.5);
            }

            input[type='radio']:checked:after {
                width: 13px;
                height: 13px;
                border-radius: 15px;
                top: -2px;
                left: -1px;
                position: relative;
                background-color: #fdfd96;
                content: '';
                display: inline-block;
                visibility: visible;
            }
            
            #fb{
                font-weight: bold;
                font-size: 20px;
            }           
            
            textarea{
                resize:none;
                width:800px;
                height:200px;
                margin-left: 100px;
                padding:10px;
                border: solid 2px black;
                border-radius:20px;
                font-size:15px;
                font-family: Times New Roman;
                letter-spacing: 1.3px;
            }
            .passup{
                appearance: button;
                backface-visibility: hidden;
                background-color: #fdfd96;
                border-radius: 6px;
                border-width: 0;
                box-shadow: rgba(50, 50, 93, .1) 0 0 0 1px inset,rgba(50, 50, 93, .1) 0 2px 5px 0,rgba(0, 0, 0, .07) 0 1px 1px 0;
                box-sizing: border-box;
                color: black;
                border:solid 2px black;
                cursor: pointer;
                font-family: Times New Roman;
                font-size: 100%;
                letter-spacing: 1px;
                height: 44px;
                line-height: 1.15;
                margin-top: 25px;
                margin-bottom:30px;
                outline: none;
                overflow: hidden;  
                position: relative;
                text-align: center;
                text-transform: none;
                transform: translateZ(0);
                transition: all .2s,box-shadow .08s ease-in;
                user-select: none;
                -webkit-user-select: none;
                width: 100px;
            }
            
            .passup:hover {
                background-color:#fbec5d;
            }
    </style>
</head>
<body>
    <?php 
    include("header.php"); 
    ?>
    
    <form method="post" action="" onsubmit="return validateForm()">
        <div class="part1">
            <h1 class="typing-animation">Wow! Duckyland @ Anaheim, California.</h1>
            <div class="colorpart">
                <h2><p id="ticket"></p></h2>
                <h2>We value your feedback.</h2>
                <p>Please complete the following form. Your feedback will help us enhance our services.</p></div>
        </div></div>
        <div class="rate">
            <h3 style="text-align: center;">Rate your overall experience in our theme park. <span style="color:red;">*</span></h3>
        </div>
       <div class="rating">
            <input type="radio" id="star5" name="rating" value="5" /><label for="star5"></label>
            <input type="radio" id="star4" name="rating" value="4" /><label for="star4"></label>
            <input type="radio" id="star3" name="rating" value="3" /><label for="star3"></label>
            <input type="radio" id="star2" name="rating" value="2" /><label for="star2"></label>
            <input type="radio" id="star1" name="rating" value="1" /><label for="star1"></label>
        </div>
    <div class="part2"> 
        <table padding="5px">
            <colgroup>
                <col span="1" style="width:150px;">
            </colgroup>
            <tr>
                <th></th>
                <th style="width: 17%">Very Satisfied😄</th>
                <th style="width: 17%">Satisfied🙂</th>
                <th style="width: 17%">Neutral😐</th>
                <th style="width: 17%">Unsatisfied☹️</th>
                <th style="width: 17%">Very Unsatisfied😵</th>
            </tr>
            <tr>
                <th>How satisfied are you with our products? <span style="color:red;">*</span></th>
                <td><input type="radio" name="radio1" value="5" id="r11"></td>
                <td><input type="radio" name="radio1" value="4" id="r12"></td>
                <td><input type="radio" name="radio1" value="3" id="r13"></td>
                <td><input type="radio" name="radio1" value="2" id="r14"></td>
                <td><input type="radio" name="radio1" value="1" id="r15"></td>
            </tr>
            <tr>
                <th>How satisfied are you with our facilities? <span style="color:red;">*</span></th>
                <td><input type="radio" name="radio2" value="5" id="r21"></td>
                <td><input type="radio" name="radio2" value="4" id="r22"></td>
                <td><input type="radio" name="radio2" value="3" id="r23"></td>
                <td><input type="radio" name="radio2" value="2" id="r24"></td>
                <td><input type="radio" name="radio2" value="1" id="r25"></td>
            </tr>
            <tr>
                <th>How satisfied are you with our services? <span style="color:red;">*</span></th>
                <td><input type="radio" name="radio3" value="5" id="r31"></td>
                <td><input type="radio" name="radio3" value="4" id="r32"></td>
                <td><input type="radio" name="radio3" value="3" id="r33"></td>
                <td><input type="radio" name="radio3" value="2" id="r34"></td>
                <td><input type="radio" name="radio3" value="1" id="r35"></td>
            </tr>
        </table>
    </div>            
        <center>
            <p id="fb">Tell us how we can improve. <span style="font-size:15px; font-weight:100;">(optional)</span></p>
            <textarea placeholder="Type your feedback here..." name="comment"></textarea><br>
            <input type="hidden"id="hidden1" name="hidden1" />
            <input type="hidden"id="hidden2" name="hidden2" />
            <input type="submit" value="Submit" class="passup" />
        </center>
        </form>
     
    <script>
        var part = localStorage.ticket.split(",");
        document.getElementById("ticket").innerHTML=part[0] + " Ticket";
        document.getElementById("hidden1").value=part[0];
        document.getElementById("hidden2").value=part[1];
    
    function validateForm() {
        var radioButtons = document.querySelectorAll('input[type="radio"]');
        var isChecked = 0;

        for (var i = 0; i < radioButtons.length; i++) {
            if (radioButtons[i].checked) {
                isChecked += 1;
            }
        }

        if (isChecked !== 4 ) {
            alert("Please select a rating for all questions.");
            return false;
        } else {
            return true;
        }
    }
    </script>
</body>
</html>