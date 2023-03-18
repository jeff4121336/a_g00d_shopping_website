<?php
function ierg4210_log_in() {
    if (empty($_POST['email']) || !preg_match("/^[\w=+\-\/][\w='+\-\/\.]*@[\w\-]+(\.[\w\-]+)*(\.[\w]{2,6})$/", $_POST['email']))
        throw new Exception("Invaild or missing email");

    if (empty($_POST['password']) || !preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,16}$/", $_POST['password']))
	    throw new Exception("Invaild or missing password");
                                      
    //login logic here
    // $q=$db->prepare('SELECT * FROM account WHERE email = ?'); 
    // $q->execute(array($email));
    // if ($r = $q->fetch()) {
    // Check if the hash of the password equals the one saved in database 
    // If yes, create authentication information in cookies and session //program code on next slide
    //     $saltedpwd = hash_hmac('sha256', $pwd, $r['salt']);
    //     if ($saltedpwd == $r['password']){
    //          $exp = time() + 36000 * 24 * 3; // 3 days
    //              $token = array (
    //                  'em' => $r['email'],
    //                  'exp' => $exp,
    //                  'k' => hash_hmac('sha256', $exp.$r['password'], $r['salt'])
    //              );
    //          setcookie('s4210', json_encode($token), $exp, '', '', true, true);
    //          $_SESSION['s4210'] = $token;
    //      $login_success = true;
    //      }
    // } 
   
    if ($login_success) {
        header('Location: admin.php', true, 302);
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
