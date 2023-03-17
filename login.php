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
            <a href="main.php">| Home Page |</a>  
            <a href="login.php">| Login </a>
        </div>
        <div> <!-- Row2 -->
            <header> Welcome to GoodShop! </header>
        </div>
        <div>
            <fieldset>
            <legend> Login Form </legend>
            <form name="login" method="POST" action="auth-process.php?action=login" enctype="multipart/form-data">
            
            <div> <input id="email" type="email" name="email" required="required" pattern="^\w+( \w+)*$"/></div>
            <label for="prod_name"> Email *</label>
            <div> <input id="password" type="text" name="password" required="required" pattern="^\w+( \w+)*$"/></div>
            <label for="prod_price"> Password *</label>
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