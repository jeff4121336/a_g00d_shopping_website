<?php
require '/var/www/html/IERG4210/lib/db.inc.php';
$res = ierg4210_cat_fetchall();

$products = '<ul>';

foreach ($res as $value){
    $products .= '<li><a href = "'.$value["cid"].'"> '.$value["name"].'</a></li>';
}

$products .= '</ul>';
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
                Home Page (You are Here!)
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
                    <div id = "products">'.$products.'
                    </div>
                    </div>';
                ?>
            </div>
            <div class="HomePageThumbnail"> <!-- Row4 Column2 -->
                <img src="HomepageImg/shoppingcart.png">
            </div>
            <div class="instructionwords"> <!-- Row4 Column3 -->
                Please search your desired products by the serach bar on the left.
            <div>
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
