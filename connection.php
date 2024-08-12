<?php

  function connection(){
    $server_name      ="localhost";
    $server_username  ="root";
    $server_password  ="";  
    $db_name          ="minimart_catalog";

    $conn = new mysqli($server_name,$server_username,$server_password,$db_name);

    if($conn->connect_error){
      die("ERROR IN CONNECTING TO DATABASE".$conn->error);
    }else{
      return $conn;
    }
  }
?>