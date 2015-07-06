

function resetTileFinderForm() {
	document.getElementById('keywords').value = '';
	document.getElementById('category').selectedIndex = 0;
	document.getElementById('surface').selectedIndex = 0;
	document.getElementById('colour').selectedIndex = 0;
	document.getElementById('size').selectedIndex = 0;
	document.getElementById('peirating').selectedIndex = 0;
	document.getElementById('type').selectedIndex = 0;
	document.getElementById('pattern').selectedIndex = 0;
	document.getElementById('material').selectedIndex = 0;
	document.getElementById('thickness').selectedIndex = 0;
	document.getElementById('edge').selectedIndex = 0;
	document.getElementById('sliprating').selectedIndex = 0;
}

function moreTileFinderOptions(show) {
	var finder_more_options = document.getElementById('finder_more_options');
	var finder_more_link_text = document.getElementById('finder_more_link_text');
	if(finder_more_options.style.display!='block'||show=='show') {
		finder_more_options.style.display = 'block';
		finder_more_link_text.innerHTML = 'Hide extra search options';
	} else {
		finder_more_options.style.display = 'none';
		finder_more_link_text.innerHTML = '› More search options';
	}
}

function updateFinderSelect() {
	
}

function goToProductTab(num) {
	var tab1 = document.getElementById('tab1');
	var tab2 = document.getElementById('tab2');
	var tab3 = document.getElementById('tab3');
        var tab4 = document.getElementById('tab4');
		tab1.className = 'tab_inactive';
		tab2.className = 'tab_inactive';
		tab3.className = 'tab_inactive';
                tab4.className = 'tab_inactive';
		document.getElementById('tab'+num).className = 'tab';
	var page1 = document.getElementById('page1');
	var page2 = document.getElementById('page2');
	var page3 = document.getElementById('page3');
		page1.style.display = 'none';
		page2.style.display = 'none';
		page3.style.display = 'none';
		document.getElementById('page'+num).style.display = 'block';
}

function checkAddQtyValue(price_per_sqm, sqm_per_box, required_sqm) {
	var price_per_sqm = parseFloat(price_per_sqm);
	var sqm_per_box = parseFloat(sqm_per_box);
	var required_sqm = parseFloat(required_sqm);
	alert('price_per_sqm: '+price_per_sqm+', sqm_per_box: '+sqm_per_box+', required_sqm: '+required_sqm);
	var total_boxes = Math.ceil(required_sqm/sqm_per_box);
	var total_price = formatMoney((price_per_sqm*sqm_per_box)*total_boxes);
	alert('Required sqm: '+required_sqm+', Boxes: '+total_boxes+', Total price: $'+total_price);
}

function addToCart(user_id, user_session, item_code, item_quantity, button_id,price) {
	var request_string = 'ajax/addtocart.php?user_id='+user_id+'&user_session='+user_session+'&item_code='+item_code+'&item_quantity='+item_quantity+'&button_id='+button_id+'&price='+price;
	//alert(request_string);
	var ajaxRequest = startAjax();	
	ajaxRequest.onreadystatechange = function() {
		if (ajaxRequest.readyState==4 && ajaxRequest.status==200) {
			if(ajaxRequest.responseText!='') { //Ajax response found
				document.writeln = eval(ajaxRequest.responseText); //convert response text to javascript
				//alert(ajaxRequest.responseText);
			}
		}
	}
	ajaxRequest.open('GET', request_string, true);
	ajaxRequest.send(null);
}

function updateCartQty(user_id, user_session, id) {
	var new_qty = document.getElementById('qty_field_'+id).value;
	if(new_qty>0&&new_qty!=null) {
		var request_string = 'ajax/updatecartqty.php?user_id='+user_id+'&user_session='+user_session+'&id='+id+'&qty='+new_qty;
		//alert(request_string);
		var ajaxRequest = startAjax();	
		ajaxRequest.onreadystatechange = function() {
			if (ajaxRequest.readyState==4 && ajaxRequest.status==200) {
				if(ajaxRequest.responseText!='') { //Ajax response found
					document.writeln = eval(ajaxRequest.responseText); //convert response text to javascript
					//alert(ajaxRequest.responseText);
				}
			}
		}
		ajaxRequest.open('GET', request_string, true);
		ajaxRequest.send(null);
	} else {
		new_qty = 1;
	}
}

