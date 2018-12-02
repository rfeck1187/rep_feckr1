SELECT *
FROM artworks
INNER JOIN artistPieces on artistPieces.artworkID = artworks.artworkID
INNER JOIN artists on artists.artistID = artistPieces.artistID
WHERE artworks.artworkID = :artworkID;
