<?php
  declare(strict_types = 1);
  /* Adatbázis kapcsolatot kezelő singleton */

  class MySqliDB {

    private $_connection;
    private static $_instance; 
    private $_host = "localhost";
    private $_username = "root";
    private $_password = "L%NUPrtl621";
    private $_database = "egyetem_orarend";
  
    /*
    Visszaadja az adatbázis objektum példányát, ez a metódus példányosítás nélkül hívható
    @return Instance
    */
    public static function getInstance() {
      if(!self::$_instance) { // Ha még nincs létrehozott példány, létrehozza
        self::$_instance = new self();
      }
      return self::$_instance;
    }
  
    // Constructor
    private function __construct() {
      $this->_connection = new mysqli($this->_host, $this->_username, $this->_password, $this->_database);
    
      // Hibakezelés
      if(mysqli_connect_error()) {
        trigger_error("Sikertelen kapcsolódás a MySQL szerverhez: " . mysql_connect_error(),
           E_USER_ERROR);
      }
      else
      {
        $this->_connection->set_charset('utf8');
        $this->_connection->query('SET collation_connection = @@collation_database;');        
      }
    }
  
    // Ennek a varázsmetódusnak az üresnek implementálása megakadályozza az objektum klónozását
    private function __clone() { }
  
    // Visszaadja az adatbázis kapcsolat kezelőjét
    public function getConnection() {
      return $this->_connection;
    }
  }
?>
