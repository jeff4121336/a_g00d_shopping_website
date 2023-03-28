<?php
//include_once('auth.php');

function ierg4210_DB() {
        // connect to the database
        // TODO: change the following path if needed
        // Warning: NEVER put your db in a publicly accessible location
        $db = new PDO('sqlite:/var/www/cart.db');

        // enable foreign key support
        $db->query('PRAGMA foreign_keys = ON;');

        // FETCH_ASSOC:
        // Specifies that the fetch method shall return each row as an
        // array indexed by column name as returned in the corresponding
        // result set. If the result set contains multiple columns with
        // the same name, PDO::FETCH_ASSOC returns only a single value
        // per column name.
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        return $db;
}
function ierg4210_cat_fetchall() {
    // DB manipulation
    global $db;
    $db = ierg4210_DB();
    $q = $db->prepare("SELECT * FROM categories LIMIT 100;");
    if ($q->execute())
        return $q->fetchAll();
}

function ierg4210_prod_fetchall(){
    global $db;
    $db = ierg4210_DB();
    $q = $db->prepare("SELECT * FROM Products LIMIT 100;");
    if ($q->execute())
        return $q->fetchAll();
}


// Since this form will take file upload, we use the tranditional (simpler) rather than AJAX form submission.
// Therefore, after handling the request (DB insert and file copy), this function then redirects back to admin.html
function ierg4210_prod_insert() {
    // input validation or sanitization

    // DB manipulation
    global $db;
    $db = ierg4210_DB();

    // TODO: complete the rest of the INSERT command
    if (!preg_match('/^\d*$/', $_POST['cid']))
        throw new Exception("invalid-cid");
    $_POST['cid'] = (int) $_POST['cid'];
    if (!preg_match('/^[\w\- ]+$/', $_POST['name']))
        throw new Exception("invalid-name");
    if (!preg_match('/^[\d\.]+$/', $_POST['price']))
        throw new Exception("invalid-price");
    if (!preg_match('/^[\w\- ]+$/', $_POST['description']))
    // EDIT 
    if (!preg_match('/^[\d\.]+$/', $_POST['inventory']))
    throw new Exception("invalid-inventory");
    // EDIT END
    
    $sql="INSERT INTO products (cid, name, price, description, inventory) VALUES (?, ?, ?, ?, ?)";
    $q = $db->prepare($sql);
    
    // Copy the uploaded file to a folder which can be publicly accessible at incl/img/[pid].jpg
    if ($_FILES["file"]["error"] == 0
    && $_FILES["file"]["type"] == ("image/jpeg" || "image/jpg" || "image/png" || "image/gif")
    && mime_content_type($_FILES["file"]["tmp_name"]) == ("image/jpeg" || "image/jpg" || "image/png" || "image/gif")
    && $_FILES["file"]["size"] < 5000000) {
    
    $cid = $_POST["cid"];
    $name = $_POST["name"];
    $price = $_POST["price"];
    $desc = $_POST["description"];
    $inv = $_POST["inventory"];
    
    $q->bindParam(1, $cid);
    $q->bindParam(2, $name);
    $q->bindParam(3, $price);
    $q->bindParam(4, $desc);
    $q->bindParam(5, $inv);
    $q->execute();
    $lastId = $db->lastInsertId();
    
    // Note: Take care of the permission of destination folder (hints: current user is apache)
    if (move_uploaded_file($_FILES["file"]["tmp_name"], "/var/www/html/IERG4210/lib/images/" . $lastId . ".jpg")) {
        // redirect back to original page; you may comment it during debug
        header('Location: admin.php');
        exit();
    }
    }
    // Only an invalid file will result in the execution below
    // To replace the content-type header which was json and output an error message
    header('Content-Type: text/html; charset=utf-8');
    echo 'Invalid file detected. <br/><a href="javascript:history.back();">Back to admin panel.</a>';
    exit();
}
// TODO: add other functions here to make the whole application complete
function ierg4210_cat_insert() {

    global $db;
    $db = ierg4210_DB();

    if (!preg_match('/^[\w\- ]+$/', $_POST['name']))
        throw new Exception("invalid-name");

    $sql="INSERT INTO CATEGORIES (name) VALUES (?)";
    $q = $db->prepare($sql);
    $name = $_POST["name"];

    $q->bindParam(1, $name);

    $q->execute();
    header('Location: admin.php');
    exit();
}

