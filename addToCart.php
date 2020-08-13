<?php 
require 'controllers/session.php';

if ( !$loggedIn ) {
	header("Location: index.php?msg=Please login!");
	exit();
}

if ( isset($_POST["quantity"]) && isset($_POST["productid"])) {
	include 'controllers/order.php';	

	$order = new Order();

	$quantity = intval($_POST["quantity"]);
	$productId = intval($_POST["productid"]);

	$status = $order->addToOrderCart($productId,$quantity);

	if ( $status == "ok" ) {
		header("Location: cart.php?msg=Product added to cart!#cart");
		exit();
	}else{
		header("Location: cart.php?msg=Product already in cart!#cart");
		exit();
	}
}

?>