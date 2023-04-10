<?php
    require '/var/www/html/IERG4210/lib/db.inc.php';
    require '/var/www/html/IERG4210/lib/auth.php';

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

if (ierg4210_getuser()  == "Guest") {
    	header('Content-Type: text/html; charset=utf-8');
        echo 'Only history orders ordered by member can be viewed. <br/>Please login.</br> <a href="javascript:history.back();">Back to pervious page.</a>'; 
        exit();
}

?>


<html lang="en">
<head>
    <meta charset="UTF-8"> 
    <title>GoodShop</title>

    <link rel="stylesheet" href=admin.css type="text/css">
    <link rel="stylesheet" href=web.css type="text/css">
</head>

<body>
        <form method="post">
            <input type="submit" name="AdminPanel" value="AdminPanel"/>
            <input type="submit" name="Login" value="Login"/>
            <input type="submit" name="Logout" value="Logout"/>
        </form>

        <div>
        <header> Welcome to GoodShop! </header>
        </div>    
        
        <div class="links">
        <a href="main.php">Home Page</a>
        </div>

        <?php
                $username = ierg4210_getuser();
                echo 'Recent 5 orders for User: '.$username;
        ?>
    
    <div> 
    <?php
        global $db;
        $db = ierg4210_DB();
        $sql1="SELECT * FROM ORDER_ WHERE User = ? ORDER BY OrderNumber DESC LIMIT 5"; /* last 5 rows */
	$q1 = $db->prepare($sql1);
	$u =  ierg4210_getuser();
        $q1->bindParam(1, $u);
        if ($q1->execute()) {
            $res1 = $q1->fetchAll();
            foreach ($res1 as $i){
                echo "</br>Order: ".$i["OID"];
		$orders = '<table border="1"> <tr> <th>User</th> <th>Payee</th> <th>Price</th> <th>Status</th> </tr>';
		$orders .= '<td> '.$i["User"].' </td>'.'<td> '.$i["Payee"].' </td>'.'<td> '.$i["Price"].' </td>'.'<td> '.$i["Status"].' </td>';
                $orders .= '</tr>';
		echo $orders;

		$sql2="SELECT * FROM ORDER_DETAILS WHERE OID = ?";
                $q2 = $db->prepare($sql2);
		$q2->bindParam(1, $i["OID"]);
                if ($q2->execute()) {
                    $ires = $q2->fetchAll();
		    $items = '</br> </br> <table border="1"> <tr> <th>Product</th> <th>Price</th> <th>Total</th> <th>Quantity</th> </tr> <tr>';
                    foreach ($ires as $i){
                        $t = $i["Price"] * $i["Quantity"];
                        $items .= '<td> '.$i["Name"].' </td>'.'<td> '.$i["Price"].' </td>'.'<td> '.$t.' </td>'.'<td> '.$i["Quantity"].' </td>';
                        $items .= '</tr>';
                        $items .= '<tr>';
                    }
                    $items .= '</table>';
                    echo $items;
                }
            }
        }
    ?>
    </table>
    </div>

    </br> </br>
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

</body>

</html>

