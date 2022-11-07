<?php

include_once "../includes/db.php";

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
$dbInstance = DB::getInstance();
$conn = $dbInstance->getConnection();
if (isset($_GET['id'])) {  
  $id = $_GET['id'];
  
    
  $query = "DELETE FROM products WHERE id = '$id'";  
  $run = mysqli_query($conn,$query);  
  if ($run) {  
    header("Location: ./index.php");  
  }else{  
       echo "Error: ".mysqli_error($conn);
  }
}
