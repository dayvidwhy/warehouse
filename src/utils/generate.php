<?php
$traversal = new traversal();
$imageData = $traversal->getStockImages();

// establish our db connection
$database = new database();
$database->addStocks($imageData);
?>