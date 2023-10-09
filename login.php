<?php include('include/dbconfig.php'); ?>
<?php
//check user
if(isset($_SESSION['user_id'])){
    header('location:profile.php');
    exit;
}
$message='';
if(isset($_POST['submit'])){
    $email = $_POST['email'];
    $pass = md5($_POST['password']);
    $sql = "SELECT * FROM users WHERE `email`=:email AND `password`=:password";
    $query = $conn->prepare($sql);
    $query->bindParam(':email', $email);
    $query->bindParam(':password', $pass);
    $query->execute();
    $rows = $query->fetch();
    $total = $query->rowCount();
    if($total){
        $_SESSION['state_login']=true;
        $_SESSION['user_id']=$rows['user_id'];
        header('location:index.php?');
    }
    else{
        header('location:login.php?error');
    }
}
if(isset($_GET['error'])){
    $message = '<div class="alert alert-danger">نام کاربری یا پسورد اشتباه است</div>';
}
?>
<!doctype html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="assets/css/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ورود</title>
    </head>
    <body>
        
<div class="main">
<?php include ('header.php');?>

<div class="single_product">
    <div class="container">
            <div class="register">
                <?=$message?>
                <div class="alert alert-info">لطفا اطلاعات خواسته شده را به دقت وارد نمایید</div>
                <form action="" method="post" >
                    <table>
                        <tr><td>ایمیل:</td><td><input type="email" name="email" placeholder="آدرس پست الکترونیک" class="form-control"></td></tr>
                        <tr><td>رمز عبور:</td><td><input type="password" name="password" placeholder="رمز عبور" class="form-control"></td></tr>
                        <tr><td colspan="2" class="single_product_btn"><button name="submit" type="submit">ورود</button> </td></tr>
                        <tr><td colspan="2">اگر هنوز در سایت ثبت نام نکرده اید برای  <a href="register.php">ثبت نام</a> کلیک نمایید.</td></tr>
                    </table>
                </form>
            </div>
    </div>
</div>

        <div class="clearfix"></div>

<?php include ('footer.php');?>

    </div>
   </body>
</html>