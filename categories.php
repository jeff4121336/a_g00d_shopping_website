<?php
    require '/var/www/html/IERG4210/lib/db.inc.php';
    $res = ierg4210_cat_fetchall();
    $products = '<ul>';
    foreach ($res as $value){
        $products .= '<li><a href =categories.php?cid='.$value["cid"].'&name='.$value["name"].'>'.$value["name"].'</a></li>';
    }
    $products .= '</ul>';

    $cid = $_GET['cid'];
    $name = $_GET['name'];
#    echo "CID: ".$cid." Name: ".$name;
?>


<html lang="en">

<head>
    <meta charset="UTF-8"> 
    <title>GoodShop</title>

    <link rel="stylesheet" href=web.css type="text/css">
</head>

<body>
    <div>
        <div class = "adminlink"> <!-- Row1 -->
            <a href="admin.php"> Admin Panel </a>    
        </div>
        <div> <!-- Row2 -->
            <header> Welcome to GoodShop! </header>
        </div>
    
        <div class="links"> <!-- Row3 -->
            <nav>
                <?php
                        echo "<a href='main.php'>Home Page</a> > ".$name." (You Are Here!)";
                ?>
            </nav>
            <div id="shoppinghoverbtn"> 
                Shopping List
                <listtodisplay>
                    Shopping List Total $10
                    <div>
                        Apple [ <input id="Quantityinput"> </input> ] @$4
                    </div>
                    <div>
                        Banana [ <input id="Quantityinput"> </input> ] @$3.5 
                    </div>
                    <div id="checkoutlink"> 
                        <a href="checkout.html">
                            [CheckOut]
                        </a>
                    </div>
                    </listtodisplay>
            </div> <!-- higher priority -->
        </div>

        <div class="prodshow"> <!-- Row4 -->
            <div class="CatagoriesBar"> <!-- Row4 Column1 -->
                <?php
                    echo '<div id = "CatagoriesBar">
                    <div id = "CatagoriesWord">'.$products.'
                    </div>
                    </div>';
                ?>
            </div>
            <div class="ThumbnailCol"> <!-- Row4 Column2 -->
            <?php
                $prod_res = ierg4210_prod_fetchall();
                foreach ($prod_res as $prod_elm) {
                    if ($prod_elm['cid'] == $cid) {
                        $pid = $prod_elm['pid'];
                        $cid = $prod_elm['cid'];
                        $name = $prod_elm['name'];
                        $price = $prod_elm['price'];
            ?>
                        <div class="ThumbnailLayout">
			<a href= <?php echo 'productpage/details.php?itn='.$pid.'&cid='.$cid ?>>
			<img class="Thumbnail" src='lib/images<?php echo '/' . $pid.'.jpg'; ?>'>
                        </a> </br>

		                    <?php echo $name. "</br>$ ".$price; ?>
		                    <div class="AddToCartBtninCataPage">
                                Add
		                    </div>
	                    </div>
            <?php
                    }
            ?>
            <?php
                }
            ?>
            </div>  
	</div>

    <div>
        <footer>
            <div>
                GoodShop Limited 2023
            </div>
            <div>
                Come And Buy! Enjoy Shopping! 
            </div>
        </footer>
    </div>
    <!-- <script src=“xxx.js" type="text/javascript"></script> -->
</body>

</html>
