<!--HEADER-->
<?php 
include('adminheader.php');
?>

<!--Global Variable-->
<?php
global $dltcount;
$dltcount=0;
?>

<!--Display deleted facility-->
<?php
require_once("../secret/helper.php");
$con=new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
if($con->connect_error){
    die("DB OPEN ERROR".$con->connect_error);
}

$sql="SELECT deletedfacid,deletedfacimgname,deletedfacname,deletedfacscare,deletedfachappy,deletedfacage,facid FROM deletedfac;";

$result=$con->query($sql);

if($result->num_rows>0){
    while($row=$result->fetch_object()){
        $deletedfacid[$dltcount]=$row->deletedfacid;
        $deletedfacimgname[$dltcount]=$row->deletedfacimgname;
        $deletedfacname[$dltcount]=$row->deletedfacname;
        $deletedfacscare[$dltcount]=$row->deletedfacscare;
        $deletedfachappy[$dltcount]=$row->deletedfachappy;
        $deletedfacage[$dltcount]=$row->deletedfacage;
        $facid[$dltcount]=$row->facid;
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
        <title>Deleted Facilities Display</title>
        <!--CSS-->
        <style>
            *{
                margin:0px;
            }

        .dltedfacility{
            width: 1000px;;
            height:100%;
            display:flex;
            flex-wrap:wrap;
            justify-content:space-around;
            margin-bottom: 80px;
        }
        
        .deletedfac{
            width:410px;
            height:285px;
            margin-bottom:200px;
            margin-top:0px;
            border:1px solid transparent;
            border-radius:25px;
        }
            
        .dltfacimg{
            width:410px;
            height:255px;
            margin-bottom:0px;
            margin-right:0px;
            margin-left:0px;
            margin-top:120px;
            border:1px solid transparent;
            border-radius:25px;
            box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;
        }
        
        .dltword{
            display: inline;
            width:0;
            height:0;
            font-size:1.3em;
            text-align: center;
            flex-wrap:wrap;
            justify-content:space-around;
        }
        </style>
    </head>
    <body>
        <!--Facility Final Removal-->
        <?php
        if(isset($_POST["facremoval"])){
            if(empty($fnChck)){
            $rmvfacid=$_POST["deletedfacid"];
            $rmvfacid2=$_POST["facid"];
            
            require_once("../secret/helper.php");
            $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            if ($con->connect_error) {
            die("DB OPEN ERROR" . $con->connect_error);
            }
            
            $sql="DELETE FROM deletedfac WHERE deletedfacid=?";
            
            $stmt=$con->prepare($sql);
            
            $stmt->bind_param("s",$rmvfacid);
            
            $stmt->execute();
            
            if($stmt->affected_rows>0){
                echo "<script>alert('Facility $rmvfacid Deleted');</script>";
                echo "<script>location='dltedfac.php'</script>";
            }
            
            else{
                echo "<script>alert('Database Issues ! Facilities $rmvfacid Not Deleted');</script>";
                echo "<script>location='dltedfac.php'</script>";
            }
            
            $filePaths = glob("../IMAGE/*{$rmvfacid2}.{png,jpg,jpeg,gif}", GLOB_BRACE);
            unlink($filePaths[0]);
            
            $stmt->close();
            $con->close();
            
            }
            
            else{
                echo"<script>alert('$fnChck');</script>";
                echo"<script>location='dltedfac.php'</script>";
            }
        }
        
        else{
            //do nothing
        }
        ?>
        
        <div class="dltedfacility">
        <?php
        echo"<span style='position:absolute;margin-left:-600px;margin-top:20px;font-size:1.2em;color:red;'><h1>Deleted Facilities</h1></span>
                <a href='adminfacilities.php' style='position:absolute;margin-left:-230px;margin-top:27px;'>
                <button type='button'><b style='font-size:1.5em;color:blue;'>⇦</b>️</button>
                </a>
                ";
        if(!empty($deletedfacid)){
        for($i=0;$i<$dltcount;$i++){
            if($deletedfacage[$i]=='U'){
                $deletedfacage[$i]="Underage (U)";
            }
            
            else if($deletedfacage[$i]=='O'){
                $deletedfacage[$i]="Non-Underage (O)";
            }
            
            
            
        echo"<form action='' method='post'>
            <div class='deletedfac$i'>
            <img src='../IMAGE/$deletedfacimgname[$i]' class='dltfacimg'/>
            <div class='dltword'>
            <div class='dltfacid'><b>$deletedfacid[$i]</b></div>
            <div class='dltfacname'>$deletedfacname[$i]</div>
            <div class='dltfacrate'>😱 $deletedfacscare[$i]  🥰 $deletedfachappy[$i]</div>
            <div class='dltfacage'>Age-Restriction: <b>$deletedfacage[$i]</b></div>
            <input type='hidden' name='deletedfacimgname' value='$deletedfacimgname[$i]'/>
            <input type='hidden' name='deletedfacid' value='$deletedfacid[$i]'/>
            <input type='hidden' name='facid' value='$facid[$i]'/>
            </div>
            </div>
            <input type='submit' name='facremoval' value='Remove' style='margin-top:10px;margin-left:175px;background-color:red;color:white;'/>
            </form>
        ";
        
        }}
        
        else{
            echo"<br/><span style='margin-left:520px;font-size:3.1em;color:red;margin-top:160px;position:absolute;background-color:white;border:5px solid darkblue;width:600px;height:300px;padding-left:90px';><br/><br/>! No Deleted Facilities !</span>";
        }
        ?>
            </div>
    </body>
</html>
