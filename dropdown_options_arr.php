<?php
require_once('model.php');

function get_disease_options(){
    $matches_arr = array();
    $sql = "SELECT disease from diseases WHERE 1=1";
    $result = mysqli_query(Db::$conn, $sql);
    if(mysqli_num_rows($result)>0){
        while($row=mysqli_fetch_assoc($result)){
            $species = $row['disease'];
            //$next_row = array('species'=>$species);
            //$matches_arr[] = $next_row;
            $matches_arr[] = $species;
        }
    }
    $_SESSION['disease-options-arr'] = $matches_arr;
    return $matches_arr;
}

function get_food_options(){
    $matches_arr = array();
    $sql = "SELECT species from lunchbox WHERE 1=1";
    $result = mysqli_query(Db::$conn, $sql);
    if(mysqli_num_rows($result)>0){
        while($row=mysqli_fetch_assoc($result)){
            $species = $row['species'];
            //$next_row = array('species'=>$species);
            //$matches_arr[] = $next_row;
            $matches_arr[] = $species;
        }
    }
    $_SESSION['food-options-arr'] = $matches_arr;
    return $matches_arr;
}

function get_metabollite_options(){
    $matches_arr = array();
    $sql = "SELECT metabollite from metabollites WHERE 1=1";
    $result = mysqli_query(Db::$conn, $sql);
    if(mysqli_num_rows($result)>0){
        while($row=mysqli_fetch_assoc($result)){
            $metabollite = $row['metabollite'];
            //$next_row = array('metabollite'=>$metabollite);
            //$matches_arr[] = $next_row;
            $matches_arr[] = $metabollite;
        }
    }
    $_SESSION['metabollite-options-arr'] = $matches_arr;
    return $matches_arr;
}
