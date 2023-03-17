<?php
function ierg4210_login() {
    if (empty($_POST['email']) || empty($_POST['password'])
    || !preg_match("/^[\w=+\-\/][\w='+\-\/\.]*@[\w\-]+(\.[\w\-]+)*(\.[\w]{2,6})$/", $_POST['email'])
    || !preg_match("/^[\w@#$%\^\&\*\-]+$/", $_POST['password']))
        throw new Exception("Wrong Credentials");

    //login logic here

    if ($login_success) {
        header('Location: admin.php', true, 302);
        exit();
    } else {
        throw new Exception("Wrong Credentials");
    }
}

function ierg4210_logout() {
    // choose cookies for login section here

    header('Location: login.php', true, 302);
    exit();
}
?>
