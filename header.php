<?php
$catmenu = $conn->query("SELECT * FROM `categories` ORDER BY `category_name` ASC");
//get data from order
$userid=0;
if(isset($_SESSION['user_id'])){
    $userid = $_SESSION['user_id'];
}
$morder = $conn->query("SELECT * FROM `order` INNER JOIN `products` ON `order`.`product_id`=`products`.`product_id` WHERE `user_id`='$userid' and `basket`=1");
$mtotal = $morder->rowCount();
?>
<div class="header">
    <div class="container navbar-contaner">
        <button class="hamber_menu open-drop_down" href="#navbar">
            <img src="assets/images/icon/hamber menu.png" alt="">
        </button>
        <div class="header_logo">
            <img src="assets/images/logo-maneli.jpg" alt="shop venuse">
        </div>

        <nav class="header-navbar" id="navbar">
            <ul class="header_nav">
                <li><a href="index.php">صفحه اصلی </a></li>
                <li> <a href="category.php">محصولات</a></li>

                <li class="drop_down">
                    <a href="#cat-dropdown" class="open-drop_down">
                        <span>دسته ها</span>
                        <i class="drop_down_icon"></i>
                    </a>
                    <ul class="drop_down_menu" id="cat-dropdown">
                        <?php while($catrow = $catmenu->fetch()){ ?>
                        <li><a href="category.php?id=<?=$catrow['category_id']?>"><?=$catrow['category_name']?></a></li>
                        <?php } ?>
                    </ul>
                </li>

                <li><a href="contactus.php">تماس با ما</a></li>
                <li><a href="aboutus.php">درباره ما</a></li>

            </ul>

        </nav>

<?php if(isset($_SESSION['user_id'])){ ?>
    <div class="login_btn">
        <a href="profile.php">خوش آمدید <?=$userrow['name'].' '.$userrow['family']?></a> |
        <a class="text-danger" href="logout.php">خروج</a></div>
    <?php if($mtotal){ ?>
        <a href="basket.php"><div class="userbasket">سبد خرید</div></a>
   <?php } ?>
<?php }else{ ?>
        <button class="login_btn"><a href="register.php">ثبت نام</a> | <a href="login.php">ورود</a></button>
<?php } ?>
    </div>
</div>