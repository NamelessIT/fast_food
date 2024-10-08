<?php 
namespace App\Database;

class DbConnection{    
    private $host = 'localhost';
    private $db_name = 'fast_food';
    private $username = 'root';
    private $password = '';
    public $conn;
    private static $instance = null;
    private function __construct() {}

    public static function getInstance() {
        if (self::$instance == null) {

            self::$instance=new DbConnection();
        }
        return self::$instance;
    }
    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn=mysqli_connect('localhost','root','','fastfood');
            if ($this->conn) {
            } else {
                throw new Exception('Kết nối database thất bại: ' . mysqli_connect_error());
            }
        } catch (PDOException $exception) {
        }
        return $this->conn;
    }

    public function closeConnection() {
        if ($this->conn !== null) {
            mysqli_close($this->conn);
            $this->conn = null;
        }
    }
}
?>