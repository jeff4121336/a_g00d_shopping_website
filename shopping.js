var ci = document.getElementById('cartinfo');
var sum = 0;
var modlist = true;
var modsum = true;
var url = new URL(location.href);
var name = url.searchParams.get("name");
var price = url.searchParams.get("price");
var pid = url.searchParams.get("itn");

$(document).ready(function(){ 
    updatelist();
    updatesum();
    console.log(document);
    $("#addtocart").click(function(){
	if (localStorage.getItem(name) === null){
	    let json = {
       		"ProductName" : name ,
		"pid" : pid,
	        "ProductPrice" : price ,
	        "Quantity" : 1
	    }
	    localStorage.setItem(pid, JSON.stringify(json));
	    alert("Product " + name + " was added!\n" + "Edit the quantity in shopping list!");
	    modlist = true;
	    modprice = true;	
	    updatelist();
	    updatesum();
	} else {
	    alert("Product has added already. You can not add the same product again!");
	}	    
    });
    
    $("#clearcart").click(function(){
        localStorage.clear();
   	updatesum();
    });

    $("#save").click(function(){
        var container = document.querySelector('#cartinfo');
		var name = container.querySelectorAll('#tempn');
		var price = container.querySelectorAll('#tempp'); 
		var id = container.querySelectorAll('#tempid');   
        var input = container.querySelectorAll('#Quantityinput');
	
	for (var i = 0; i < name.length; i++){
	
	    if (input[i].value < 0 || input[i].value > 1000 || input[i].value == "") {
		alert("Invaild input detected! Please enter value 0-999");
		continue;
	    } 
	    if (input[i].value == 0){
		alert(name[i].innerHTML +" will be removed!\nAdd it again in the product page if you want!");
		localStorage.removeItem(id[i].innerHTML);
		modlist = true;
		updatelist();
		continue;
	    }
	    let json = {
                "ProductName" : name[i].innerHTML,
		"pid" : id[i].innerHTML,
                "ProductPrice" : price[i].innerHTML,
                "Quantity" : input[i].value
            }
            localStorage.setItem(id[i].innerHTML, JSON.stringify(json));
	console.log(id[i].innerHTML, name[i].innerHTML, price[i].innerHTML, input[i].value);
	}
	
	updatesum();	
    });
});
function updatelist(){
    if (localStorage.length == 0){
        ci.innerHTML = "</br>" + "Set quantity to 0 to remove unwanted products" +  "</br>" + "Press SAVE to save the quantity of products" + "</br>" + " Press CLEAR to clear the shopping list" + "</br> </br>" + "Nothing in the Cart now.";  
    } else {
        //sum
	if (modlist) {
	modlist = false;
	ci.innerHTML = "</br>" + "Set quantity to 0 to remove unwanted products" +  "</br>" + "Press SAVE to save the quantity of products" + "</br>" + " Press CLEAR to clear the shopping list" + "</br> </br>";
        for (var i = 0; i < localStorage.length; i++) {
	    var n = localStorage.key(i);
            var temp = JSON.parse(localStorage.getItem(n));
	    var tempn = temp.ProductName;
	    var tempp = temp.ProductPrice;
	    var tempq = temp.Quantity;	
	    var tempid = temp.pid;
		if (tempn == undefined)
			continue;
	    //console.log(Object.keys(temp)); use for check json key
	    var Item = document.createElement("div");
            Item.innerHTML =  "#<span id=tempid>" + tempid + "</span>" + " <span id=tempn>" + tempn + "</span>" + "<input value='"+ tempq +"' type='number' id='Quantityinput' min='0' max='999'> </input>" + " @ $" + "<span id=tempp>" + tempp + "</span>";
	    ci.appendChild(Item);;
	}
	}
	setTimeout(updatelist, 500);
    }
}

function updatesum() {
    var cp = document.getElementById("cartprice");
	
    if (localStorage.length == 0){
   	sum = 0;
	cp.innerHTML = "Total $" + sum;
    } else {
	sum = 0;
        for (var i = 0; i < localStorage.length; i++) {
            var n = localStorage.key(i);
            var temp = JSON.parse(localStorage.getItem(n));
            var tempn = temp.ProductName;
	    var tempp = temp.ProductPrice;
            var tempq = temp.Quantity;
	    if (tempn == undefined)
                continue;
	    sum += tempp * tempq;
        }
	cp.innerHTML = "Total $" + sum;
//	console.log(sum);
   }
}