function ierg4210_cat_edit(){

    global $db;
    $db = ierg4210_DB();

    if (!preg_match('/^\d*$/', $_POST['cid']))
    throw new Exception("invalid-cid");
    $_POST['cid'] = (int) $_POST['cid'];
    if (!preg_match('/^[\w\- ]+$/', $_POST['name']))
    throw new Exception("invalid-name");

    $cid = $_POST["cid"];
    $name = $_POST["name"];

    $sql="UPDATE Categories SET name = ? WHERE cid = ?";
    $q = $db->prepare($sql);
    $q->bindParam(1, $name);
    $q->bindParam(2, $cid);
    $q->execute();
    header('Location: admin.php');
    exit();
}

function ierg4210_cat_delete(){

    global $db;
    $db = ierg4210_DB();

    if (!preg_match('/^\d*$/', $_POST['cid']))
        throw new Exception("invalid-cid");
    $_POST['cid'] = (int) $_POST['cid'];
    $cid = $_POST["cid"];

    $sql="DELETE FROM Categories WHERE cid = ?";
    $q = $db->prepare($sql);
    $q->bindParam(1, $cid);
    $q->execute();

    header('Location: admin.php');
    exit();
}
function ierg4210_prod_delete_by_cid(){

    global $db;
    $db = ierg4210_DB();

    if (!preg_match('/^\d*$/', $_POST['cid']))
        throw new Exception("invalid-cid");
    $_POST['cid'] = (int) $_POST['cid'];
    $cid = $_POST["cid"];

    $sql="DELETE FROM Products WHERE cid = ?";
    $q = $db->prepare($sql);
    $q->bindParam(1, $cid);
    $q->execute();

    header('Location: admin.php');
    exit();
}

function ierg4210_prod_edit(){

    global $db;
    $db = ierg4210_DB();

    if (!preg_match('/^\d*$/', $_POST['pid']))
        throw new Exception("invalid-pid");
    $_POST['pid'] = (int) $_POST['pid'];
    if (!preg_match('/^[\w\- ]+$/', $_POST['name']))
        throw new Exception("invalid-name");
    if (!preg_match('/^[\d\.]+$/', $_POST['price']))
        throw new Exception("invalid-price");
    if (!preg_match('/^[\w\- ]+$/', $_POST['description']))
        throw new Exception("invalid-description");
    // EDIT 
    if (!preg_match('/^[\d\.]+$/', $_POST['inventory']))
        throw new Exception("invalid-inventory");
    // EDIT END
    $sql="UPDATE products SET name = ?, price = ?, description = ?, inventory = ? WHERE pid = ?";
    $q = $db->prepare($sql);
    
    // Copy the uploaded file to a folder which can be publicly accessible at incl/img/[pid].jpg
    if ($_FILES["file"]["error"] == 0
    && $_FILES["file"]["type"] == ("image/jpeg" || "image/jpg" || "image/png" || "image/gif")
    && mime_content_type($_FILES["file"]["tmp_name"]) == ("image/jpeg" || "image/jpg" || "image/png" || "image/gif")
    && $_FILES["file"]["size"] < 50000000) {
    
    $pid = $_POST["pid"];
    $name = $_POST["name"];
    $price = $_POST["price"];
    $inv = $_POST["inventory"];
    $desc = $_POST["description"];
    
    $q->bindParam(1, $name);
    $q->bindParam(2, $price);
    $q->bindParam(3, $desc);
    $q->bindParam(4, $inv);
    $q->bindParam(5, $pid);
    $q->execute();

    if (move_uploaded_file($_FILES["file"]["tmp_name"], "/var/www/html/IERG4210/lib/images/" . $pid . ".jpg")) {
        // redirect back to original page; you may comment it during debug
        header('Location: admin.php');
        exit();
    }   
    }
    header('Content-Type: text/html; charset=utf-8');
    echo 'Invalid file detected. <br/><a href="javascript:history.back();">Back to admin panel.</a>';
    exit();
}
function ierg4210_prod_delete(){

    global $db;
    $db = ierg4210_DB();
    
    if (!preg_match('/^\d*$/', $_POST['pid']))
        throw new Exception("invalid-pid");
    $_POST['pid'] = (int) $_POST['pid'];
    $pid = $_POST["pid"];

    
    $sql="DELETE FROM Products WHERE pid = ?";
    $q = $db->prepare($sql);
    $q->bindParam(1, $pid);
    $q->execute();

    header('Location: admin.php');
    exit();
}


