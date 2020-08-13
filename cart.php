<?php 
require 'controllers/session.php';

if (!$loggedIn) {
	header("Location: index.php?msg=Please login!");
	exit();
}
include 'models/product.php';
include 'controllers/order.php';

$order = new Order;

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
			<form id="addProduct" style="margin-bottom: 50px;">
			<h4>Your Order Cart</h4>
			<hr><br>
			<?php 

				$results = $order->getMyOrderCart();

				if( $results[0] == "ok" ){

					$allProducts = $results[1];

					foreach ($allProducts as $order) {
						$orderId = $order[3];
						$product = $order[0];
						$quantity = $order[1];
						$verified = $order[2];
						$totalPrice = $product->getPrice() * $quantity;
						echo '
						<div class="product-card card-3">
							<div class="image">
								<img src="productImages/'.$product->getImage().'">
								<div class="extra">
									<small>Category:<br>'.$product->getCategory().'</small>
									<br><br>
									<small>Trademark:<br>'.$product->getTrademark().'</small>
								</div>
							</div>
							<div class="product-body">
								<div class="product-price">&pound;'.$product->getPrice().'</div>
								<div class="product-title">'.$product->getTitle().'</div>
								<div class="product-hr"></div>
								<p style="max-width:1000px;">'.$product->getDescription().'</p>
								<div class="product-hr"></div>
								<div>Quantity orderd: '.$quantity.'</div>
								<div>Order verified: '.$verified.'</div>
								<div>Total price: &pound;'.$totalPrice.'</div>
								<a class="deleteOrder" href="deleteOrder.php?orderId='.$orderId.'">Delete Order</a>
							</div>
						</div>
						';
					}
					
				}

				if ( $results[0] == "noOrder" ) {
					echo "Your cart is empty";
				}

			?>	
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