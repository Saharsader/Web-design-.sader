<?php
session_start();
require_once "../include/dbconfig.php";
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
//get all data from comments
$q = $conn->prepare("SELECT * FROM `comments` INNER JOIN `products` ON `comments`.`product_id`=`products`.`product_id` ORDER BY `comments`.`created_at` DESC");
$q->execute();
$total = $q->rowCount();
//delete
if(isset($_GET['del'])){
    $id = $_GET['id'];
    $del = $conn->prepare("DELETE FROM `comments` WHERE `comment_id`='$id'");
    $del->execute();
    header('location:comments.php?ok');
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
            include ("menu.php");
            ?>
        </div>
        <div class="col-10 admin-content text-right py-3">
            <h4>لیست نظرات</h4>
            <hr>
            <table class="table table-striped table-hover text-center">
                <thead>
                <tr>
                    <th>#</th>
                    <th>نام</th>
                    <th>محصول</th>
                    <th>پیام</th>
                    <th>عملیات</th>
                </tr>
                </thead>
                <tbody>
                <?php if($total){ $count = 0; while($rows = $q->fetch()) { $count++;?>
                <tr>
                    <td><?=$count?></td>
                    <td><?=$rows['name']?></td>
                    <td><?=$rows['product_name']?></td>
                    <td><?=$rows['comments_text']?></td>
                    <td>
                        <a href="comments.php?id=<?=$rows['comment_id']?>&del" class="btn btn-sm btn-danger">حذف</a>
                    </td>
                </tr>
                <?php } } else {?>
                <tr><td colspan="5">محتوایی جهت نمایش موجود نمی باشد.</td></tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>