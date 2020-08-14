<?php 
require 'controllers/session.php';

if ( !$loggedIn ) {
	header("Location: index.php?msg=Please Login");
	exit();
}
if ( !$_SESSION["admin"] ) {
	header("Location: index.php?msg=Access denied!");
	exit();
}

include 'controllers/product.php';

$productController = new ProductController();
$allProducts = $productController->getProducts("id > 0");
if( isset($_GET["delId"]) ){
	$delId = intval($_GET["delId"]);
	$r = $productController->deleteProduct($delId);
	if($r){
		$r = "Product deleted";
	}else{
		$r = "error";
	}
	header("Location: viewProducts.php?msg=".$r);
	exit();
}

?>

<!DOCTYPE html>
<html>
<head>
	<?php include 'views/php/head.php'; ?>
</head>
<body style="overflow-x: hidden;">

	<div class="main">
		<div class="landing" id="landing">
			<div class="landing-content">
				<a href="index.php"><div class="landingText">Online <span>Bazzar</span></div></a>
				<small style="color: #fff;background-color: #444;padding: 0 5px 0 5px;">View Customers</small>
			</div>

			<div id="viewCustomers">
				
				<?php 

					if( $allProducts[0] == "ok" ){
						echo '
								<table>
									<tr>
										<th>Product Id</th>
										<th>Product Title</th>
										<th>Product Description</th>
										<th>Product Price</th>
										<th>Product Category</th>
										<th>Product Trademark</th>
										<th>Delete</th>
									</tr>
									';
						foreach ($allProducts[1] as $product) {
							echo '
								
									<tr>
										<td>'.$product->getId().'</td>
										<td>'.$product->getTitle().'</td>
										<td>'.$product->getDescription().'</td>
										<td>'.$product->getPrice().'</td>
										<td>'.$product->getCategory().'</td>
										<td>'.$product->getTrademark().'</td>
										<td><a style="background-color:#ea8b8b;color:#fff;padding:5px;box-sizing:border-box;font-size:15px;" href="viewProducts.php?delId='.$product->getId().'">Delete</a></td>
									</tr>
							';
						}
						echo '
						<tr>
						<td><a href="index.php" style="color:#000;">Back to Home</a></td>
						</tr>
						</table>';

					}else{
						echo '
						<table>
						<div style="color:#fff;">No products found</div>
						<br>
						<a href="index.php" style="color:#fff;background-color:#ea8b8b;">Back to Home</a>
						</table>';
					}

				?>

			</div>

		</div>

		<br>

		<div class="below">

			<div class="element" id="footer">
				&copy; Online Bazzar 2019
				<span class="links">
					<?php 
						if ($loggedIn) {
							echo '
								<a href="lout.php" class="lout">Logout</a>
								<a href="#profile">Profile</a>
							';
						}else{
							echo '
								<a href="login.php">Login</a>
								<a href="register.php">Register</a>
							';
						}
					?>
					<a href="manual.php">User Manual</a>
					<a href="#landing">Top</a>
				</span>
			</div>

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