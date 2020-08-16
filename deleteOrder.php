<?php 
require 'controllers/session.php';
if (!$loggedIn) {
	header("Location: index.php?msg=Please login!");
	exit();
}
include 'models/product.php';
include 'controllers/order.php';
$order = new Order;
if ( isset($_GET["orderId"]) ) {
	$orderId = intval($_GET["orderId"]);
	if($order->deleteOrder($orderId) > 0 ){
		header("Location: cart.php?msg=Order deleted!");
		exit();
	}else{
		header("Location: cart.php?msg=Delete Error!");
		exit();
	}
}

?>
