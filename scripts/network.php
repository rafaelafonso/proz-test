<?php

class Network {

    public $conn;

    // connectDB
    //
    public function connectDB() {

        $config = include("config.php");

        $servername = $config["host"];
        $username = $config["username"];
        $password = $config["password"];
        $database = $config["database"];

        // Create connection
        $this->conn = new mysqli($servername, $username, $password);

        // Check connection
        if ($this->conn->connect_error) {
            die("<p>Connection failed: " . $this->conn->connect_error);
        }

        // Create database
        $sql = "CREATE DATABASE $database";
        $this->conn->query($sql);

        // database connection established
        $this->conn = new mysqli($servername, $username, $password, $database);

        // sql to create User table (if it doesn't exist)
        $sql = "CREATE TABLE User (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(30) NOT NULL,
            password VARCHAR(30) NOT NULL
        )";

        $this->conn->query($sql);

        // sql to create MiniGlossary table (if it doesn't exist)
        $sql = "CREATE TABLE MiniGlossary (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            topic VARCHAR(40) NOT NULL,
            term1 VARCHAR(40) NOT NULL,
            term2 VARCHAR(40) NOT NULL,
            term3 VARCHAR(40) NOT NULL,
            term4 VARCHAR(40),
            term5 VARCHAR(40)
        )";

        $this->conn->query($sql);

        // sql to create Translation table (if it doesn't exist)
        $sql = "CREATE TABLE Translation (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            miniGlossaryID Int(6) NOT NULL,
            content VARCHAR(140) NOT NULL,
            language VARCHAR(140) NOT NULL,
            term VARCHAR(40) NOT NULL
        )";

        $this->conn->query($sql);

        // sql to create Language table (if it doesn't exist)
        $sql = "CREATE TABLE Language (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            language VARCHAR(140) NOT NULL
        )";

        $this->conn->query($sql);

        // if there are no languages, introducing some by default
        $sql = "SELECT * FROM Language";
        $languages = $this->conn->query($sql);

        if (count($languages->fetch_assoc()) == 0) {
            $sql = "INSERT INTO Language (language)
            VALUES ('Spanish')";
            $this->conn->query($sql);

            $sql = "INSERT INTO Language (language)
            VALUES ('English')";
            $this->conn->query($sql);

            $sql = "INSERT INTO Language (language)
            VALUES ('French')";
            $this->conn->query($sql);
        }

    }

    // writeUser
    //
    public function writeUser($username, $password) {

        $this->connectDB();

        // sql to insert data
        $sql = "INSERT INTO User (username, password)
        VALUES ('$username', '$password')";

        if ($this->conn->query($sql) === TRUE) {
        } else {
            echo "<p>Error: " . $sql . "<br>" . $this->conn->error;
        }

        // disconnect
        $this->conn->close();
    }

    // writeMiniGlossary
    //
    public function writeMiniGlossary($topic, $term1, $term2, $term3, $term4, $term5) {

        $this->connectDB();

        // sql to insert data
        $sql = "INSERT INTO MiniGlossary (topic, term1, term2, term3, term4, term5)
        VALUES ('$topic', '$term1', '$term2', '$term3', '$term4', '$term5')";

        if ($this->conn->query($sql) === TRUE) {
        } else {
            echo "<p>Error: " . $sql . "<br>" . $this->conn->error;
        }

        // disconnect
        $this->conn->close();
    }

    // writeTranslation
    //
    public function writeTranslation($miniGlossaryID, $content, $term, $language) {

        $this->connectDB();

        // sql to insert data
        $sql = "INSERT INTO Translation (miniGlossaryID, content, term, language)
        VALUES ('$miniGlossaryID', '$content', '$term', '$language')";

        if ($this->conn->query($sql) === TRUE) {
        } else {
            echo "<p>Error: " . $sql . "<br>" . $this->conn->error;
        }

        // disconnect
        $this->conn->close();
    }

    // read
    //
    public function read($table) {

        $this->connectDB();

        // Check connection
        if ($this->conn->connect_error) {
            die("<p>Connection failed: " . $this->conn->connect_error);
        }

        $sql = "SELECT * FROM $table";
        $result = $this->conn->query($sql);

        // disconnect
        $this->conn->close();

        return $result;
    }

    // search
    //
    public function search($table, $field, $value) {

        $this->connectDB();

        $sql = "SELECT * FROM $table WHERE $field LIKE '$value'";
        $result = $this->conn->query($sql);

        // disconnect
        $this->conn->close();

        return $result;
    }
}

?>
