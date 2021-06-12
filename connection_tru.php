<?php
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
        //if(self::$init===TRUE)
          //  return;
        $servername = "localhost";
        $admin_user = "nkimf20";
        $admin_password = "nkimf20424";
        $dbname = "C354_nkimf20";
        self::$init = TRUE;
        self::$conn=mysqli_connect($servername, $admin_user, $admin_password, $dbname);
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
