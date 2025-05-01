<?php
require_once ("../secret/helper.php");
?>
<?php

$con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

$cancellation_id = isset($_GET['cancellation_id']) ? $_GET['cancellation_id'] : (isset($_POST['cancellation_id']) ? $_POST['cancellation_id'] : null);

if ($cancellation_id) {
    $sql = "SELECT cancel.payment_id as payment_id,p.user_id,c.name,cancel.date,cancel.ticket_name,cancel.ticket_amount,cancel.price FROM cancellation cancel join payment p on cancel.payment_id = p.payment_id join client c on p.user_id = c.user_id WHERE cancellation_id = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param('i', $cancellation_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $fpID=$row['payment_id'];
    $fticketname=$row['ticket_name'];
    $stmt->close();
} else {
    echo "No cancellation ID provided.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $sqlbefore="select * from payment where payment_id ='$fpID'";
                $resultbefore=$con->query($sqlbefore);
                if ($resultbefore->num_rows>0) {
                    while ($row=$resultbefore->fetch_object()) {
                        $payment=$row->payment_id;
                        $ticketname = explode("|", $row->ticket_name);
                        $ticketqty = explode("|", $row->ticket_amount);
                        $bookdate = explode("|", $row->book_date);
                        $price = explode("|", $row->price);
                        $total=$row->total_price;
                    }
                }
                for($x=0;$x<20;$x++){
                    if (!empty($ticketname[$x])) {
                        if ($ticketname[$x]==$fticketname) {
                        $ticketname[$x]="";
                        $total=$total-$price[$x];
                        $ticketqty[$x]="";
                        $bookdate[$x]="";
                        $price[$x]="";
                    }
                    }
                }
                $nticketname = array_filter($ticketname, function($value) {
                return $value !== "";});
                $nticketqty = array_filter($ticketqty, function($value) {
                return $value !== "";});
                $nbookdate = array_filter($bookdate, function($value) {
                return $value !== "";});
                $nprice = array_filter($price, function($value) {
                return $value !== "";});
                $upticketname=implode("|",$nticketname);
                $upqty=implode("|",$nticketqty);
                $update=implode("|",$nbookdate);
                $upprice=implode("|",$nprice);
                
                $sqllast="update payment set ticket_name=?,ticket_amount=?,book_date=?,price=?,total_price=? where payment_id =?";
                $stmtlast=$con->prepare($sqllast);
                $stmtlast->bind_param("ssssds",$upticketname,$upqty,$update,$upprice,$total,$fpID);
                $stmtlast->execute();
    
    
    $sql = "DELETE FROM cancellation WHERE cancellation_id = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param('i', $cancellation_id);
    if ($stmt->execute()) {
        echo "<script>location='admincancellation.php'</script>";
    }
    $stmt->close();
}

$con->close();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Refund Confirmation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            font-family: Comic Sans MS;
        }

        .container {
            max-width: 800px;
            margin: 40px auto;
            padding: 20px;
            background: url("../IMAGE/duckbg.jpg");
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-style: dotted;
            border-width: 10px;
            border-color: white;
        }

        form {
            margin-bottom: 20px;
            margin-top: 50px;
        }

        table {
            width: 50%;
            border: solid 2px;
            border-radius: 20px;
            margin-left: 210px;
            background-color: white;
        }

        th {
            width: 20%;
            font-size: 20px;
            text-align: right;
        }

        td {
            font-size: 20px;
        }

        .button-container {
            text-align: center;
            margin-top: 0px;
        }

        .button-container input[type="submit"] {
            background-color: white;
            color: black;
            font-size: 15px;
            padding: 10px 20px;
            border-radius: 20px;
            cursor: pointer;
            margin: 0 10px;
        }

        input[type="submit"]:hover {
            background-color: #F4C430;
        }
        
        .btnCancel{
            background-color: white;
            color: black;
            font-size: 15px;
            padding: 10px 20px;
            border-radius: 20px;
            cursor: pointer;
        }
        
        .btnCancel:hover{
            background-color: #F4C430;
        }
        
        #message {
            padding-top: 25px;
            text-align: center;
            font-weight: bold;
            color: #ff0000;
        }
    </style>
</head>
<body>
    <h1>Refund Confirmation</h1>
    <div class="container">
        <form id="refundForm" action="" method="POST">
            <div class="refundTable">
                <table cellpadding="10" cellspacing="5">
                    <tr>
                        <th>User ID: </th>
                        <td><?php echo $row['user_id']; ?>
                            <input type="hidden" id="userID" name="userID" value="<?php echo $row['user_id']; ?>"/>
                        </td>
                    </tr>
                    <tr>
                        <th>Name: </th>
                        <td><?php echo $row['name']; ?>
                            <input type="hidden" name="userName" value="<?php echo $row['name']; ?>"/>
                        </td>
                    </tr>
                    <tr>
                        <th>Date: </th>
                        <td><?php echo $row['date']; ?>
                            <input type="hidden" name="date" value="<?php echo $row['date']; ?>"/>
                        </td>
                    </tr>
                    <tr>
                        <th>Category: </th>
                        <td><?php echo $row['ticket_name']; ?>
                            <input type="hidden" name="category" value="<?php echo $row['ticket_name']; ?>"/>
                        </td>
                    </tr>
                    <tr>
                        <th>Quantity: </th>
                        <td><?php echo $row['ticket_amount']; ?>
                            <input type="hidden" name="quantity" value="<?php echo $row['ticket_amount']; ?>"/>
                        </td>
                    </tr>
                    <tr>
                        <th>Refund Amount: </th>
                        <td><?php echo "RM ".$row['price']; ?>
                            <input type="hidden" name="refundAmount" value="<?php echo $row['price']; ?>"/>
                        </td>
                    </tr>
                </table>
            </div>
            <div id="message"></div>
            <br />
            <br />
            <input type="hidden" name="cancellation_id" value="<?php echo $cancellation_id; ?>"/>
            <div class="button-container">
                <input type="submit" value="Refund" class="btnRefund" />
                <input type="button" value="Cancel" class="btnCancel" onclick="location.href='admincancellation.php';" />
            </div>
        </form>
    </div>
</body>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const refundForm = document.getElementById('refundForm');
        const messageDisplay = document.getElementById('message');

        refundForm.addEventListener('submit', function (event) {
            event.preventDefault();
            const userID = document.getElementById('userID').value;
            const refundAmount = parseFloat(document.querySelector('input[name="refundAmount"]').value);
            if (refundAmount > 0) {
                //display refund success message
                messageDisplay.textContent = `Refund of RM ${refundAmount} for User ID ${userID} successful.`;
                //delay before displaying redirecting message
                setTimeout(function () {
                    messageDisplay.textContent = "Redirecting you back to Ticket Cancellation Request Page in 3 seconds...";                    
                    setTimeout(function () {
                        refundForm.submit(); //submit form to delete cancellation row
                    }, 3000);
                }, 2000);
            } else {
                
            }
        });
    });
</script>
</html>