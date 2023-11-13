<?php
//require_once('connection_tru.php');
require_once('connection.php');
//require('diseases_arr.php');
function search_tables($searchterm) {
    $out = array();
    $sql = "SHOW TABLES";
    $res = mysqli_query(Db::$conn, $sql);

    if (mysqli_num_rows($res) > 0) {
        while ($table_arr = mysqli_fetch_array($res)) {
            $table = $table_arr[0];
            $sql_search_fields = array();
            
            $sql_columns = "SHOW COLUMNS FROM " . $table;
            $res_columns = mysqli_query(Db::$conn, $sql_columns);

            while ($col_info = mysqli_fetch_assoc($res_columns)) {
                $col_name = $col_info['Field'];
                $sql_search_fields[] = "`$col_name` LIKE '%" . mysqli_real_escape_string(Db::$conn, $searchterm) . "%'";
            }
            mysqli_free_result($res_columns); // Free the result set

            if (!empty($sql_search_fields)) {
                $sql_search_query = "SELECT * FROM `$table` WHERE " . implode(" OR ", $sql_search_fields);
                $res_search = mysqli_query(Db::$conn, $sql_search_query);

                if (mysqli_num_rows($res_search) > 0) {
                    while ($row = mysqli_fetch_assoc($res_search)) {
                        $next_row = array();
                        foreach ($row as $key => $value) {
                            // Check for null and convert encoding if not null
                            $next_row[$key] = $value !== null ? mb_convert_encoding($value, "UTF-8", "auto") : null;
                        }
                        $out[] = $next_row;
                    }
                }
                mysqli_free_result($res_search); // Free the result set
            }
        }
    }
    mysqli_free_result($res); // Free the main result set
    return $out;
}
////////////////////////////////////////////////////////////////////////////
function edit_profile($prof_arr)
{
    $oldname = $prof_arr[0];
    $newname = $prof_arr[1];
    $oldpass = $prof_arr[2];
    $newpass = $prof_arr[3];
    $oldemail = $prof_arr[4];
    $newemail = $prof_arr[5];

    $updated_prof = ['name'=>$oldname, 'password'=>$oldpass, 'email'=>$oldemail];

    //name, pass, email
    if ($newname != "") {
        $sql = "UPDATE Users SET Username = '$newname' WHERE Username = '$oldname'";
        $result = mysqli_query(Db::$conn, $sql);
        if ($result == false) {
            $updated_prof['name'] = 'Error Name update';
        }
        else{//mysql success
            $oldname = $newname;
            //add to array
            $updated_prof['name'] = $newname;
        }
    } //if Username changed must find new Username

    if ($newpass != "") {
        $sql = "UPDATE Users SET Password = '$newpass' WHERE Username = '$oldname'";
        $result = mysqli_query(Db::$conn, $sql);
        if ($result == false) {
            $updated_prof['password'] = 'Error Password update';
        }
        else{
            $oldpass = $newpass;
            $updated_prof['password'] = $newpass;
        }
    }


    if ($newemail != "") {
        $sql = "UPDATE Users SET Email = '$newemail' WHERE Username = '$oldname'";
        $result = mysqli_query(Db::$conn, $sql);
        if ($result == true) {
            $updated_prof['email'] = 'Error Email update';
        }
        else{
            $oldemail = $newemail;
            $updated_prof['email'] = $newemail;
        }
    }

    return $updated_prof;
}


///////////////////////////////////////////////////////////////////////
//https://stackoverflow.com/a/14290878/13865853
function search_disease($disease_option){
    // search DB for substring of question
    //add results to an array of strings
    //return array of strings or empty array
    //
    $user_id = -1;
    $matches_arr = array();
    $sql = "SELECT * FROM diseases
    WHERE disease LIKE '%$disease_option%'";

    $result = mysqli_query(Db::$conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        //iterate
        while($row = mysqli_fetch_assoc($result)){
            //get username
            $disease = mb_convert_encoding($row['disease'], "UTF-8", "auto");
            $food = mb_convert_encoding($row['food'], "UTF-8", "auto");
            $en_name = mb_convert_encoding($row['en_name'], "UTF-8", "auto");
            $health_effect = mb_convert_encoding($row['healthEffect'], "UTF-8", "auto");
            $metabollite = mb_convert_encoding($row['metabollite'], "UTF-8", "auto");
            //$citation = $row['citation'];
            $next_row = array("Disease"=>$disease, "Food"=>$food,
                "Name"=>$en_name, "Health Benefits"=>$health_effect, "Metabollite"=>$metabollite);
            $matches_arr[] = $next_row;
        }
    }
    $_SESSION['disease-matches-arr'] = $matches_arr;
    return $matches_arr;
    //https://stackoverflow.com/questions/1548159/php-how-to-send-an-array-to-another-page

}

