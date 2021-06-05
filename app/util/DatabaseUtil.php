<?php

/**
 * Database
 * Provides a PDO connection object
 */
class DatabaseUtil
{
    // Default database connection parameters, depending on HTTP_HOST
    // private static $defaultConnectionParameters = ["user" => "root", "db_name" => "nestiShop", "password" => "", "host" => "localhost"];
    // private static $defaultConnectionParameters = ["user" => "c21alidjinou", "db_name" => "c21alidjinou", "password" => "qsdF7854", "host" => "localhost"];

    private static $connectionParameters = null;
    private static $conn = null; // Connection object

    /**
     * connect
     *  connect to a database, return resulting connection
     * @return PDO connection object
     */
    public static function connect(): ?PDO
    {
        $parameters = self::getParameters();

        if (self::$conn == null) {
            try {
                self::$conn = new PDO(
                    "mysql:host={$parameters['host']};dbname={$parameters['db_name']}",
                    $parameters['user'],
                    $parameters['password']
                );
            } catch (PDOException $e) {
                die($e->getMessage());
            }
        }
        return self::$conn;
    }

    public static function disconnect()
    {
        self::$conn = null;
    }

    public static function getParameters()
    {
        if (self::$connectionParameters == null) {
            // If connection parameters not initiated, pull them from a JSON file
            $jsonString = file_get_contents(__DIR__ . "/../../config/databaseParameters.json");
            $allConnectionParameters = json_decode($jsonString, true);
            $address = $_SERVER['SERVER_NAME']; // get host address, without the port
            if (isset($allConnectionParameters[$address])) {
                self::$connectionParameters = $allConnectionParameters[$address];
            } else {
                self::$connectionParameters = $allConnectionParameters['localhost']; // if no parameters specified for current host, revert to defaults
            }
        }
        return self::$connectionParameters;
    }
}
