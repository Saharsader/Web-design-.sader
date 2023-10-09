<?php include('include/dbconfig.php'); ?>
<?php
//check user
if(isset($_SESSION['userid'])){
    header('location:profile.php');
    exit;
}

$message='';
if(isset($_POST['submit'])){
    $name = $_POST['name'];
    $family = $_POST['family'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $pass = md5($_POST['password']);
    $sql = "INSERT INTO users(name,family,email,phone,password,address) 
                        VALUE (:name,:family,:email,:phone,:password,:address)";
    $query = $conn->prepare($sql);
    $query->bindParam(':name', $name);
    $query->bindParam(':family', $family);
    $query->bindParam(':email', $email);
    $query->bindParam(':phone', $phone);
    $query->bindParam(':password', $pass);
    $query->bindParam(':address', $address);
    $submit = $query->execute();
    if($submit){
        header('location:login.php?op=reg');
    }
    else{
        header('location:register.php?error');
    }
}
if(isset($_GET['error'])){
    $message = '<div class="alert alert-danger">مشکلی در ثبت پیش آمده مجدد امتحان کنید</div>';
}
?>
<!doctype html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="assets/css/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ثبت نام</title>
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
                        <tr><td>نام</td><td><input type="text" name="name" placeholder="نام" class="form-control"></td></tr>
                        <tr><td>نام خانوادگی</td><td><input type="text" name="family" placeholder="نام خانوادگی" class="form-control"></td></tr>
                        <tr><td>ایمیل</td><td><input type="email" name="email" placeholder="ایمیل" class="form-control"></td></tr>
                        <tr><td>شماره موبایل</td><td><input type="text" name="phone" placeholder="شماره موبایل" class="form-control"></td></tr>
                        <tr><td>رمز عبور</td><td><input type="password" name="password" placeholder="رمز عبور" class="form-control"></td></tr>
                        <tr><td>آدرس</td><td><textarea style="height: 150px" name="address" rows="4"></textarea></td></tr>
                        <tr><td colspan="2" class="single_product_btn"><button name="submit" type="submit">ثبت نام</button> </td></tr>
                        <tr><td colspan="2">اگر قبلا در سایت ثبت نام کرده اید برای <a href="login.php">ورود</a> کلیک نمایید.</td></tr>
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