<?php
 session_start();
 session_unset();
 unset($_SESSION['user_id']);
   header('location: login.php');
   exit();
 ?>