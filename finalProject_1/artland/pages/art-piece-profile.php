<?php

// include config
include('config.php');

// get action
$action = $_GET['action'];

// get the artwork ID from the url
$artworkID = get('artworkID');

$artPiece = null;


// if the artworkID is not null get a list of art pieces from the database with the ID
if(!empty($artworkID)) {
    $sql = file_get_contents('../sql/get-piece-by-artworkID.sql');
    $params = array(
	   'artworkID' => $artworkID
    );
    $statement = $database->prepare($sql);
    $statement->execute($params);
    $artworks = $statement->fetchAll(PDO::FETCH_ASSOC);

// set $artworks equal to first piece in $artworks
    $artPiece = $artworks[0];
}

// get array of products
$sql = file_get_contents('../sql/getProducts.sql');
$statement = $database->prepare($sql);
$statement->execute();
$products = $statement->fetchAll(PDO::FETCH_ASSOC);

// get all the item info from cart class
$cart = &$_SESSION['cart'];

// if form submitted
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    
    
    if($action == "add" || $action == "edit") {
        $quantity = $_POST['quantity'];
        $productID = $_POST['productID'];
        $cart = &$_SESSION['cart'];
        $cart->addToCart($artworkID, $quantity, $productID, $database);
        $_SESSION['cart'] = &$cart;
    }

}

?>

<!DOCTYPE html>
<!--
Template Name: Artland
Author: <a href="http://www.os-templates.com/">OS Templates</a>
Author URI: http://www.os-templates.com/
Licence: Free to use under our free template licence terms
Licence URI: http://www.os-templates.com/template-terms
-->
<html>
<head>
<title>Artland | Pages | Art Piece</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<link href="../layout/styles/layout.css" rel="stylesheet" type="text/css" media="all">
</head>
<body id="top">

<!-- Top Background Image Wrapper -->
<div class="bgded overlay" style="background-image:url('../images/bg.jpg');"> 
  <!-- ################################################################################################ -->
  <div class="wrapper row1">
    <header id="header" class="hoc clear"> 
      <!-- ################################################################################################ -->
      <div id="logo" class="fl_left">
        <h1><a href="gallery.php">Artland</a></h1>
      </div>
      <nav id="mainav" class="fl_right">
        <ul class="clear">
          <li><a href="">Home</a></li>
            <li class="active"><a href="gallery.php">Gallery</a></li>
            <li><a href="cart.php">Cart</a></li>
          <li>
              <?php if (!isset($_SESSION["adminID"]) && !isset($_SESSION["userID"])) : ?>
               <a href="login.php">
                Log In
              </a>
              <?php else :?>
               <a href="logout.php">
                Log Out
              </a>
              <?php endif; ?>
              </li>
        </ul>
      </nav>
      <!-- ################################################################################################ -->
    </header>
  </div>
  <!-- ################################################################################################ -->

  <div id="breadcrumb" class="hoc clear"> 
    <!-- ################################################################################################ -->
    <ul>
      <li><a href="gallery.php">Home</a></li>
        <li><a href="gallery.php#">Gallery</a></li>
      <li><a href="#">Artwork</a></li>
      
    </ul>
    <!-- ################################################################################################ -->
  </div>
  <!-- ################################################################################################ -->
</div>
<!-- End Top Background Image Wrapper -->

<div class="wrapper row3">
  <main class="hoc container clear"> 
    <!-- main body -->
    <!-- ################################################################################################ -->
    <div class="content"> 

            <h1><?php echo $artPiece['title']; ?></h1>
            <img class="imgl borderedbox inspace-5" src="<?php echo $artPiece['imageSource']; ?>" alt="">
            <p style="font-size: 18px;">Artist: <?php echo $artPiece['name']; ?></p>
            <p style="font-size: 18px;">Date: <?php echo $artPiece['date']; ?></p>
            <p style="font-size: 18px;">Medium: <?php echo $artPiece['medium']; ?></p>
            <p style="font-size: 18px;">Housed: <?php echo $artPiece['location']; ?></p>
            
            <?php if(isset($_SESSION["userID"])) : ?>
                <form action="" method="POST">
                <div class="form-element">
				  
                <?php if($action == "add") : ?>
                    <input type="hidden" value="<?php echo $artPiece['artworkID']; ?>" />
                    <p>Product: </p>  
                    <select required name="productID">
                    <option value="" selected disabled>Select</option>
                    <?php foreach($products as $product) : ?>
                        <option  value="<?php echo $product['productID']; ?>" ><?php echo $product['productName']; ?> - $<?php echo $product['price']; ?></option>
                    <?php endforeach; ?>
                    </select>
                    <br/>
                    <input type="text" name="quantity" value="" placeholder="Quantity" />
                    </div> 
                    <br />
                    <div class="form-element">
                    <input type="submit" value="Add to Cart"/>
                    </div>
                    
                <?php elseif($action == "edit") : ?>
                    <?php foreach($cart as $artworkID => $item) : ?>
                        <?php if($item['artworkID'] == $artPiece['artworkID']) : ?>
                            <input type="hidden" value="<?php echo $artworkID; ?>" />
                            <p>Product: </p>  
                            <select required name="productID">
                            <option value="<?php echo $item['productID']; ?>" selected><?php echo $item['productName']; ?></option>
                            <?php foreach($products as $product) : ?>
                                <?php if($product['productID'] != $item['productID']) : ?>
                                    <option  value="<?php echo $product['productID']; ?>" ><?php echo $product['productName']; ?> - $<?php echo $product['price']; ?></option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                            </select>
                            <br/>
                            <input type="text" name="quantity" value="" placeholder="<?php echo $item['quantity']; ?>" />
                        <?php endif; ?>
                    <?php endforeach; ?>
                    <br />
                    <div class="form-element">
                    <input type="submit" value="Submit Edit"/>
                    </div>
                <?php endif; ?>
                    
                </form>
                <br />
                <a href="cart.php">View my Cart</a>
            <?php endif; ?>

      <!-- ################################################################################################ -->
    </div>
    <!-- ################################################################################################ -->
    <!-- / main body -->
    <div class="clear"></div>
  </main>
