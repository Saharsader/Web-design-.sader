<?php
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
        $sql = "SELECT product_img FROM products WHERE product_id = :product_id";
        $result = $conn->prepare($sql);
        $result->bindParam(':product_id', $delete_id);
        $result->execute();
        $results = $result->fetch();
        @unlink($results['product_img']);
        $array_folder = explode("/", $results['product_img']);
        $folder = $array_folder[0] . "/" . $array_folder[1] . "/" . $array_folder[2];
        rmdir($folder);
        $sql = "DELETE FROM products WHERE product_id = :product_id";
        $query = $conn->prepare($sql);
        $query->bindParam(':product_id', $delete_id);
        $query->execute();
        $success = "محصول مورد نظر حذف شد.";
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
                window.location = "all-products.php";
            } else {
                window.location = "all-products.php";
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
            <h4>کل محصولات</h4>
            <hr>
            <form class="form-group">
                <input type="text" class="form-control" placeholder="جستجو...">
            </form>
            <table class="table table-striped table-hover text-center">
                <thead>
                <tr>
                    <th>کد</th>
                    <th>نام</th>
                    <th>قیمت (تومان)</th>
                    <th>جنس</th>
                    <th>تصویر</th>
                    <th>عملیات</th>

                </tr>
                </thead>
                <tbody>
                <?php
                $sql = "SELECT * FROM products GROUP BY product_id DESC";
                $result = $conn->prepare($sql);
                $result->execute();
                if ($result->rowCount() > 0) {
                    $id = 1;
                    $results = $result->fetchAll();
                    foreach ($results as $result) {
                        ?>
                        <tr>

                            <td><?php echo $id++ ?></td>
                            <td><?php echo $result['product_name'] ?></td>
                            <td><?php echo number_format($result['product_price']) ?></td>
                            <td><?php echo $result['product_type'] ?></td>
                            <td>
                                <img class="img-thumbnail" src="../upload/products/<?php echo $result['product_img'] ?>" alt="" width="50" height="50">
                            </td>
                            <td>
                                <a href="add-product.php?edit=<?php echo $result['product_id'] ?>"
                                   class="btn btn-sm btn-primary">ویرایش</a>
                                <a href="all-products.php?delete=<?php echo $result['product_id'] ?>"
                                   class="btn btn-sm btn-danger">حذف</a>
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