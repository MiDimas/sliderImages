<?php
$path = $_SERVER['DOCUMENT_ROOT'];

if(isset($_SERVER['REDIRECT_URL'])){
    $url = $_SERVER['REDIRECT_URL'];
}
else{
    $url = "/start";
}




require_once("$path/system/settings/routPages.php");