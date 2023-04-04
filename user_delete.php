<?php
require './lib/function.php';

if (!isset($_COOKIE['Cookie'])) {
    header("location: ./login.php");
}

$role = get_role(explode(";", $_COOKIE['Cookie'])[0])['user_role'];

if($role==="3"){
    header("location: ./list_user.php");
}

if (!isset($_POST['id'])) {
    header("location: ./list_user.php");
}
    
delete_student_by_id($_POST['id']);

 header("location: ./list_user.php");