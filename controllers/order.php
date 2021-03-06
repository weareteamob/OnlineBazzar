<?php 
include 'connection.php';
class Order extends Connection{

	public function __construct(){
		$this->connect();
	}

	public function addToOrderCart($productId,$quantity){
		$query = "INSERT INTO `order_cart`(`customer_id`, `product_id`, `quantity`) VALUES (?,?,?)";
		$st = $this->conn->prepare($query);
		$st->bind_param("iii",$a,$b,$c);

		$a = $_SESSION["userid"];
		$b = $productId;
		$c = $quantity;

		if ( $st->execute() ){
			$rt = "ok";
		}else{
			$rt = "error";
		}
		return $rt;
	}

	public function getMyOrderCart(){
		$r = array();
		$query = "SELECT oc.id,oc.product_id,quantity,description,verified,title,price,image,category,trademark FROM order_cart oc,products p WHERE oc.product_id = p.id AND oc.customer_id = ? ORDER BY oc.id DESC";
		$st = $this->conn->prepare($query);
		$st->bind_param("i",$sid);
		$sid = $_SESSION["userid"];

		if ( $st->execute() ){
			$st->store_result();
			$st->bind_result($orderId,$productId,$quantity,$description,$verified,$title,$price,$image,$category,$trademark);

			if ( $st->num_rows < 1 ) {
				$r[0] = "noOrder";
			}else{
				$r[0] = "ok";
				$r[1] = array();
				while( $st->fetch() ){

					$product = new Product();
					$product->setId($productId);
					$product->setDescription($description);
					$product->setTitle($title);
					$product->setPrice($price);
					$product->setImage($image);
					$product->setCategory($category);
					$product->setTrademark($trademark);

					array_push($r[1],array($product,$quantity,$verified,$orderId));
				}
			}

		}else{
			$r[0] = "Error";
		}
		$st->close();
		return $r;
	}


	public function verifyOrder($orderId){
		$q = "UPDATE `order_cart` SET `verified` = 'true' WHERE id = ?";
		$qs = $this->conn->prepare($q);
		$qs->bind_param("i",$orderId);
		$r = $qs->execute();
		return $r;
	}

	public function deleteOrder($orderId){
		$q = "DELETE FROM `order_cart` WHERE id = ?";
		$qs = $this->conn->prepare($q);
		$qs->bind_param("i",$orderId);
		$r = $qs->execute();
		$qs->close();
		return $r;
	}


}

?>