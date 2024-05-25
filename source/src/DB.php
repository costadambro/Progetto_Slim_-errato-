<?php
class DB{
    private static $servername;
    private static $username;
    private static $password;
    private static $dbname;
    private static $conn;

    public static function conn()
    {
        if (!isset(self::$conn)) {
            self::$servername = "mysql";
            self::$username = "root";
            self::$password = "ciccio";
            self::$dbname = "playlist";
            self::$conn = new mysqli(self::$servername, self::$username, self::$password, self::$dbname)
                or die("Connessione al database fallita: " . self::$conn->connect_error);
        }
        return self::$conn;
    }
}

?>