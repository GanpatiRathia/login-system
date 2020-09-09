<?php 
class Database{
    protected  $pdo;
    protected static $instance;
  
    protected function __construct() {
        try{
            $dsn = 'mysql:host='.DB_HOST.';dbname='.DB_NAME.'';
            $this->pdo = new PDO($dsn, DB_USER, DB_PASS);
        }catch(PDOEXception $e){
            echo $e->getMessage();
        }
    }

    public static function instance(){
        if(self::$instance === null){
            self::$instance = new self;
        }

        return self::$instance;
    }

    public function __call($method, $args){
        return call_user_func_array(array($this->pdo, $method), $args);
    }
}
?>