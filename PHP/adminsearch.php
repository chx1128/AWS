<?php
//declare array to keep table column name and table headerin the browser
$header = array(
    "payment_id" => "Transaction ID",
    "order_id" => "Order ID",
    "user_id" => "User ID",
    "name" => "Name",
    "ticket_name" => "Ticket",
    "ticket_amount" => "Quantity",
    "price" => "Price (RM)",
    "total_price" => "Total Price (RM)",
    "date" => "Date",
    "time" => "Time"
);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>SEARCH</title>
    <style>
        body {
            font-family: sans-serif;
        }
        html{
            max-width:1550px;
            margin:auto;
        }
        h1 {
            text-align: center;
        }
        #tranId {
            width: 50%;
            padding: 10px;
            margin-top: 10px;
            margin-bottom: 10px;
            margin-left: 10px;
            border: 1px solid lightgray;
            border-radius: 5px;
            box-sizing: border-box;
        }
        #form {
            display: flex;
            align-items: center;
            font-size: 1.2em;
        }
        .btn {
            display: flex;
            align-items: center;
            margin-left: 2%;
        }
        .btnSearch, .btnShowAll {
            width: 60%;
            padding: 10px;
            background-color: #00032E;
            color: white;
            border: none;
            border-radius: 5px;
            margin-right: 2%;
            font-size: 1em;
            cursor: pointer;
        }
        .btnSearch:hover {
            background-color: darkblue;
            transition: 0.1s;
        }
        .btnShowAll:hover {
            background-color: darkgreen;
            transition: 0.1s;
        }
        table {
            width: 90%;
            border: none;
            margin: 0 auto;
        }
        h2 {
            margin-left: 5%;
        }
        th {
            background-color: lightgray;
            text-align: center;
            padding: 10px;
        }
        td {
            padding: 10px;
            text-align: left;
        }
    </style>
</head>
<body>
    <?php
    include('../PHP/adminheader.php');
    require_once '../secret/helper.php';
    ?>

    <h2>Transaction History</h2>
    <table border="1" cellspacing="0" cellpadding="5">
        <thead>
            <tr>
                <th>Transaction ID</th>
                <th>Order ID</th>
                <th>User ID</th>
                <th>Name</th>
                <th>Product</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Total</th>
                <th>Date</th>
                <th>Time</th>
            </tr>
        </thead>
        <tbody id="tableBody">
            
        </tbody>
    </table>

    <script>
        function validateInput() {
            let tranId = document.getElementById("tranId").value;
            let btnSearch = document.getElementById("btnSearch");
            let pattern = /^[Pp]\d{4}$/;

            if (pattern.test(tranId)) {
                btnSearch.disabled = false;
            } else {
                btnSearch.disabled = true;
            }
        }

        function searchRecords() {
            let tranId = document.getElementById("tranId").value;
            let xmlhttp = new XMLHttpRequest();

            if (window.XMLHttpRequest) {
                xmlhttp = new XMLHttpRequest(); //object
            } else if (ActiveXObject("Microsoft.XMLHTTP")) {
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            } else {
                alert("Problem with your browser!");
                return false;
            }

            xmlhttp.open("POST", "../PHP/search.php", true);
            xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xmlhttp.onreadystatechange = function () {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    document.getElementById("tableBody").innerHTML = xmlhttp.responseText;
                }
            };
            xmlhttp.send("tranId=" + tranId + "&action=search");
        }

        function showAllRecords() {
            let tranIdbox = document.getElementById("tranId");
            let xmlhttp = new XMLHttpRequest();

            if (window.XMLHttpRequest) {
                xmlhttp = new XMLHttpRequest(); //object
            } else if (ActiveXObject("Microsoft.XMLHTTP")) {
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            } else {
                alert("Problem with your browser!");
                return false;
            }
            
            xmlhttp.open("POST", "../PHP/search.php", true);
            xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xmlhttp.onreadystatechange = function () {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    document.getElementById("tableBody").innerHTML = xmlhttp.responseText;
                    tranIdbox.value = "";
                }
            };
            xmlhttp.send("action=showAll");
        }

        window.onload = function () {
            showAllRecords();
            document.getElementById("tranId").addEventListener("keydown", function(event) {
                if (event.key === "Enter") {
                    event.preventDefault();
                    validateInput();
                    if (!document.getElementById("btnSearch").disabled) {
                        searchRecords();
                    }
                }
            });
        };
    </script>
</body>
</html>