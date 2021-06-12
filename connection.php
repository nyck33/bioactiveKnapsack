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
        $servername = "127.0.0.1";
        $admin_user = "root";
        $admin_password = "tennis33";
        $dbname = "bioactiveKnapsack";
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

