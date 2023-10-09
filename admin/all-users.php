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
    if (isset($_GET['delete']) && !empty($_GET['delete'])) {
        $delete_id = $_GET['delete'];
        $sql = "DELETE FROM users WHERE user_id = :user_id";
        $query = $conn->prepare($sql);
        $query->bindParam(':user_id', $delete_id);
        $query->execute();
        $success = "کاربر مورد نظر حذف شد.";
    }
} else {
    header("location: ../index.php");
    exit();
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
    <!-- js sweetalert2 -->
    <script src="js/sweetalert2@11.js"></script>
    <!-- icon -->
    <script src="js/all.js"></script>
</head>
<body>
<?php
if (isset($success)) {
    ?>
    <script>
        swal.fire({
            title: 'موفق',
            text: "<?php echo $success?>",
            icon: 'success',
            confirmButtonText: 'باشه'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location = "all-users.php";
            } else {
                window.location = "all-users.php";
            }
        })
    </script>
    <?php
}
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-2 admin-menu text-center bg-light py-3">
            <?php
            include("menu.php");
            ?>
        </div>
        <div class="col-10 admin-content text-right py-3">
            <h4>کل کاربران</h4>
            <table class="table table-striped table-hover text-center">
                <thead>
                <tr>
                    <th>کد</th>
                    <th>نام</th>
                    <th>نام خانوادگی</th>
                    <th>ایمیل</th>
                    <th>شماره تلفن</th>
                    <th>آدرس</th>
                    <th>دسترسی</th>
                    <th>عملیات</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $sql = "SELECT * FROM users GROUP BY user_id DESC";
                $result = $conn->prepare($sql);
                $result->execute();
                if ($result->rowCount() > 0) {
                    $id = 1;
                    $results = $result->fetchAll();
                    foreach ($results as $result) {
                        ?>
                        <tr>

                            <td><?php echo $id++ ?></td>
                            <td><?php echo $result['name'] ?></td>
                            <td><?php echo $result['family'] ?></td>
                            <td><?php echo $result['email'] ?></td>
                            <td><?php echo $result['phone'] ?></td>
                            <td><?php echo $result['address'] ?></td>
                            <td><?php
                                switch ($result['permission']) {
                                    case "user":
                                        echo "کاربر";
                                        break;
                                    case "admin":
                                        echo "ادمین";
                                        break;
                                } ?></td>
                            <td>
                                <?=$result['permission']=='admin'?'-':'<a href="all-users.php?delete='.$result['user_id'].'"
                                   class="btn btn-sm btn-danger">حذف</a>'?>
                            </td>

                        </tr>
                        <?php
                    }
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>