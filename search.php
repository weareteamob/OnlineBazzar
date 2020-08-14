<?php 
require 'controllers/session.php';

$searchKeyword = null;
$priceRange= null;
$category= null;

if ( !isset($_GET["searchKeyword"]) ) {
	header("Location: index.php?msg=Please enter search keyword");
	exit();
}

include 'controllers/product.php';

$productController = new ProductController();

if( isset($_GET["searchKeyword"]) )$searchKeyword = $_GET["searchKeyword"];
if( isset($_GET["priceRange"]) ) $priceRange = $_GET["priceRange"];
if( isset($_GET["category"]) ) $category = $_GET["category"];


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
				<div class="landingText">Online <span>Bazzar</span></div>
				<small style="color: #fff;background-color: #444;padding: 0 5px 0 5px;">Search</small>
			</div>
			<div class="username">Welcome<?php if($loggedIn) echo ", ".$_SESSION["username"]; ?></div>
			<div class="nav">
				<a href="index.php">Home</a>
				<a href="#about">About</a>
				<?php 
					if ($loggedIn) {
						echo '
							<a href="lout.php" class="lout">Logout</a>
							<a href="cart.php">My Cart</a>	
							<a href="#profile">Profile</a>
						';
					}else{
						echo '
							<a href="login.php">Login</a>
							<a href="register.php">Register</a>
						';
					}
				?>
			</div>
		</div>
		<div class="below">
			<div class="element" id="searchResult">
				<h4>Search Results</h4>
				<br><hr><br>
				<?php 
					$condition = "title LIKE '".$searchKeyword."%' ";
					if( $priceRange != null ){
						$priceRange = explode("-", $priceRange);
						$condition .= "AND price >= ".$priceRange[0]." AND price <= ".$priceRange[1]." ";
					}
					if( $category != null ){
						$condition .= "AND category LIKE '".$category."%'";
					}
					$results = $productController->getProducts($condition);

					if( $results[0] == "noProducts" ){
						echo '<div class="center mtop">No products found!</div>';
					}

					if( $results[0] == "ok" ){

						$allProducts = $results[1];

						foreach ($allProducts as $product) {
							echo '
							<div class="product-card">
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
									<p>'.$product->getDescription().'</p>
									<div class="product-hr"></div>
									<form method="POST" action="addToCart.php">
										<input type="number" name="quantity" placeholder="Quantity.." style="padding-left: 10px;width: 100%;" required>
										<input type="hidden" name="productid" value="'.$product->getId().'">
										<button type="submit">Add to cart<img src="views/images/cart.png"></button>
									</form>
								</div>
							</div>
							';
						}
						
					}

				?>	

				<!-- <div class="product-card">
					<div class="image">
						<img src="views/images/landing.jpg">
						<div class="extra">
							Category
							<br>
							Trademark
						</div>
					</div>
					<div class="product-body">
						<div class="product-price">&pound;30</div>
						<div class="product-title">Title</div>
						<div class="product-hr"></div>
						<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
						tempor incididunt ut labore et dolore magna aliqua. </p>
						<div class="product-hr"></div>
						<form method="POST" action="addToCart.php">
							<input type="text" name="quantity" placeholder="Quantity.." style="padding-left: 10px;width: 100%;" required>
							<input type="hidden" name="productid">
							<button type="submit">Add to cart<img src="views/images/cart.png"></button>
						</form>
					</div>
				</div> -->

			</div>


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