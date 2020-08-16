<?php 
require 'controllers/session.php';

if ( !$loggedIn ) {
	header("Location: index.php?msg=Please Login");
	exit();
}
include 'controllers/customer.php';
$customerController = new CustomerController();

if( isset($_GET["delete"]) ){

	if ( $customerController->deleteAccount() ) {
		header("Location: lout.php?msg=Account deleted successfully.");
		exit();	
	}else{
		header("Location: index.php?msg=Error while deleting account!");
		exit();
	}

} 


?>