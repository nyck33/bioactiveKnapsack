<?php

//error code
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//When controller.php is accessed for the first time

if (empty($_POST['page'])) {
    $d_type = 'none';
    //$_SESSION['display_type'] = $d_type;
    include('startpage.php');
    exit();
}
if(!isset($_SESSION)){
    session_start();
}

/*
*   When commands come from StartPage or SpaPage
*/

require ('model.php');  // connect to MySQL database; functions to access DB tables
//require('model2.php');

if ($_POST['username']=='googleUser'){
    $_SESSION['valid_user'] = 'googleUser';
    $login_json = array('dad'=> 3);
    echo json_encode($login_json);
    include('spa.php');
    die();
}
else if($_POST['username']=='User'){
    if(isset($_SESSION['username'])){
        $_POST['username'] = $_SESSION['username'];
    }
}

// When commands come from StartPage
if ($_POST['page'] == 'StartPage') {

    $command = $_POST['command'];
    //$username = mysqli_real_escape_string(Db::conn, $_POST['username']);
    $username = $_POST['username'];
    //set session variable username
    $_SESSION['username'] = $username;
    //$password = mysqli_real_escape_string(Db::conn, $_POST['password']);
    $password = $_POST['password'];
    $email='';
    //if coming from join
    if(!empty($_POST['email'])){
        $email = $_POST['email'];
    }
    //stupid extra variable for requirements
    $valid_username = '';
    $user_id = '';
    $signin = 'signin';
    $join = 'join';
    //$success_join = 'success';
    switch ($command) {  // When a command is sent from the client
        case 'SignIn':  // With username and password
            if (user_exists($username)== false) {
                //user does not exist
                something_wrong($signin);
            }
            else { //user exists validate entries first
                if((check_username()!='ok') || (check_password()!='ok')){
                    something_wrong($signin);
                }
                else{//all entries are well formatted
                    //set valid_username
                    //$valid_username = $username;
                    //set as session var
                    $_SESSION['valid_user'] = $username;
                    //validate existing user
                    if(validate_existing_user($username, $password)==false){
                        something_wrong($signin);//row with username, pass not found
                    }
                    else {
                        //get user id
                        $user_id = get_user_id($username);
                        if($user_id!=-1){
                            //store everything in Session
                            $_SESSION['password'] = $password;
                            $_SESSION['username'] = $username;
                            //todo: must find email for sign-in from table
                            $user_arr = get_user_info($username);
                            $email = $user_arr['email'];
                            $id = $user_arr['user_id'];
                            $_SESSION['email'] = $email;
                            $_SESSION['user_id'] = $id;
                            include('spa.php');
                            //terminate script on success
                            exit();
                        }

                    }
                }

            }
            //clear out arrays on unsuccessful signin
            $_POST = array();
            $_SESSION = array();
            $_REQUEST = array();
            exit();
        case 'Join':  // With username, password, email, some other information
            //check username, password, email
            if((check_username()!='ok') || (check_password()!='ok') ||(check_email()!='ok')){
                //something is malformed
                something_wrong($join);
            }
            else {
                if (user_exists($username) == true) {//should not exist for join
                    something_wrong($join);
                } else {//username not in DB
                    //add user
                    if(add_user($username, $password, $email)==true) {
                        //todo: this gets cleared out anyways
                        $_SESSION['display_type'] = "success";
                        include('startpage.php');
                    }
                }
            }
            //todo: pretty sure on join clearing all vars ok, start new session on signin
            //on success and  clear for join
            $_POST = array();
            $_SESSION = array();
            $_REQUEST = array();
            exit();
    }
}
// When commands come from 'SpaPage'
else if ($_POST['page'] == 'SpaPage'){
    //require('model2.php');
    //if question not asked and no search
    //command is ask-question or search-term
    $command = $_POST['command'];
    $username= $_SESSION['valid_user'];  //session var is gone
    switch($command) {  // When a command is sent from the client
        case 'ask-question':
            $q_asked = $_POST['question-asked'];
            //return t or f
            $result = post_a_question($q_asked, $username);
            if($result==true){
                $_SESSION['q-ask-success'] = true;
            }
            else {
                $_SESSION['q-ask-success'] = false;
            }
            include('spa.php');
            exit();
        //search questions table
        case 'search-term':
            $matches_arr = [];
            $term_searched = $_POST['term-searched'];
            //returns array of matches or empty array
            $matches_arr = search_questions($term_searched);

            include('spa.php');
            exit();
        case 'search-disease':
            $matches_arr = [];
            $disease = $_POST['search_term'];

            //todo: decide to use session or returned arr
            if(isset($_SESSION['disease-matches-arr'])){
                $matches_arr = $_SESSION['disease-matches-arr'];
            }
            else{
                $matches_arr = search_disease($disease);
            }
            if(count($matches_arr) > 0) {
                //encode in UTF8
                foreach($matches_arr as $col => $val){
                    $utf8_val = mb_convert_encoding($val, "UTF-8", "auto");
                    $matches_arr[$col] = $utf8_val;
                }
                //header('Content-Type: application/json');
                $disease_json = json_encode($matches_arr, JSON_UNESCAPED_UNICODE);
                echo $disease_json;
            }
            else{
                echo "error";
            }
            //unset only if set-->
            unset($_SESSION['disease-matches-arr']);
            break;
        case 'search-food':
            $matches_arr = [];
            $food = $_POST['search_term'];
            $matches_arr = search_food($food);
            //todo: decide to use session or returned arr
            if(isset($_SESSION['food-matches-arr'])){
                $matches_arr = $_SESSION['food-matches-arr'];
            }
            if(count($matches_arr) > 0) {
                //encode in UTF8
                foreach($matches_arr as $col => $val){
                    $utf8_val = mb_convert_encoding($val, "UTF-8", "auto");
                    $matches_arr[$col] = $utf8_val;
                }
                //header('Content-Type: application/json');
                $food_json = json_encode($matches_arr, JSON_UNESCAPED_UNICODE);
                echo $food_json;
            }
            else{
                echo "error";

            }
            //unset only if set-->
            unset($_SESSION['food-matches-arr']);
            break;
        case 'search-metabollite':
            $matches_arr = [];
            $metabollite = $_POST['search_term'];
            $matches_arr = search_metabollite($metabollite);
            //todo: decide to use session or returned arr
            if(isset($_SESSION['metabollite-matches-arr'])){
                $matches_arr = $_SESSION['metabollite-matches-arr'];
            }
            if(count($matches_arr) > 0) {
                //encode in UTF8
                foreach($matches_arr as $col => $val){
                    $utf8_val = mb_convert_encoding($val, "UTF-8", "auto");
                    $matches_arr[$col] = $utf8_val;
                }
                //header('Content-Type: application/json');
                $metabollite_json = json_encode($matches_arr, JSON_UNESCAPED_UNICODE);
                echo $metabollite_json;

            }
            else{
                echo "error";
            }
            //unset only if set-->
            unset($_SESSION['metabollite-matches-arr']);
            break;
        case 'searchDB':
            $search_term = $_POST['searchterm'];
            $results_arr = array();
            //arr of matches_arr's
            $results_arr = search_tables($search_term);

            if (!empty($results_arr)) {
                $first_res = $results_arr[0];
                $results_json = json_encode($results_arr, JSON_UNESCAPED_UNICODE);
                echo $results_json;
            } else {
                // Handle the case where no results are found
                echo json_encode([]);
            }
            
            break;


        case 'edit-profile-deux':
            $old_name = $_SESSION['username'];
            $old_password = $_SESSION['password'];
            $old_email = $_SESSION['email'];
            $new_username = $_POST['newUsername'];
            $new_password = $_POST['newPassword'];
            $new_email = $_POST['newEmail'];
            $old_prof_arr = [$old_name, $new_username, $old_password, $new_password,
                                $old_email, $new_email];

            $updated_prof_arr = edit_profile($old_prof_arr);
            $new_username = $updated_prof_arr['name'];
            $new_password = $updated_prof_arr['password'];
            $new_email = $updated_prof_arr['email'];
            // in case of error, don't want to update session vars
            if (!(substr($new_username, 0, 5) == 'Error')){
                $_SESSION['username'] = $new_username;
            }
            if (!(substr($new_password, 0, 5) == 'Error')){
                $_SESSION['password'] = $new_password;
            }
            if (!(substr($new_email, 0, 5) == 'Error')){
                $_SESSION['email'] = $new_email;
            }

            //header('Content-Type: application/json');
            $prof_json = json_encode($updated_prof_arr, JSON_UNESCAPED_UNICODE);
            echo $prof_json;
            break;
        case 'delete-account':
            $deletion_arr = array();
            $userid = "";
            if(isset($_SESSION['user_id'])){
                $userid = $_SESSION['user_id'];
            }
            else{
                $deletion_arr['deleted'] = 'could not find user id for user';
                //header('Content-Type: application/json');
                $deletion_json = json_encode($deletion_arr, JSON_UNESCAPED_UNICODE);
                echo $deletion_json;
            }
            $deletion = delete_user($userid);
            if($deletion){
                $deletion_arr['deleted'] = 'account deleted';
            }
            else{
                $deletion_arr['deleted'] = 'could not find account for deletion';
            }
            //header('Content-Type: application/json');
            $deletion_json = json_encode($deletion_arr, JSON_UNESCAPED_UNICODE);
            echo $deletion_json;
            break;

        case 'SignOut':
            $sign_out_type = "";
            //todo: try an associative array here like matches_arr
            $signout_obj = new stdClass();
            if(isset($_POST['signoutType'])){
                $sign_out_type = $_POST['signoutType'];
                $signout_obj ->type = 'google';
                header('Content-Type: application/json');
                $signout_json = json_encode($signout_obj, JSON_UNESCAPED_UNICODE);
                echo $signout_json;
            }
            //sign out of Google
            echo '<script type="text/javascript"',
                'signOut();',
                '</script>';
            end_session();

    }
}
else{
    echo $_POST['page'];
    echo $_POST['command'];
    exit();
}

function end_session(){
    unset($_SESSION);
    session_destroy();
    session_write_close();
    header('Location: startpage.php');
    die;
}

function something_wrong($display_type){
    $error_msg_username = '* Wrong username, or';
    $error_msg_password = '* Wrong password, or'; // Set an error message into a variable.
    $error_msg_email = '* Email is invalid';
    // This variable will used in the form in 'view_startpage.php'.
    //$d_type = $display_type;  // It will display the start page with the SignIn box.
    $_SESSION['display_type'] = $display_type;
    $_SESSION['error_msg_username'] = $error_msg_username;
    $_SESSION['error_msg_password'] = $error_msg_password;
    $_SESSION['error_msg_email'] = $error_msg_email;
    // This variable will be used in 'view_startpage.php'.
    include('startpage.php');
}
?>


