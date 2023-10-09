<?php
include ('include/dbconfig.php');
include ('include/jdf.php');
if(isset($_GET['id'])){
    $id = $_GET['id'];
}
else{
    header('location:index.php');
    exit();
}

$userid=0;
$now = time();
$message ='';
if(isset($_SESSION['user_id'])){
    $userid = $_SESSION['user_id'];
}
//get user
$user = $conn->query("SELECT * FROM `users` WHERE `user_id`='$userid'");
$userrow = $user->fetch();
//get data from product
    $products = $conn->prepare("SELECT * FROM `products` WHERE `product_id`=:id ");
    $products->bindParam(':id',$id);
    $products->execute();
    $rows = $products->fetch();
    $catid = $rows['category_id'];
    $price = $rows['product_price'];
//get data similar from product
$q = $conn->query("SELECT * FROM `products` WHERE `category_id`=$catid ORDER BY RAND() LIMIT 4");
//get all comment
$c = $conn->query("SELECT * FROM `comments` WHERE `product_id`='$id'");
//submit basket
if(isset($_GET['basket'])){
    $basket = $conn->query("INSERT INTO `order` (`user_id`,`product_id`,`price`,`order_date`,`basket`,`order_count`) VALUES ('$userid','$id','$price','$now',1,1)");
    if($basket){
        header('location:single.php?op=bok&id='.$id);
    }
    else{
        header('location:single.php?op=berr&id='.$id);
    }
}
//order
$order = $conn->query("SELECT * FROM `order` WHERE `user_id`='$userid' and `product_id`='$id' and `basket`=1");
$total = $order->rowCount();
//submit comment
if(isset($_POST['submit'])){
    $name = $_POST['name'];
    $text = $_POST['message'];
    $proid = $rows['product_id'];
    $comment = $conn->query("INSERT INTO `comments`(`name`,`comments_text`,`product_id`,`created_at`) VALUES ('$name','$text','$proid','$now')");
    if($comment){
        header('location:single.php?op=cok&id='.$id.'#comment');
    }
    else{
        header('location:single.php?op=cerror&id='.$id.'#comment');
    }
}
//message
if(isset($_GET['op'])){
    $op = $_GET['op'];
    switch($op){
        case 'cok':
            $message = '<div class="alert alert-success">پیام شما با موفقیت درج شد</div>';
            break;
        case 'cerror':
            $message = '<div class="alert alert-danger">مشکلی در ثبت پیش آمده مجدد تلاش نمایید.</div>';
            break;
        case 'bok':
            $message = '<div class="alert alert-success">محصول با موفقیت به سبد خرید اضافه شد.</div>';
            break;
        case 'berr':
            $message = '<div class="alert alert-danger">مشکلی پیش آمده مجدد تلاش نمایید.</div>';
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
    <title><?=$rows['product_name']?></title>
    </head>
    <body>
        
<div class="main">
    <?php include('header.php'); ?>
 </div>

<div class="breadcrumbz">

</div>

<div class="single_product">
    <div class="container">
        <div class="single_product_right">
            <div class="single_product_pic">
               <img src="upload/products/<?=$rows['product_img']?>" alt="<?=$rows['product_name']?>">
            </div>
        </div>

        <div class="single_product_left">
            <div class="single_product_body">
                <h1><?=$rows['product_name']?></h1>
                
                <div class="single_product_price">
                    <p>قیمت:</p>
                    <span ><?=number_format($rows['product_price'])?> تومان</span>
                </div>

                <div class="single_product_props">
                   <p>ویژگی ها:</p>
                   <span><?=nl2br($rows['product_property'])?></span>
                   
                    <div class="single_product_colors">
                        <p>رنگبندی:</p>
                        <span class="single_product_color">
                            <?=$rows['product_color']?>
                        </span>
                    </div>
                    <div class="single_product_colors">
                        <p>مارک:</p>
                        <span class="single_product_color">
                        <?=$rows['product_type']?>
                    </span>
                    </div>
                </div>

                <div class="single_product_description">
                    <span>توضیحات:</span>
                     <p><?=$rows['product_description']?></p>
                </div>
                <?php if($userid){
                    if($total) {?>
                        <a href="basket.php"><div class="alert alert-danger">محصول با موفقیت به سبد خرید اضافه شد.</div></a>
                    <?php }else{ ?>
                        <div class="single_product_btn">
                            <a href="single.php?basket&id=<?=$rows['product_id']?>"><button type="submit" name="submit">اضافه کردن به سبد خرید</button></a>
                        </div>
                <?php } }else{ ?>
                    <a href="login.php"><div class="alert alert-warning">برای خرید محصول ابتدا باید وارد حساب کاربری خود شوید.</div></a>
                <?php } ?>
            </div>
        </div>

        <div class="clearfix"></div>

    </div>
</div>

<div class="new_posts">
    <div class="container">
        <h2 class="p_15">محصولات مرتبط</h2>
        <?php while($srows = $q->fetch()) { ?>
        <div class="col_4">
            <div class="new_post_card">
                <div class="new_post_pic">
                    <img src="upload/products/<?=$srows['product_img']?>" alt="<?=$srows['product_name']?>">
                </div>
                <div class="new_post_body">
                    <div>
                        <p class="new_post_title"><?=$srows['product_name']?></p>
                        <p
                            <?=$srows['product_discount']==''?'class="new_post_price_off"':'class="new_post_price"'?>><?=number_format($srows['product_price'])?> تومان</p>
                        <div class="clearfix"></div>
                    </div>
                    <div>
                        <p class="new_post_description"><?=mb_substr($srows['product_description'],0,150)?></p>
                        <?=$srows['product_discount']==''?'':'<p class="new_post_price_off">'.number_format($srows['product_discount']).' تومان</p>';?>
                    </div>
                </div>
            </div> 
        </div>
        <?php } ?>
        
    </div>
  <div class="clearfix"></div>
</div>

<div class="single_comments">
    <div class="container">
       <h5>دیدگاه کاربران</h5>

       <div class="single_comment">
        <?php while($crows = $c->fetch()){ ?>
          <div class="single_comment_item">
              <img src="assets/images/user.jpg" alt="<?=$crows['name']?>">
              <div class="single_comment_name_date">
                 <span><?=$crows['name']?></span>
                 <span><?=jdate('Y/m/d',$crows['created_at'])?></span>
              </div>
              <p class="single_comment_text"><?=$crows['comments_text']?></p>
          </div>
            <hr>
          <?php } ?>
       </div>



        <div class="register" id="comment">
            <?php if(isset($_GET['comment'])) echo $message; ?>
            <p class="alert alert-info">لطفا نظر خود را درج نمایید</p>
        <form action="" method="post">
            <table>
                <tr><td>نام</td><td><input name="name" type="text" required></td></tr>
                <tr><td>نظر</td><td><textarea style="height: 150px" name="message" rows="5" required></textarea> </td></tr>
                <tr><td colspan="2" class="single_product_btn"><button name="submit" type="submit">ارسال</button></td></tr>
            </table>
        </form>
        </div>
    </div>
</div>

<?php include ('footer.php'); ?>
    </div>
   </body>
</html>