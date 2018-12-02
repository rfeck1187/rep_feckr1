
CREATE TABLE artworks
( artworkID INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  title CHAR(100) NOT NULL,
  date CHAR(30) NOT NULL,
  medium CHAR(50) NOT NULL,
  imageSource CHAR(100) NOT NULL
);

CREATE TABLE artists
(  artistID INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
   name CHAR(50),
   dob CHAR(100)
);

CREATE TABLE artistPieces
( artworkID INT NOT NULL,
  artistID INT NOT NULL,
  PRIMARY KEY (artworkID, artistID)
);

CREATE TABLE users
( userID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  adminID INT NULL,
  name CHAR(50) NOT NULL,
  username CHAR(50) NOT NULL,
  password CHAR(50) NOT NULL
);

CREATE TABLE products
( productID INT NOT NULL PRIMARY KEY,
  productName CHAR(50) NOT NULL,
  price DECIMAL NOT NULL
);

CREATE TABLE final_order_items
( orderID INT UNSIGNED NOT NULL PRIMARY KEY,
  productID INT UNSIGNED NOT NULL,
  artworkID INT UNSIGNED NOT NULL,
  quantity INT UNSIGNED NULL
);

CREATE TABLE final_orders
( orderID INT UNSIGNED NOT NULL,
  customerID  INT UNSIGNED NOT NULL,
  totalPrice FLOAT UNSIGNED NULL,
  date DATE NOT NULL
);



INSERT INTO artworks VALUES
  (NULL, "Almond Blossom", "1890", "Oil on canvas", "./images/almond-blossom.jpg"),
  (NULL, "Bridge over a Pond of Water Lilies", "1899", "Oil on canvas", "./images/bridge-over-a-pond-of-water-lilies.jpg"),
  (NULL, "Farm Garden with Sunflowers", "1913", "Oil on canvas", "./images/farm-garden-with-flowers.jpg"),
  (NULL, "Garden in Bloom", "1888", "Oil on canvas", "./images/garden-in-bloom-arles.jpg"),
  (NULL, "Irises", "1889", "Oil on canvas", "./images/irises.jpg"),
  (NULL, "Lilac in the Sun", "1872", "Oil on canvas", "./images/lilac-in-the-sun.jpg"),
  (NULL, "The Mulberry Tree", "1889", "Oil on canvas", "./images/mulberry-tree.jpg"),
  (NULL, "Cafe Terrace at Night", "1888", "Oil on canvas", "./images/night-cafe.jpg"),
  (NULL, "Nympheas at Giverny", "1908", "Oil on canvas", "./images/nympheas-at-giverny.jpg"),
  (NULL, "Sunflowers", "1888", "Oil on canvas", "./images/sunflowers.jpg"),
  (NULL, "The Birch Wood", "1903", "Oil on canvas", "./images/the-birch-wood.jpg"),
  (NULL, "The Kiss", "1908", "Oil on canvas", "./images/the-kiss.jpg"),
  (NULL, "Starry Night", "1889", "Oil on canvas", "./images/the-starry-night.jpg"),
  (NULL, "Undergrowth with Two Figures", "1890", "Oil on canvas", "./images/undergrowth-with-two-figures.jpg"),
  (NULL, "Waterlilies Morning with Weeping Willows", "Around 1915-1926", "Oil on canvas", "./images/waterlilies-morning-with-weeping-willows.jpg"),
  (NULL, "What Field with Cypresses", "1889", "Oil on canvas", "./images/wheat-field-with-cypresses.jpg");
  

INSERT INTO artists VALUES
  (NULL, "Vincent van Gogh", "March 30, 1853"),
  (NULL, "Claude Monet", "November 14, 1840"),
  (NULL, "Gustav Klimt", "July 14, 1862");

INSERT INTO users VALUES
  (NULL, 1, "John Doe", "admin1", "password1"),
  (NULL, NULL, "Hank Anderson", "customer1", "sumo");

INSERT INTO artistPieces VALUES
  (1, 1),
  (2, 2),
  (3, 3),
  (4, 1),
  (5, 1),
  (6, 2),
  (7, 1),
  (8, 1),
  (9, 2),
  (10, 1),
  (11, 3),
  (12, 3),
  (13, 1),
  (14, 1),
  (15, 2),
  (16, 1);
  
INSERT INTO products VALUES
  ( 1, "Notebook", 6.49),
  (2, "Coffee Mug", 7.99),
  (3, "Backpack", 24.99),
  (4, "Baseball Hat", 14.99);
  
  
