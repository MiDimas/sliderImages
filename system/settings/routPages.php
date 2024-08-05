<?php

$pages = [
    "/" => "slider",
    "/demonstration" => "slider",
    "/army" => "sliderPatri",
    "/zoomer" => "sliderZoomer"


];



foreach($pages as $key => $value){

    if($url == $key){
        require_once "$path/pages/{$value}.php";
        break;
    }

}
