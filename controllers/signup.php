<?php 
include 'connection.php';
include 'models/customer.php';

class SignUp extends Connection{

	public function __construct(){
		$this->connect();
	}

	public function signUp($customer){

		$usernameAvailable = false;

		$c = "SELECT id FROM customers WHERE username = ?";
		$sc = $this->conn->prepare($c);
		$sc->bind_param("s",$customer->getUsername());

		if ( $sc->execute() ) {
			$sc->store_result();

			if ( $sc->num_rows == 0 ) {
				$usernameAvailable = true;
			}
		}

		if ( $usernameAvailable ) {
			
			$query = "INSERT INTO `customers`(`username`, `password`, `email`, `name`, `address`) VALUES (?,?,?,?,?)";
			$st = $this->conn->prepare($query);
			$st->bind_param("sssss",$a,$b,$c,$d,$e);

			$a = $customer->getUsername();
			$b = $customer->getPassword();
			$c = $customer->getEmail();
			$d = $customer->getName();
			$e = $customer->getAddress();

			if ( $st->execute() ){
				$rt = "ok";
			}else{
				$rt = "error";
			}

		}else{
			$rt = "usernameTaken";
		}
		return $rt;

	}

}

	
if ( isset($_POST["btnRegister"]) ) {

	$returnValue = "";

	if ( isset($_POST["username"]) && isset($_POST["password"]) &&
		 isset($_POST["name"]) && isset($_POST["email"]) && isset($_POST["address"])
		) {

		$name = $_POST["name"];
		$emailAddress = $_POST["email"];
		$un = $_POST["username"];
		$ps = $_POST["password"];
		$address = $_POST["address"];

		if ( strlen($name) > 0 
			 && strlen($emailAddress) > 0 
			 && strlen($un) > 0 
			 && strlen($ps) > 0
			 && strlen($address) > 0
			) {
			
			if ( 
				 strlen($un) > 6 && strlen($ps) > 6
				) {

					$newCustomer = new Customer;

					$newCustomer->setEmail($emailAddress);
					$newCustomer->setName($name);
					$newCustomer->setUsername($un);
					$newCustomer->setPassword(md5($ps));
					$newCustomer->setAddress($address);

					$addMember = new SignUp();
					$returnValue = $addMember->signUp($newCustomer);

					if ( $returnValue == "ok" ) {
						$returnValue = "Registration successful. Please login to continue.";
					}
					if ( $returnValue == "error" ) {
						$returnValue = "Registration error.";
					}
					if ( $returnValue == "usernameTaken" ) {
						$returnValue = "Username already taken.";
					}

			}else{
				$returnValue = "Username and password must be at least 5 letters!";
			}

		}else{
			$returnValue = "Please enter all the fields.";
		}

	}else{
		$returnValue = "No Post values.";
	}

	header("Location: register.php?msg=".$returnValue."#register");
	exit();

}

?>