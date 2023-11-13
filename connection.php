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
        $servername = "sql304.infinityfree.com";
        $admin_user = "if0_35413583";
        $admin_password = "W40WSeSwwE6ztK";
        $dbname = "if0_35413583_bioactiveknapsack";
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

