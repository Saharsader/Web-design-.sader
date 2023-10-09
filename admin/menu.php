<?php require_once "../include/dbconfig.php";?>
<img src="img/user.png" class="img-fluid" alt="" width="50" height="50">
<h5 class="font-weight-bold pt-3"><?php echo $results_session['name'] . " " . $results_session['family'] ?></h5>
<hr>
<!-- Menu -->
<nav class="text-right">
    <div class="d-flex justify-content-between py-2">
        <a class="d-block" href="index.php">داشبورد</a>
        <i class="fas fa-home"></i>
    </div>
    <div class="d-flex justify-content-between py-2">
        <a class="d-block" href="all-users.php">کاربران</a>
        <i class="fas fa-users"></i>
    </div>
    <div class="d-flex justify-content-between py-2">
        <a class="d-block" href="information.php">اطلاعات تماس</a>
        <i class="fas fa-phone"></i>
    </div>
    <ul class="nav nav-sidebar d-flex justify-content-between p-0" data-widget="treeview">
        <li class="nav-item"><a href="contact.php" class="nav-link px-0">پیام ها</a></li>
        <i class="fas fa-comments"></i>
    </ul>
    <ul class="nav nav-sidebar d-flex justify-content-between p-0" data-widget="treeview">
        <li class="nav-item"><a href="comments.php" class="nav-link px-0">نظرات</a></li>
        <i class="fas fa-ticket-alt "></i>
    </ul>
    <ul class="nav nav-sidebar d-flex justify-content-between p-0" data-widget="treeview">
        <li class="nav-item"><a href="" class="nav-link px-0">محصولات<i class="fas fa-caret-down mr-1 text-muted"></i></a>
            <ul class="nav nav-treeview px-2">
                <li class="nav-item"><a href="all-products.php" class="nav-link py-1">کل</a></li>
                <li class="nav-item"><a href="add-product.php" class="nav-link py-1">افزودن</a></li>
            </ul>
        </li>
        <i class="fas fa-box-open"></i>
    </ul>
    <div class="d-flex justify-content-between py-2">
        <a class="d-block" href="order.php">سفارشات</a>
        <i class="fas fa-people-carry"></i>
    </div>

    <div class="d-flex justify-content-between py-2">
        <a class="d-block" href="logout.php">خروج</a>
        <i class="fas fa-sign-out-alt "></i>
    </div>
</nav>