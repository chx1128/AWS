<!--HEADER-->
<?php 
include('adminheader.php');
?>

<!--Global Variable-->
<?php
global $dltcount;
$dltcount=0;
?>

<!--Display deleted tickets-->
<?php
require_once("../secret/helper.php");
$con=new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
if($con->connect_error){
    die("DB OPEN ERROR".$con->connect_error);
}

$sql="SELECT deletetkid,deleteimgname,deletetkname,deletetkprice,deletetkdesc,deletetkcat,productid FROM deletedtic;";

$result=$con->query($sql);

if($result->num_rows>0){
    while($row=$result->fetch_object()){
        $deletetkid[$dltcount]=$row->deletetkid;
        $deleteimgname[$dltcount]=$row->deleteimgname;
        $deletetkname[$dltcount]=$row->deletetkname;
        $deletetkprice[$dltcount]=$row->deletetkprice;
        $deletetkdesc[$dltcount]=$row->deletetkdesc;
        $deletetkcat[$dltcount]=$row->deletetkcat;
        $productid[$dltcount]=$row->productid;
        $dltcount++;
    }
}

else{
    //do nothing
}

$result->free();
$con->close();

?>

<!--Final Removal Check Error-->
<?php
function fnRemovalChck(){
    $fnChck=array();
    
    if($rmvfacid==null){
        $fnChck["deletedfacid"]="! No Delete ID Filled !";
    }
    
    return $fnChck;
}
?>

<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Deleted Ticket Product Page</title>
        <!--CSS-->
        <style>
            *{
                margin:0px;
            }

        .dltedticket{
            width: 1000px;;
            height:100%;
            display:flex;
            flex-wrap:wrap;
            justify-content:space-around;
            margin-bottom: 80px;
        }
        
        .deletedticket{
            width:410px;
            height:285px;
            margin-bottom:200px;
            margin-top:0px;
            border:1px solid transparent;
            border-radius:25px;
        }
            
        .dlttkimg{
            width:400px;
            height:120px;
            margin-bottom:0px;
            margin-right:0px;
            margin-left:0px;
            margin-top:120px;
            box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;
        }
        
        .dltword{
            display: inline;
            width:0;
            height:0;
            font-size:1.5em;
            text-align: center;
            flex-wrap:wrap;
            
            justify-content:space-around;
        }
        </style>
    </head>
    <body>
        <!--Ticket Products Final Removal-->
        <?php
        if(isset($_POST["tkremoval"])){
            if(empty($fnChck)){
            $rmvtkid=$_POST["deletetkid"];
            $rmvtkid2=$_POST["productid"];
            
            require_once("../secret/helper.php");
            $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            if ($con->connect_error) {
            die("DB OPEN ERROR" . $con->connect_error);
            }
            
            $sql="DELETE FROM deletedtic WHERE deletetkid=?";
            
            $stmt=$con->prepare($sql);
            
            $stmt->bind_param("s",$rmvtkid);
            
            $stmt->execute();
            
            if($stmt->affected_rows>0){
                echo "<script>alert('Facility $rmvtkid Deleted');</script>";
                echo "<script>location='dltedtic.php'</script>";
            }
            
            else{
                echo "<script>alert('Database Issues ! Facilities $rmvtkid Not Deleted');</script>";
                echo "<script>location='dltedtic.php'</script>";
            }
            
            $filePaths=glob("../IMAGE/*{$rmvtkid2}.{png,jpg,jpeg,gif}", GLOB_BRACE);
            unlink($filePaths[0]);
            
            $stmt->close();
            $con->close();
            
            }
            
            else{
                echo"<script>alert('$fnChck');</script>";
                echo"<script>location='dltedtic.php'</script>";
            }
        }
        
        else{
            // do nothing
        }
        ?>
        
        <div class="dltedticket">
        <?php
        echo"<span style='position:absolute;margin-left:-600px;margin-top:20px;font-size:1.2em;color:red;'><h1>Deleted Tickets</h1></span>
                <a href='adminproductsstatus.php' style='position:absolute;margin-left:-260px;margin-top:27px;'>
                <button type='button'><b style='font-size:1.5em;color:blue;'>⇦</b>️</button>
                </a>
                ";
        
        if(!empty($deletetkid)){
        for($i=0;$i<$dltcount;$i++){
            if($deletetkcat[$i]=='SA'){
                $deletetkcat[$i]="Spot Access(SA)";
            }
            
            else if($deletetkcat[$i]=='PA'){
                $deletetkcat[$i]="Package Access(PA)";
            }
            
            else if($deletetkcat[$i]=='IA'){
                $deletetkcat[$i]="Individual Access(IA)";
            }
            
        echo"<form action='' method='post'>
            <div class='deletedticket$i'>
            <img src='../IMAGE/$deleteimgname[$i]' class='dlttkimg'/>
            <div class='dltword'>
            <div class='dlttkid'><b>$deletetkid[$i]</b></div>
            <div class='dlttkname'>$deletetkname[$i]</div>
            <div class='dlttkrate'>$deletetkprice[$i]</div>
            <div class='dlttkage'>Category: $deletetkcat[$i]</b></div>
            <input type='hidden' name='deleteimgname' value='$deleteimgname[$i]'/>
            <input type='hidden' name='deletetkid' value='$deletetkid[$i]'/>
            <input type='hidden' name='productid' value='$productid[$i]'/>
            </div>
            </div>
            <input type='submit' name='tkremoval' value='Remove' style='margin-top:10px;margin-left:175px;background-color:red;color:white;'/>
            </form>
        ";
        
        }}
        
        else{
echo"<br/><span style='margin-left:520px;font-size:3.1em;color:red;margin-top:160px;position:absolute;background-color:white;border:5px solid darkblue;width:600px;height:200px;padding-left:100px;padding-top:130px;'>! No Deleted Tickets !</span>";        }
        ?>
            </div>
    </body>
</html>