function search_food($food_option){
    // search DB for substring of question
    //add results to an array of strings
    //return array of strings or empty array
    //
    $user_id = -1;
    $matches_arr = array();
    $sql = "SELECT * FROM lunchbox
    WHERE species LIKE '%$food_option%'";

    $result = mysqli_query(Db::$conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        //iterate
        while($row = mysqli_fetch_assoc($result)){
            //get username
            $kingdom = mb_convert_encoding($row['kingdom'], "UTF-8", "auto");
            $species = mb_convert_encoding($row['species'], "UTF-8", "auto");
            $summary = mb_convert_encoding($row['summary'], "UTF-8", "auto");
            $how_to_eat = mb_convert_encoding($row['edible'], "UTF-8", "auto");
            $medicinal  = mb_convert_encoding($row['medicinalUsage'], "UTF-8", "auto");
            $health_benefits = mb_convert_encoding($row['healthBenefits'], "UTF-8", "auto");

            //$citation = $row['citation'];
            $next_row = array("kingdom"=>$kingdom, "Scientific Name"=>$species,
                "Summary"=>$summary, "How to Eat"=>$how_to_eat, "Medicinal"=>$medicinal,
                "Health Effect"=>$health_benefits);
            //"Sources"=>$citation);
            $matches_arr[] = $next_row;
        }
    }
    $_SESSION['food-matches-arr'] = $matches_arr;
    return $matches_arr;
    //https://stackoverflow.com/questions/1548159/php-how-to-send-an-array-to-another-page

}

function search_metabollite($metabollite_option){
    // search DB for substring of question
    //add results to an array of strings
    //return array of strings or empty array
    //
    $user_id = -1;
    $matches_arr = array();
    $sql = "SELECT * FROM metabollites
    WHERE metabollite LIKE '%$metabollite_option%'";

    $result = mysqli_query(Db::$conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        //iterate
        while($row = mysqli_fetch_assoc($result)){
            //get username
            $metabollite = mb_convert_encoding($row['metabollite'], "UTF-8", "auto");
            $en_name = mb_convert_encoding($row['enName'], "UTF-8", "auto");
            $health_effect = mb_convert_encoding($row['healthEffect'], "UTF-8", "auto");
            $foods = mb_convert_encoding($row['foods'], "UTF-8", "auto");
            $next_row = array("metabollite"=>$metabollite, "Scientific Name"=>$en_name,
                "Health Benefits"=>$health_effect, "Foods"=>$foods);
            $matches_arr[] = $next_row;
        }
    }
    $_SESSION['metabollite-matches-arr'] = $matches_arr;
    return $matches_arr;
    //https://stackoverflow.com/questions/1548159/php-how-to-send-an-array-to-another-page

}


//////////////////////////////////////////////////////////////////////
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
    // search DB for substring of question
    //add results to an array of strings
    //return array of strings or empty array
    //
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
function get_user_info($username){
    // search database for userid of the person who wrote the question
    //not current user
    //return userid or false for failure
    //
    $user_arr = array();
    $sql = "SELECT * from Users WHERE Username='$username'";
    $result = mysqli_query(Db::$conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $user_arr['username'] = $row['Username'];
        $user_arr['password'] = $row['Password'];
        $user_arr['user_id'] = $row['Id'];
        $user_arr['email'] = $row['Email'];

        return $user_arr;
    } else
        return false;
}

function delete_user($user_id){
    $sql = "DELETE from Users WHERE Id='$user_id'";
    $res = mysqli_query(Db::$conn, $sql);
    if($res==true){
        return true;
    }
    return false;
}

function get_user_name($user_id){
    // search database for userid of the person who wrote the question
    //not current user
    //return userid or false for failure
    //
    $sql = "SELECT * from Users WHERE Id='$user_id'";
    $result = mysqli_query(Db::$conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row['Username'];
    } else
        return false;
}


