<?php
class User{
 
    // database connection and table name
    private $conn;
    private $table_name = "users";
 
    // object properties
public $users_id;
public $firstname;
public $lastname;
public $email;
public $password;
public $company;
public $status;
public $role;
public $created;
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
    // signup user
    function signup(){
    
        if($this->isAlreadyExist()){
            return false;
        }
        // query to insert record
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                    firstname=:firstname, lastname=:lastname, email=:email, password=:password, company=:company, status=:status, role=:role";
    
        // prepare query
        $stmt = $this->conn->prepare($query);
    
        // sanitize
	$this->firstname=htmlspecialchars(strip_tags($this->firstname));
	$this->lastname=htmlspecialchars(strip_tags($this->lastname));
	$this->email=htmlspecialchars(strip_tags($this->email));
	$this->password=htmlspecialchars(strip_tags($this->password));
	$this->company=htmlspecialchars(strip_tags($this->company));
	$this->status=htmlspecialchars(strip_tags($this->status));
	$this->role=htmlspecialchars(strip_tags($this->role));
    
        // bind values
        $stmt->bindParam(":firstname",$this->firstname);
	$stmt->bindParam(":lastname",$this->lastname);
	$stmt->bindParam(":email",$this->email);
	$stmt->bindParam(":password",$this->password);
	$stmt->bindParam(":company",$this->company);
	$stmt->bindParam(":status",$this->status);
	$stmt->bindParam(":role",$this->role);
    
        // execute query
        if($stmt->execute()){
            $this->id = $this->conn->lastInsertId();
            return true;
        }
    
        return false;
        
    }
    // login user
    function login(){
        // select all query
        $query = "SELECT *                
                FROM
                    " . $this->table_name . " 
                WHERE
                    email='".$this->email."' AND password='".$this->password."'";
        // prepare query statement
        $stmt = $this->conn->prepare($query);
        // execute query
        $stmt->execute();
	//$stmt->fetch(PDO::FETCH_ASSOC);
        return $stmt;
    }
    function isAlreadyExist(){
        $query = "SELECT *
            FROM
                " . $this->table_name . " 
            WHERE
                email='".$this->email."'";
        // prepare query statement
        $stmt = $this->conn->prepare($query);
        // execute query
        $stmt->execute();
        if($stmt->rowCount() > 0){
            return true;
        }
        else{
            return false;
        }
    }
}