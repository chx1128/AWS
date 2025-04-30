<?php
//declare array to keep table column name and table header in the browser
$header = array(
    "membership_id" => "Membership ID",
    "user_id" => "User ID",
    "name" => "Member Name",
    "email" => "Email",
    "phone" => "Phone",
    "date_join" => "Date Join",
    "date_exp" => "Date Expired",
    "total_payment" => "Total Payment (RM)"
);
?>
<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin Membership Page</title>
        <script src="scripts/jquery-1.9.1.js"></script>

        <style>
            body {
                font-family: Arial, sans-serif;
            }

            .error, .info
            {
                width: 50%;
                padding: 5px;
                margin: 2% 10%;
                font-size: 0.9em;
                list-style-position: inside;
            }

            .error
            {
                border: 2px solid #FBC2C4;
                background-color: #FBE3E4;
                color: #8A1F11;
            }

            .info
            {
                border: 2px solid #92CAE4;
                background-color: #D5EDF8;
                color: #205791;
            }

            h1, h2{
                margin-top: 5%;
                margin-right: 40%;
                margin-bottom: 2%;
                margin-left: 10%;
            }

            .deleteAll-btn{
                background-color: #FF4949;
                color: white;
                font-size: 1em;
                border: none;
                padding: 6px 12px;
                cursor: pointer;
                border-radius: 4px;
                margin: 1% auto;
                width: 150px;
                height: 50px;
            }

            .deleteAll-btn:hover{
                background-color: #FF3232;
            }

            h1, .deleteAll-btn{
                display: inline-block;
                vertical-align: bottom;
                justify-content: space-between;
            }

            table {
                max-width: 1500px;
                border-collapse: collapse;
                margin: 0 auto;
            }

            th, td {
                padding: 8px;
                text-align: left;
                border-bottom: 1px solid #ddd;
            }

            tr {
                background-color: white;
            }

            tr:nth-child(odd){
                background-color: #F2F2F2;
            }

            th {
                background-color: #FFEBEB;
            }

            .delete-btn{
                background-color: #FF4949;
                color: white;
                border: none;
                padding: 6px 12px;
                cursor: pointer;
                border-radius: 4px;
            }

            .delete-btn:hover{
                background-color: #FF3232;
            }

            .add-btn{
                background-color: #3844FF;
                color: white;
                border: none;
                padding: 6px 12px;
                cursor: pointer;
                border-radius: 4px;
            }

            .add-btn:hover{
                background-color: #000FFF;
            }

            .edit-btn{
                background-color: #10AC00;
                color: white;
                border: none;
                padding: 6px 12px;
                cursor: pointer;
                border-radius: 4px;
            }

            .edit-btn:hover{
                background-color: #0E9200;
            }

            #deletepage, #editpage, #addpage{
                background-color: #FAFAFA;
                position: fixed;
                border-radius: 10px;
                top: 15%;
                z-index: 50;
                width: 120%;
                height: 85%;
                max-height: 100%;
            }

            .deleteTable, .editTable, .addTable{
                width: 1000px;
                margin-left: 10%;
            }

            .deleteBtns, p, .editBtns, .addBtns{
                padding-top: 2%;
                padding-bottom: 2%;
                margin-left: 10%;
                font-size: 1.5em;
                color: red;
            }
        </style>
    </head>

    <body>
        <?php
        include("adminheader.php");
        require_once '../secret/helper.php';
        ?>
        <form action="" method="POST">
            <h1>Admin Membership Page</h1>
            <input type="submit" value="Delete Checked" name="btnDelete" class="deleteAll-btn"/>

            <table border="1" cellspacing="0" cellpadding="5">
                <tr>
                    <th></th>
                    <?php
                    foreach ($header as $key => $value) {
                        echo "<th>";
                        echo "$value";
                        echo "</th>";
                    }
                    ?>
                    <th colspan="2">
                        <input type="button" value="Add Member" name="btnAdd" class="add-btn"
                               onclick="window.location.href = 'admin-memberships.php?hddAdd=1'"/>
                    </th>
                </tr>

                <?php
                //connect to DB
                $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

                //check if there is any connection error
                if ($con->connect_error) {
                    die("Connection failed: " . $con->connect_error);
                }

                //sql statement
                $sql = "SELECT membership_id,c.user_id as user_id,date_join,date_exp,name,user_email,phone,total_payment FROM membership m join client c ON m.user_id = c.user_id;";

                //execute sql statement
                $result = $con->query($sql);

                //fetch_object - retreive record 1 by 1
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_object()) {
                        printf("<tr>
                        <td><input type='checkbox' name='chkDelete[]' value='%s' /></td>
                        <td>%s</td>
                        <td>%s</td>
                        <td>%s</td>
                        <td>%s</td>
                        <td>%s</td>
                        <td>%s</td>
                        <td>%s</td>
                        <td>%d</td>

                        <td>
                            <a href='admin-memberships.php?editid=%s'>
                                <input type='button' name='btnEdit' class='edit-btn' value='Edit'/>
                            </a> 
                        </td>
                        <td>
                        <a href='admin-memberships.php?deleteid=%s'>
                            <input type='button' name='btnDelete' class='delete-btn' value='Delete'/>
                           </a>  
                        </td>
                    </tr>", $row->membership_id   //for checkbox
                                , $row->membership_id
                                , $row->user_id
                                , $row->name
                                , $row->user_email
                                , $row->phone
                                , $row->date_join
                                , $row->date_exp
                                , $row->total_payment
                                , $row->membership_id   //query string
                                , $row->membership_id   //query string
                        );
                    }

                    printf("<tr>
                        <td colspan='11'>
                            %d record(s) returned. 
                        </td>
                    </tr>", $result->num_rows);
                } else {
                    // No records found
                    echo "<tr><td colspan='11'>No records found.</td></tr>";
                }

                //security purpose
                $result->free();
                $con->close();
                ?>
            </table>
        </form>



        <!----------------------------- DELETE ----------------------------->
        <?php
        $deleteId = isset($_GET['deleteid']) ? $_GET['deleteid'] : null;

        // Set a variable to control the display of deletepage
        $showDeletePage = !empty($deleteId);

        if ($showDeletePage) {
            ?>
            <div id="deletepage">
                <form action="" method="POST" >
                    <?php
                    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                        //GET method
                        //retrieve record and display
                        //retrieve membership ID from URL
                        if (isset($_GET['deleteid'])) {
                            $id = strtoupper(trim($_GET['deleteid']));
                        } else {
                            $id = "";
                        }


                        //Create connection between system and DB
                        $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

                        //prevent error, move all special character from id
                        $id = $con->real_escape_string($id);

                        //sql statement
                        $sql = "SELECT membership_id,m.user_id,name,user_email,phone,date_join,date_exp,total_payment from membership m join client c on m.user_id = c.user_id WHERE membership_id = '$id'";

                        //ask connection to run sql
                        $result = $con->query($sql);
                        //retrieve data record by record
                        if ($row = $result->fetch_object()) {
                            $id = $row->membership_id;
                            $user_id = $row->user_id;
                            $name = $row->name;
                            $email = $row->user_email;
                            $phone = $row->phone;
                            $dateJoin = $row->date_join;
                            $dateExp = $row->date_exp;
                            $payment = $row->total_payment;

                            //display
                            printf('
                        <p>Are you sure you want to delete the following detail?</p>
                            
                        <table class="deleteTable">
                            <tr>
                                <td>Membership ID: </td>
                                <td>%s</td>
                            </tr>
                            
                            <tr>
                                <td>User ID: </td>
                                <td>%s</td>
                            </tr>
                            
                            <tr>
                                <td>Member Name: </td>
                                <td>%s</td>
                            </tr>
                            
                            <tr>
                                <td>Email: </td>
                                <td>%s</td>
                            </tr>
                            
                            <tr>
                                <td>Phone: </td>
                                <td>%s</td>
                            </tr>
                            
                            <tr>
                                <td>Date Join: </td>
                                <td>%s</td>
                            </tr>
                            
                            <tr>
                                <td>Date Expired: </td>
                                <td>%s</td>
                            </tr>
                            
                            <tr>
                                <td>Total Payment (RM): </td>
                                <td>%s</td>
                            </tr>
                        </table>
                        
                        <div class="deleteBtns">
                        <input type="hidden" name="deleteid" value="%s"/>
                        <input type="hidden" name="name" value="%s"/>
                        <input type = "submit" value = "Yes" name = "btnYes" />
                        <input type = "button" value = "Cancel" name = "btnCancel" id="cancelbtn"
                        onclick="location=\'admin-memberships.php\'"/>
                        </div>
                        ', $id, $user_id, $name, $email, $phone, $dateJoin, $dateExp, $payment, $id, $name);
                        } else {
                            //record not found!
                            echo "<div class='error'>
                        Record Not Found, please try again. 
                        <a href='admin-memberships.php'>[ Back ]</a>
                        </div>";
                        }
                    } else {
                        //POST Method
                        //delete

                        $id = strtoupper(trim($_POST["deleteid"]));   //id from hidden field
                        $name = trim($_POST["name"]);

                        //create connection
                        $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

                        //sql statement
                        $sql = "DELETE FROM Membership WHERE membership_id = ?";

                        //ask connection to process sql
                        $stmt = $con->prepare($sql);

                        //pass in a value into sql parameter
                        $stmt->bind_param("s", $id);

                        //execute sql
                        $stmt->execute();

                        if ($stmt->affected_rows > 0) {
                            //record deleted
                            printf("<div class='info'>
                            Member <b>%s</b>'s membership has been deleted.
                            <a href='admin-memberships.php'>[ Back ]</a>
                            </div>", $name);
                        } else {
                            //unable to deleted
                            echo "<div class='error'>
                        Unable to delete.
                        <a href='admin-memberships.php'>[ Back ]</a>
                          </div>";
                        }
                    }
                    ?>


                </form>
            </div>
            <?php
        }   //close if
        ?>

        <!----------------------------- Edit ----------------------------->
        <?php
        $editId = isset($_GET['editid']) ? $_GET['editid'] : null;

        // Set a variable to control the display of editpage
        $showEditPage = !empty($editId);

        if ($showEditPage) {
            ?>
            <div id="editpage">
                <?php
                //retrieve existing record and display, then later only update the record in DB
                if ($_SERVER["REQUEST_METHOD"] == "GET") {
                    //GET METHOD _ retrieve id from url
                    //retrieve record

                    if (isset($_GET['editid'])) {
                        $editid = strtoupper(trim($_GET['editid']));
                    } else {
                        $editid = "";
                    }

                    //Create connection between system and DB
                    $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

                    //prevent error, move all special character from id
                    $editid = $con->real_escape_string($editid);

                    //sql statement
                    $sql = "SELECT membership_id,m.user_id as user_id,name,user_email,phone,date_join,date_exp,total_payment FROM membership m join client c on m.user_id = c.user_id WHERE membership_id  = '$editid'";

                    //ask connection to run sql
                    $result = $con->query($sql);
                    //retrieve data record by record
                    if ($row = $result->fetch_object()) {
                        $editid = $row->membership_id;
                        $user_id = $row->user_id;
                        $name = $row->name;
                        $email = $row->user_email;
                        $phone = $row->phone;
                        $dateJoin = $row->date_join;
                        $dateExp = $row->date_exp;
                        $payment = $row->total_payment;
                    } else {
                        //record not found
                        echo "<div class='error'>
                                Record Not Found, please try again. 
                                <a href='admin-memberships.php'>[ Back ]</a>
                              </div>";
                    }
                    $result->free();
                    $con->close();
                } else {
                    //POST METHOD
                    //Update action

                    $editid = strtoupper(trim($_POST["editid"]));
                    $user_id = strtoupper(trim($_POST["userId"]));
                    if (!checkExistUserIDClient($user_id) && preg_match("/^U\d{4}$/", $user_id)) {
                        echo "<ul class='error'>";
                        echo "<li>
                                No such <b>User ID</b>.
                                <a href='admin-memberships.php'>[ Back ]</a>
                              </li>";
                        echo "</ul>";
                        exit;
                    }
                    $name = trim($_POST["name"]);
                    $email = trim($_POST["email"]);
                    $phone = trim($_POST["phone"]);
                    $dateJoin = trim($_POST["dateJoin"]);
                    $dateExp = date('Y-m-d', strtotime($dateJoin . ' +1 year'));
                    $payment = trim($_POST["payment"]);

                    //Validation
                    $error["userId"] = checkUserID($user_id);

                    //remove null value
                    $error = array_filter($error);

                    if (empty($error)) {
                        //NO ERROR
                        //Create connection between system and DB
                        $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

                        //Sql statement
                        $sql = "UPDATE membership
                        SET user_id = ?, date_join = ?, date_exp = ?
                        WHERE membership_id = ?";

                        //Process sql
                        $stmt = $con->prepare($sql);

                        //Pass in parameter ubto the "?" inside the sql
                        $stmt->bind_param('ssss', $user_id, $dateJoin, $dateExp, $editid);

                        //Run sql -> insert record into DB
                        $stmt->execute();

                        //Check if the record updated successfully
                        if ($stmt->affected_rows > 0) {
                            //record updated
                            printf("<div class='info'>
                        Membership ID <b>%s</b> has been updated.
                        <a href='admin-memberships.php'>[ Back ]</a>
                            </div>", $editid);
                        } else {
                            //unable to update
                            echo "<div class='error'>Database issues! Unable to update reocrd. </div>
                                <a href='admin-memberships.php'>[ Back ]</a>
                            ";
                        }
                        $con->close();
                        $stmt->close();
                    } else {
                        //WITH ERROR, DISPLAY ERROR MSG
                        echo ("<ul class='error'>");
                        foreach ($error as $value) {
                            echo "<li>$value</li>";
                        }
                        echo ("</ul>");
                    }
                }
                ?>

                <form action="" method="POST">
                    <h2>Edit Details</h2>
                    <table class="editTable">
                        <tr>
                            <td>Membership ID: </td>
                            <td>
                                <?php echo isset($editid) ? $editid : ""; ?>
                                <input type="hidden" name="editid" value="<?php echo isset($editid) ? $editid : ""; ?>"
                            </td>
                        </tr>

                        <tr>
                            <td>User ID: </td>
                            <td><input type="text" name="userId" value="<?php echo isset($user_id) ? $user_id : "" ?>" required/></td>
                        </tr>

                        <tr>
                            <td>Member Name: </td>
                            <td>
                                <?php echo isset($name) ? $name : ""; ?>
                                <input type="hidden" name="name" value="<?php echo isset($name) ? $name : ""; ?>"
                            </td>
                        </tr>

                        <tr>
                            <td>Email: </td>
                            <td>
                                <?php echo isset($email) ? $email : ""; ?>
                                <input type="hidden" name="email" value="<?php echo isset($email) ? $email : ""; ?>"
                            </td>
                        </tr>

                        <tr>
                            <td>Phone: </td>
                            <td>
                                <?php echo isset($phone) ? $phone : ""; ?>
                                <input type="hidden" name="phone" value="<?php echo isset($phone) ? $phone : ""; ?>"
                            </td>
                        </tr>

                        <tr>
                            <td>Date Join: </td>
                            <td>
                                <input type="date" name="dateJoin" id="dateJoin" value="<?php echo isset($dateJoin) ? $dateJoin : ""; ?>" onchange="calculateExpiration()" required/>
                            </td>
                        </tr>

                        <tr>
                            <td>Date Expired: </td>
                            <td>
                                <?php echo isset($dateExp) ? $dateExp : ""; ?>
                                <input type="hidden" name="dateExp" value="<?php echo isset($dateExp) ? $dateExp : ""; ?>"
                            </td>
                        </tr>

                        <tr>
                            <td>Total Payment (RM): </td>
                            <td>
                                <?php echo isset($payment) ? $payment : ""; ?>
                                <input type="hidden" name="payment" value="<?php echo isset($payment) ? $payment : ""; ?>"
                            </td>
                        </tr>

                    </table>
                    <br/>
                    <div class="editBtns">
                        <input type="submit" value="Update" name="btnUpdate" />
                        <input type="button" value="Cancel" name="btnCancel" onclick="location = 'admin-memberships.php'"/>
                    </div>
                </form>
            </div> 
            <?php
        }   //close if
        ?>

        <!-----------------------------Delete Checked----------------------------->
        <?php
        //check if the user click the delete button??
        if (isset($_POST["btnDelete"])) {
            // YES, user clicked delete button
            // retrieve checkbox
            if (isset($_POST["chkDelete"])) {
                $checked = $_POST["chkDelete"];
            } else {
                $checked = null;
            }


            // check if have any value in $checked
            if (!empty($checked)) {
                echo "<script>
            if (confirm('This will delete all selected records. Are you sure you want to delete?')) {
                document.querySelector('form').submit();
            }
                      </script>";
                // at least 1 checkbox selected
                $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

                // remove all special characters from id
                $escaped = array();
                foreach ($checked as $value) {
                    $escaped[] = $con->real_escape_string($value);
                }

                $sql = "DELETE FROM Membership WHERE membership_id IN('" .
                        implode("', '", $escaped) . "')";

                if ($con->query($sql)) {
                    printf("<div class='info'>
                            <b>%d</b> record(s) has been deleted.
                            </div>", $con->affected_rows);
                }

                $con->close();
            }
        }
        ?>

        <!----------------------------- Add ----------------------------->
        <?php

        //fucntion to select the last membership_id from fatabase
        function getLastMembershipID($con) {
            $sql = "SELECT membership_id FROM Membership ORDER BY membership_id DESC LIMIT 1";
            $result = $con->query($sql);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                return $row['membership_id'];
            } else {
                return "M0000";
            }
        }

        //Create connection between system and DB
        $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        // Calculate next membership ID
        $lastMembershipID = getLastMembershipID($con);
        $lastNumber = intval(substr($lastMembershipID, 1)); // Extract numeric part
        $nextNumber = $lastNumber + 1;
        $nextMembershipID = 'M' . sprintf('%04d', $nextNumber); // Format with leading zeros

        $con->close();

        // Set a variable to control the display of addpage
        $showAddPage = false;

        if (isset($_GET["hddAdd"])) {
            $showAddPage = true;
        }

        if ($showAddPage) {
            ?>
            <div id="addpage">
                <?php
                //if user click any button
                if (!empty($_POST)) {

                    $user_id = strtoupper(trim($_POST['userID']));
                    if (!checkExistUserIDClient($user_id) && preg_match("/^U\d{4}$/", $user_id)) {
                        echo "<ul class='error'>";
                        echo "<li>
                                No such <b>User ID</b>.
                                <a href='admin-memberships.php'>[ Back ]</a>
                              </li>";
                        echo "</ul>";
                        exit;
                    }
                    $dateJoin = trim($_POST["dateJoin"]);
                    $dateExp = date('Y-m-d', strtotime($dateJoin . ' +1 year'));
                    $payment = '200.00';

                    $error["userID"] = checkUserID($user_id);

                    //remove null value
                    $error = array_filter($error);

                    //check if $error contain any error msg
                    if (empty($error)) {
                        $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

                        //NO ERROR, PROCEED TO INSERT RECORD
                        //Sql statement
                        $sql = "INSERT INTO membership
                            (membership_id, user_id, date_join, date_exp, total_payment) 
                            VALUES (?,?,?,?,?)";

                        //Process sql
                        $stmt = $con->prepare($sql);

                        //Pass in parameter ubto the "?" inside the sql
                        $stmt->bind_param('ssssd', $nextMembershipID, $user_id, $dateJoin, $dateExp, $payment);

                        //Run sql -> insert record into DB
                        $stmt->execute();

                        //Check if the record inserted successfully
                        if ($stmt->affected_rows > 0) {
                            //record inserted
                            printf("<div class='info'>
                                Membership ID <b>%s</b> has been inserted.
                                <a href='admin-memberships.php'>[ Back ]</a>
                            </div>", $nextMembershipID);
                        } else {
                            //record unable to insert due to DB error
                            echo "<div class='error'>Database issues! Unable to insert reocrd. </div>
                                    <a href='admin-memberships.php'>[ Back ]</a>
                        ";
                        }
                        $con->close();
                        $stmt->close();
                    } else {
                        //WITH ERROR, DISPLAY ERROR MSG
                        echo "<ul class='error'>";
                        foreach ($error as $value) {
                            echo "<li>$value</li>";
                        }
                        echo "</ul>";
                    }
                }
                ?>

                <form action="" method="POST">
                    <h2>Add Membership</h2>
                    <table class="addTable">
                        <tr>
                            <td>Membership ID: </td>
                            <td>
                                <?php echo isset($nextMembershipID) ? $nextMembershipID : ''; ?>
                            </td>
                        </tr>

                        <tr>
                            <td>User ID: </td>
                            <td>
                                <input type="text" name="userID" value="<?php echo isset($user_id) ? $user_id : "" ?>" required/>
                            </td>
                        </tr>

                        <tr>
                            <td>Date Join: </td>
                            <td>
                                <input type="date" name="dateJoin" id="dateJoin" value="<?php echo isset($dateJoin) ? $dateJoin : "" ?>" onchange="calculateExpiration()" required/>
                            </td>
                        </tr>

                        <tr>
                            <td>Date Expired: </td>
                            <td>
                                <?php echo isset($dateExp) ? $dateExp : ''; ?>
                            </td>
                        </tr>

                        <tr>
                            <td>Total payment (RM): </td>
                            <td>200.00</td>
                        </tr>
                    </table>
                    <br/>
                    <div class="addBtns">
                        <input type="submit" value="Insert" name="btnInsert" />
                        <input type="button" value="Cancel" name="btnCancel" onclick="location = 'admin-memberships.php'"/>
                    </div>
                </form>
            </div>
            <?php
        }    //close if
        ?>
    </body>

    <script>
        function calculateExpiration() {
            // Get selected date from date input
            var dateJoin = new Date(document.getElementById('dateJoin').value);
            // Calculate expiration date
            var dateExp = new Date(dateJoin.getFullYear() + 1, dateJoin.getMonth(), dateJoin.getDate());
            // Format date as dd/mm/yyyy
            var formattedDate = ('0' + dateExp.getDate()).slice(-2) + '/' + ('0' + (dateExp.getMonth() + 1)).slice(-2) + '/' + dateExp.getFullYear();
            // Set value of dateExp input field
            document.getElementById('dateExp').value = formattedDate;
        }
    </script>
</html>