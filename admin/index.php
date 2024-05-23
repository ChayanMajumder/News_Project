<?php
session_start();
print_r($_SESSION);
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true){
  header("Location: login.php");
  exit;
}



?>