</div>
<!-- ################################################################################################ -->

<div class="wrapper row4 bgded overlay" style="background-image:url('../images/bg-bottom.jpg');">
  <footer id="footer" class="hoc clear"> 
    
    <div class="one_third first">
      <h6 class="heading">Artland</h6>
      <nav>
        <ul class="nospace">
          <li><a href="gallery.php"><i class="fa fa-lg fa-home"></i></a></li>
          <li><a href="#">About</a></li>
          <li><a href="#">Contact</a></li>
          <li><a href="#">Terms</a></li>
          <li><a href="#">Privacy</a></li>
          <li><a href="#">Cookies</a></li>
          <li><a href="#">Disclaimer</a></li>
        </ul>
      </nav>
      <p>Find us on social media.</p>
      <ul class="faico clear">
        <li><a class="faicon-facebook" href="#"><i class="fa fa-facebook"></i></a></li>
        <li><a class="faicon-twitter" href="#"><i class="fa fa-twitter"></i></a></li>
        <li><a class="faicon-dribble" href="#"><i class="fa fa-dribbble"></i></a></li>
        <li><a class="faicon-linkedin" href="#"><i class="fa fa-linkedin"></i></a></li>
        <li><a class="faicon-google-plus" href="#"><i class="fa fa-google-plus"></i></a></li>
        <li><a class="faicon-vk" href="#"><i class="fa fa-vk"></i></a></li>
      </ul>
    </div>
    <div class="one_third">
      <h6 class="heading">Contact Info</h6>
      <ul class="nospace linklist contact">
        <li><i class="fa fa-map-marker"></i>
          <address>
          Street Name &amp; Number, Town, Postcode/Zip
          </address>
        </li>
        <li><i class="fa fa-phone"></i> +00 (123) 456 7890</li>
        <li><i class="fa fa-fax"></i> +00 (123) 456 7890</li>
        <li><i class="fa fa-envelope-o"></i> info@domain.com</li>
      </ul>
    </div>
    <div class="one_third">
      <h6 class="heading">Recent Updates</h6>
      <ul class="nospace linklist">
        <li>
          <article>
            <h2 class="nospace font-x1"><a href="#">Imperdiet a auctor odio</a></h2>
            <time class="font-xs block btmspace-10" datetime="2018-04-06">Friday, 6<sup>th</sup> April 2045</time>
            <p class="nospace">Tristique orci ut malesuada fermentum quam non sed eget sagittis mi [&hellip;]</p>
          </article>
        </li>
        <li>
          <article>
            <h2 class="nospace font-x1"><a href="#">Vehicula aliquam ornare</a></h2>
            <time class="font-xs block btmspace-10" datetime="2018-04-05">Thursday, 5<sup>th</sup> April 2045</time>
            <p class="nospace">Vivamus luctus nec eros nec tincidunt donec at sagittis nisi in id massa [&hellip;]</p>
          </article>
        </li>
      </ul>
    </div>
    <!-- ################################################################################################ -->
  </footer>
</div>
<!-- ################################################################################################ -->
<div class="wrapper row5">
  <div id="copyright" class="hoc clear"> 
    <!-- ################################################################################################ -->
    <p class="fl_left">Copyright &copy; 2018 - All Rights Reserved</p>
    <p class="fl_right">Template by <a target="_blank" href="http://www.os-templates.com/" title="Free Website Templates">OS Templates</a></p>
    <!-- ################################################################################################ -->
  </div>
</div>
<!-- ################################################################################################ -->

<a id="backtotop" href="#top"><i class="fa fa-chevron-up"></i></a>
<!-- JAVASCRIPTS -->
<script src="../layout/scripts/jquery.min.js"></script>
<script src="../layout/scripts/jquery.backtotop.js"></script>
<script src="../layout/scripts/jquery.mobilemenu.js"></script>
</body>
</html>