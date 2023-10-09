<?php include('include/dbconfig.php'); ?>
<?php
//check user
if(isset($_SESSION['user_id'])){
    $id= $_SESSION['user_id'];
}
else{
    header('location:login.php');
    exit;
}
$user = $conn->query("SELECT * FROM `users` WHERE `user_id`='$id'");
$userrow = $user->fetch();
//get data from user
$q = $conn->query("SELECT * FROM `users` WHERE `user_id`='$id'");
$user = $q->fetch();
$message='';
if(isset($_POST['submit'])){
    $name = $_POST['name'];
    $family = $_POST['family'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $pass='';
    if(isset($_POST['password']) && $_POST['password']!=''){
        $pass = ",`password`='".md5($_POST['password'])."'";
    }

    $sql = "UPDATE users SET `name`='$name',`family`='$family',`email`='$email',`phone`='$phone',`address`='$address' $pass";
    $query = $conn->prepare($sql);
    $submit = $query->execute();
    if($submit){
        header('location:profile.php?ok');
    }
    else{
        header('location:profile.php?error');
    }
}
if(isset($_GET['error'])){
    $message = '<div class="alert alert-danger">مشکلی در ثبت پیش آمده مجدد امتحان کنید</div>';
}
if(isset($_GET['ok'])){
    $message = '<div class="alert alert-success">تغییرات با موفقیت ثبت شد.</div>';
}
?>
<!doctype html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="assets/css/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>صفحه شخصی</title>
    </head>
    <body>
        
<div class="main">
<?php include ('header.php');?>

<div class="single_product">
    <div class="container">
            <div class="register">
                <?=$message?>
                <div class="alert alert-info">صفحه شخصی </div>
                <form action="" method="post" >
                    <table>
                        <tr><td>نام</td><td><input type="text" name="name" value="<?=$user['name']?>" class="form-control"></td></tr>
                        <tr><td>نام خانوادگی</td><td><input type="text" name="family" value="<?=$user['family']?>" class="form-control"></td></tr>
                        <tr><td>ایمیل</td><td><input type="email" name="email" value="<?=$user['email']?>" class="form-control"></td></tr>
                        <tr><td>شماره موبایل</td><td><input type="text" name="phone" value="<?=$user['phone']?>" class="form-control"></td></tr>
                        <tr><td>رمز عبور</td><td><input type="password" name="password" placeholder="***" class="form-control"></td></tr>
                        <tr><td>آدرس</td><td><textarea style="height: 150px" name="address" rows="4"><?=$user['address']?></textarea></td></tr>
                        <tr><td colspan="2" class="single_product_btn"><button name="submit" type="submit">ویرایش</button> </td></tr>
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