<?php
//array with disease names from DietNavi

//include ('vendor/autoload.php');

include_once ('vendor/simple_html_dom.php');
function get_diseases_arr(){
    $diseases_arr = [];
    $html = file_get_html('http://www.knapsackfamily.com/DietNavi/top.php');
    foreach($html->find('img') as $element){
        $alt_val = $element->alt;
        if($alt_val!= ""){
            $diseases_arr[]= $alt_val;
        }
    }

    $_SESSION['diseases_arr'] = $diseases_arr;
}
//make food names arr for select options from DB
function get_foodnames_arr(){

}
//same for metabollites
function get_metabollites_arr(){

}
