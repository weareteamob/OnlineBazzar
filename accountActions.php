<?php 
require 'controllers/session.php';

if ( !$loggedIn ) {
	header("Location: index.php?msg=Please Login");
	exit();
}

include 'controllers/customer.php';

$customerController = new CustomerController();

if (isset($_POST["btnEditAccount"])) {
	if( !isset($_POST["username"]) || !isset($_POST["email"]) || !isset($_POST["name"]) || !isset($_POST["address"]) ){
		header("Location: accountActions.php?msg=Empty post.");
		exit();
	}
	if( strlen($_POST["username"]) < 1 || strlen($_POST["email"]) < 1 || strlen($_POST["name"]) < 1 || strlen($_POST["address"]) < 1  ){
		header("Location: accountActions.php?msg=Edit fields empty!");
		exit();
	}

	$username = $_POST["username"];
	$email = $_POST["email"];
	$name = $_POST["name"];
	$address = $_POST["address"];
	$r = $customerController->updateInfo($username,$email,$name,$address);
	if($r){
		$r = "Customer information edited";
		$_SESSION["username"] = $username;
		$_SESSION["email"] = $email;
		$_SESSION["name"] = $name;
		$_SESSION["address"] = $address;
	}else{
		$r = "error";
	}
	header("Location: accountActions.php?msg=".$r);
	exit();
}

if( isset($_POST["btnChangePassword"]) ){

	if( !isset($_POST["oldPassword"]) || !isset($_POST["newPassword"]) ){
		header("Location: accountActions.php?msg=Empty post.#changePassword");
		exit();
	}
	if( strlen($_POST["oldPassword"]) < 1 || strlen($_POST["newPassword"]) < 1 ){
		header("Location: accountActions.php?msg=Please provide old and new password for changing.!#changePassword");
		exit();
	}
	$newPassword = $_POST["newPassword"];
	$oldPassword = $_POST["oldPassword"];

	$r = $customerController->updatePassword($newPassword,$oldPassword);

	if ($r) {
		$r = "Password changed sucessfully.";
	}else{
		$r = "Old password is incorrect.";
	}

	header("Location: accountActions.php?msg=".$r."#changePassword");
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
				<small style="color: #fff;background-color: #444;padding: 0 5px 0 5px;">Edit Account / Change Password </small>
			</div>

			<div id="viewCustomers">

				<form method="POST" action="accountActions.php" class="accountActions" id="editAccount">
					<h2 style="border-bottom: 1px solid #eee;padding: 0 0 10px 0;box-sizing: border-box;">Edit Account</h2><br>
						
					<label>
						<span>Username</span><br>
						<input type="text" name="username" placeholder="Username..." class="full" value="<?php echo $_SESSION['username']; ?>">
					</label>

					<label>
						<span>Email</span><br>
						<input type="text" name="email" placeholder="Email..." class="full" value="<?php echo $_SESSION['email']; ?>">
					</label>

					<label>
						<span>Name</span><br>
						<input type="text" name="name" placeholder="Name..." class="full" value="<?php echo $_SESSION['name']; ?>">
					</label>

					<label>
						<span>Address</span><br>
						<input type="text" name="address" placeholder="Address..." class="full" value="<?php echo $_SESSION['address']; ?>">
					</label>

					<button class="r" style="margin-top: 20px;" name="btnEditAccount" type="submit">Edit</button>
					<a href="index.php" class="btn-simple">Cancel</a>
				</form>

				<form method="POST" action="accountActions.php" class="accountActions" id="changePassword">
					<h2 style="border-bottom: 1px solid #eee;padding: 0 0 10px 0;box-sizing: border-box;">Change Password</h2><br>
						
					<label>
						<span>Old Password</span><br>
						<input type="text" name="oldPassword" placeholder="Old Password..." class="full" autocomplete="off">
					</label>

					<label>
						<span>New Password</span><br>
						<input type="text" name="newPassword" placeholder="New Password..." class="full">
					</label>

					<button class="r" style="margin-top: 20px;" name="btnChangePassword" type="submit">Change</button>
					<a href="index.php" class="btn-simple">Cancel</a>
				</form>

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
	if (window.location.hash == "#changePassword") {
		document.getElementById("editAccount").style.display = "none";
		document.getElementById("changePassword").style.display = "block";
	}else{
		document.getElementById("changePassword").style.display = "none";
	}
</script>

</body>
</html>