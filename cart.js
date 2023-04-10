function getCartItems() {

  /* @TODO Your Implementation Here. */
  /* ========== REGION START ========== */
    const ret = [];
    for (var i = 0; i < localStorage.length; i++) {
    var n = localStorage.key(i);
    var temp = JSON.parse(localStorage.getItem(n));
    if (temp.pid == undefined) {
	continue;
    }
    let format = {
    	pid: temp.pid,
	name: temp.ProductName,
	price: temp.ProductPrice,
	quantity: temp.Quantity 
    }
	  
    ret.push(format);  
  }
  console.log(ret);
  return ret;
  /* ========== REGION END ========== */
}

/**
 * This function clears all items in the cart. 
 */
function clearCart() {
  /* @TODO Your Implementation Here. */
  /* ========== REGION START ========== */
  localStorage.clear();
  updatesum();
  /* ========== REGION END ========== */ 
}
