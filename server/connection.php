<?php
require_once '../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable("../");
$dotenv->load();


class Database
{

    public static $connection;

    public static function setConnection()
    {
        if (!isset($connection)) {
            $host = $_ENV["DB_HOST_REMOTE"];
            $username = $_ENV["DB_USERNAME"];
            $password = $_ENV["DB_PASSWORD"];
            $database = $_ENV["DB_NAME_REMOTE"];
            $port = $_ENV["PORT"];
            Database::$connection = new mysqli($_ENV["DB_HOST"], $_ENV["DB_USERNAME"], $_ENV["DB_PASSWORD"], $_ENV["DB_NAME"], $_ENV["PORT"]);
            // Database::$connection = new mysqli($host, $username, $password, $database, $port);
        }
    }
    public static function iud($query, $paraArr)
    {
        Database::setConnection();
        $stmt = Database::$connection->prepare($query);
        $paramTypes = str_repeat('s', count($paraArr));
        if (!empty($paraArr)) {
            $stmt->bind_param($paramTypes, ...$paraArr);
        }
        $stmt->execute();
    }
    public static function iud_nor($query)
    {
        Database::setConnection();
        Database::$connection->query($query);
    }
    public static function search($query, $paraArr)
    {
        Database::setConnection();
        $stmt = Database::$connection->prepare($query);
        $paramTypes = str_repeat('s', count($paraArr));
        if (!empty($paraArr)) {
            $stmt->bind_param($paramTypes, ...$paraArr);
        }
        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    }
    public static function search_nor($query)
    {
        Database::setConnection();
        $result = Database::$connection->query($query);
        return $result;
    }
}
