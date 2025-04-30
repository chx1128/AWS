<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <h1>Demo output</h1>
        <table border="1" cellspacing="0" cellpadding="5">
            <tr>
                <th>User_id</th>
                <th>user_email</th>
                <th>user_pass</th>
                <th>phone</th>
                <th>birth_date</th>
                <th>age</th>
                <th>personal_img</th>
                <th>membership_id</th>
            </tr>
       <?php 
       require_once ("../secret/helper.php"); 
       //connect database
       $con = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
       if($con->connect_error)  //check connection 
       {
           die("connection failed: " .$con->connect_error);
       }
       //write query
       $sql="select * from client";
       
       //execute query
       $result= $con->query($sql);
       
       //check query 
       if ($result->num_rows>0) {
           while($row = $result->fetch_object()){
           printf("<tr>
                   <td>%s</td>
                   <td>%s</td>
                   <td>%s</td>
                   <td>%s</td>
                   <td>%s</td>
                   <td>%d</td>
                   <td>%s</td>
                   <td>%s</td></tr>
                   ",$row->user_id
                    ,$row->user_email
                    ,$row->user_pass
                    ,$row->phone
                    ,$row->birth_date
                    ,$row->age
                    ,$row->personal_img
                    ,$row->membership_id);
           }
           printf("<tr colspan='8'><td>%d record found</td></tr>",$result->num_rows);
       }
       ?>
       </table>
        <?php  
        $currenttime=date('Y');
        echo "$currenttime";
        
        
        ?>
        <?php

// Create DateTime objects for two different times
$time1 = new DateTime('2024-05-10 12:00:00');
$time2 = new DateTime('2024-05-10 11:58:00');

// Find the difference between the two times
$interval = $time1->diff($time2);
$interval2 =$interval->format('%I:%S');
// Output the difference
echo "<br>$interval2";
if ($interval2>"03:00") {
    echo "hello";
}else{echo "hi";}

?>
        <form action="" method="post">
            <input type="text" value="13" name="test12"/><br>
            <button type="submit" name="submit1">submit1</button>
        </form>
        <form action="" method="post">
            <button type="submit" name="submit2">submit2</button>
        </form>
        <?php   
if (isset($_POST['submit1'])) {
    $value1=$_POST['test12'];
    echo $value1;
}
        ?>
    </body>
</html>
