<?php
session_start();
require_once('conn.php');
$id = $_SESSION['id'];
$i =0 ; 
$datum = date("Y-m-d H:i:s");
            if ($conn->connect_error) {
                die('Connection failed: ' . $conn->connect_error);
            }
            $sql = "INSERT INTO objednavky(id_user,datum_objednavky) 
            VALUES(?,?);";
            $stmt = mysqli_prepare($conn,$sql);
            mysqli_stmt_bind_param($stmt,"is",$id,$datum);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);


            $sql2 = "SELECT id FROM objednavky WHERE id = (SELECT MAX(id) FROM objednavky) ";
            $stmt = mysqli_prepare($conn,$sql2);
            mysqli_stmt_execute($stmt);
            $result2 = mysqli_stmt_get_result($stmt);
            $check_row = mysqli_fetch_assoc($result2);
            $idobj = $check_row['id'];
foreach($_SESSION['objednavkaList'] as $content ){
            $sql = "INSERT INTO objednavka_list(id_objednavky,id_produkt) 
            VALUES(?,?);";

            $stmt = mysqli_prepare($conn,$sql);
            mysqli_stmt_bind_param($stmt,"is",$idobj,$content);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            //mysqli_query($conn,$sql);
            $_SESSION['objednavkaList'][$i]=-1;
            $i++;
            
}
$_SESSION['orderAllNumber'] = 0;
header('Location:myProfileIndex.php');
?>