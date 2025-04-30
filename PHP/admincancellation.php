<?php
require_once ("../secret/helper.php");
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Cancellation</title>
         <style>
             body {
  font-family: Arial, sans-serif;
  margin: 0;
  padding: 0;
  background-color: #f8f8f8;
}

.container {
  max-width: 1200px;
  margin: 20px auto;
  padding: 20px;
  background: url("/Assignment/IMAGE/duckbg.jpg");
  border-radius: 10px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  border-style: dotted;
  border-width: thick;
  border-color: white;
}

h1 {
    margin-bottom: 50px;
    margin-top: 50px;
  text-align: center;
}

table {
  width: 100%;
  border-collapse: collapse;
  border-radius: 5px;
}

th, td {
  padding: 8px;
  border-bottom: 1px solid #ddd;
  text-align: left;
}

th {
  background-color: black;
  color: white;
  font-size: 18px;
}

td {
    background-color: white;
}   
</style>
</head>
    <header>
        <?php
        include('adminheader.php');
        ?>
    </header>
    <body>
        <h1>Ticket Cancellation Request</h1>
        <div class="container">
            <table>
                <tr>
                    <th>Payment ID</th>
                    <th>User ID</th>                   
                    <th>Date</th>
                    <th>Ticket</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Reason</th>
                    <th>Action</th>
                </tr>
          <?php

          $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
          if ($con->connect_error) {
            die("Connection failed: " . $con->connect_error);
          }

          $sql = "SELECT cancellation_id,c.payment_id,user_id,c.date,c.ticket_name,c.ticket_amount,c.price,reason FROM cancellation c join payment p on c.payment_id =p.payment_id";
          $stmt = $con->prepare($sql);

          $stmt->execute();
          $result = $stmt->get_result();

          if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
              $cid = $row['cancellation_id'];
              echo "<tr>
                <td>{$row['payment_id']}</td>
                <td>{$row['user_id']}</td>
                <td>{$row['date']}</td>
                <td>{$row['ticket_name']}</td>
                <td>{$row['ticket_amount']}</td>
                <td>RM " . $row['price'] . "</td>
                <td >{$row['reason']}</td>
                <td>";

              echo "<form method='post' action='' style='display: inline-block;'>";
              echo "<input type='hidden' name='cancellation_id' value='$cid'>";

              echo "<button type='submit' name='action' value='approve' onclick='return alert(\"Directing to refund confirmation page...\")'>Approve</button>";
              echo " | ";
              echo "<button type='submit' name='action' value='reject' onclick='return confirm(\"Are you sure you want to reject? This action cannot be undone.\")'>Reject</button>";
              echo "</form>";

              echo "</td>
              </tr>";
            }
          } else {
            echo "<tr><td colspan='10'>No cancellation requests found.</td></tr>";
          }

          $stmt->close();
          $con->close();
        ?>
             
            </table>
        </div>
        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
          $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
          if ($con->connect_error) {
            die("Connection failed: " . $con->connect_error);
          }

          $cid = isset($_POST['cancellation_id']) ? mysqli_real_escape_string($con, $_POST['cancellation_id']) : "";
          $action = isset($_POST['action']) ? $_POST['action'] : "";

          
        if ($cid && $action == 'approve') {
            echo "<script>location='adminrefund.php?cancellation_id=$cid'</script>";
        } elseif ($cid && $action == 'reject') {
            $sql = "DELETE FROM cancellation WHERE cancellation_id = ?";
            $stmt = $con->prepare($sql);
            $stmt->bind_param('i', $cid);
            $stmt->execute(); 
            echo "<script>location='admincancellation.php'</script>";
        }
              $con->close();
    }
      ?>
    </body> 
</html>