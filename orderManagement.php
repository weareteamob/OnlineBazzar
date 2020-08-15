<?php 
require 'controllers/session.php';

if (!$loggedIn) {
	header("Location: index.php?msg=Please login!");
	exit();
}

if ( !$loggedIn ) {
	header("Location: index.php?msg=Please Login");
	exit();
}
if ( !$_SESSION["admin"] ) {
	header("Location: index.php?msg=Access denied!");
	exit();
}

include 'models/product.php';
include 'controllers/order.php';

$order = new Order();

if ( isset($_POST["btnVerify"]) ) {
	
	$orderId = intval($_POST["orderId"]);
	$status = $order->verifyOrder($orderId);
	if( $status > 0 ){
		header("Location: orderManagement.php?msg=Order verified!");
		exit();
	}else{
		header("Location: orderManagement.php?msg=Verify Error!".$status);
		exit();
	}

}

if ( isset($_POST["btnDelete"]) ) {
	$orderId = intval($_POST["orderId"]);
	if($order->deleteOrder($orderId) > 0 ){
		header("Location: orderManagement.php?msg=Order deleted!");
		exit();
	}else{
		header("Location: orderManagement.php?msg=Delete Error!");
		exit();
	}
}


?>
<!DOCTYPE html>
<html>
<head>
	<?php include 'views/php/head.php'; ?>
</head>
<body style="overflow-y: hidden;">

	<div class="main">
		<div class="landing" id="landing">
			<div class="landing-content">
				<div class="landingText">Online <span>Bazzar</span></div>
				<small style="color: #fff;background-color: #444;padding: 0 5px 0 5px;">My Cart</small>
			</div>
			<div id="cart"></div>
			<form action="orderManagement.php" method="POST" id="addProduct" style="margin-bottom: 50px;">
			<h4>Order Management</h4>
			<hr><br>

				<label class="full">
					Order Id<br>
					<input type="number" placeholder="Order id..." class="full" name="orderId" required>
				</label>

				<button type="submit" name="btnVerify" class="r" style="background-color: #3ba03b;">Verify Order</button>
				<button type="submit" name="btnDelete" class="mr r" style="background-color: #dc3b3b;">Delete Order</button>

			<div><a href="index.php" class="btn-simple" style="position: absolute;top: 10px;right:0;">Back</a></div>

			</form>
		</div>
		<div class="below">

		</div>
	</div>

<?php 
	$msg = "";
	if(isset($_GET["msg"])){
		$msg = $_GET["msg"];
		echo '<div id="msg">';
		echo htmlspecialchars($msg);
		echo '</div>';
	}  
?>
<script type="text/javascript">
	if( document.getElementById('msg') ){
		setTimeout(function(){
			document.getElementById('msg').style.display = "none";
		},6000);
	}
</script>

</body>
</html>