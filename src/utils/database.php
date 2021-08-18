<?php
class Database {
    // store a reference to our database
    var $link;

    // connect to the database
    function connect() {
        $this->link = new mysqli("db", $_ENV["DB_USERNAME"], $_ENV["DB_PASSWORD"]);
        
        // if the connection errored
        if ($this->link -> connect_errno) {
            echo "Database connection failed: " . $mysqli -> connect_error;
            exit();
        }
        return $this->link;
    }

    // select the database as the default for future queries
    function selectDatabase () {
        $this->link->select_db($_ENV["DB_DATABASE"]);
    }

    // create our default database
    function createDatabase () {
        $this->link->query("CREATE DATABASE IF NOT EXISTS " . $_ENV["DB_DATABASE"]);
    }

    // accepts sql query
    function query ($query): void {
        $this->link->query($query);
    }

    // reproduce the stock table with correct format
    function recreateStockTable (): void {
        $this->link->query("DROP TABLE IF EXISTS stock");
        $this->link->query(<<<EOL
            CREATE TABLE IF NOT EXISTS stock (
                stock_id varchar(40) NOT NULL,
                stock_name varchar(40) NOT NULL,
                image_path varchar(80) NOT NULL,
                stock_story varchar(40) DEFAULT NULL,
                image_large varchar(80) NOT NULL,
                in_stock int(11) DEFAULT NULL,
                PRIMARY KEY (stock_id)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1;
        EOL);
    }

    function addStock ($stockId, $stockName, $imageDir, $stockStory, $inStock) {
        echo 'adding stock';
        $query = $this->link->prepare(<<<EOL
            INSERT INTO stock (
                stock_id,
                stock_name,
                image_path,
                stock_story,
                image_large,
                in_stock
            ) VALUES (?, ?, ?, ?, ?, ?)
        EOL);
        $query->bind_param("ssssss", $stockId, $stockName, $imageDir, $stockStory, $imageDir, $inStock);
        $query->execute();
        var_dump($query);
    }

    function addStocks ($imageData) {
        // var_dump($imageData);
        $this->connect();
        $this->createDatabase();
        $this->selectDatabase();
        $this->recreateStockTable();
        for ($i = 0; $i < sizeof($imageData); $i++) {
            $this->addStock(
                $imageData[$i][0],
                $imageData[$i][1],
                $imageData[$i][2],
                $imageData[$i][3],
                $imageData[$i][4]
            );
        }
        $this->disconnect();
    }

    function fetchStock ($stockName) {
        $this->connect();
        $this->selectDatabase();
        $query = $this->link->prepare(<<<EOL
            SELECT * FROM stock
            WHERE (stock_name = ?)
            AND (in_stock != 0)
        EOL);
        $query->bind_param("s", $stockName);
        $query->execute();
        $rows = $query->get_result()->fetch_all(MYSQLI_ASSOC);
        $this->disconnect();
        return $rows;
    }

    function fetchCategories () {
        $this->connect();
        $this->selectDatabase();
        $query = $this->link->prepare(<<<EOL
            SELECT stock_name, MAX(image_path) FROM stock
            WHERE (in_stock != 0)
            GROUP BY stock_name
        EOL);
        $query->execute();
        $rows = $query->get_result()->fetch_all(MYSQLI_ASSOC);
        $this->disconnect();
        return $rows;
    }

    // close the database
    function disconnect() {
        $this->link->close();
    }
}
?>