$command = '';
$username = '';
$password = '';
if(isset($_POST['command'])){
    $command = $_POST['command'];
}
if(isset($_POST['username'])){
    $username = $_POST['username'];
}
if(isset($_POST['password'])){
    $password = $_POST['password'];
}
$email = '';
if(!empty($_POST['email'])){
    $email = $_POST['email'];
}
//Signin
//check is user exists
//for Join this should return false
//for SignIn this should return true
function user_exists($username){

    $sql = "SELECT Username, Password, Email, Id FROM Users"; //WHERE
             //Username={$username}";
    $result = mysqli_query(Db::$conn, $sql);
    //check results return true if >0
    if(mysqli_num_rows($result)>0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $temp_user = $row["Username"];
            $temp_pass = $row["Password"];
            if ($username == $row["Username"]) {
                return true;
            }
        }
    }

    return false;

}
function validate_existing_user($username, $password){

    $sql = "SELECT Username, Password, Email, Id FROM Users"; //WHERE
             //Username={$username}";

    $result = mysqli_query(Db::$conn, $sql);
    $num_results = mysqli_num_rows($result);
    if($num_results>0){
        //output data of each row
        while($row = mysqli_fetch_assoc($result)){
            if(($row["Username"]==$username) && ($row["Password"]==$password)){
                //user and password found
                $_SESSION['user_id'] = $row['Id'];
                return true;
            }
        }
    }
    else{// 0 results
        return false; //results were 0
    }
    return false;
}
//password is correct
//for Signin if user_exists() returns True, run this to check that
//password is correct
function check_username(){
    $usernameErr = '';
    if(empty($_POST["username"])){
        $usernameErr = "Please enter a username";
    }
    else{
        $username = $_POST['username'];
        if(!preg_match("/^[a-zA-Z0-9_]+$/", $username)) {
            $usernameErr = "Alpha lower, upper and underscore only for username";
        }
        else{//username is ok
            $usernameErr = "ok";
        }
    }
    return $usernameErr;

}

function check_password(){
    $passwordErr = '';
    if(empty($_POST["password"])){//nothing entered
        $passwordErr= "Please enter a password";
    }
    else{//password is entered
        $password = $_POST['password'];
        if(strlen($password)<= '6'){
            $passwordErr = "Password must contain at least 8 chars";
        }
        elseif(!preg_match("#[0-9]+#", $password)){
            $passwordErr = "Password must contain at least 1 number";
        }
        elseif(!preg_match("#[A-Z]+#", $password)){
            $passwordErr = "Password must contain one capital letter";
        }
        elseif(!preg_match("#[a-z]+#", $password)){
            $passwordErr = "Password must contain one lowercase letter";
        }
        else{//everything is ok
            $passwordErr = "ok";
        }
    }
    return $passwordErr;
}

function check_email(){
    $emailErr = '';
    if(empty($_POST["email"])) {
        $emailErr = "Enter email";
    }
    else{
        $email = $_POST['email'];
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $emailErr = "Invalid email format";
        }
        else{
            $emailErr = "ok";
        }
    }
    return $emailErr;
}


//called after user_exists returns false for Join
//return true
function add_user($username, $password, $email){
    $current_date = date("Ymd");
    $sql = "INSERT INTO Users (Username, Password, Email, Date)
    VALUES ('$username', '$password', '$email', $current_date)";

    if(mysqli_query(Db::$conn, $sql)){
        return true;
    }
    else{
        echo "Error: " . $sql . "<br>" . mysqli_error(Db::$conn);
        return false;
    }

}

function get_user_id($username){
    $sql = "SELECT Username, Password, Email, Id FROM Users"; //WHERE
             //Username='$username'";

    $result = mysqli_query(Db::$conn, $sql);
    $user_id = -1;
    if(mysqli_num_rows($result)>0) {
        //output data of each row

        while ($row = mysqli_fetch_assoc($result)) {
            if ($row["Username"] == $username) {
                //user found
                $user_id = $row["Id"];
                //set here
                $_SESSION['user_id'] = $user_id;
                return $user_id;
            }
        }

    }
    return $user_id; //return -1
}
//////////////////////////////////////////////////////////////////////////////////////////


