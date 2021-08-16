<?php
// search the database for stocks by this id
require_once(__DIR__ . '/../scripts/connect.php');

// establish our db connection
$db = new MySQLDatabase();
$db->connect();

// create the iterator to traverse our stock directory
$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator(__DIR__ . "/../public/stock"), RecursiveIteratorIterator::SELF_FIRST );

$db->query("DROP TABLE IF EXISTS stock");

$db->query("
    CREATE TABLE IF NOT EXISTS stock (
        stock_id varchar(40) NOT NULL,
        stock_name varchar(40) NOT NULL,
        image_path varchar(80) NOT NULL,
        stock_story varchar(40) DEFAULT NULL,
        image_large varchar(80) NOT NULL,
        in_stock int(11) DEFAULT NULL,
        PRIMARY KEY (stock_id)
    ) ENGINE=InnoDB DEFAULT CHARSET=latin1;
");

// first delete all rows in table
$db->query("DELETE FROM stock");

function endsWith( $haystack, $needle) {
    return $needle === "" || (substr($haystack, -strlen($needle)) === $needle);
}

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
    print($imagePath . PHP_EOL);
    $stockId = substr($stockFileName, 0, strlen($stockFileName) - 4);

    // insert into the database
    $inStock = '1';
    $query = $db->link->prepare("INSERT INTO stock (stock_id, stock_name, image_path, stock_story, image_large, in_stock) VALUES (?, ?, ?, ?, ?, ?)");
    $query->bind_param("ssssss", $stockId, $stockName, $imageDir, $stockStory, $imageDir, $inStock);
    $query->execute();
}

$db->disconnect();
echo 'done';
?>