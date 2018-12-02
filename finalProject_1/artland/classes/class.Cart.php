<?php
    // define the class and implement interator
class Cart implements iterator {
    public $item;
    protected $database;
    
    // putting $database in the construct throws a PDO serialize/unserialize exception. Leaving DB out does not throw an error when adding to cart or listing the cart items on cart.php
    function __construct() {
    }
    
    // get the artworkID of the piece and the itemID of the product they selected
    function addToCart($artworkID, $quantity, $productID, $database) {
        
        
        $sql = file_get_contents('../sql/get-product-by-ID.sql');
	    $params = array(
		   'productID' => $productID
	    );
	    $statement = $database->prepare($sql);
	    $statement->execute($params);
	    $products = $statement->fetchAll(PDO::FETCH_ASSOC);
	    $product = $products[0];
        
        $sql = file_get_contents('../sql/get-piece-by-artworkID.sql');
	    $params = array(
		   'artworkID' => $artworkID
	    );
	    $statement = $database->prepare($sql);
	    $statement->execute($params);
	    $artworks = $statement->fetchAll(PDO::FETCH_ASSOC);
	    $artPiece = $artworks[0];
        
        // indexed by artworkID, meaning each artwork can only have 1 product assigned to it. To have multiple products assigned to one piece, build an orders and order_items table and use orderID as index and the order_items table to get the corresponding items
        $this->item[$artworkID] = array (
                'artworkID' => $artworkID,
                'productID' => $productID, 
                'imageSource' => $artPiece['imageSource'],
                'productName' => $product['productName'],
                'quantity' => $quantity,
                'price' => $product['price']
              );
       
    }
    
    // get item
    public function getItem() {
        return $this->item;
    }
    
    // iterator methods
    public function rewind() {
        reset($this->item);
    }
    public function current() {
        return current($this->item);
    }
    public function key() {
        return key($this->item);
    }
    public function next() {
        return next($this->item);
    }
    public function valid() {
        $key = key($this->item);
        return ($key !== NULL && $key !== FALSE);
    }
    
}
?>