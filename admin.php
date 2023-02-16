<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8"> 
    <title>GoodShop</title>

    <link rel="stylesheet" href=web.css type="text/css">
    <link rel="stylesheet" href=admin.css type="text/css">
</head>

<body>

<?php
    require __DIR__.'/lib/db.inc.php';
    $res = ierg4210_cat_fetchall();
    $options = '';
    foreach ($res as $value){
    $options .= '<option value="'.$value["cid"].'"> '.$value["name"].' </option>';
    }
echo date('h:i:s A');
?>

    <div> 
        <header> Welcome to GoodShop! </header>
    </div>

    <div class="adminheader"> 
        Admin Panel
    </div>

    <div class="container"> <!--  Flex box (2 columns 3 Forms)-->

        <div id="FlexCol1">
        <fieldset>
        <legend> New Product</legend>
        <form id="prod_insert" method="POST" action="admin-process.php?action=prod_insert"
        enctype="multipart/form-data">
            <label for="prod_cid"> Category *</label>
            <div> <select id="prod_cid" name="cid"><?php echo $options; ?></select></div>

            <label for="prod_name"> Name *</label>
            <div> <input id="prod_name" type="text" name="name" required="required" pattern="^[\w\-]+$"/></div>

            <label for="prod_price"> Price *</label>
            <div> <input id="prod_price" type="text" name="price" required="required" pattern="^\d+\.?\d*$"/></div>

            <label for="prod_desc"> Description *</label>
            <div> <input id="prod_desc" type="text" name="description"/> </div>

            <label for="prod_image"> Image * </label>
            <div> <input type="file" name="file" required="true" accept="image/jpeg"/> </div>

            <input type="submit" value="Submit"/>
        </form>
        </fieldset>
        </div>
        
        <div id="FlexCol2">

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
</body>

</html>