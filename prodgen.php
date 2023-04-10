<?php
//add comment
require '/var/www/html/IERG4210/lib/db.inc.php';
$res = ierg4210_cat_fetchall();

$products = '<ul>';
foreach ($res as $value){
    $products .= '<li><a href =categories.php?cid='.$value["cid"].'&name='.$value["name"].'>'.$value["name"].'</a></li>';
}
$products .= '</ul>';
?>


<?php
    $prod_res = ierg4210_prod_fetchall();
   
    foreach ($prod_res as $prod_elm) {
        $pid = $prod_elm['pid'];
        $cid = $prod_elm['cid'];
        $name = $prod_elm['name'];
        $price = $prod_elm['price'];
?>
<div class="ThumbnailLayout">
    <a href='productpage/details.php?itn=<?php echo htmlspecialchars($pid) ?>&cid=<?php echo htmlspecialchars($cid) ?>&name=<?php echo htmlspecialchars($name) ?>&price=<?php echo htmlspecialchars($price) ?>'>
        <img class="Thumbnail" src='lib/images<?php echo '/' . $pid.'.jpg'; ?>'>
    </a></br>
        <?php echo $name. "</br>$ ".$price; ?>
    <div>
        <a href='productpage/details.php?itn=<?php echo htmlspecialchars($pid) ?>&cid=<?php echo htmlspecialchars($cid) ?>&name=<?php echo htmlspecialchars($name) ?>&price=<?php echo htmlspecialchars($price) ?>'>
            Add
        </a>
    </div>
</div>
<?php
    }
?>
