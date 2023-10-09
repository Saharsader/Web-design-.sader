<?php
include ('include/dbconfig.php');
$userid=0;
$now = time();
$message ='';
if(isset($_SESSION['user_id'])){
    $userid = $_SESSION['user_id'];
}
//get user
$user = $conn->query("SELECT * FROM `users` WHERE `user_id`='$userid'");
$userrow = $user->fetch();
//get information
$info = $conn->query("SELECT * FROM `information`");
$rowinfo = $info->fetch();
//submit contact
if(isset($_POST['submit'])){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $subject = $_POST['subject'];
    $text = $_POST['text'];
    $q = $conn->query("INSERT INTO `contact`(`name`,`email`,`phone`,`subject`,`content`,`created_at`) VALUES('$name','$email','$phone','$subject','$text','$now')");
    if($q){
        header('location:contactus.php?op=ok');
    }
    else{
        header('location:contactus.php?op=error');
    }
}
//message
if(isset($_GET['op'])){
    $op = $_GET['op'];
    switch($op){
        case 'ok':
            $message = '<div class="alert alert-success">پیام شما با موفیت ارسال شد</div>';
            break;
        case 'error':
            $message = '<div class="alert alert-danger">مشکلی در ارسال پیش آمده مجدد تلاش نمایید.</div>';
    }
}
?>
<!doctype html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
      <link rel="stylesheet" href="assets/css/style.css">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>تماس با ما</title>
    </head>
    <body>
        
       <div class="main">
           <?php include 'header.php'?>

         <div class="contact_us">
             <?=$message?>
            <div class="container">
                <h1 class="p_15">تماس با ما</h1>

                 <form action="" method="post">

                    <div class="row">

                        <div class="contact_inputs p_15">
                            <label for="contact_name">نام و نام خانوادگی</label>
                            <input id="contact_name" type="text" name="name">
                        </div>
    
                        <div class="contact_inputs p_15">
                            <label for="contact_email">ایمیل</label>
                            <input id="contact_email" type="email" name="email">
                        </div>
    
                        <div class="contact_inputs p_15">
                            <label for="contact_phone">شماره تماس</label>
                            <input id="contact_phone" type="text" name="phone">
                        </div>
    
                        <div class="contact_inputs p_15">
                            <label for="contact_subject">موضوع</label>
                            <input id="contact_subject" type="text" name="subject">
                        </div>
    
                        <div class="contact_message p-15">
                            <label for="contact_message">متن پیام </label>
                             <textarea name="text" id="contact_message"></textarea>
                        </div>
    
                        <div class="contact_btn p-15">
                            <input value="ارسال" type="submit" name="submit">
                        </div>
                    </div>

                 </form>

                 <hr> 
                 <div class="contact_info">
                    <h2 class="p_15">اطلاعات تماس</h2>

                    <div class="row flex_column">
                        <div class="contact_info_right p-15">
                            <address>آدرس: <?=$rowinfo['address']?></address>
                            <address> تلفن: <?=$rowinfo['tel']?> </address>
                            <address>ایمیل: <?=$rowinfo['email']?></address>
                            <address>تلگرام: <a href="https://t.me/<?=$rowinfo['telegram']?>"><?=$rowinfo['telegram']?></a></address>
                            <address>واتس اپ: <a href="https://wa.me.me/<?=$rowinfo['whatsapp']?>"><?=$rowinfo['whatsapp']?></a></address>
                            <address>اینستاگرام: <a href="https://instagram.com.me/<?=$rowinfo['instagram']?>"><?=$rowinfo['instagram']?></a></address>

                            <hr>

                            <p>
                                ساعات کاری امورمشتریان:
                                <br>
                                شنبه تا چهارشنبه ساعت 9 الی 18
                            </p>
                        </div>

                        <div class="contact_info_left p-15">
                            <img src="assets/images/tamas 1.png" alt="omor moshtarian">
                        </div>

                    </div>
                 </div>

            </div>
         </div>


           <?php include 'footer.php'?>
            
        </div>
     </body>
</html>