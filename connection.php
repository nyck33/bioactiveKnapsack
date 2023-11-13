<?php

require_once 'env_loader.php';

class Db
{
    //new version with user authentication
    private static $servername;
    private static $dbname;
    private static $admin_user;
    private static $admin_password;

    private static $init = False;
    public static $conn;

    public static function initialize(){
        if(self::$init===TRUE) return;
        self::$servername = getenv('DB_HOST');
        self::$dbname = getenv('DB_NAME');
        self::$admin_user = getenv('DB_USER');
        self::$admin_password = getenv('DB_PASS');
        self::$init = TRUE;

        self::$conn=mysqli_connect(self::$servername, self::$admin_user, self::$admin_password, self::$dbname);
    }
}
//initialize db
Db::initialize();
//check connection
if(!Db::$conn){
    die("Connect failed " . mysqli_connect_error());
}

