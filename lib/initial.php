<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "assignment_db";

$conn = new mysqli($servername, $username, $password);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = 'CREATE DATABASE IF NOT EXISTS ' . $dbname;
mysqli_query($conn, $sql);
mysqli_select_db($conn, $dbname);

$sql_query_create_tb = "CREATE TABLE IF NOT EXISTS tb_user ("
        . "user_id int(11) NOT NULL AUTO_INCREMENT,"
        . "user_name varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,"
        . "user_sex varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,"
        . "user_job varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,"
        . "user_mobile varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,"
        . "user_email varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,"
        . "user_address varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,"
        . "user_username varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,"
        . "user_pass varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,"
        . "user_role int(2) DEFAULT 3,"
        . "PRIMARY KEY (user_id)"
        . ")ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
$conn->query($sql_query_create_tb);

$sql_query_create_tb = "CREATE TABLE IF NOT EXISTS tb_cmt ("
        . "cmt_id int(11) NOT NULL AUTO_INCREMENT,"
        . "commentor_id int(11) COLLATE utf8_unicode_ci DEFAULT NULL,"
        . "commentor_username varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,"
        . "comment varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,"
        . "profile_id int(11) COLLATE utf8_unicode_ci DEFAULT NULL,"
        . "PRIMARY KEY (cmt_id),"
        . "FOREIGN KEY (commentor_id) REFERENCES tb_user(user_id) ON DELETE CASCADE"
        . ")ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
$conn->query($sql_query_create_tb);

$sql_query_create_tb = "CREATE TABLE IF NOT EXISTS tb_homework ("
        . "hw_id int(11) NOT NULL AUTO_INCREMENT,"
        . "hw_name varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,"
        . "hw_created DATETIME DEFAULT CURRENT_TIMESTAMP,"
        . "hw_dir varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,"
        . "teacher_id int(11) COLLATE utf8_unicode_ci DEFAULT NULL,"
        . "PRIMARY KEY (hw_id),"
        . "FOREIGN KEY (teacher_id) REFERENCES tb_user(user_id) ON DELETE CASCADE"
        . ")ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
$conn->query($sql_query_create_tb);

$sql_query_create_tb = "CREATE TABLE IF NOT EXISTS tb_homework_submit ("
        . "sub_hw_id int(11) NOT NULL AUTO_INCREMENT,"
        . "sub_hw_name varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,"
        . "sub_hw_created DATETIME DEFAULT CURRENT_TIMESTAMP,"
        . "sub_hw_dir varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,"
        . "id_of_hw int(11)COLLATE utf8_unicode_ci DEFAULT NULL,"
        . "student_id int(11) COLLATE utf8_unicode_ci DEFAULT NULL,"
        . "PRIMARY KEY (sub_hw_id),"
        . "FOREIGN KEY (student_id) REFERENCES tb_user(user_id) ON DELETE CASCADE,"
        . "FOREIGN KEY (id_of_hw) REFERENCES tb_homework(hw_id) ON DELETE CASCADE"
        . ")ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
$conn->query($sql_query_create_tb);

$sql_query_create_tb = "CREATE TABLE IF NOT EXISTS tb_challenge ("
        . "chall_id int(11) NOT NULL AUTO_INCREMENT,"
        . "chal_hint varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,"
        . "PRIMARY KEY (chall_id)" 
        . ")ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
$conn->query($sql_query_create_tb);

?>