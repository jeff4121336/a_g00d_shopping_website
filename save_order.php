<?php
require '/var/www/html/IERG4210/lib/auth.php';
/**
 * This function saves the order into the databse.
 * @param order an object containing order details
 */
function save_order($order) {
  /* @TODO Comment out the current return statement */
  // /* ========== REGION START ========== */
  // file_put_contents("order.json", json_encode($order, JSON_PRETTY_PRINT));
  // echo json_encode($order);
  /* ========== REGION END ========== */

  /* @TODO Your Implementation Here. */
  /* ========== REGION START ========== */
  file_put_contents("order.json", json_encode($order, JSON_PRETTY_PRINT));
  $dbinsert = json_decode(file_get_contents("/var/www/html/IERG4210/order.json"));
  
  global $db;
  $db = ierg4210_DB();
  $orderid =  $dbinsert->id;
  $orderstatus = $dbinsert->status;
  $ordertotal = $dbinsert->purchase_units[0]->amount->value;
  $orderpayee = $dbinsert->purchase_units[0]->payee->merchant_id;
  $username = ierg4210_getuser();


  $sql="INSERT INTO ORDER_ (OID, User, Payee, Price, Status) VALUES (?, ?, ?, ?, ?)";
  $q = $db->prepare($sql);
  $q->bindParam(1, $orderid);
  $q->bindParam(2, $username);
  $q->bindParam(3, $orderpayee);
  $q->bindParam(4, $ordertotal);
  $q->bindParam(5, $orderstatus);
  $q->execute(); 
  $itemarray = $dbinsert->purchase_units[0]->items;
  foreach($itemarray as $i) {
    $itemname = $i->name;
    $itemprice = $i->unit_amount->value;
    $itemquantity = $i->quantity;

    $sql="INSERT INTO ORDER_DETAILS VALUES (?, ?, ?, ?)";
    $q = $db->prepare($sql);
    $q->bindParam(1, $orderid);
    $q->bindParam(2, $itemname);
    $q->bindParam(3, $itemprice);
    $q->bindParam(4, $itemquantity);
    $q->execute(); 
  }
  /* ========== REGION END ========== */
}

$json = file_get_contents("php://input");
$order = json_decode($json);
save_order($order);

?>

