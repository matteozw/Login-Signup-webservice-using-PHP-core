<?php
class Database{
	// db credentials
	private $dsn = 'mysql:dbname=zimtruck_loads_trefoil;host=localhost';
	private $username = 'root';
	private $password = 'Matrix000';
	public $conn;
	//get the db connection
	public function getConnection(){
		$this->conn = null;
		
		try{
			$this->conn= new PDO($this->dsn, $this->username, $this->password);
			//$this->conn = newPDO('mysql:host='.$this->host.';dbname='.$this->db_name,$this->username,$this->password);
			$this->conn->exec('set names utf8');
		//echo 'successful connection';
		}catch(PDOException $exception){
			echo 'Connection error:'.$exception->getMessage();
		}
		return $this->conn;
	}
}