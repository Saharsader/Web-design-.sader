<?php include ('include/dbconfig.php');
//get user
$userid=0;
if(isset($_SESSION['user_id'])){
    $userid = $_SESSION['user_id'];
}
$user = $conn->query("SELECT * FROM `users` WHERE `user_id`='$userid'");
$userrow = $user->fetch();
$id ='';
if(isset($_GET['id'])){
    $id = ' AND `category_id`='.$_GET['id'];
}
//produts
$products = $conn->query("SELECT * FROM `products` WHERE TRUE $id ORDER BY `product_id` DESC");
$total = $products->rowCount();
//category
$cat = $conn->query("SELECT * FROM `categories` ORDER BY `category_name` ASC");
?>
<!doctype html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
<link rel="stylesheet" href="assets/css/style.css">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> صفحه محصولات</title>
    </head>
    <body>
        
<div class="main">
  <?php include ('header.php');?>

<div class="breadcrumbz">

</div>

<div class="category_sec">
    <div class="container">
        <div class="cat_flex">
            <div class="cat_sidebar">
                <div class="cat_sidebar_filters">
                    <div class="cat_sidebar_boxes">
                        <div id="message"></div>
                        <h3>نوع لباس</h3>
                        <ul>
                            <?php while($rowcat = $cat->fetch()){ ?>
                            <li>
                                <input <?=@$_GET['id']==$rowcat['category_id']?'CHECKED':''; ?>
                                    name="cat" class="cat" value="<?=$rowcat['category_id']?>" type="checkbox">
                                <label for="sort_1"><?=$rowcat['category_name']?></label>
                            </li>
                            <?php } ?>
                        </ul>

                    </div>

                </div>

            </div>
    
            <div class="cat_content" id="ajax">
                <?php if($total){  while($rows = $products->fetch()) { ?>
                <div class="cat_col_post">
                    <a href="single.php?id=<?=$rows['product_id']?>">
                    <div class="new_post_card">
                        <div class="new_post_pic">
                            <img src="upload/products/<?=$rows['product_img']?>" alt="<?=$rows['product_name']?>">
                        </div>
                        <div class="new_post_body">
                            <div>
                                <p class="new_post_title"><?=$rows['product_name']?></p>
                                <p
                                    <?=$rows['product_discount']==''?'class="new_post_price_off"':'class="new_post_price"'?>><?=number_format($rows['product_price'])?> تومان</p>
                                <div class="clearfix"></div>
                            </div>
                            <div>
                                <p class="new_post_description"><?=mb_substr($rows['product_description'],0,150)?></p>
                                <?=$rows['product_discount']==''?'':'<p class="new_post_price_off">'.number_format($rows['product_discount']).' تومان</p>';?>
                            </div>
                        </div>
                    </div>
                    </a>
                </div>

                <?php } }else {?>
                <p>محتوایی جهت نمایش موجود نمی باشد</p>
                <?php } ?>
            </div>

        </div>
       

    </div>

</div>



<?php include ('footer.php') ?>
    <script src="assets/js/jquery.js"></script>
    <script>
        $(document).ready(function() {
            $('.cat').click(function() {
                var names = [];
                $("input:checkbox[name=cat]:checked").each(function(){
                    names.push($(this).val());
                });
                $.ajax({
                    url: 'ajax.php',
                    type: 'POST',
                    data: 'cat='+names,
                    success:function(result)
                    {
                        $('#ajax').html(result);
                        //$('input[type="text"]').val('');
                    }
                });
            });
        });
    </script>
    </div>
   </body>
</html>