<?php


include('config.php');

session_destroy();

header('location: gallery.php');
die();
?>
