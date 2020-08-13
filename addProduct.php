<?php 
require 'controllers/session.php';
include 'controllers/product.php';

if ( !$loggedIn ) {
	header("Location: index.php?msg=Please Login");
	exit();
}
if ( !$_SESSION["admin"] ) {
	header("Location: index.php?msg=Access denied!");
	exit();
}

if ( isset($_POST["btnAdd"]) ) {
	
	$productController = new ProductController();

	if ( 

		isset($_POST["title"]) &&
		isset($_POST["price"]) &&
		isset($_POST["category"]) &&
		isset($_POST["trademark"]) &&
		isset($_POST["description"]) &&
		isset($_FILES["image"])

	 ) {
		
		$title = $_POST["title"];
		$price = $_POST["price"];
		$category = $_POST["category"];
		$trademark = $_POST["trademark"];
		$description = $_POST["description"];

		$image =  $_FILES["image"]["tmp_name"];
		$imageName = $_FILES["image"]["name"];
		$randString = generateRandomString();
		$imageName = $randString.$imageName;
		if (move_uploaded_file($image, "productImages/".$imageName)) {
				
			$product = new Product();
			$product->setDescription($description);
			$product->setTitle($title);
			$product->setPrice($price);
			$product->setImage($imageName);
			$product->setCategory($category);
			$product->setTrademark($trademark);
			$status = $productController->addProduct($product);
			if ( $status == "ok" ) {
				header("Location: addProduct.php?msg=Product added.");
			}else{
				header("Location: addProduct.php?msg=Error.");
			}
		}

	}else{
		header("Location: addProduct.php?msg=Invalid Post request.");
		exit();
	}

}

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
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
				<small style="color: #fff;background-color: #444;padding: 0 5px 0 5px;">Add Product</small>
			</div>
			<form method="POST" action="addProduct.php" id="addProduct" enctype="multipart/form-data">
				<label class="half">
					Title<br>
					<input type="text" name="title" placeholder="Product title/name..." class="full">
				</label>
				<label class="half">
					<span class="r">Price (&pound;)</span><br>
					<input type="number" name="price" placeholder="Product price..." class="full">
				</label>
				<label class="half">
					Category<br>
					<select name="category" class="full">
						<option value="music">Music</option>
						<option value="clothing">Clothing</option>
						<option value="electronics">Electronics</option>
						<option value="books">Books</option>
						<option value="business">Business Product</option>
						<option value="phone">Phones</option>
						<option value="jwellery">Jwellery</option>
						<option value="art">Art</option>
						<option value="food">Food</option>
						<option value="musical instrument">Musical Instruments</option>
						<option value="software">Software</option>
						<option value="hardware">Hardware</option>
						<option value="sport">Sports</option>
						<option value="video">Video,Blue-Ray</option>
						<option value="audio">Audio</option>
						<option value="other">Other</option>
					</select>
				</label>
				<label class="half">
					<span class="r">Trademark</span><br>
					<input type="text" name="trademark" placeholder="Product trademark..." class="full">
				</label>
				<label class="half">
					<span class="center">Product image</span><br>
					<input type="file" name="image" class="full">
				</label>
				<label>
					<span class="r">Description</span><br>
					<textarea class="full" name="description" placeholder="Product description..."></textarea>
				</label>
				<button class="r" style="margin-top: 20px;" name="btnAdd" type="submit">Add</button>
				<a href="index.php" class="btn-simple">Cancel</a>
			</form>
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