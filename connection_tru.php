<?php
class Db
{
    /*
    mysql --host=us-cdbr-east-04.cleardb.com 
    --user=bead3e90ed60e8 --password=035c401b 
    --reconnect heroku_498e3772e72c9f9 < nkim.sql
    */
    //new version with user authentication
    private static $url; 
    private static $server;
    private static $db;
    private static $username;
    private static $password;

    private static $init = False;
    public static $conn;

    public static function initialize(){
        //if(self::$init===TRUE)
          //  return;
        $url = parse_url(getenv("CLEARDB_DATABASE_URL"));
        $server = $url["host"];
        $username = $url["user"];
        $password = $url["pass"];
        $db = substr($url["path"], 1);
        self::$init = TRUE;
        self::$conn=mysqli_connect($server, $username, $password, $db);
    }
}
//initialize db
Db::initialize();
//check connection
if(!Db::$conn){
    die("Connect failed " . mysqli_connect_error());
}

//create table Users
/*
CREATE TABLE Users(
    Username VARCHAR(50) NOT NULL,
    Password VARCHAR(50) NOT NULL,
    Email VARCHAR(50) NOT NULL,
    Id INT(25) AUTO_INCREMENT PRIMARY KEY,
    Date INT(20) NOT NULL
);
*/
