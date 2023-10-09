<?php include('include/dbconfig.php'); ?>
<?php
//check user
$id=$userid='';
if(isset($_SESSION['userid'])){
    $id= $_SESSION['userid'];
}
$user = $conn->query("SELECT * FROM `users` WHERE `user_id`='$id'");
$userrow = $user->fetch();
?>
<!doctype html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
   <link rel="stylesheet" href="assets/css/style.css">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
       <title>درباره ما</title>
       </head>
       <body>
           
   <div class="main">
<?php include 'header.php'?>

<div class="about_info">
   <h2 class="p_15"> درباره ما</h2>
<br>
   <div class="row">
       <div class="about_info_right p_15">
           <address>بهترین فروشگاه آنلاین شاپ درکشور</address>
           <address>سایت مانلی برترین فروشگاه لوازم آرایشی در کشور می باشد با بیش از 15 سال سابقه فعالیت.
           </address>
           <hr>
           <p>
               فروشگاه آنلاین شاپ مانلی
           </p>
       
       </div>

       <div class="about_info_left p_15">
           <img src="assets/images/dm.jpg" alt="">
       
       </div>


       <?php include 'footer.php'?>
       
   </div>
</body>
</html>