function increaseCartQty(user_id, user_session, id) {
	var request_string = 'ajax/increasecartqty.php?user_id='+user_id+'&user_session='+user_session+'&id='+id;
	//alert(request_string);
	var ajaxRequest = startAjax();	
	ajaxRequest.onreadystatechange = function() {
		if (ajaxRequest.readyState==4 && ajaxRequest.status==200) {
			if(ajaxRequest.responseText!='') { //Ajax response found
				document.writeln = eval(ajaxRequest.responseText); //convert response text to javascript
				//alert(ajaxRequest.responseText);
			}
		}
	}
	ajaxRequest.open('GET', request_string, true);
	ajaxRequest.send(null);
}

function decreaseCartQty(user_id, user_session, id) {
	var request_string = 'ajax/decreasecartqty.php?user_id='+user_id+'&user_session='+user_session+'&id='+id;
	//alert(request_string);
	var ajaxRequest = startAjax();	
	ajaxRequest.onreadystatechange = function() {
		if (ajaxRequest.readyState==4 && ajaxRequest.status==200) {
			if(ajaxRequest.responseText!='') { //Ajax response found
				document.writeln = eval(ajaxRequest.responseText); //convert response text to javascript
				//alert(ajaxRequest.responseText);
			}
		}
	}
	ajaxRequest.open('GET', request_string, true);
	ajaxRequest.send(null);
}

function removeFromCart(user_id, user_session, id) {
	var request_string = 'ajax/removefromcart.php?user_id='+user_id+'&user_session='+user_session+'&id='+id;
	//alert(request_string);
	var ajaxRequest = startAjax();	
	ajaxRequest.onreadystatechange = function() {
		if (ajaxRequest.readyState==4 && ajaxRequest.status==200) {
			if(ajaxRequest.responseText!='') { //Ajax response found
				document.writeln = eval(ajaxRequest.responseText); //convert response text to javascript
				//alert(ajaxRequest.responseText);
			}
		}
	}
	ajaxRequest.open('GET', request_string, true);
	ajaxRequest.send(null);
}

function formatMoney(num) {
	num = num.toString().replace(/\$|\,/g,'');
	if(isNaN(num))
	num = "0";
	sign = (num == (num = Math.abs(num)));
	num = Math.floor(num*100+0.50000000001);
	cents = num%100;
	num = Math.floor(num/100).toString();
	if(cents<10)
	cents = "0" + cents;
	for (var i = 0; i < Math.floor((num.length-(1+i))/3); i++)
	num = num.substring(0,num.length-(4*i+3))+','+
	num.substring(num.length-(4*i+3));
	return (((sign)?'':'-') + num + '.' + cents);
}

function startAjax() {
	var ajaxRequest; // The variable that makes Ajax possible!
	try {
		//Opera 8.0+, Firefox, Safari
		ajaxRequest = new XMLHttpRequest();
	} catch (e) {
		//Internet Explorer Browsers
		try{
			ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			try{
				ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e) {
				//Something went wrong
				alert("Your browser broke!");
				return false;
			}
		}
	}
	//alert('Ajax started');
	return ajaxRequest;
}

function addToCartPdtDetails(user_id,shop_order_id, user_session, item_code, item_quantity, button_id,totprice) {
	var request_string = 'ajax/addToCartPdtDetails.php?user_id='+user_id+'&shop_order_id='+shop_order_id+'&user_session='+user_session+'&item_code='+item_code+'&item_quantity='+item_quantity+'&button_id='+button_id+'&totprice='+totprice;
	//alert(request_string);
	var ajaxRequest = startAjax();	
	ajaxRequest.onreadystatechange = function() {
		if (ajaxRequest.readyState==4 && ajaxRequest.status==200) {
			if(ajaxRequest.responseText!='') { //Ajax response found
				document.writeln = eval(ajaxRequest.responseText); //convert response text to javascript
                                console.log(ajaxRequest.responseText);
				//alert(ajaxRequest.responseText);
                                //return false;
                                //window.location="http://180.235.128.82/~titi2698/cart.php";
                                window.location="cart.php";
			}
		}
	}
	ajaxRequest.open('GET', request_string, true);
	ajaxRequest.send(null);
}