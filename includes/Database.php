<?php

Class Database {
 
	private $server = "mysql:host=localhost;dbname=db_techshop";
	private $username = "root";
	private $password = "root";
	private $options  = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC];
	protected $conn;
 	
	public function open() {
 		try {
 			$this->conn = new PDO($this->server, $this->username, $this->password, $this->options);

 			return $this->conn;

 		} catch(PDOException $e) {
 			echo "OPS! Há algum problema na conexão: " . $e->getMessage();
 		}
    }
 
	public function close() {
   		$this->conn = null;
 	}
}

$pdo = new Database();
 
