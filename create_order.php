<?php

/** https://stackoverflow.com/questions/4323411/how-can-i-write-to-the-console-in-php ***/


function gen_digest($array)
{
  $digest = hash("sha256", implode(";", $array));
  return $digest;
}
function gen_uuid()
{
  $data = random_bytes(16);
  return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
}
function create_order($cart)
{	  
  $json = <<<HEREA
  {
    "purchase_units": [
      {
        "amount": {
          "currency_code": "HKD",
          "value": 5,
          "breakdown": {
            "item_total": {
              "currency_code": "HKD",
              "value": 5
            }
          }
        },
        "items": [ ]
      }
    ]
  }
HEREA;
  
  $order = json_decode($json);
   
  $total = 0;
  foreach($cart as $ele) {
    $total += $ele->price * $ele->quantity;
    $itemjson = <<<HEREB
    {
      "name": "1:ProductA",
      "unit_amount": {
        "currency_code": "HKD",
        "value": 1
      },
      "quantity": 1
    }   
HEREB;
  
    $item = json_decode($itemjson);
    $item->name = $ele->name;
    $item->unit_amount->value = (double) $ele->price;
    $item->quantity = $ele->quantity;
    array_push($order->purchase_units[0]->items, $item);
  }

  $order->purchase_units[0]->amount->breakdown->item_total->value = $total;
  $order->purchase_units[0]->amount->value = $total;

  $order->purchase_units[0]->custom_id = gen_digest(array($order->purchase_units[0]->amount->currency_code));
  $order->purchase_units[0]->invoice_id = gen_uuid(); // invoice_id must be unique to avoid crashes.

  return json_encode($order);

}

$json = file_get_contents("php://input");
$cart = json_decode($json);
echo create_order($cart);
?>
