<?php
include ('include/dbconfig.php');
include ('include/jdf.php');
$userid=0;
$now = time();
$message ='';
if(isset($_SESSION['user_id'])){
    $userid = $_SESSION['user_id'];
}
//get user
$user = $conn->query("SELECT * FROM `users` WHERE `user_id`='$userid'");
$userrow = $user->fetch();
//get data from order
$order = $conn->query("SELECT * FROM `order` INNER JOIN `products` ON `order`.`product_id`=`products`.`product_id` WHERE `user_id`='$userid' and `basket`=1");
$total = $order->rowCount();
if(isset($_POST['submit'])){
    $count = $_POST['hiddencount'];
    $basket = $conn->query("UPDATE `order` SET `basket`=0,`order_count`='$count' WHERE `user_id`='$userid'");
    if($basket){
        header('location:basket.php?op=ok');
    }
    else{
        header('location:basket.php?op=error');
    }
}
//delete
if(isset($_GET['del'])){
    $id = $_GET['del'];
    $delete = $conn->query("DELETE FROM `order` WHERE `user_id`='$userid' AND `order_id`='$id'");
    if($delete){
        header('location:basket.php?op=dok');
    }
    else{
        header('location:basket.php?op=error');
    }
}
//message
if(isset($_GET['op'])){
    $op = $_GET['op'];
    switch($op){
        case 'ok':
            $message = '<div class="alert alert-success">سفارشات شما با موفقیت ثبت شد</div>';
            break;
        case 'dok':
            $message = '<div class="alert alert-success">حذف محصول با موفقیت انجام شد</div>';
            break;
        case 'error':
            $message = '<div class="alert alert-danger">مشکلی آمده مجدد تلاش نمایید.</div>';
            break;
    }
}
?>
<!doctype html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
<link rel="stylesheet" href="assets/css/style.css">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>سبد خرید</title>
    </head>
    <body>
        
<div class="main">
    <?php include('header.php'); ?>
 </div>

<div class="breadcrumbz">

</div>

<div class="single_product">
    <div class="container">
        <div class="basket">
            <?=$message?>
        <table>
            <tr>
                <th>شماره</th>
                <th>نام محصول</th>
                <th>قیمت واحد</th>
                <th>جمع کل</th>
                <th>حذف</th>
            </tr>
            <?php if($total){ while($rows = $order->fetch()) { ?>
            <tr>
                <td>#</td>
                <td><?=$rows['product_name']?></td>
                <td id="price"><?=$rows['price']?></td>
                <td class="sum"><?=$rows['price']?></td>
                <td><a href="basket.php?del=<?=$rows['order_id']?>"><img src="assets/images/delete.png"></a></td>
            </tr>
            <?php } }else{ ?>
            <tr><td colspan="6">سبد خرید شما خالی می باشد.</td></tr>
            <?php } ?>
        </table>
            <?php if($total) { ?>
                    <form action="basket.php" method="post">
            <div class="single_product_btn"><button type="submit" name="submit" style="width:20%;margin-right:40%;">ثبت نهایی</button></a></div>
                        <input id="hiddencount" name="hiddencount" type="hidden">
                    </form>
            <?php } ?>
        </div>
    </div>
</div>

        <div class="clearfix"></div>

    </div>
</div>




<?php include ('footer.php'); ?>
    </div>
<script src="assets/js/jquery.js"></script>
<script>
    $(document).ready(function() {
        $('.num').on('keyup',function(){
            var price = $('#price').text();
            var num = 1;
            var num = $('.num').val();
            if(num>0) {
                $('.sum').html(Number(price * num).toLocaleString('en'));
                $('#hiddencount').val(num);
            }
        });
    });
</script>
   </body>
</html>