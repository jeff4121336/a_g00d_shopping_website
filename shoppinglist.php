<?php
echo '
	<div id="shoppinghoverbtn">
             Shopping List
                <listtodisplay>
                    Shopping List Total $10
                <?php
                     $dataObject = $_POST; //Fetching all posts
		     var_dump($dataObject);;
		?>
                <div id="clearcart">
                    <button> Clear </button>
                </div>
                <div id="checkoutlink">
                    <a href="../checkout.html">
                        [CheckOut]
                    </a>
                </div>
                </listtodisplay>
        </div>
';
?>
