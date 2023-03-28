<?php
require '/var/www/html/IERG4210/lib/auth.php';
$res = ierg4210_cat_fetchall();

$products = '<ul>';
foreach ($res as $value){
    $products .= '<li><a href =categories.php?cid='.$value["cid"].'&name='.$value["name"].'>'.$value["name"].'</a></li>';
}
$products .= '</ul>';

if(isset($_POST['AdminPanel'])) {
	if (ierg4210_auth()) {
		header('Location: admin.php');
	}
}

if(isset($_POST['Login'])) {
    header('Location: login.php');
    exit();
}

if(isset($_POST['Logout'])){
        header('Location: login.php');
	ierg4210_log_out();
	exit();
}

?>

<html lang="en">

<head>
    <meta charset="UTF-8"> 
    <title>GoodShop</title>

    <link rel="stylesheet" href=web.css type="text/css">
</head>

<body>
    <div>
        <form method="post">
            <input type="submit" name="AdminPanel" value="AdminPanel"/>
            <input type="submit" name="Login" value="Login"/>
            <input type="submit" name="Logout" value="Logout"/>
	</form>
	<?php
		$username = ierg4210_getuser();
		echo ' User: '.$username;	
	?>
	<div> <!-- Row2 -->
            <header> Welcome to GoodShop! </header>
        </div>
    
        <div class="links"> <!-- Row3 -->
                Home Page (You are Here!)
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
                        <a href="checkout.php">
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
    <script src=shopping.js type="text/javascript"> </script>
    <script src=infscroll.js type="text/javascript"> </script>
</body>

</html>


