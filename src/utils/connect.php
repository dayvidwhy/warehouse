<?php
class MySQLDatabase {
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
    function query($query) {
        $this->link->query($query);
    }

    // close the database
    function disconnect() {
        $this->link->close();
    }
}
?>