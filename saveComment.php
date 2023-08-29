<?php
session_start();
if(!(isset($_SESSION['id']))){
    header('Location: index.php');
}
require_once('conn.php');
if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
$komentar = $_POST['komentar'];
//if(preg_match("/^[a-zA-Z0-9 + . + ,]+$/", $komentar)==1){
$idUser = $_SESSION['id'];
$sql="INSERT INTO komentare(id_user,komentar) 
VALUES(?,?);";
$stmt = mysqli_prepare($conn,$sql);
mysqli_stmt_bind_param($stmt,"is",$idUser,$komentar);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);
header('Location: contact.php');
//}
//else{header('Location: contact.php');}
?>