<?php 
require 'controllers/session.php';

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
				<small style="color: #fff;background-color: #444;padding: 0 5px 0 5px;">Home</small>
			</div>
			<div class="username">Welcome<?php if($loggedIn) echo ", ".$_SESSION["username"]; ?></div>
			<div class="nav">
				<a href="#">Home</a>
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
							<a href="manual.php" title="User Manual">Manual</a>
							<a href="login.php">Login</a>
							<a href="register.php">Register</a>
						';
					}
				?>
			</div>
		</div>
		<div class="below">
			<div class="element" id="searchBox">
				<h4>Search</h4>
				<form method="GET" action="search.php#searchResult" class="full">
					<label class="full">
						Search Keyword
						<input type="text" name="searchKeyword" class="full" placeholder="Search keyword...">
					</label>

					<br><small class="r">Filter search</small><br>
					<label class="half">
						Price Range (&pound;)<br>
						<input type="text" name="priceRange" class="full" placeholder="20-50..." title="From-To">
					</label>
					<label class="half">
						Category <br>
						<select name="category" class="full">
							<option value="">Choose</option>
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
					<br>
					<button class="r" type="submit">Search</button>
				</form>
			</div>

			<?php 
				if ($loggedIn) {
					if ( $_SESSION["admin"] ) {
						echo '
						<div class="element" id="admin">
							<h4>Admin Actions</h4>
							<br>
								<a href="addProduct.php">Add Product</a>
								<a href="updateDelete.php">Update Product</a>
								<a href="updateDelete.php#delete">Delete Product</a>
								<a href="orderManagement.php">Manage Orders</a>
								<a href="viewCustomers.php">View Customers</a>
								<a href="viewProducts.php">View Products</a>
						</div>
						';
					}
				}
			?>

			<?php 

				if ($loggedIn) {
					echo '
					<div class="element" id="profile">
						<h4>Profile Card</h4><br>
						<div class="profile-card">
							
							<div class="un" title="Id and Username">#'.$_SESSION["userid"].' '.$_SESSION["username"].'</div>
							<div title="Name">Name:'.$_SESSION["name"].'</div>
							<div title="Address"><i>'.$_SESSION["address"].'</i></div>
							<div title="Email" class="em">'.$_SESSION["email"].'</div>
						</div>
						<br><hr><br>
						<div style="text-align:center;">
							<a href="accountActions.php" class="profileBtn">Edit Account</a>
							<a href="accountActions.php#changePassword" class="profileBtn">Change Password</a>
							<a href="#" id="btnDeleteAccount" class="profileBtn">Delete Account</a>
						</div>
					</div>
					<script type="text/javascript">
						document.getElementById("btnDeleteAccount").onclick = function(){
							var confirmation = confirm("Are you sure you want to delete your account");
							if (confirmation) {
								window.location.href = "deleteAccount.php?delete=true";
							}
						}
					</script>
					';
				}

			?>

			<div class="element about" id="about">
				<h4>About us</h4>

				<p>
					Online Bazzar is one of the web based online dealing system where various customers can easily surf the website contains new product with their prices. Your own data and the data of client can be kept safely and with proper managed. By using the HTML, PHP, CSS java script I am going to developed as well design website where you have to sign up and to view the details user should have user name and password.  The user can browse various data once he/she is logged in. “Online Bazzar “you can contact us whatever you like on the website.
				</p>
				<p>
					“Online Bazzar” is an online business site. This site primarily offers the web based shopping of excessive dresses, devices, accessories and pretty much whatever else Online shopping is the way toward purchasing items through web without going to store or shop's area physically. Here individuals utilize their credit/charge or other bank card for installment.
					It was hard to purchase the items wandering in the market a really long time in prior time. It will be so hard to go to the market in the event that he/she have a busy timetable This site esteemed the less consuming time. Information will be kept secretly m reasonable.
					The project is build up with the utilization of the most prevalent web programming language PHP. This builds up the ability of programming in PHP language and creates a complete system without blunder. So the learning of other module of the course will likewise be used to build up the total venture.

				</p>

			</div>

			<div class="element" id="social">
				<h4>Connect with us</h4><br>
				<a href="#"><img src="views/images/fb.png"></a>
				<a href="#"><img src="views/images/twt.png"></a>
				<a href="#"><img src="views/images/insta.png"></a>
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