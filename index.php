<?php include ('include/dbconfig.php');
//get user
$userid=0;
if(isset($_SESSION['user_id'])){
    $userid = $_SESSION['user_id'];
}
$user = $conn->query("SELECT * FROM `users` WHERE `user_id`='$userid'");
$userrow = $user->fetch();
//get products
$newproducts = $conn->query("SELECT * FROM `products` ORDER BY `product_id` DESC LIMIT 8 ");
//most sell
$sell = $conn->query("SELECT *,sum(`price`) as sum FROM `order` INNER JOIN `products` ON `order`.`product_id`=`products`.`product_id` group by `order`.`product_id` ORDER BY `sum` DESC");
?>
<!doctype html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <title> مانلی شاپ - صفحه اصلی</title>
    </head>
 <body>
        
       <div class="main">
            <?php include('header.php'); ?>

     <img src="./assets/images/banner.jpg" alt="" width="100%" height="350">

</div>

             <div class="new_posts">
    <div class="container">
        <h2 class="p_15">جدیدترین محصولات</h2>
        <?php while($newrows = $newproducts->fetch()) { ?>
        <div class="col_4">
            <a href="single.php?id=<?=$newrows['product_id']?>">
                <div class="new_post_card">
                    <div class="new_post_pic">
                        <img src="upload/products/<?=$newrows['product_img']?>" alt="<?=$newrows['product_name']?>">
                    </div>
                    <div class="new_post_body">
                        <div>
                            <p class="new_post_title"><?=$newrows['product_name']?></p>
                            <p
                            <?=$newrows['product_discount']==''?'class="new_post_price_off"':'class="new_post_price"'?>><?=number_format($newrows['product_price'])?> تومان</p>
                            <div class="clearfix"></div>
                        </div>
                        <div>
                            <p class="new_post_description"><?=mb_substr($newrows['product_description'],0,150)?>...</p>
                            <?=$newrows['product_discount']==''?'':'<p class="new_post_price_off">'.number_format($newrows['product_discount']).' تومان</p>';?>
                        </div>
                    </div>
                </div> 
            </a>
        </div>
        <?php } ?>
        
    </div>
  <div class="clearfix"></div>
             </div>

             <div class="home_ad">
    <div class="container">
        <div class="home_ad_right">
            <img src="assets/images/ad 1.jpeg" alt="تبلیغات">
        </div>
        <div class="home_ad_left">
            <img src="assets/images/ad 2.jpg" alt="تبلیغات فروشگاهی">
        </div>
        <div class="clearfix"></div>
    </div>
            </div>

             <div class="most_sales">
    <div class="container">
        <h2 class="p_15">بیشترین فروش</h2>

        <?php while($mrows = $sell->fetch()) { ?>
          <div class="most_sales_item">
              <a href="single.php?id=<?=$mrows['product_id']?>">
            <div class="new_post_card">
                <div class="new_post_pic">
                    <img src="upload/products/<?=$mrows['product_img']?>" alt="<?=$newrows['product_name']?>">
                </div>
                <div class="new_post_body">
                    <div>
                        <p class="new_post_title"><?=$mrows['product_name']?></p>
                        <p
                            <?=$mrows['product_discount']==''?'class="new_post_price_off"':'class="new_post_price"'?>><?=number_format($mrows['product_price'])?> تومان</p>
                        <div class="clearfix"></div>
                    </div>
                    <div>
                        <p class="new_post_description"><?=mb_substr($mrows['product_description'],0,150)?></p>
                        <?=$mrows['product_discount']==''?'':'<p class="new_post_price_off">'.number_format($mrows['product_discount']).' تومان</p>';?>
                    </div>
                </div>
            </div>
              </a>
          </div>
        <?php } ?>




          </div>

         <div class="clearfix"></div>
        
    </div>
             </div>

             <div class="why_us">
  <div class="container why-us-container">
      <div class="col_4">
          <div class="why_us_card">
              <img src="assets/images/poshtiban.jpg" alt="">
              <h4>پشتیبانی آنلاین</h4>
              <p>با پشتیبانی24 ساعته تمام نیازهای شما
                   رابرطرف خواهیم کرد</p>
          </div>

      </div>
      <div class="col_4">
        <div class="why_us_card">
           <img src="assets/images/shield.png" alt="">
           <h4>پرداخت امن </h4>
           <p>
               100% گارانتی
           </p>
        </div>

    </div>
    <div class="col_4">
        <div class="why_us_card">
            <img src="assets/images/delivery-truck.png" alt="">
            <h4>پست اکسپرس</h4>
            <p>
                ارسال همه روزه به همه نقاط کشور
            </p>
        </div>

    </div>
    <div class="col_4">
        <div class="why_us_card">
            <img src="assets/images/shop.png" alt="">
            <h4>تنوع کالا</h4>
            <p>
                باتنوع بی نظیرکالا انتخاب را برای شما ساده ولذت بخش می کنیم
            </p>
        </div>

    </div>
<div class="clearfix"></div>
  </div>
             </div>


    <?php include 'footer.php';?>
</html>