<?php
session_start();
require_once "../include/dbconfig.php";
require_once "../include/jdf.php";
if (isset($_SESSION["state_login"]) && $_SESSION["state_login"] === true) {
    $user_id = $_SESSION["user_id"];
    $sql_session = "SELECT * FROM users WHERE user_id = :user_id";
    $result_session = $conn->prepare($sql_session);
    $result_session->bindParam(':user_id', $user_id);
    $result_session->execute();
    if ($result_session->rowCount() > 0) {
        $results_session = $result_session->fetch();
    }
}
else
{
    header("location: ../index.php");
    exit();
}
$now = time();
//new order
$norder = $conn->prepare("SELECT * FROM `order` INNER JOIN `products` ON `order`.`product_id`=`products`.`product_id` INNER JOIN `users` ON `users`.`user_id`=`order`.`user_id` WHERE `basket`=0 AND `status`=0");
$norder->execute();
$ntotal = $norder->rowCount();
//complete order
$lorder = $conn->prepare("SELECT * FROM `order` INNER JOIN `products` ON `order`.`product_id`=`products`.`product_id` INNER JOIN `users` ON `users`.`user_id`=`order`.`user_id` WHERE `basket`='1' AND `status`=1");
$lorder->execute();
$ltotal = $lorder->rowCount();
//delivery order

if(isset($_GET['full'])){
    $id = $_GET['id'];
    $q = $conn->prepare("UPDATE `order` SET `status`=1,`basket`=1,`complete_date`='$now' WHERE `order_id`=$id");
    $q->execute();
    if($q){
        header('location:order.php?ok');
    }
}
if(isset($_GET['delivery'])){
    $id = $_GET['id'];
    $q = $conn->prepare("UPDATE `order` SET `status`=1,`delivery_date`='$now' WHERE `order_id`=$id");
    $q->execute();
    if($q){
        header('location:order.php?ok');
    }
}
?>
<!doctype html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>پنل مدیریت</title>
    <!-- css -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/adminlte.min.css">
    <link rel="stylesheet" href="css/admin.css">
    <!-- js -->
    <script src="js/jquery-3.5.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/adminlte.min.js"></script>
    <!-- icon -->
    <script src="js/all.js"></script>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-2 admin-menu text-center bg-light py-3">
            <?php
            include("menu.php");
            ?>
        </div>
        <div class="col-10 admin-content text-right py-3">
            <h4>سفارشات</h4>
            <hr>
            <form class="form-group">
                <input type="text" class="form-control" placeholder="جستجو...">
            </form>
            <ul class="nav nav-tabs nav-justified border-bottom-0">
                <li class="nav-item"><a data-toggle="tab" class="nav-link text-dark active" href="#tab1">جدیدترین</a></li>
                <li class="nav-item"><a data-toggle="tab" class="nav-link text-dark" href="#tab2">تکمیل شده</a></li>
            </ul>
            <div class="tab-content">
                <div id="tab1" class="tab-pane active">
                    <table class="table table-striped table-hover text-center">
                        <thead>
                        <tr>
                            <th>کد</th>
                            <th>سفارش دهنده</th>
                            <th>نام محصول</th>
                            <th>مبلغ</th>
                            <th>تاریخ ثبت</th>
                            <th>عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if($ntotal) { while($nrows = $norder->fetch()) { ?>
                        <tr>
                            <td>#</td>
                            <td><?=$nrows['name'].' '.$nrows['family']?></td>
                            <td><?=$nrows['product_name']?></td>
                            <td><?=number_format($nrows['price'])?></td>
                            <td><?=jdate('Y,m,d',$nrows['order_date'])?></td>
                            <td>
                                <a href="order.php?id=<?=$nrows['order_id']?>&full" class="btn btn-sm btn-primary">تکمیل</a>
                                <a href="order.php?delete" class="btn btn-sm btn-danger">حذف</a>
                            </td>
                        </tr>
                        <?php }}else{ ?>
                        <tr><td colspan="7">محتوایی جهت نمایش موجود نمی باشد.</td></tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
                <div id="tab2" class="tab-pane fade">
                    <table class="table table-striped table-hover text-center">
                        <thead>
                        <tr>
                            <th>کد</th>
                            <th>سفارش دهنده</th>
                            <th>نام محصول</th>
                            <th>مبلغ</th>
                            <th>تاریخ ثبت</th>
                            <th>تاریخ تکمیل</th>
                            <th>عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if($ltotal) { while($lrows = $lorder->fetch()) { ?>
                            <tr>
                                <td>#</td>
                                <td><?=$lrows['name'].' '.$lrows['family']?></td>
                                <td><?=$lrows['product_name']?></td>
                                <td><?=number_format($lrows['price'])?> تومان</td>
                                <td><?=jdate('Y,m,d',$lrows['order_date'])?></td>
                                <td><?=jdate('Y,m,d',$lrows['complete_date'])?></td>
                                <td>
                                    <a href="order.php?delete" class="btn btn-sm btn-danger">حذف</a>
                                </td>
                            </tr>
                        <?php }}else{ ?>
                            <tr><td colspan="8">محتوایی جهت نمایش موجود نمی باشد.</td></tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>
</body>
</html>