<?php

require './lib/function.php';

if (!isset($_COOKIE['Cookie'])) {
    header("location: ./login.php");
}

$cur_id = explode(";", $_COOKIE['Cookie'])[0];
$cur_username = explode(";", $_COOKIE['Cookie'])[1];
$user = get_user($cur_id);
$role = get_role($cur_id)['user_role'];

if (basename($_FILES["fileToUpload"]["name"]) === "") {
    echo "<script type='text/javascript'>alert('You must choose file to upload');</script>";
} elseif (isset($_POST['upload_question']) && $role === '2' && basename($_FILES["fileToUpload"]["name"]) !== "") {
    $result = upload_question();
    if ($result !== null) {
        $path = pathinfo($result);
        add_question_to_db($path['filename'], $result, $cur_id);
    }
} elseif (isset($_POST['upload_answer']) && !check_hw_exist($_POST['hw_id'])) {
     echo "<script type='text/javascript'>alert('Homework not exist');</script>";
} elseif (isset($_POST['upload_answer']) && $role === '3' && basename($_FILES["fileToUpload"]["name"]) !== "") {
    $result = upload_answer(addslashes($_POST['hw_id']));
    if ($result !== null) {
        $path = pathinfo($result);
        add_answer_to_db($path['filename'], $result, $_POST['hw_id'] ,$cur_id);
    }
} else {
    echo "<script type='text/javascript'>alert('You dont have permission');</script>";
}
header("Refresh:0; url=homework.php");
