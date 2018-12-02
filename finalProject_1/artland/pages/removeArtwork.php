<?php

include('config.php');

// get the artwork ID from the url
$artworkID = get('artworkID');

$sql = file_get_contents('../sql/removeArtwork.sql');
        $params = array( 
            'artworkID' => $artworkID,
            
        );
        $statement = $database->prepare($sql);
        $statement->execute($params);

$sql = file_get_contents('../sql/removeArtistPiece.sql');
        $params = array( 
            'artworkID' => $artworkID,
            
        );
        $statement = $database->prepare($sql);
        $statement->execute($params);

header('location: gallery.php');
die();

?>
