<?php
// search the database for stocks by this id
require_once(__DIR__ . "/../utils/strings.php");

// create the iterator to traverse our stock directory
$directory = new RecursiveDirectoryIterator(__DIR__ . "/../public/stock");
$iterator = new RecursiveIteratorIterator($directory, RecursiveIteratorIterator::SELF_FIRST);

$imageData = array();
foreach ($iterator as $path) {
    // skip directories
    if ($path->isDir()) continue;

    // found an image, get the string
    $imagePath = $path->__toString();
    $imagePath = substr($imagePath, strpos($imagePath, ".."));

    // pieces of the directory
    $dirSplit = explode('/', $imagePath);

    // the name of the stock or range
    $stockName = $dirSplit[3];

    // the potential story of name
    $stockStory = "";

    // where image is stored
    $imageDir = "";

    // file name or id
    $stockFileName = "";

    if (sizeof($dirSplit) == 5) {
        $stockStory = $stockName;
        $stockFileName = $dirSplit[4];
        $imageDir = 'stock/' . $stockName . '/' . $stockFileName;
    } else if (sizeof($dirSplit) == 6) {
        $stockStory = $dirSplit[4];
        $stockFileName = $dirSplit[5];
        $imageDir = 'stock/' . $stockName . '/' . $stockStory . '/' . $stockFileName;
    }

    // stock id is the filename minus the file extension
    if (!endsWith($stockFileName, ".png") && !endsWith($stockFileName, ".jpg")) continue;

    $stockId = substr($stockFileName, 0, strlen($stockFileName) - 4);

    // insert into the database
    $inStock = '1';
    array_push($imageData, [$stockId, $stockName, $imageDir, $stockStory, $inStock]);
}

// establish our db connection
$database = new Database();
$database->addStocks($imageData);
?>