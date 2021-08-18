<?php
require_once(__DIR__ . "/../utils/database.php");
require_once(__DIR__ . "/../utils/traversal.php");

$traversal = new Traversal();
$imageData = $traversal->getStockImages();

// establish our db connection
$database = new Database();
$database->addStocks($imageData);
?>