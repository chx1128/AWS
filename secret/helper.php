<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->

<?php
// Replace these with your RDS details
define("DB_HOST","localhost");
define("DB_USER","root");
define("DB_PASS","");
define("DB_NAME","assign"); 


//function to check exist name
function checkSameStudentID($email){
    $exist = false;
    //create connection to database
    $con=new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
    //important
    $email= $con->real_escape_string($email);
    //select * from student Where STUdentID = 'abc'
    $sql = "select * from client Where user_email = '$email'";
    if($result =$con ->query($sql)){
    if ($result->num_rows > 0) {
        //same student ID detected!
        $exist =true;
    }
    }
    $result->free();
    $con->close();
    return $exist; 
}





function checkSameUserIDMembership($user_id) {
    $exist = false;
    //create connection
    $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    $users_id = $con->real_escape_string($user_id);

    $sql = "SELECT * FROM Membership WHERE user_id = '$users_id'";

    if ($result = $con->query($sql)) {
        if ($result->num_rows > 0) {
            //same user_id detected!
            $exist = true;
        }
    }

    $result->free();
    $con->close();
    return $exist;
}
//function to check User ID
function checkUserID($user_id) {
    if ($user_id == null) {
        return "Please enter the <b>User ID</b>.";
    } else if (!preg_match("/^U\d{4}$/", $user_id)) {
        return "Invalid <b>User ID</b>, please try again!";
    } else if (checkSameUserIDMembership($user_id)) {
        return "Same <b>User ID</b> found.";
    }
}
//function check EXIST user ID in client table
function checkExistUserIDClient($user_id) {
    // Create connection
    $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    // Sanitize user ID to prevent SQL injection
    $users_id = $con->real_escape_string($user_id);

    // SQL query to check for existence of user ID in the Client table
    $sql = "SELECT user_id FROM Client WHERE user_id = '$users_id'";

    // Execute the query
    $result = $con->query($sql);

    // Check if any row is returned
    $exists = ($result && $result->num_rows > 0);

    // Close the connection
    $con->close();

    // Return true if user ID exists, false otherwise
    return $exists;
}


//function to check User ID

?>
