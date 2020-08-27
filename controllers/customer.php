<?php 
include 'connection.php';
class CustomerController extends Connection{

	public function __construct(){
		$this->connect();
	}

	public function deleteAccount(){
		$q = "DELETE FROM customers WHERE id = ?";
		$qs = $this->conn->prepare($q);
		$qs->bind_param("i",$_SESSION["userid"]);
		$r = $qs->execute();
		$qs->close();
		return $r;
	}

	public function updateInfo($username,$email,$name,$address){
		$q = "UPDATE `customers` SET `username` = ?, email = ?,name = ?,address = ? WHERE id = ?";
		$qs = $this->conn->prepare($q);
		$qs->bind_param("ssssi",$username,$email,$name,$address,$_SESSION["userid"]);
		$r = $qs->execute();
		$qs->close();
		return $r;
	}

	public function updatePassword($newPassword,$oldPassword){
		$q = "UPDATE `customers` SET `password` = ? WHERE id = ? AND password = ?";
		$qs = $this->conn->prepare($q);
		$qs->bind_param("sis",md5($newPassword),$_SESSION["userid"],md5($oldPassword));
		$r = $qs->execute();
		$qs->close();
		return $this->conn->affected_rows;
	}

	public function getAllCustomers(){
		$r = array();
		$query = "SELECT * FROM customers";
		$st = $this->conn->prepare($query);

		if ( $st->execute() ){
			$st->store_result();
			$st->bind_result($dbUid,$dbUn,$dbPs,$dbEmail,$dbName,$dbAddress);

			if ( $st->num_rows < 1 ) {
				$r[0] = "No customers found.";
			}else{
				$r[0] = "found";
				$r[1] = array();
				while( $st->fetch() ){
					array_push($r[1],array($dbUid,$dbUn,$dbEmail,$dbName,$dbAddress));
				}
			}

		}else{
			$r = "Error";
		}
		return $r;
	}

}

?>