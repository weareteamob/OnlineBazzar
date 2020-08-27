<?php 
include 'connection.php';
include 'models/product.php';

class ProductController extends Connection{

	public function __construct(){
		$this->connect();
	}

	public function addProduct($product){
		$query = "INSERT INTO `products`(`description`, `title`, `price`, `image`, `category`, `trademark`) VALUES (?,?,?,?,?,?)";
		$st = $this->conn->prepare($query);
		$st->bind_param("ssisss",$a,$b,$c,$d,$e,$f);

		$a = $product->getDescription();
		$b = $product->getTitle();
		$c = $product->getPrice();
		$d = $product->getImage();
		$e = $product->getCategory();
		$f = $product->getTrademark();

		if ( $st->execute() ){
			$rt = "ok";
		}else{
			$rt = "error";
		}
		return $rt;
	}

	public function getProducts($where){
		$r = array();
		$query = "SELECT * FROM products WHERE ".$where;
		$st = $this->conn->prepare($query);

		if ( $st->execute() ){
			$st->store_result();
			$st->bind_result($id,$description,$title,$price,$image,$category,$trademark);

			if ( $st->num_rows < 1 ) {
				$r[0] = "noProducts";
			}else{
				$r[0] = "ok";
				$r[1] = array();
				while( $st->fetch() ){

					$product = new Product();
					$product->setId($id);
					$product->setDescription($description);
					$product->setTitle($title);
					$product->setPrice($price);
					$product->setImage($image);
					$product->setCategory($category);
					$product->setTrademark($trademark);

					array_push($r[1],$product);
				}
			}

		}else{
			$r[0] = "Error";
		}
		return $r;
	}


	public function updateProduct($productId,$updateTo,$updateColumn){
		$q = "UPDATE `products` SET ".$updateColumn." = '".$updateTo."' WHERE id = ?";
		$qs = $this->conn->prepare($q);
		$qs->bind_param("i",$productId);
		$r = $qs->execute();
		$qs->close();
		return $r;
	}

	public function deleteProduct($productId){
		$q = "DELETE FROM `products` WHERE id = ?";
		$qs = $this->conn->prepare($q);
		$qs->bind_param("i",$productId);
		$r = $qs->execute();
		$qs->close();
		return $r;
	}


}

?>