<?php
class Database {
    private static $host = 'localhost';
    private static $db = 'restaurant';
    private static $user = 'root';
    private static $pass = '';
    private static $charset = 'utf8mb4';
    private static $pdo = null;

    public static function connect() {
        if (self::$pdo === null) {
            $dsn = "mysql:host=" . self::$host . ";dbname=" . self::$db . ";charset=" . self::$charset;
            self::$pdo = new PDO($dsn, self::$user, self::$pass);
        }
        return self::$pdo;
    }
}
?>
