<?php
require_once ('include/dbconfig.php');
$and ='';
if(isset($_POST['cat']) && $_POST['cat']!=''){
    foreach($_POST as $key=>$val){
        $and .= ' AND `category_id`IN ('.$val.') ';
    }
}
$products = $conn->query(" SELECT * FROM `products` WHERE TRUE $and ORDER BY `product_id` DESC");
$total = $products->rowCount();
?>
    <?php if($total) { while($rows = $products->fetch()) { ?>
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
    <?php }} else{ ?>
<div class="cat_col_post">محتوایی جهت نمایش موجود نمی باشد</div>
<?php } ?>
