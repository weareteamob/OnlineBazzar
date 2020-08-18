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

if (isset($_POST["btnDeleteProduct"])) {
	if( !isset($_POST["productid"])){
		header("Location: updateDelete.php?msg=Empty post.#delete");
		exit();
	}
	if( intval($_POST["productid"]) < 1 ){
		header("Location: updateDelete.php?msg=Product id requried to delete!#delete");
		exit();
	}
	$productId = $_POST["productid"];
	$r = $productController->deleteProduct($productId);
	if($r){
		$r = "Product deleted";
	}else{
		$r = "error";
	}
	header("Location: updateDelete.php?msg=".$r."#delete");
	exit();
}

if (isset($_POST["btnUpdateProduct"])) {
	if( !isset($_POST["productid"]) || !isset($_POST["updateColumn"]) || !isset($_POST["updateTo"])  ){
		header("Location: updateDelete.php?msg=Empty post.");
		exit();
	}
	if( intval($_POST["productid"]) < 1 || strlen($_POST["updateColumn"]) < 1 || strlen($_POST["updateTo"]) < 1  ){
		header("Location: updateDelete.php?msg=Please fill up all required update values.");
		exit();
	}
	$productId = $_POST["productid"];
	$updateColumn = $_POST["updateColumn"];
	$updateTo = $_POST["updateTo"];
	$r = $productController->updateProduct($productId,$updateTo,$updateColumn);
	if($r){
		$r = "Product updated";
	}else{
		$r = "error";
	}
	header("Location: updateDelete.php?msg=".$r);
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
				<small style="color: #fff;background-color: #444;padding: 0 5px 0 5px;">Update / Delete Product</small>
			</div>
			<form method="POST" action="updateDelete.php" id="updateProduct" enctype="multipart/form-data">
				<h2 style="border-bottom: 1px solid #eee;padding: 0 0 10px 0;box-sizing: border-box;">Update Product</h2><br>
				<label class="half">
					Product id<br>
					<input type="number" name="productid" placeholder="Product id..." class="full">
				</label>
				<label class="half">
					To update<br>
					<select name="updateColumn" class="full">
						<option value="description">Description</option>
						<option value="title">Title</option>
						<option value="price">Price</option>
						<option value="trademark">Trademark</option>
					</select>
				</label>
				<label>
					<span>Update value</span><br>
					<input type="text" name="updateTo" placeholder="Updae value..." class="full">
				</label>
				<button class="r" style="margin-top: 20px;" name="btnUpdateProduct" type="submit">Update</button>
				<a href="index.php" class="btn-simple">Cancel</a>
			</form>

			<form method="POST" action="updateDelete.php" id="deleteProduct">
				<h2 style="border-bottom: 1px solid #eee;padding: 0 0 10px 0;box-sizing: border-box;">Delete Product</h2><br>
				<input type="number" name="productid" placeholder="Product id..." class="full">
				</label>
				<button class="r" style="margin-top: 20px;" name="btnDeleteProduct" type="submit">Delete</button>
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

	if (window.location.hash == "#delete") {
		document.getElementById("updateProduct").style.display = "none";
		document.getElementById("deleteProduct").style.display = "block";
	}else{
		document.getElementById("deleteProduct").style.display = "none";
	}

</script>

</body>
</html>