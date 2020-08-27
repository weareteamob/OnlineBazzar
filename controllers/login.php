<?php 
include 'connection.php';

class Login extends Connection{

	public function __construct(){
		$this->connect();
	}

	public function login($un,$ps){

		$r = "";
		$query = "SELECT * FROM customers WHERE username = ? AND password = ?";
		$st = $this->conn->prepare($query);
		$st->bind_param("ss",$usn,$pss);
		$usn = $un;
		$pss = md5($ps);

		if ( $st->execute() ){
			$st->store_result();
			$st->bind_result($dbUid,$dbUn,$dbPs,$dbEmail,$dbName,$dbAddress);

			if ( $st->num_rows < 1 ) {
				$r = " Username or password is incorrect!";
			}else{
				if( $st->fetch() ){
					
					$_SESSION["userid"] = $dbUid; 
					$_SESSION["username"] = $dbUn;
					$_SESSION["email"] = $dbEmail;
					$_SESSION["name"] = $dbName;
					$_SESSION["address"] = $dbAddress;
					$_SESSION["admin"] = false;

					if ( strtolower($dbUn) == "administrator" ) {
						$_SESSION["admin"] = true;
					}

					$r = "success";

				}
			}

		}else{
			$r = "Error";
		}
		return $r;
	}

}


if ( isset($_POST["btnLogin"]) ) {

	$returnValue = "";

	if ( isset($_POST["username"]) && isset($_POST["password"]) ) {

		$un = $_POST["username"];
		$ps = $_POST["password"];

		if ( strlen($un) > 6 && strlen($ps) > 6 ) {
			$loginUser = new Login();
			$returnValue = $loginUser->login($un,$ps);

			if ( $returnValue == "success" ) {
				header("Location: index.php?msg=Logged in");
				exit();
			}

		}else{
			$returnValue = "Enter username and password!";
		}

	}else{
		$returnValue = "Enter username and password!";
	}

	header("Location: login.php?msg=".$returnValue);
	exit();

}



?>