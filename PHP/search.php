<!DOCTYPE html>
<?php
require_once '../secret/helper.php';

// Connect to DB
$con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check if there is any connection error
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// Process the AJAX request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'];

    // Default SQL statement
    $sql = "SELECT payment_id, order_id, p.user_id, name, ticket_name, ticket_amount, price, total_price, date, time
            FROM Payment p JOIN Client c ON p.user_id = c.user_id";

    // Modify SQL based on the action
    if ($action == 'search' && !empty($_POST['tranId'])) {
        $tranId = $con->real_escape_string($_POST['tranId']);
        $sql .= " WHERE payment_id = '$tranId'";
    }

    // Execute SQL statement
    $result = $con->query($sql);

    // Fetch records and generate HTML table rows
    if ($result->num_rows > 0) {
        $payment = null;
        while ($row = $result->fetch_object()) {
            $ticketname = explode("|", $row->ticket_name);
            $ticketamount = explode("|", $row->ticket_amount);
            $ticketprice = explode("|", $row->price);

            $num_tickets = count($ticketname);

            if ($row->payment_id != $payment) {
                printf("<tr>
                            <td rowspan='%d'>%s</td>
                            <td rowspan='%d'>%s</td>
                            <td rowspan='%d'>%s</td>
                            <td rowspan='%d'>%s</td>
                            <td>%s</td>
                            <td>%s</td>
                            <td>%s</td>
                            <td rowspan='%d'>%s</td>
                            <td rowspan='%d'>%s</td>
                            <td rowspan='%d'>%s</td>
                        </tr>",
                    $num_tickets,
                    $row->payment_id,
                    $num_tickets,
                    $row->order_id,
                    $num_tickets,
                    $row->user_id,
                    $num_tickets,
                    $row->name,
                    $ticketname[0],
                    $ticketamount[0],
                    $ticketprice[0],
                    $num_tickets,
                    $row->total_price,
                    $num_tickets,
                    $row->date,
                    $num_tickets,
                    $row->time
                );

                // Update prev_payment_id
                $payment = $row->payment_id;

                // Print remaining rows if there are more tickets
                for ($i = 1; $i < $num_tickets; $i++) {
                    printf("<tr>
                                <td>%s</td>
                                <td>%s</td>
                                <td>%s</td>
                            </tr>",
                        $ticketname[$i],
                        $ticketamount[$i],
                        $ticketprice[$i]
                    );
                }
            }
        }
        printf("<tr>
                    <td colspan='10'>%d record(s) returned.</td>
                </tr>", $result->num_rows);
    } else {
        echo "<tr><td colspan='10'>No records found.</td></tr>";
    }

    $result->free();
}

$con->close();
?>
