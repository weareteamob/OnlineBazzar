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

include 'controllers/customer.php';

$customerController = new CustomerController();

$allCustomers = $customerController->getAllCustomers();

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

					if( $allCustomers[0] == "found" ){
						echo '
								<table>
									<tr>
										<th>Customer Id</th>
										<th>Customer Username</th>
										<th>Customer Email</th>
										<th>Customer Name</th>
										<th>Customer Address</th>
									</tr>
									';
						foreach ($allCustomers[1] as $customer) {
							echo '
								
									<tr>
										<td>'.$customer[0].'</td>
										<td>'.$customer[1].'</td>
										<td>'.$customer[2].'</td>
										<td>'.$customer[3].'</td>
										<td>'.$customer[4].'</td>
									</tr>
							';
						}
						echo '
						<tr>
						<td><a href="index.php" style="color:#000;">Back to Home</a></td>
						</tr>
						</table>';

					}else{
						echo 'No customers found';
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