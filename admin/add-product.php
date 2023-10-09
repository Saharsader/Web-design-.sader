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
    //cat
    $cat = $conn->query("SELECT * FROM `categories` ORDER BY `category_name` ASC");
    //edit
    if (isset($_GET['edit']) && !empty($_GET['edit'])) {
        $edit_id = $_GET['edit'];
        $sql_edit = "SELECT * FROM products WHERE product_id = :product_id";
        $result_edit = $conn->prepare($sql_edit);
        $result_edit->bindParam(':product_id', $edit_id);
        $result_edit->execute();
        if ($result_edit->rowCount() > 0)
            $results_edit = $result_edit->fetch();

    }
    if (isset($_POST['btn_save'])) {
        if (isset($_GET['edit']) && !empty($_GET['edit'])) {
            if (isset($_POST['name'], $_POST['price'], $_POST['type'], $_POST['description'])
                && !empty($_POST['name']) && !empty($_POST['price']) && !empty($_POST['type'])
                 && !empty($_POST['description'])) {
                $product_id = $_GET['edit'];
                $category_id = $_POST['category'];
                $name = $_POST['name'];
                $price = $_POST['price'];
                $discount = $_POST['discount'];
                $property = $_POST['property'];
                $size = $_POST['size'];
                $type = $_POST['type'];
                $color = $_POST['color'];
                $description = $_POST['description'];
                $sql = "UPDATE products SET category_id=:category_id, product_name = :product_name, product_price = :product_price,product_discount=:product_discount, product_property = :product_property,
                             product_type = :product_type,  product_color = :product_color, product_description = :product_description";
                if (isset($_FILES['img']['name']) && !empty($_FILES['img']['name'])) {
                    $image_temp_name = $_FILES["img"]["tmp_name"];
                    $image_name = $_FILES['img']['name'];
                    $array_image = explode(".", $image_name);
                    $image_format = end($array_image);
                    //$name_folder = explode("/", $results_edit['product_img']);
                    $image_address = "../upload/products/". $array_image[0] . "." . $image_format;
                    if (in_array($image_format, array('png', 'jpg', 'jpeg','PNG','JPG','JPEG','GIF','gif'))) {
                        @unlink($results_edit['product_img']);
                        if (move_uploaded_file($image_temp_name, $image_address)) {
                            $sql .= ", product_img = :product_img";
                        } else {
                            $errors[] = "خطا در انتقال عکس";
                        }
                    } else {
                        $errors[] = "فرمت عکس نامعتبر است";
                    }
                } else {
                    //$name_folder = explode("/", $results_edit['product_img']);
                    //$array_image = explode(".", $name_folder[3]);
                    //$image_format = end($array_image);
                    //$old_image_name = $results_edit['product_img'];
                    $image_name = $results_edit['product_img'];
                    //rename($old_image_name, $image_address);
                    $sql .= ", product_img = :product_img";
                }
                $sql .= " WHERE product_id = :product_id";
                $query = $conn->prepare($sql);
                $query->bindParam(":category_id", $category_id);
                $query->bindParam(":product_name", $name);
                $query->bindParam(":product_price", $price);
                $query->bindParam(":product_discount", $discount);
                $query->bindParam(":product_property", $property);
                $query->bindParam(":product_type", $type);
                $query->bindParam(":product_color", $color);
                $query->bindParam(":product_description", $description);
                $query->bindParam(":product_img", $image_name);
                $query->bindParam(":product_id", $edit_id);
                $query->execute();
                $success = "محصول مورد نظر ویرایش شد.";
            } else {
                if (empty($_POST['name'])) {
                    $errors[] = "لطفا فیلد نام محصول را پر نمائید.";
                }
                if (empty($_POST['price'])) {
                    $errors[] = "لطفا فیلد قیمت محصول را پر نمائید.";
                }
                if (empty($_POST['type'])) {
                    $errors[] = "لطفا فیلد جنس محصول را پر نمائید.";
                }
                if (empty($_POST['description'])) {
                    $errors[] = "لطفا فیلد توضیحات محصول را پر نمائید.";
                }
            }
        } else {
            if (isset($_POST['name'], $_POST['price'], $_POST['type'], $_POST['description'], $_FILES['img']['name'])
                && !empty($_POST['name']) && !empty($_POST['price']) && !empty($_POST['type'])
               && !empty($_POST['description']) && !empty($_FILES['img']['name'])) {
                $name = $_POST['name'];
                $price = $_POST['price'];
                $discount = $_POST['discount'];
                $property = $_POST['property'];
                $type = $_POST['type'];
                $color = $_POST['color'];
                $description = $_POST['description'];
                $category_id = $_POST['category'];
                $name_folder = 'products';
                //mkdir("../img/" . $name_folder);
                $image_temp_name = $_FILES["img"]["tmp_name"];
                $image_name = $_FILES['img']['name'];
                $array_image = explode(".", $image_name);
                $image_format = end($array_image);
                $image_address = "../upload/" . $name_folder . "/" .$image_name;
                if (in_array($image_format, array('png', 'jpg', 'jpeg','PNG','JPG','JPEG','GIF','gif'))) {
                    if (move_uploaded_file($image_temp_name, $image_address)) {
                        $sql = "INSERT INTO products(category_id, product_name, product_price,product_discount, product_property, product_type, product_color, product_description, product_img)
                                VALUES(:category_id, :product_name, :product_price,:product_discount, :product_property, :product_type, :product_color , :product_description, :product_img)";
                        $query = $conn->prepare($sql);
                        $query->bindParam(":category_id", $category_id);
                        $query->bindParam(":product_name", $name);
                        $query->bindParam(":product_price", $price);
                        $query->bindParam(":product_discount", $discount);
                        $query->bindParam(":product_property", $property);
                        $query->bindParam(":product_type", $type);
                        $query->bindParam(":product_color", $color);
                        $query->bindParam(":product_description", $description);
                        $query->bindParam(":product_img", $image_name);
                        $query->execute();
                        $lastInsertId = $conn->lastInsertId();
                        if ($lastInsertId) {
                            $success = "محصول ثبت شد";
                        }
                    } else {
                        $errors[] = "خطا در انتقال عکس";
                    }
                } else {
                    $errors[] = "فرمت عکس نامعتبر است";
                }
            } else {
                if (empty($_POST['name'])) {
                    $errors[] = "لطفا فیلد نام محصول را پر نمائید.";
                }
                if (empty($_POST['price'])) {
                    $errors[] = "لطفا فیلد قیمت محصول را پر نمائید.";
                }
                if (empty($_POST['type'])) {
                    $errors[] = "لطفا فیلد جنس محصول را پر نمائید.";
                }
                if (empty($_POST['description'])) {
                    $errors[] = "لطفا فیلد توضیحات محصول را پر نمائید.";
                }
                if (empty($_FILES['img']['name'])) {
                    $errors[] = "لطفا فیلد انتخاب عکس را پر نمائید.";
                }
            }
        }
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
            <h4>افزودن محصول</h4>
            <hr>
            <?php
            if (isset($errors) && count($errors) > 0) {
                foreach ($errors as $error) {
                    echo '<div class="alert alert-danger text-center">' . $error . '</div>';
                }
            }
            ?>
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="form-group row">
                    <div class="col-12">
                        <label>گروه</label>
                        <select name="category" class="form-control">
                            <option value="">انتخاب کنید</option>
                            <?php while($rowcat = $cat->fetch()){ ?>
                                <option <?=@$results_edit['category_id']==$rowcat['category_id']?'SELECTED':''?>  value="<?=$rowcat['category_id']?>"><?=$rowcat['category_name']?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-4">
                        <label>نام محصول</label>
                        <input type="text" class="form-control" name="name" placeholder="نام محصول" value="<?php
                        if (isset($_GET['edit']) && !empty($_GET['edit'])) {
                            echo $results_edit['product_name'];
                        }
                        ?>">
                    </div>
                    <div class="col-4">
                        <label>قیمت محصول</label>
                        <input type="text" class="form-control" name="price" placeholder="قیمت محصول" value="<?php
                        if (isset($_GET['edit']) && !empty($_GET['edit'])) {
                            echo $results_edit['product_price'];
                        }
                        ?>">
                    </div>
                    <div class="col-4">
                        <label>قیمت با تخفیف</label>
                        <input type="text" class="form-control" name="discount" placeholder="تخفیف" value="<?php
                        if (isset($_GET['edit']) && !empty($_GET['edit'])) {
                            echo $results_edit['product_discount'];
                        }
                        ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-6">
                        <label>برند </label>
                        <input type="text" class="form-control" name="type" placeholder="برند یا مارک" value="<?php
                        if (isset($_GET['edit']) && !empty($_GET['edit'])) {
                            echo $results_edit['product_type'];
                        }
                        ?>">

                    </div>
                    <div class="col-6">
                        <label>رنگ بندی </label>
                        <input type="text" class="form-control" name="color" placeholder="رنگ هارا با + جدا کنید" value="<?php
                        if (isset($_GET['edit']) && !empty($_GET['edit'])) {
                            echo $results_edit['product_color'];
                        }
                        ?>">
                    </div>
                </div>
                <div class="form-group row align-items-center">
                    <div class="col-6">
                        <label>ویژگی ها </label>
                        <textarea type="text" rows="5" class="form-control" name="property"
                                  placeholder="ویژگی های محصول"><?php
                            if (isset($_GET['edit']) && !empty($_GET['edit'])) {
                                echo $results_edit['product_property'];
                            }
                            ?></textarea>
                    </div>
                    <div class="col-6">
                        <label>توضیحات</label>
                        <textarea type="text" rows="5" class="form-control" name="description"
                                  placeholder="توضیحات محصول"><?php
                            if (isset($_GET['edit']) && !empty($_GET['edit'])) {
                                echo $results_edit['product_description'];
                            }
                            ?></textarea>
                    </div>
                    <div class="col-12">
                        <label>انتخاب عکس</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="img">
                            <label class="custom-file-label text-center">انتخاب عکس</label>
                        </div>
                    </div>
                </div>
                <div class="text-left">
                    <button type="submit" class="btn btn-success" name="btn_save">ثبت محصول</button>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>