function ierg4210_account_set_up() {
    global $db;
    $db = ierg4210_DB();

    if (empty($_POST['email']) || !preg_match("/^[\w=+\-\/][\w='+\-\/\.]*@[\w\-]+(\.[\w\-]+)*(\.[\w]{2,6})$/", $_POST['email']))
        throw new Exception("Invaild or missing email");

    if (empty($_POST['password']) || !preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,16}$/", $_POST['password']))
            throw new Exception("Invaild or missing password");
    
    $salt = random_bytes('10');
    $hashed = hash_hmac('sha256', $_REQUEST['password'], $salt);

    $sql="INSERT INTO USER (email, salt, hashedpassword , flag) VALUES (?, ?, ?, ?)";
    $q = $db->prepare($sql);

    $email = $_POST['email'];
    if ($_POST['user'] == "admin")
    	$flag = 1;
    else 
	$flag = 0;

    echo $email." ".$salt." ".$hashed." ".$flag;
    $q->bindParam(1, $email);
    $q->bindParam(2, $salt);
    $q->bindParam(3, $hashed);
    $q->bindParam(4, $flag);

    $q->execute();
    
    header('Location: main.php', true, 302);
    exit();
}

function ierg4210_change_pw() {
        global $db;
        $db = ierg4210_DB();
        $q=$db->prepare('SELECT * FROM USER WHERE email = ?');
        $q->execute(array($_POST['email']));
        if ($r = $q->fetch()) {
            $saltedpwd = hash_hmac('sha256', $_POST['password'], $r['salt']);
            if ($saltedpwd == $r["hashedpassword"]) {
                $newpwd = $_POST['newpassword'];
	        $testforsamepw = hash_hmac('sha256', $newpwd, $r['salt']);
                if ($testforsamepw == $saltedpwd) { // Same pw
                    header('Content-Type: text/html; charset=utf-8');
		    echo 'Wrong/Repeat Credentials, fail to change password. <br/><a href="javascript:history.back();">Back to login page.</a>';
		    exit();
                }
		//Insert here
                $newsalt = random_bytes('10');
                $hashednewpwd = hash_hmac('sha256', $newpwd, $newsalt);
                $sql= "UPDATE USER SET salt = ?, hashedpassword = ? WHERE email = ?";
                $q = $db->prepare($sql);

                $email = $_POST['email'];

                $q->bindParam(1, $newsalt);
                $q->bindParam(2, $hashednewpwd);
                $q->bindParam(3, $email);
                $q->execute();

                header('Content-Type: text/html; charset=utf-8');
                echo 'Sucessfully changed your password! <br/><a href="javascript:history.back();">Back to login page and login with new credentials.</a>';
		ierg4210_log_out();
	    	exit();
	    }
        }

        header('Content-Type: text/html; charset=utf-8');
        echo 'Wrong/Repeat Credentials, fail to change password. <br/><a href="javascript:history.back();">Back to login page.</a>';
        exit();
}
?>
