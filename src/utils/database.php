<?php
class Database {
    // store a reference to our database
    var $link;

    // connect to the database
    function connect() {
        $this->link = new mysqli("db", $_ENV["DB_USERNAME"], $_ENV["DB_PASSWORD"]);
        if ($this->link -> connect_errno) {
            echo "Database connection failed: " . $mysqli -> connect_error;
            exit();
        }
        $this->link->query("CREATE DATABASE IF NOT EXISTS " . $_ENV["DB_DATABASE"]);
        $this->link->select_db($_ENV["DB_DATABASE"]);
        return $this->link;
    }

    // accepts sql query
    function query ($query) {
        $this->link->query($query);
    }

    // reproduce the stock table with correct format
    function recreateStockTable () {
        $this->link->query("DROP TABLE IF EXISTS stock");
        $this->link->query("
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
    }

    function addStock ($stockId, $stockName, $imageDir, $stockStory, $inStock) {
        $query = $this->link->prepare("INSERT INTO stock (stock_id, stock_name, image_path, stock_story, image_large, in_stock) VALUES (?, ?, ?, ?, ?, ?)");
        $query->bind_param("ssssss", $stockId, $stockName, $imageDir, $stockStory, $imageDir, $inStock);
        $query->execute();
    }

    // close the database
    function disconnect() {
        $this->link->close();
    }
}
?>