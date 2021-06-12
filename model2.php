<?php
/* model2
author: Nobu Kim
*/
//require_once('connection.php');
require('model.php');

function post_a_question($q, $username){

    $user_id = get_user_id($username);
    //user found proceed to post question in DB
    $current_date = date("Ymd");
    $sql = "INSERT INTO Questions(Question, UserId, Date)
                            VALUES('$q', '$user_id', '$current_date')";
    $result = mysqli_query(Db::$conn, $sql);
    if($result!=false){
        return true;
    }
    else{
        return false;
    }
}
//https://stackoverflow.com/a/14290878/13865853
function search_questions($search_item){
    /* search DB for substring of question
    add results to an array of strings
    return array of strings or empty array
    */
    $user_id = -1;
    $matches_arr = array();
    $sql = "SELECT * FROM Questions 
    WHERE Question LIKE '%$search_item%'";
    //todo: may have to get all results and check substring in
    //php
    $result = mysqli_query(Db::$conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        //iterate
        while($row = mysqli_fetch_assoc($result)){
            //get username
            $user_id = $row['UserId'];
            $username = get_user_name($user_id);
            $next_row = array("Question"=>$row['Question'], "Username"=>$username,
                "Date"=>$row['Date']);
            $matches_arr[] = $next_row;
        }
    }
    $_SESSION['matches_arr'] = $matches_arr;
    return $matches_arr;
    //https://stackoverflow.com/questions/1548159/php-how-to-send-an-array-to-another-page

}

function get_user_name($user_id){
    /* search database for userid of the person who wrote the question
    not current user
    return userid or false for failure
    */
    $sql = "SELECT * from Users WHERE Id='$user_id'";
    $result = mysqli_query(Db::$conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row['Username'];
    } else
        return false;
}


