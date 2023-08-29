<html>
<?php
session_start();

$currentCookieParams = session_get_cookie_params();  
$sidvalue = session_id();  
setcookie(  
    'PHPSESSID',//name  
    $sidvalue,//value  
    0,//expires at end of session  
    $currentCookieParams['path'],//path  
    $currentCookieParams['domain'],//domain  
    true, //secure  
    true //HttpOnly 
);  

$match = false;
require_once('conn.php');
if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }

 $user = $_POST['email'];
 $password = hash('ripemd160', $_POST['password']);
 if((preg_match("/^[a-zA-Z0-9]+$/", $user)==1)&&(preg_match("/^[a-zA-Z0-9]+$/", $_POST['password'])==1)) {  
 $sqlcheck = "SELECT id,username,email,password_hashed FROM user
 Where username = ? AND password_hashed = ?";    //prepisal som email na username
 $stmt = mysqli_prepare($conn,$sqlcheck);
 mysqli_stmt_bind_param($stmt,"ss",$user,$password);
 mysqli_stmt_execute($stmt);
 $result = mysqli_stmt_get_result($stmt);
 mysqli_stmt_close($stmt);
}
    
  while($check_row = mysqli_fetch_assoc($result)){
        $match=true; //if($check_row['email']==$email && $check_row['password_hashed']==$password)
        $_SESSION['id']=$check_row['id'];
        //$_SESSION['email']=$user;
        $_SESSION['password']=$password;
        $_SESSION['username']=$check_row['username'];
                 
    }
  //mysqli_close($conn);
  if($match==true){
    header("Location:myProfileIndex.php");
  }
  else{
    $_SESSION["login"] = false;
    $_SESSION["loginFalseTime"] = time();
    header("Location:index.php");
  }

 ?>
 </html>