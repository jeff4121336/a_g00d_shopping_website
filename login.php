<?php
    require '/var/www/html/IERG4210/lib/auth.php'
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
            <a href="admin.php"> Admin Panel |</a>  
            <a href="main.php">| Home Page </a>         
	</div>
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
            </div>
                
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
