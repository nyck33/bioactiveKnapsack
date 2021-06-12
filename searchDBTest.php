<!doctype html>

<html lang="en">
<head>
    <meta charset="utf-8">

    <title>The HTML5 Herald</title>
</head>
<body>

<?php
//from model.php
//cho "hello";
//////////////////////////////////////////////////////////////////////
include('model.php');
/*have an array of matches_arr
on client side, make a table from each matches arr
*/
function search_tables($searchterm){
    /* from https://stackoverflow.com/a/34344552/8442553
    */
    $out = array();
    $count =0;
    //echo $count;
    $sql = "SHOW TABLES";
    $res = mysqli_query(Db::$conn, $sql);
    //echo $res;
    //echo "'mysqli_num_rows($res)'";
    if(mysqli_num_rows($res)>0){
        while($table_arr = mysqli_fetch_array($res)){
            //echo "in func";
            $table = $table_arr[0];
            //$out .= $table.";";
            //array to hold fields in col like term
            $sql_search_fields = array();
            //get everything from table to get cols
            $sql_all = "SELECT * FROM ".$table;
            $col_arr = array();
            $res_all = mysqli_query(Db::$conn, $sql_all);
            $num_rows = mysqli_num_rows($res_all);
            if($num_rows >0 ){
                for($i=0; $i< $num_rows; $i++){
                    //method to get field info
                    $fieldinfo = mysqli_fetch_field_direct($res_all, $i);
                    if(!is_null($fieldinfo-> name)){
                        $col_arr[] = $fieldinfo->name;
                    }
                }
                for($i=0; $i<count($col_arr); $i++){
                    $col = $col_arr[$i];
                    $sql_search_fields[] = " WHERE ".$col." LIKE '%" .$searchterm."%'";
                }
                mysqli_close($res_all);
            }
            $full_sql_arr = array();
            for($i=0; $i<count($sql_search_fields); $i++){
                $curr_search = $sql_all.$sql_search_fields[$i];
                $full_sql_arr[] = $curr_search;
            }
            //$sql_search .= implode(" OR ", $sql_search_fields);
            //echo "$sql_search '$sql_search'";
            for($i=0; $i<count($full_sql_arr); $i++){
                $curr_sql = $full_sql_arr[$i];
                $curr_res = mysqli_query(Db::$conn, $curr_sql);
                $num_rows = mysqli_num_rows($curr_res);
                $matches_arr = [];
                if($num_rows>0){
                    while($row = mysqli_fetch_assoc($curr_res)){
                        if($table=="diseases"){
                            $disease = mb_convert_encoding($row['disease'], "UTF-8", "auto");
                            $food = mb_convert_encoding($row['food'], "UTF-8", "auto");
                            $en_name = mb_convert_encoding($row['en_name'], "UTF-8", "auto");
                            $health_effect = mb_convert_encoding($row['healthEffect'], "UTF-8", "auto");
                            $metabollite = mb_convert_encoding($row['metabollite'], "UTF-8", "auto");
                            $next_row = array("Disease"=>$disease, "Food"=>$food,
                                "Name"=>$en_name, "Health Benefits"=>$health_effect, "Metabollite"=>$metabollite);
                            $matches_arr[] = $next_row;

                        }
                        else if($table=="lunchbox"){
                            $kingdom = mb_convert_encoding($row['kingdom'], "UTF-8", "auto");
                            $species = mb_convert_encoding($row['species'], "UTF-8", "auto");
                            $summary = mb_convert_encoding($row['summary'], "UTF-8", "auto");
                            $how_to_eat = mb_convert_encoding($row['edible'], "UTF-8", "auto");
                            $medicinal  = mb_convert_encoding($row['medicinalUsage'], "UTF-8", "auto");
                            $health_benefits = mb_convert_encoding($row['healthBenefits'], "UTF-8", "auto");
                            $next_row = array("kingdom"=>$kingdom, "Scientific Name"=>$species,
                                "Summary"=>$summary, "How to Eat"=>$how_to_eat, "Medicinal"=>$medicinal,
                                "Health Effect"=>$health_benefits);
                            $matches_arr[] = $next_row;
                        }
                        else if($table=="metabollites"){
                            $metabollite = mb_convert_encoding($row['metabollite'], "UTF-8", "auto");
                            $en_name = mb_convert_encoding($row['enName'], "UTF-8", "auto");
                            $health_effect = mb_convert_encoding($row['healthEffect'], "UTF-8", "auto");
                            $foods = mb_convert_encoding($row['foods'], "UTF-8", "auto");
                            $next_row = array("metabollite"=>$metabollite, "Scientific Name"=>$en_name,
                                "Health Benefits"=>$health_effect, "Foods"=>$foods);
                            $matches_arr[] = $next_row;
                        }
                        //arr of arrs
                        $out[] = $matches_arr;
                    }
                    //$out.= "In table: ".$table." Query: " .$curr_sql. "\n";
                    //echo $out;
                }
                //mysqli_close($curr_res);
            }
        }
        //mysqli_close($res);
    }
    return $out;
}

$term = 'motion';
$res_matches = search_tables($term);
foreach($res_matches as $matches_arr){
    foreach($matches_arr as $col => $val){
        //$utf8_val = mb_convert_encoding($val, "UTF-8", "auto");
        //$matches_arr[$col] = $utf8_val;
        echo "col=".$col." val=".$val;
        echo "<br>";
    }
}


//echo $res_string;
//echo "bye";
//$testsql = "SELECT * FROM diseases WHERE disease LIKE '%obesity%'";

//$testres = mysqli_query(Db)
?>
</body>
</html>
