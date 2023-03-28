<?php
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

if(isset($_POST['Guest'])){
	header('Location: main.php');
	ierg4210_log_out();
	session_regenerate_id();
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
        <div>
            <fieldset>
            <legend> Login Form </legend>
            <form name="login" method="POST" action="auth-process.php?action=log_in" enctype="multipart/form-data">
            <label for="email"> Email *</label> 
            <div> <input id="email" type="email" name="email" required="required"/> </div>
            <label for="password"> Password *</label>
	    <div> <input id="password" type="password" name="password" required="required" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,16}$"/></div>
	    <input type="submit" value="Submit"/>
	    </form>
	    <form method="post">
		<input type="submit" name="Guest" value="Login as Guest"/>
	    </form>
	    </fieldset>

            <fieldset>
            <legend> Change Password </legend>
            <form name="login" method="POST" action="auth-process.php?action=change_pw" enctype="multipart/form-data">
            <label for="email"> Email *</label>
            <div> <input id="email" type="email" name="email" required="required"/> </div>
            <label for="password"> Old Password *</label>
            <div> <input id="password" type="password" name="password" required="required" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,16}$"/></div>
            <label for="password"> New Password *</label>
            <div> <input id="newpassword" type="password" name="newpassword" required="required" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,16}$"/></div>
            <input type="submit" value="Submit"/>
            </form>
            </fieldset>

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
    <script src=shopping.js type="text/javascript"> </script>
</body>

</html>
