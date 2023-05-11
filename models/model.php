<?php
  class Model{
    private $result;
    private $query;
    private $connection;
    private $currentTable;

    function __construct($db, $table){
      try {
        $this->connection = new PDO("mysql:host=localhost;dbname=$db", "root", "");
        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->currentTable= $table;
      } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
      }
    }

    private function runQuery($query, $method){  
      $this->result= $this->connection->query($query);
      return $this->result;
    }

    public function getAll(){
      return $this->runQuery("SELECT * FROM {$this->currentTable};", "get");
    }

    public function get($query){
      return $this->runQuery($query, 'get');
    }
    public function post(){

    }
    public function put(){

    }
    public function del(){

    }
  }
