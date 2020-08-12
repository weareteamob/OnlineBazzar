<?php
session_start();
if( !isset($_SESSION["username"]) ){
	header("Location: index.php");
	exit();
} 
$_SESSION = array();

$msg = "Logged out";
if ( isset($_GET["msg"]) ) {
	$msg = $_GET["msg"];
}

if ( session_destroy() ) {
	header("Location: index.php?msg=".$msg);
	exit();
}else{
	echo "Logout error";
}

?>