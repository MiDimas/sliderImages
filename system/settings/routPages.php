<?php

$pages = [
    "/" => "slider",
    "/demonstration" => "slider"
    

    
];



foreach($pages as $key => $value){

    if($url == $key){
        require_once "$path/pages/{$value}.php";
        break;
    }

}

