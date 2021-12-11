<?php

//Класс для работы с базой данных

Class Connect_db {

    protected $dbname = 'feedback';
    protected $dbhost = 'localhost';
    protected $dbusername = 'root';
    protected $dbuserpassword = '';
    protected $db;

    public function __construct($dbhost=null, $dbusername=null, $dbuserpassword=null, $dbname=null) {

        if($dbhost!=null && $dbusername!=null && $dbuserpassword!=null && $dbname!=null) {
            $this->dbhost = $dbhost;
            $this->dbusername = $dbusername;
            $this->dbuserpassword = $dbuserpassword;
            $this->dbname = $dbname;
        }
    }
    
    public function db_connect() {
        $config = [
            'dns' => 'mysql:host='.$this->dbhost.';dbname='.$this->dbname.';charset=utf8',
            'username' => $this->dbusername,
            'password' => $this->dbuserpassword,
        ];
        try {
            
            $this->db = new PDO($config['dns'], $config['username'], $config['password']);
            $this->db->setAttribute(\PDO::ATTR_ERRMODE,\PDO::ERRMODE_EXCEPTION);
            return $this->db;
        } catch (PDOException $PDOException) {
            echo $PDOException->getMessage();
        }
        return false;
    }
    public function db_close() {
        $this->db = null;
    }
}

?>