<?php
include_once('db.inc.php');

function ierg4210_log_in() {
    if (empty($_POST['email']) || !preg_match("/^[\w=+\-\/][\w='+\-\/\.]*@[\w\-]+(\.[\w\-]+)*(\.[\w]{2,6})$/", $_POST['email']))
        throw new Exception("Invaild or missing email");

    if (empty($_POST['password']) || !preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,16}$/", $_POST['password']))
	    throw new Exception("Invaild or missing password");
                                      
    //login logic here
    $admin_login_success = false;
    $user_login_success = false;
    global $db;
    $db = ierg4210_DB();
    $q=$db->prepare('SELECT * FROM USER WHERE email = ?'); 
    $q->execute(array($_POST['email']));
    if ($r = $q->fetch()) {
    // Check if the hash of the password equals the one saved in database 
    // If yes, create authentication information in cookies and session //program code on next slide
         $saltedpwd = hash_hmac('sha256', $_POST['password'], $r['salt']);
         if ($saltedpwd == $r['hashedpassword']){
              $exp = time() + 3600; // 1 hour
                  $token = array (
                      'em' => $r['email'],
                      'exp' => $exp,
                      'k' => hash_hmac('sha256', $exp.$r['hashedpassword'], $r['salt'])
                  );
              setcookie('auth', json_encode($token), $exp, '', '', true, true);
              $_SESSION['auth'] = $token;
	      if ($r['flag'] == "1")
	      	$admin_login_success = true;
	      if ($r['flag'] == "0")
                $user_login_success = true;	
	 }
    } 
   
    if ($admin_login_success) {
        header('Location: admin.php', true, 302);
        exit();
    } else if ($user_login_success) {	   
	header('Location: main.php', true, 302);
        exit();
    } else {
        throw new Exception("This account is not exist!");
    }
}

function ierg4210_log_out() {
    // choose cookies for login section here

    header('Location: login.php', true, 302);
    exit();
}

?>
