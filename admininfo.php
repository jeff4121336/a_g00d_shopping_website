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

if(!ierg4210_auth()) {	
	header('Loction: login.php');
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
        <?php
                $username = ierg4210_getuser();
                echo ' User: '.$username;
        ?>

    <div>
        <header> Welcome to GoodShop! </header>
    </div>


    <div class="links">
        <a href="main.php">Home Page</a>
    </div>

    <div>
    </br>
	General Orders 
    </br>
    <table border="1">
        <tr> 
           <th>OID</th>
           <th>User</th>
           <th>Payee</th>
           <th>Price</th>
           <th>Status</th>
        </tr>

    <?php
        global $db;
        $db = ierg4210_DB();
        $sql1="SELECT * FROM ORDER_";
        $q = $db->prepare($sql1);
        if ($q->execute()) {
            $res = $q->fetchAll();
            $orders = '<tr>';
            foreach ($res as $i){
                $orders .= '<td> '.$i["OID"].' </td>'.'<td> '.$i["User"].' </td>'.'<td> '.$i["Payee"].' </td>'.'<td> '.$i["Price"].' </td>'.'<td> '.$i["Status"].' </td>';
                $orders .= '</tr>';
                $orders .= '<tr>';
            }
            echo $orders;
        }
    ?>
    </table>
    </div>
    </br> </br>
    Order Details sort by oid
    </br>
    <div>
    <table border="1">
        <tr> 
           <th>OID</th>
           <th>Name</th>
	   <th>Price</th>
	   <th>Total</th>
           <th>Quantity</th>
        </tr>
    <?php
        $sql2="SELECT * FROM ORDER_DETAILS";
        $q = $db->prepare($sql2);
        if ($q->execute()) {
            $ires = $q->fetchAll();
            $items = '<tr>';
	    foreach ($ires as $i){
		$t = $i["Price"] * $i["Quantity"];
                $items .= '<td> '.$i["OID"].' </td>'.'<td> '.$i["Name"].' </td>'.'<td> '.$i["Price"].' </td>'.'<td> '.$t.' </td>'.'<td> '.$i["Quantity"].' </td>';
                $items .= '</tr>';
                $items .= '<tr>';
            }
            echo $items;
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

