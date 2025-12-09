<?php
require_once __DIR__ . '/../Classes/UserManager.php';
require_once __DIR__ .'/../Classes/User.php';
require_once __DIR__ .'/../Classes/Student.php';
require_once __DIR__ .'/../Classes/Course.php';
require_once __DIR__ .'/../Classes/Teacher.php';
class Data{
    //variable to decides if use data from database or hardcodded data
    public bool $connection;
    public ?PDO $dbConn=null; // can be either PDO object or null


   
    public function checkDatabaseConnection(){
        $host = 'localhost';
        $db   = 'your_database';
        $user = 'your_username';
        $password = 'your_password';
        $port = '5432';

        try{ 
            //creates a new connection using PDO (PHP Data Objects).
            //The string is the DSN (Data Source Name) telling PDO how to connect.
            //$user and $pass are passed in to log in.

            $this->dbConn= new PDO("pgsql:host=$host;port=$port;dbname=$db",
             $user,$password); // becomes a PDO object if successful
            //throw exceptions if anything goes wrong
            $this->dbConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //use data from database (DataManager)
            $this->connection=true;
        } catch(PDOException $e){
            //use hardcodded data (DataManagerMock)
            $this->connection=false;
            $this->dbConn=null;
        }
    }
    public function __construct() {
    $this->checkDatabaseConnection();
    }
    
}
?>