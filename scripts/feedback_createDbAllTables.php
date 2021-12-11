<?php

/* 
 * Создание базы данных и всех таблиц для работы сайта!!!
 * 
 * 
 */
$dbname = 'feedback';
$dbhost = 'localhost';
$dbusername = 'root';
$dbuserpassword = '';

function db_connect($dbhost, $dbusername, $dbuserpassword) { 
    $config = [
        'dns' => 'mysql:host='.$dbhost.';charset=utf8',
        'username' => $dbusername,
        'password' => $dbuserpassword,
    ];
    try {
        
        $db = new PDO($config['dns'], $config['username'], $config['password']);
        $db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        return $db;
    } catch (PDOException $PDOException) {
        echo $PDOException->getMessage();
    }
    return false;
}
function db_close($PDO) {
        $PDO = null;
}

$PDO = db_connect($dbhost, $dbusername, $dbuserpassword);

if(!$PDO)die("Не удалось подключиться к хосту $dbhost");

try{
    $PDO->query('CREATE DATABASE IF NOT EXISTS `'.$dbname.'`');
} catch (PDOException $exception) {
    echo $exception->getMessage()."Ошибка создания базы данных".$dbname;
    exit;
}

echo "База данных $dbname успешно создана.<br>";

db_close($PDO);




include_once "../libraries/connect_db.class.php";

$ObjDb = new Connect_db();
$PDO = $ObjDb->db_connect();
if(!$PDO){
    die('Ошибка подключения к базе данных');
}

# создание таблицы пользователей
$user_tablename = 'users';

$table_def = "user_id SMALLINT NOT NULL AUTO_INCREMENT,";
$table_def.="name VARCHAR(20) BINARY NOT NULL,";
$table_def.="phone VARCHAR(20) NOT NULL,";
$table_def.="email VARCHAR(40) NOT NULL,";
$table_def.="PRIMARY KEY (user_id),";
$table_def.="UNIQUE (email)";

try{
    $PDO->query("CREATE TABLE $user_tablename ($table_def) ENGINE=InnoDB;");    
} catch (PDOException $exception) {
    echo $exception->getMessage()."Ошибка создания таблицы данных".$user_tablename;
    exit;
}

echo "Таблица $user_tablename успешно создана.<br />";


# создание таблицы загруженых файлов
$file_tablename = 'files';

$table_def = "";
$table_def = "file_id SMALLINT NOT NULL AUTO_INCREMENT,";
$table_def.="user_id SMALLINT NOT NULL,";
$table_def.="filename VARCHAR(50) BINARY NOT NULL,";
$table_def.="accessdate TIMESTAMP,";
$table_def.="PRIMARY KEY (file_id),";
$table_def.="FOREIGN KEY (user_id) REFERENCES users(user_id) ON UPDATE CASCADE ON DELETE CASCADE";

try{
    $PDO->query("CREATE TABLE $file_tablename ($table_def) ENGINE=InnoDB;");
} catch (PDOException $exception) {
    echo $exception->getMessage()."Ошибка создания таблицы данных".$file_tablename;
    exit;
}

echo "Таблица $file_tablename успешно создана.<br />";

$ObjDb->db_close();
