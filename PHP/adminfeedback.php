<?php 
require_once ("../secret/helper.php");
$con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

$rating = isset($_GET['star_rating']) ? $_GET['star_rating'] : "all";

$filter = array();
$filter[] = "<a href='?star_rating=all'>All Ratings</a>";
for ($i = 1; $i <= 5; $i++) {
        $filter[] = "<a href='?star_rating=$i'>$i Stars</a>";
}
$separator = implode(" | ", $filter);

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Customer Feedback</title>
    <style>
        .title{
                font-size: 2.0em;
                font-weight: bold;
                margin:auto;
                margin-top: 50px;
                width:1100px;
                text-align: center;
            }
            .middle{
                width:1000px;
                height:100%;
                border: 1px solid black;
                border-radius:20px;
                margin:auto;
                margin-top: 50px;
                background-color: #ffffff;
                background-image: linear-gradient(180deg, #ffffff 11%, #c8cdd9 93%);
                padding-bottom: 50px;
                padding-top: 70px;
            }           
            .feedbox{
                width:900px;
                height:150px;
                border:2px solid black;
                border-radius: 10px;
                margin:auto;
                margin-top: 60px;
                display:flex;
                background-color:white;
            }
            .userimg{
                width: 170px;
                height:100px;
                margin-left: 20px;
                margin-top: 22px;
                border: 1px solid black;
                border-radius: 50px;
            }
            .insideimg{width: 100px;height: 100px;margin-left: -2px;position: absolute;border-radius: 50px;}
            .user{
                width:250px;
                height:30px;
                font-size: 1.5em;
                font-weight: bold;
                margin-left:45px;
                margin-top: 18px;
            }
            .starcontainer{
                position: absolute;
                margin-top: 15px;
                margin-left: 600px;
                
            }
            .star::after{
                color: rgb(255, 223, 0);
                font-size: 20px;
                content: "\2605";
            }
            .date{
                position: absolute;
                margin-top: 20px;
                margin-left: 795px;
            }
            .comment{
                width:700px;
                height:55px;
                margin-top: 60px;
                margin-left:160px;
                border:1px solid black;
                border-radius:10px;
                position: absolute;
                padding-left: 20px;
                padding-top: 5px;
            }
            .edit{
                margin-left: 870px;
                margin-top: 10px;
            }
            .reply{
                cursor:pointer;
                border: 1px solid black;
                border-radius: 5px;
                background-color: white;
            }
            .reply:hover{
                background-color: #f5f7fa;
            }
            .delete{
                background-color: red;
                color:white;
                font-weight: bold;
                cursor:pointer;
                border-radius: 25px;
                border: solid black 1px;
            }
            
            .delete:hover{
                background-color: #d1001f;
            }
            
            .starcat{
                width:1000px;
                height:30px;
                margin:auto;
                padding-left:40px;
                margin-top: -40px;
                position: absolute;
                
            }
            #filter{
                margin:auto;
                padding-left:50px;
            }
            .filter{
                border:solid 2px;
                width:500px;
                height:25px;
                padding-top:10px;
                border-radius:50px;
            }
            .error{
                padding-top:30px;
            }
            a{
                text-decoration: none;
            }
            .satisfaction {
                width: 900px;
                margin-top: 10px;
                margin-left: 80px;
                font-size: 12px;
            }
            .tname{
                font-size: 0.8em;
                width:80px;
                margin-top: 18px;
                margin-left:530px;
                position:absolute;
            }
    </style>
</head>
<body>
    <?php include('adminheader.php'); ?>
    <div class="title">Customer Feedback</div>
    <div class='middle'>
    <p id='filter' class="filter">Filter: <?php echo $separator; ?></p>
    
    
    <?php
    
    $satlevel = array(
    1 => "Very Unsatisfied",
    2 => "Unsatisfied",
    3 => "Neutral",
    4 => "Satisfied",
    5 => "Very Satisfied"
);
    
    
    $sql = "SELECT feedback_id,f.user_id,name,star_rating,q1,q2,q3,date,user_comment,personal_img,ticket_name FROM feedback f join client c on f.user_id=c.user_id";
if ($rating != "all") {
    $sql = "SELECT feedback_id,f.user_id,name,star_rating,q1,q2,q3,date,user_comment,personal_img,ticket_name FROM feedback f join client c on f.user_id=c.user_id WHERE star_rating = $rating";
}
$result = $con->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<div class='feedbox' id='feedbox".$row['feedback_id']."'>
            <div class='userimg'>
            <img class='insideimg' src='../uploads/".$row['personal_img']."'/></div>
            <div class='user'>" . $row['name'] . "</div>
            <div class='starcontainer'>";
                for ($j = 1; $j <= $row['star_rating']; $j++) {
                    echo "<label class='star s".$j."' ></label>";
            }
            echo "</div>
                <div class='tname'>".$row['ticket_name']."</div>
            <div class='satisfaction'>
                Products: ".$satlevel[$row['q1']]."<br>
                Facilities: ".$satlevel[$row['q2']]."<br>    
                Services: ".$satlevel[$row['q3']]."
            </div>
            <div class='date'>" . $row['date'] . "</div>
            <div class='comment'>" . $row['user_comment'] . "</div>
        </div>
        <div class='edit'>
            <form method='post' action=''>
                <input type='hidden' name='feedback_id' value='" . $row['feedback_id'] . "'>
                <button class='delete' type='submit' onclick='return confirm(\"Are you sure you want to delete this feedback? This action cannot be undone.\")'>Remove</button>
            </form>
        </div>";
    }
} else {
    echo "<div class='error'><center>No feedback yet.<center></div>";
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['feedback_id'])) {
    $feedbackId = $_POST['feedback_id'];

    $stmt = $con->prepare("DELETE FROM feedback WHERE feedback_id = ?");

    if ($stmt) {
        $stmt->bind_param("i", $feedbackId);

        if ($stmt->execute()) {
            echo "<script>
                document.getElementById('feedbox".$feedbackId."').remove();
                location='adminfeedback.php';
                  </script>";
        } else {
            echo "Error deleting feedback: " . $con->error;
        }
        
        $stmt->close();
    } 
}
$con->close();
?>
    </div>
</body>
</html>