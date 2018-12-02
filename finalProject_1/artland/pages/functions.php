<?php 
    
    function searchArt($term, $database) {
	// search by artist name
	$term = '%' . $term . '%';
	$sql = file_get_contents('../sql/get-artworks-by-artistID.sql');
	$params = array(
		'term' => $term
	);
	$statement = $database->prepare($sql);
	$statement->execute($params);
	$artworks = $statement->fetchAll(PDO::FETCH_ASSOC);
	return $artworks; 
}


function get($key) {
	if(isset($_GET[$key])) {
		return $_GET[$key];
	}
	
	else {
		return '';
	}
}
 
?>