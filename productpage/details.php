<?php
    require '/var/www/html/IERG4210/lib/db.inc.php';
    $res = ierg4210_cat_fetchall();

    $cid = $_GET['cid'];
    $itn = $_GET['itn'];
    #echo "Itn: ".$itn."  CID: ".$cid;
    $products = '<ul>';
    foreach ($res as $value){
        $products .= '<li><a href =../categories.php?cid='.$value["cid"].'&name='.$value["name"].'>'.$value["name"].'</a></li>';
        if ($value["cid"] == $cid)
                $catname = $value["name"];
    }
    $products .= '</ul>';

    $prod = ierg4210_prod_fetchall();
    foreach ($prod as $prod_elm) {
        if ($prod_elm['pid'] == $itn)
        {
        $name = $prod_elm['name'];
        $price = $prod_elm['price'];
        $inventory = $prod_elm['inventory'];
        $description = $prod_elm['description'];
        }
    }
?> 

<html lang="en">

<head>
    <meta charset="UTF-8"> 
    <title>GoodShop</title>

    <link rel="stylesheet" href=../web.css type="text/css">
    <link rel="stylesheet" href=prodinfo.css type="text/css">
</head>

<body>
    <div>
        <div> <!-- Row1 -->
            <header> Welcome to GoodShop! </header>
        </div>

        <div class = "links"> <!-- Row2 -->
            <nav>
                <?php echo '<a href="../main.php">Home Page</a> >' ?>
                <?php echo '<a href="../categories.php?cid='.$cid.'&name='.$catname.'">'.$catname.'</a> > '.$name.' (You are here!)'; ?>
            </nav>
           <div id="shoppinghoverbtn">
		Shopping List
		<listtodisplay>
		    <div id="cartinfo">
		    </div>
			</br>
                    <div id="cartprice">
                        Total $-
                    </div>
		    <div id="btnlist">
			<button id="save"> SAVE </button>
                        <button id="clearcart"> CLEAR </button>
                    </div>
                    <div id="checkoutlink">
                        <a href="../checkout.php">
                            [CheckOut]
                        </a>
                    </div>
                    </listtodisplay>
            </div>    
	</div>
        <div class="ProdInfoRow3"> <!-- Row 3 -->
                <!-- Row3 Column1 -->
                <div>
                <?php
                    echo '<div class = "CatagoriesBar">
                    <div class = "CatagoriesWord">'.$products.'
                    </div>
                    </div>';
                ?>
                </div>
                <div> <!-- Row3 Column2 product img -->
                    <img class="ThumbnailInProd" src='../lib/images<?php echo '/' . $itn.'.jpg'; ?>'>
                </div>

                <div class="DetailProdinfo"> <!-- Row3 Column3 product info -->
                <?php
                    echo "<p>Product: ".$name."</p> <p>Price: $".$price."</p> <p>Inventory: ".$inventory."</p> <p>Description: ".$description."</p>";
                
             
                if ($inventory <= 3)
                    {
                            echo "<p id='onlyxleft'> Only ".$inventory." left!!!</p>";
                    } ?>
                
		<button id="addtocart" type="button">Add To Cart</button>
            	</div>
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

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script src=../shopping.js type="text/javascript"> </script>
</body>
</html>

