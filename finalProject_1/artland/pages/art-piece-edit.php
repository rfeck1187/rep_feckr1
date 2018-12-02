<?php

// include config
include('config.php');

// get action
$action = $_GET['action'];

// get the artworkID from the url
$artworkID = get('artworkID');

$artPiece = null;

// if the artworkID is not null get a list of art pieces from the database with the ID passed in the URL
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

// get array of artists
$sql = file_get_contents('../sql/getArtists.sql');
$statement = $database->prepare($sql);
$statement->execute();
$artists = $statement->fetchAll(PDO::FETCH_ASSOC);


// if form submitted
if ($_SERVER['REQUEST_METHOD'] == "POST") {
	   $artworkID = $_POST['artworkID'];
        $title = $_POST['title'];
	    $imageSource = $_POST['imageSource'];
	    $date = $_POST['date'];
        $medium = $_POST['medium'];
        $location = $_POST['location'];
	
	if ($action == "edit") {
		$sql = file_get_contents('../sql/updateArtwork.sql');
        $params = array( 
            'artworkID' => $artworkID,
			'title' => $title,
			'imageSource' => $imageSource,
            'date' => $date,
            'medium' => $medium,
            'location' => $location,
            
        );
        $statement = $database->prepare($sql);
        $statement->execute($params); 	
	}
	
    elseif($action == "add") {
        $artistID = $_POST['artistID'];
        
		// insert new art piece
		$sql = file_get_contents('../sql/insertArtwork.sql');
		$params = array(
			'artworkID' => $artworkID,
			'title' => $title,
            'date' => $date,
            'medium' => $medium,
            'imageSource' => $imageSource,
            'location' => $location
            
		);
		$statement = $database->prepare($sql);
		$statement->execute($params);
		
		// set the info for artPieces
		$sql = file_get_contents('../sql/insertArtPiece.sql');
            $params = array(
                'artworkID' => $artworkID,
				'artistID' => $artistID
            );
        $statement = $database->prepare($sql);
        $statement->execute($params);
	}
	// redirect to gallery
	header('location: gallery.php');
    die();
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
<title>Artland | Pages | Edit</title>
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
          <li><a href="gallery.php">Home</a></li>
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
      <li><a href="#">Home</a></li>
        <li><a href="gallery.php#">Gallery</a></li>
      <li><a href="#">Artwork</a></li>
      
    </ul>
    <!-- ################################################################################################ -->
  </div>
  <!-- ################################################################################################ -->
</div>
<!-- End Top Background Image Wrapper -->
<!-- ################################################################################################ -->

<div class="wrapper row3">
  <main class="hoc container clear"> 
    <!-- main body -->
    <!-- ################################################################################################ -->
    <div class="content"> 
      <!--  -->
        <form action="" method="POST">
        
            <?php if($action == 'add') :?>
                <h1>Add Piece</h1> 
                <p style="font-size: 18px;">Artwork ID</p><input required type="text" name="artworkID" />
                <p style="font-size: 18px;">Title: </p><input required type="text" name="title" />
                <p style="font-size: 18px;">Image Source: </p><input required type="text" name="imageSource"  />
                <p style="font-size: 18px;">Artist Name: </p>
                <select required name="artistID">
                    <option value="" selected disabled>Select</option>
                    <?php foreach($artists as $artist) : ?>
                        <option  value="<?php echo $artist['artistID']; ?>" ><?php echo $artist['name']; ?></option>
                    <?php endforeach; ?>
                </select>
                <p style="font-size: 18px;">Date Created: </p><input required type="text" name="date" />
                <p style="font-size: 18px;">Medium: </p><input required type="text" name="medium"  />
                <p style="font-size: 18px;">Current Location: </p><input required type="text" name="location" />
            
            <?php elseif($action == 'edit') :?>
                <h1>Manage Piece</h1>
                <p style="font-size: 18px;">Artwork ID: <input readonly type="text" name="artworkID" value="<?php echo $artPiece['artworkID']; ?>" /><p>
                <p style="font-size: 18px;">Title: <input type="text" name="title" value="<?php echo $artPiece['title']; ?>" /></p>
                <p style="font-size: 18px;">Image Source: <input type="text" name="imageSource" value="<?php echo $artPiece['imageSource']; ?>" /></p>
                <img class="imgl borderedbox inspace-5" src="<?php echo $artPiece['imageSource']; ?>" alt="">
                <p style="font-size: 18px;">Artist: <input readonly type="text" name="name" value="<?php echo $artPiece['name']; ?>" /></p>
                <p style="font-size: 18px;">Date: <input type="text" name="date" value="<?php echo $artPiece['date']; ?>" /></p>
                <p style="font-size: 18px;">Medium: <input type="text" name="medium" value="<?php echo $artPiece['medium']; ?>" /></p>
                <p style="font-size: 18px;">Housed:<input type="text" name="location" value="<?php echo $artPiece['location']; ?>" /></p>
    
            <?php endif; ?>
            &nbsp;
        <input type="submit">
            &nbsp;
        <input type="reset">
            <br />
        <?php if($action == 'edit') :?>
            <a href="removeArtwork.php?artworkID=<?php echo $artworkID; ?>" style="font-size:1.5em;" >Delete Piece</a>
        <?php endif; ?>
        </form>

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