<?php
include_once('db.inc.php');
session_start();
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
	session_regenerate_id();
	 }
    } 
   
    if ($admin_login_success) {
        header('Location: admin.php', true, 302);
        exit();
    } else if ($user_login_success) {	   
	header('Location: main.php', true, 302);
        exit();
    } else {
	header('Content-Type: text/html; charset=utf-8');
        echo 'This account does not exist. / Wrong Credentals. <br/><a href="javascript:history.back();">Back to login page.</a>';
        exit();
       // throw new Exception("This account is not exist!");
    }
}

function ierg4210_log_out() {
    // choose cookies for login section here
    setcookie('auth', "", time() - 3600);
    session_destroy();
    exit();
}


function ierg4210_auth() {
    if ((!empty($_COOKIE['auth'])) &&  (!empty($_SESSION['auth']))) {
        //stripslashes() returns a string with backslashes stripped off 
        // (\' becomes ' and so on.)
        if ($token = json_decode(stripslashes($_COOKIE['auth']), true)) {
            if (time() > $token['exp']) {
	        header('Content-Type: text/html; charset=utf-8');
        	echo 'No permission for admin panel. <br/><a href="javascript:history.back();">Back to pervious page.</a>';
	    }

            global $db;
            $db = ierg4210_DB();
            $q=$db->prepare('SELECT * FROM USER WHERE email = ?');
            $q->execute(array($token['em']));
            if ($r = $q->fetch()) {
                $verifypwd = hash_hmac('sha256', $token['exp'].$r['hashedpassword'], $r['salt']);
                if ($verifypwd == $token['k']) {
                    $_SESSION['auth'] = $_COOKIE['auth'];
                    if ($r['flag'] == "1") {
			    return 1;
		    }
                }
            }
        }
    }
        header('Content-Type: text/html; charset=utf-8');
        echo 'No permission for admin panel. <br/><a href="javascript:history.back();">Back to pervious page.</a>'; 
       exit();
}

function ierg4210_getuser() {

    if ((!empty($_COOKIE['auth'])) &&  (!empty($_SESSION['auth']))) {
        //stripslashes() returns a string with backslashes stripped off 
        // (\' becomes ' and so on.)
        if ($token = json_decode(stripslashes($_COOKIE['auth']), true)) {
            if (time() > $token['exp']) {
	    	return "Guest";
	    }

            global $db;
            $db = ierg4210_DB();
            $q=$db->prepare('SELECT * FROM USER WHERE email = ?');
            $q->execute(array($token['em']));
            if ($r = $q->fetch()) {
                $verifypwd = hash_hmac('sha256', $token['exp'].$r['hashedpassword'], $r['salt']);
                if ($verifypwd == $token['k']) {
                    $_SESSION['auth'] = $_COOKIE['auth'];
                            return $token['em'];
                }
            }
        }
    }
	return "Guest"; 
}
