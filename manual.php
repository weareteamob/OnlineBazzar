<?php 
require 'controllers/session.php';

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
				<small style="color: #fff;background-color: #444;padding: 0 5px 0 5px;">User Manual</small>
			</div>
			<div id="cart"></div>
			<form id="addProduct" style="margin-bottom: 50px;">
			<h4>User Manual</h4>
			<hr><br>

				<div class="element manual">
					<h4>Search</h4>
					<small class="c">We can search from home page search form.</small>
					<img src="views/images/manual/search.PNG" style="width: 100%;">
				</div>

				<div class="element manual">
					<h4>Search Results</h4>
					<small class="c">Search list of product are shown as per search keyword, category, price</small>
					<img src="views/images/manual/search result.PNG" style="width: 100%;">
				</div>

				<div class="element manual">
					<h4>Login</h4>
					<small class="c">We can enter into login form from home page login button.</small>
					<img src="views/images/manual/login1.PNG">
					<img src="views/images/manual/login2.PNG" style="height: 600px;">
				</div>

				<div class="element manual">
					<h4>Register</h4>
					<small class="c">We can enter into register form from home page register button.</small>
					<img src="views/images/manual/register1.PNG">
					<img src="views/images/manual/register2.PNG" style="height: 600px;">
				</div>

				<div class="element manual">
					<h4>Add to cart</h4>
					<small class="c">Logged in users can add products to cart.</small>
					<img src="views/images/manual/ad dto cart.PNG" style="width: 100%;">
				</div>

				<div class="element manual">
					<h4>Cart</h4>
					<small class="c">Logged in users can view their cart.</small>
					<img src="views/images/manual/cart.PNG" style="width: 100%;">
				</div>

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