<?php

// connect the MySQL database
$DB_USER = "feckr1";
$DB_PASSWORD = "3#lyugOm";

$database = new PDO('mysql:host=csweb.hh.nku.edu;dbname=db_fall18_feckr1',
$DB_USER,
$DB_PASSWORD);

//include functions
include('functions.php');

// autoload classes
function my_autoloader($class) {
    include('../classes/class.' . $class . '.php');
    }
    
spl_autoload_register('my_autoloader');


// start the session
session_start();



$current_url = basename($_SERVER['REQUEST_URI']);


// if session key adminID is set get $admin from the database
if (isset($_SESSION["adminID"])) {
	$sql = file_get_contents('../sql/getAdmin.sql');
    $params = array(
	   'adminID' => $_SESSION['adminID']
    );
    $statement = $database->prepare($sql);
    $statement->execute($params);
    $userArray = $statement->fetchAll(PDO::FETCH_ASSOC);
    $user = $userArray[0];
}

// if session key userID is set get $user from the database
if (isset($_SESSION["userID"])) {
	$sql = file_get_contents('../sql/getUser.sql');
    $params = array(
	   'userID' => $_SESSION['userID']
    );
    $statement = $database->prepare($sql);
    $statement->execute($params);
    $userArray = $statement->fetchAll(PDO::FETCH_ASSOC);
    $user = $userArray[0];
    
    
    // if userID set and cart is not already set, create a new Cart object
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = new Cart();
    }
}

// if there is no customer or admin logged in, redirect to login page before allowing access to cart
if (!isset($_SESSION["userID"])  && !isset($_SESSION["adminID"]) && $current_url == "cart.php") {
    header("Location: login.php");
    die();
}


