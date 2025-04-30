<!DOCTYPE html>
<html>
<head>
    <title>Modification</title>
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
  <h1>Ticket Modification Request</h1>
  <form method="post" action="">
    <div class="container">
      <table>
        <tr>
          <th>Payment ID</th>
          <th>User_id</th>
          <th>Ticket</th>
          <th>Date</th>
          <th>Quantity</th>
          <th>Price</th>
          <th>New Date</th>
          <th>New Quantity</th>
          <th>New Price</th>
          <th>Action</th>
        </tr>

        <?php
          require_once ("../secret/helper.php");

          $number=0;
          $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
          if ($con->connect_error) {
            die("Connection failed: " . $con->connect_error);
          }

          $sql = "SELECT modification_id,m.payment_id as payment_id,p.user_id as user_id,m.ticketname as ticket,m.date as date,ticketqty,m.price as price,new_date,new_ticketqty,new_price FROM modification m join payment p on m.payment_id = p.payment_id";
          $stmt = $con->prepare($sql);

          $stmt->execute();
          $result = $stmt->get_result();

          if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
              $mid = $row['modification_id'];
              $pid[$number] =$row['payment_id'];
              $oriname[$number]=$row['ticket'];
              $newdate[$number]=$row['new_date'];
              $newqty[$number]=$row['new_ticketqty'];
              $newprice[$number]=$row['new_price'];
              $number++;
              echo "<tr>
                <td>{$row['payment_id']}</td>
                <td>{$row['user_id']}</td>
                <td>{$row['ticket']}</td>
                <td>{$row['date']}</td>
                <td>{$row['ticketqty']}</td>
                <td>{$row['price']}</td>
                <td>{$row['new_date']}</td>
                <td>{$row['new_ticketqty']}</td>
                <td>{$row['new_price']}</td>
                <td>";

              echo "<form method='post' action='adminmodification.php' style='display: inline-block;'>";
              echo "<input type='hidden' name='modification_id' value='$mid'>";

              echo "<button type='submit' name='action' value='approve' onclick='return confirm(\"Are you sure you want to approve? This action cannot be undone.\")'>Approve</button>";
              echo " | ";
              echo "<button type='submit' name='action' value='reject' onclick='return confirm(\"Are you sure you want to reject? This action cannot be undone.\")'>Reject</button>";
              echo "</form>";
              
              echo "</td>
              </tr>";
            }
          } else {
            echo "<tr><td colspan='10'>No modification requests found.</td></tr>";
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

          $mid = isset($_POST['modification_id']) ? mysqli_real_escape_string($con, $_POST['modification_id']) : "";
          $action = isset($_POST['action']) ? $_POST['action'] : "";
          $sql2="select * from modification where modification_id ='$mid'";
          $stmt2=$con->query($sql2);
          if ($stmt2->num_rows>0) {
              while ($row=$stmt2->fetch_object()) {
                 $fpID=$row->payment_id;   
                 $fticketname=$row->ticketname;
                 $fndate=$row->new_date;
                 $fnqty=$row->new_ticketqty;
                 $fnprice=$row->new_price;
              }
          }
          if ($mid &&  $action == 'reject') {            
            $sql = "DELETE FROM modification WHERE modification_id = ?";
            $stmt = $con->prepare($sql);
            $stmt->bind_param('i', $mid);
            $stmt->execute();  
            
            echo "<script>location='adminmodification.php'</script>";
            }
            if ($mid && $action == 'approve') {
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
                        $total=$total-$price[$x]+$fnprice;
                        $ticketqty[$x]=$fnqty;
                        $bookdate[$x]=$fndate;
                        $price[$x]=$fnprice;
                    }
                    }
                }
                $upqty=implode("|",$ticketqty);
                $update=implode("|",$bookdate);
                $upprice=implode("|",$price);
                $sql = "DELETE FROM modification WHERE modification_id = ?";
            $stmt = $con->prepare($sql);
            $stmt->bind_param('i', $mid);
            $stmt->execute();  
            echo "<script>location='adminmodification.php';</script>";
            }
             $lastsql="update payment set ticket_amount=?,book_date=?,price=?,total_price = ? where payment_id =?";
             $stmtlast=$con->prepare($lastsql);
             $stmtlast->bind_param("sssds",$upqty,$update,$upprice,$total,$fpID);
             $stmtlast->execute();
             
        
        }
      ?>
  </form>
</body>
</html>