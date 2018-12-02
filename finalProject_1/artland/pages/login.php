<?php

// include config
include('config.php');

// if form submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	
	$username = $_POST['username'];
	$password = $_POST['password'];
	
	// find the user that has matching username and password
	$sql = file_get_contents('../sql/login.sql');
	$params = array(
		'username' => $username,
		'password' => $password
	);
	$statement = $database->prepare($sql);
	$statement->execute($params);
	$users = $statement->fetchAll(PDO::FETCH_ASSOC);
	

	if(!empty($users)) {
		$user = $users[0];
		
        // set a session variable with a key of either adminID or userID
        // if there is an adminID, set the user as an admin
        if(!empty($user['adminID'])) {
		  $_SESSION['adminID'] = $user['adminID'];
        }
        else {
		   $_SESSION['userID'] = $user['userID'];
        }
		// redirect to the gallery.php file
		header('location: gallery.php');
        die();
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
<title>Artland | Pages | Login</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<link href="../layout/styles/layout.css" rel="stylesheet" type="text/css" media="all">
</head>
<body id="top">
<!-- ################################################################################################ -->

<!-- Top Background Image Wrapper -->
<div class="bgded overlay" style="background-image:url('../images/bg.jpg');"> 
  <!-- ################################################################################################ -->
  <div class="wrapper row1">
    <header id="header" class="hoc clear"> 
      <!-- ################################################################################################ -->
      <div id="logo" class="fl_left">
        <h1><a href="gallery.phpl">Artland</a></h1>
      </div>
      <nav id="mainav" class="fl_right">
        <ul class="clear">
          <li><a href="gallery.php">Home</a></li>
            <li><a href="gallery.php">Gallery</a></li>
            <li><a href="cart.php">Cart</a></li>
          <li class="active"><a href="login.php">Log In</a></li>
        </ul>
      </nav>
      <!-- ################################################################################################ -->
    </header>
  </div>
  <!-- ################################################################################################ -->

  <div id="breadcrumb" class="hoc clear"> 
    <!-- ################################################################################################ -->
    
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
      <!-- ################################################################################################ -->
      <h1>Login</h1>
      
      
      <div id="comments">
        <form method="post">
          <div class="one_third first">
            <input type="text" name="username" placeholder="Username" />
          </div>
          <div class="one_third">
            <input type="password" name="password" placeholder="Password" />
          </div>
          <div class="block clear">
          </div>
          <div>
            <input type="submit" value="Log In" />
          </div>
        </form>
      </div>
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
>
<a id="backtotop" href="#top"><i class="fa fa-chevron-up"></i></a>
<!-- JAVASCRIPTS -->
<script src="../layout/scripts/jquery.min.js"></script>
<script src="../layout/scripts/jquery.backtotop.js"></script>
<script src="../layout/scripts/jquery.mobilemenu.js"></script>
</body>
</html>