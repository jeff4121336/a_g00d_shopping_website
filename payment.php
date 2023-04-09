<!DOCTYPE html>
<html>

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Ensures optimal rendering on mobile devices -->
</head>

<body>
  <!-- Include the PayPal JavaScript SDK; replace "test" with your own sandbox Business account app client ID -->
	<script src="https://www.paypal.com/sdk/js?client-id=<?php echo json_decode(file_get_contents("/var/www/html/IERG4210/productpage/secret.json"))->client_id; ?>"></script>
<script> <?php include_once("/var/www/html/IERG4210/cart.js") ?> </script>

  <!-- Set up a container element for the button -->
  <div id="paypal-button-container"></div>

<script>

let currentDomain = window.location.origin;
//console.log(currentDomain);
const create_order = currentDomain + "/IERG4210/create_order.php";
//console.log(link);
const save_order = currentDomain + "/IERG4210/save_order.php";

    paypal.Buttons({
      /* Sets up the transaction when a payment button is clicked */
      createOrder: async (data, actions) => {
        /* [TODO] create an order from localStorage */
        let order_details = await fetch(create_order , {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify(getCartItems(), null, 2)
        }).then(response => response.json());

        console.log(order_details);

        return actions.order.create(order_details);
      },

      /* Finalize the transaction after payer approval */
      onApprove: async (data, actions) => {
        return actions.order.capture()
          .then(async orderData => {
            /* Successful capture! For dev/demo purposes: */
            console.log('Capture result', orderData, JSON.stringify(orderData, null, 2));

            await fetch(save_order, {
              method: "POST",
              headers: {
                "Content-Type": "application/json",
              },
              body: JSON.stringify(orderData, null, 2)
            });

            clearCart(); // Clear the web shop cart
            window.location.href = "payment.php"; // Redirect to another page
          });
      },
    }).render('#paypal-button-container');
  </script>
</body>

</html>
