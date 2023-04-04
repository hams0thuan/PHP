<?php
global $conn;

function connect_db() {

    global $conn;
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "assignment_db";

    $tmp_conn = new mysqli($servername, $username, $password) or die("Can't not connect to database");
    $sql = 'SHOW DATABASES LIKE "' . $dbname . '"';
    $query = mysqli_query($tmp_conn, $sql);
    $row = mysqli_fetch_assoc($query);

    if (!isset($row)) {
        echo ("Database not found, please run ");
        ?> <a href="./login.php">login.php</a> first!

        <?php
        exit();
    }

    if (!$conn) {
        $conn = $conn = new mysqli($servername, $username, $password, $dbname) or die("Can't not connect to database");
        mysqli_set_charset($conn, 'utf8');
    }
}

function disconnect_db() {

    global $conn;

    if ($conn) {
        mysqli_close($conn);
    }
}

function add_data_to_db() {
    global $conn;

    connect_db();

    //password is their fullname no capital no space, ex: ronaldo | pham viet thang
    $sql_query_add_data = "REPLACE INTO tb_user(user_id, user_name, user_sex, user_job, 
            user_mobile, user_email, user_address, user_username, user_pass, user_role) VALUES"
            . "(1,'C.Ronaldo','Male','Teacher','012345678','ronaldocr@otf.com','Portugal', 'CristianoRonaldo','e24dd2210803b4737a9bd9e3163a4ca807b63201c3bc32b68fb122ca52efff36',2),"
            . "(2,'W.Rooney','Male','Teacher','088866687','rooneywa@gotf.com','England','WayneRooney','19e8637cbb1f4c04d22526f99261415f0a71f53d18484d39a1e1b289d66e57cd','2'),"
            . "(3,'R.Ferdinand','Male','Teacher','0678912345','ferdinandri@otf.com','England','RioFerdinand','241d06cbdd78dfe474288287f61dcbb92ce350f7a99201ed69eb5df08c41384c','2'),"
            . "(4,'Pham Viet Thang','Male','Student','0999888666','thanpv@otf.com','Thanh Xuan,Ha Noi, Viet Nam','ThangPV','a6f10cd6948c369108612d1f002e1224c15439c4508b764d2852a39afc2fb9bf',3),"
            . "(5,'Le Quoc Trung','Male','Student','0912345456','trunglq@otf.com','Ha Dong, Viet Nam','TrungLQ','76b8cca82f8c0699026d459f764dededd65d8ce75ad92ebc4bb1dd8ad30e8d64',3),"
            . "(6,'Nguyen Van Phung','Male','Student','0966568954','phungnv@gotf.com','Luong Tai, Bac Ninh, Viet Nam','PhungNV','7a964d174fd5b7e8ab5a9383e01bdf63a398a9c16a089153d0c51299fba5feab',3),"
            . "(7,'Nguyen Viet Hieu','Male','Student','0383537015','hieunv@otf.com','Quan 1, Ho Chi Minh, Viet Nam','HieuNV','ef226652471374aef65490f41a3b71869018166f59a5261eee26d7bf9212022b',3),"
            . "(8,'Pham Tien Dat','Male','Student','0213834231','datpt@otf.com','Hoang Van Thai, Thanh Xuan, Ha Noi, Viet Nam','DatPT','06296005cce6e09fa45e0b866e2b2005293c5760ec3a4ec1b815c6876a4eaa3c','3'),"
            . "(9,'Le Cong Tru','Male','Student','0213784321','trulc@otf.com','Bui Xuong Trach, Thanh Xuan, Ha Noi, Viet Nam','TruLC','f57225dbb08cf17e8a58c610fd9bbe97e832a86e3e9569a55ca7e38541340881',3),"
            . "(10,'Adriano','Male','Student','0861829329','adriano@gotf.com','Brazil','Adriano','8d4ae25d44b05bd1ec2ff3a40eecd0d801a5d2cd1ef1c1e8b14e91051c5bf662','3')"; 
            

    $conn->query($sql_query_add_data);
}

function get_all_user() {

    global $conn;

    connect_db();

    $sql = "select user_id, user_name, user_sex ,user_job, user_mobile, user_role from tb_user";

    $query = mysqli_query($conn, $sql);

    $result = array();

    if ($query) {
        while ($row = mysqli_fetch_assoc($query)) {
            $result[] = $row;
        }
    }

    return $result;
}

function get_ID_by_username_and_pass($username, $pass) {
    global $conn;

    connect_db();
    $username = addslashes($username);
    $pass = addslashes($pass);

    $sql = "SELECT user_id FROM tb_user WHERE user_username = '{$username}' AND user_pass ='{$pass}'";

    $query = mysqli_query($conn, $sql);
    $result = mysqli_fetch_assoc($query);

    return $result;
}

function get_pass_by_username($username) {
    global $conn;

    connect_db();
    $username = addslashes($username);

    $sql = "SELECT user_pass FROM tb_user WHERE user_username = '{$username}'";
    $query = mysqli_query($conn, $sql);
    $result = mysqli_fetch_assoc($query);

    return $result;
}

function get_role($id) {
    global $conn;

    connect_db();

    $id = addslashes($id);

    $sql = "select user_role from tb_user where user_id = {$id}";
    $query = mysqli_query($conn, $sql);
    $result = mysqli_fetch_assoc($query);

    return $result;
}

function get_user($id) {

    global $conn;

    connect_db();

    $id = addslashes($id);

    $sql = "select user_id, user_name, user_sex, user_job, user_mobile,"
            . "user_email, user_address, user_username, user_pass, user_role from tb_user where user_id = {$id}";

    $query = mysqli_query($conn, $sql);

    $result = mysqli_fetch_assoc($query);

    return $result;
}

function add_student($name, $sex, $mobile, $email, $address, $username, $password) {

    $role = get_role(explode(";", $_COOKIE['Cookie'])[0])['user_role'];

    if ($role === "3" || $role === null) {
        header("Location: ./user_detail.php");
    }

    global $conn;

    connect_db();

    $cmd = "SELECT MAX(user_id) as maxID FROM tb_user";
    $result = mysqli_query($conn, $cmd);
    $values = mysqli_fetch_assoc($result);

    $id = $values['maxID'] + 1;
    $name = addslashes($name);
    $sex = addslashes($sex);
    $job = "Student";
    $mobile = addslashes($mobile);
    $email = addslashes($email);
    $address = addslashes($address);
    $username = addslashes($username);
    $password = hash('sha256', addslashes($password));

    $sql = "INSERT INTO tb_user(user_id, user_name, user_sex, user_job, 
            user_mobile, user_email, user_address, user_username, user_pass) VALUES
            ('$id','$name', '$sex', '$job', '$mobile', '$email', '$address', '$username', '$password')
    ";

    $query = mysqli_query($conn, $sql);

    return $query;
}

function edit_student($id, $name, $sex, $mobile, $email, $address, $username, $password) {
    $role = get_role(explode(";", $_COOKIE['Cookie'])[0])['user_role'];

    if ($role === "3" || $role === null) {
        header("Location: ./user_detail.php");
    }

    global $conn;

    connect_db();

    $id = addslashes($id);
    $name = addslashes($name);
    $sex = addslashes($sex);
    $mobile = addslashes($mobile);
    $email = addslashes($email);
    $address = addslashes($address);
    $username = addslashes($username);
    $password = hash('sha256', addslashes($password));

    $sql = "
            UPDATE tb_user SET
            user_name = '$name',
            user_sex = '$sex',
            user_mobile = '$mobile',
            user_email = '$email',
            user_address = '$address',
            user_username = '$username',
            user_pass = '$password' 
            WHERE user_id = $id AND user_role = 3
    ";

    $query = mysqli_query($conn, $sql);

    return $query;
}

function delete_student_by_id($id) {

    $role = get_role(explode(";", $_COOKIE['Cookie'])[0])['user_role'];

    if ($role === "3" || $role === null) {
        return;
    }

    global $conn;

    connect_db();

    $id = addslashes($id);

    $sql = "
            DELETE FROM tb_user
            WHERE user_id = $id AND user_role = 3
    ";

    $query = mysqli_query($conn, $sql);

    return $query;
}

function delete_cmt_by_id($id) {

    global $conn;

    connect_db();

    $id = addslashes($id);

    $sql = "
            DELETE FROM tb_cmt
            WHERE cmt_id = $id
    ";

    $query = mysqli_query($conn, $sql);

    return $query;
}

function save_comment($profile_id, $commentor_id, $commentor_username, $comment) {
    global $conn;
    connect_db();

    $cmd = "SELECT MAX(cmt_id) as maxID FROM tb_cmt";
    $result = mysqli_query($conn, $cmd);
    $values = mysqli_fetch_assoc($result);

    $id = $values['maxID'] + 1;

    $commentor_id = addslashes($commentor_id);
    $commentor_username = addslashes($commentor_username);
    $profile_id = addslashes($profile_id);
    $comment = addslashes($comment);

    $sql = "INSERT INTO `tb_cmt`(`cmt_id`, `commentor_id`, `commentor_username`, `comment`, `profile_id`) "
            . "VALUES ('$id','$commentor_id ','$commentor_username','$comment','$profile_id') ";

    $query = mysqli_query($conn, $sql);

    return $query;
}

function get_all_comment_of_profile($profile) {
    global $conn;

    connect_db();

    $profile = addslashes($profile);

    $sql = "select * from tb_cmt WHERE profile_id = {$profile}";

    $query = mysqli_query($conn, $sql);

    $result = array();

    if ($query) {
        while ($row = mysqli_fetch_assoc($query)) {
            $result[] = $row;
        }
    }

    return $result;
}

function teacher_role_edit_profile($id, $name, $sex, $mobile, $email, $address, $username) {

    $role = get_role(explode(";", $_COOKIE['Cookie'])[0])['user_role'];

    if ($role === "3" || $role === null) {
        header("location: ./profile.php");
    }

    global $conn;

    connect_db();

    $id = addslashes($id);
    $name = addslashes($name);
    $sex = addslashes($sex);
    $mobile = addslashes($mobile);
    $email = addslashes($email);
    $address = addslashes($address);
    $username = addslashes($username);

    $sql = "
            UPDATE `tb_user` SET
            `user_name` = '$name',
            `user_sex` = '$sex',
            `user_mobile` = '$mobile',
            `user_email` = '$email',
            `user_address` = '$address',
            `user_username` = '$username'
            WHERE `user_id` = $id
    ";

    $query = mysqli_query($conn, $sql);

    return $query;
}

function student_role_edit_profile($id, $sex, $mobile, $email, $address) {
    global $conn;

    connect_db();

    $id = addslashes($id);
    $sex = addslashes($sex);
    $mobile = addslashes($mobile);
    $email = addslashes($email);
    $address = addslashes($address);

    $sql = "
            UPDATE tb_user SET
            user_sex = '$sex',
            user_mobile = '$mobile',
            user_email = '$email',
            user_address = '$address'
            WHERE user_id = $id
    ";

    $query = mysqli_query($conn, $sql);

    return $query;
}

function change_pass($id, $new_password) {

    global $conn;

    connect_db();

    $cur_id = explode(";", $_COOKIE['Cookie'])[0];

    $id = addslashes($id);
    $new_password = addslashes($new_password);

    if ($cur_id !== $id) {
        header("Location: ./profile.php");
    }

    $sql = "
            UPDATE tb_user SET
            user_pass = '$new_password'
            WHERE user_id = $id
    ";
    $query = mysqli_query($conn, $sql);

    return $query;
}

function check_username_exist($username) {
    global $conn;

    connect_db();

    $username = addslashes($username);

    $sql = "SELECT user_username FROM `tb_user` WHERE user_username = '{$username}'";

    $query = mysqli_query($conn, $sql);
    $result = mysqli_fetch_assoc($query);
    if ($result === null) {
        return false;
    }
    return true;
}

function get_hw_list() {
    global $conn;

    connect_db();

    $sql = "SELECT `hw_id`,`hw_name`,`hw_created`, `hw_dir`, tb_user.user_name FROM `tb_homework` LEFT JOIN `tb_user` ON tb_homework.teacher_id = tb_user.user_id;";

    $query = mysqli_query($conn, $sql);

    $result = array();

    if ($query) {
        while ($row = mysqli_fetch_assoc($query)) {
            $result[] = $row;
        }
    }

    return $result;
}

function check_hw_exist($id) {

    global $conn;

    connect_db();

    $id = addslashes($id);

    $sql = "SELECT hw_id FROM `tb_homework` WHERE hw_id = '{$id}'";

    $query = mysqli_query($conn, $sql);
    $result = mysqli_fetch_assoc($query);

    if ($result === null) {
        return false;
    }
    return true;
}

function get_hw_by_hw_id($id) {

    global $conn;

    connect_db();

    $id = addslashes($id);

    $sql = "SELECT * FROM `tb_homework` WHERE hw_id = '{$id}'";

    $query = mysqli_query($conn, $sql);
    $result = mysqli_fetch_assoc($query);

    return $result;
}

function get_all_submitted_hw() {

    global $conn;

    connect_db();

    $sql = "SELECT `sub_hw_id`, `sub_hw_name`, `sub_hw_created`, `sub_hw_dir`, "
            . "id_of_hw, student_id, tb_homework.hw_name , tb_user.user_name FROM tb_homework_submit "
            . "LEFT JOIN `tb_homework` ON tb_homework_submit.id_of_hw = tb_homework.hw_id "
            . "LEFT JOIN `tb_user` ON tb_homework_submit.student_id = tb_user.user_id;";

    $query = mysqli_query($conn, $sql);

    $result = array();

    if ($query) {
        while ($row = mysqli_fetch_assoc($query)) {
            $result[] = $row;
        }
    }

    return $result;
}

function get_sub_homework($id) {

    global $conn;

    connect_db();

    $id = addslashes($id);

    $sql = "SELECT * FROM `tb_homework_submit` WHERE sub_hw_id = '{$id}'";

    $query = mysqli_query($conn, $sql);
    $result = mysqli_fetch_assoc($query);

    return $result;
}

function delete_hw($id) {

    global $conn;

    connect_db();

    $id = addslashes($id);

    $sql = "
            DELETE FROM tb_homework_submit
            WHERE sub_hw_id = $id
    ";

    $query = mysqli_query($conn, $sql);

    return $query;
}

function delete_teacher_hw($id) {

    global $conn;

    connect_db();

    $id = addslashes($id);

    $sql = "
            DELETE FROM tb_homework
            WHERE hw_id = $id
    ";

    $query = mysqli_query($conn, $sql);

    return $query;
}

function upload_question() {
    $target_dir = "./data/homework/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $FileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    if (file_exists($target_file)) {
        $message = "Sorry, file already exists.";
        echo "<script type='text/javascript'>alert('$message');</script>";
        return;
    }

    if ($_FILES["fileToUpload"]["size"] > 100000000) {
        $message = "Sorry, your file is too large.";
        echo "<script type='text/javascript'>alert('$message');</script>";
        return;
    }

    if ($FileType != "jpg" && $FileType != "png" && $FileType != "jpeg" && $FileType != "gif" && $FileType != "pdf" && $FileType != "doc" && $FileType != "docx" && $FileType != "txt" && $FileType != "rar" && $FileType != "zip") {
        $message = "Sorry, your files are not allowed.";
        echo "<script type='text/javascript'>alert('$message');</script>";
        return;
    }

    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        $message = "The file " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " has been uploaded.";
        echo "<script type='text/javascript'>alert('$message');</script>";
        return $target_file;
    } else {
        $message = "Sorry, there was an error uploading your file.";
        echo "<script type='text/javascript'>alert('$message');</script>";
        return;
    }
}

function upload_answer($id) {
    if (!file_exists("./data/homework_submit/" . $id . "/")) {
        mkdir("./data/homework_submit/" . $id . "/", 0777, true);
    }
    $target_dir = "./data/homework_submit/" . $id . "/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $FileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    if (file_exists($target_file)) {
        $message = "Sorry, file already exists.";
        echo "<script type='text/javascript'>alert('$message');</script>";
        return;
    }

    if ($_FILES["fileToUpload"]["size"] > 100000000) {
        $message = "Sorry, your file is too large.";
        echo "<script type='text/javascript'>alert('$message');</script>";
        return;
    }

    if ($FileType != "jpg" && $FileType != "png" && $FileType != "jpeg" && $FileType != "gif" && $FileType != "pdf" && $FileType != "doc" && $FileType != "docx" && $FileType != "txt" && $FileType != "rar" && $FileType != "zip") {
        $message = "Sorry, your files are not allowed.";
        echo "<script type='text/javascript'>alert('$message');</script>";
        return;
    }

    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        $message = "The file " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " has been uploaded.";
        echo "<script type='text/javascript'>alert('$message');</script>";
        return $target_file;
    } else {
        $message = "Sorry, there was an error uploading your file.";
        echo "<script type='text/javascript'>alert('$message');</script>";
        return;
    }
}

function add_question_to_db($file_name, $file_path, $teacher_id) {

    global $conn;

    connect_db();

    $cmd = "SELECT MAX(hw_id) as maxID FROM tb_homework";
    $result = mysqli_query($conn, $cmd);
    $values = mysqli_fetch_assoc($result);

    $id = $values['maxID'] + 1;

    $sql = "INSERT INTO `tb_homework`(`hw_id`, `hw_name`, `hw_dir`, `teacher_id`) VALUES ('$id','$file_name','$file_path','$teacher_id')";
    $query = mysqli_query($conn, $sql);

    return $query;
}

function add_answer_to_db($file_name, $file_path, $hw_id, $student_id) {

    global $conn;

    connect_db();

    $cmd = "SELECT MAX(sub_hw_id) as maxID FROM tb_homework_submit";
    $result = mysqli_query($conn, $cmd);
    $values = mysqli_fetch_assoc($result);

    $id = $values['maxID'] + 1;
    $hw_id = addslashes($hw_id);

    $sql = "INSERT INTO `tb_homework_submit`(`sub_hw_id`, `sub_hw_name`, `sub_hw_dir`, `id_of_hw`, `student_id`) "
            . "VALUES ('$id','$file_name','$file_path','$hw_id', '$student_id')";
    $query = mysqli_query($conn, $sql);

    return $query;
}

function delete_data_link($id) {
    global $conn;
    connect_db();

    $id = addslashes($id);
    $sql = "SELECT sub_hw_dir FROM `tb_homework_submit` WHERE id_of_hw ={$id}";
    $query = mysqli_query($conn, $sql);
    $result = array();

    if ($query) {
        while ($row = mysqli_fetch_assoc($query)) {
            $result[] = $row;
        }
    }

    foreach ($result as $item) {
        unlink($item['sub_hw_dir']);
    }
    return;
}

function upload_challenge() {
    global $conn;

    connect_db();

    $cmd = "SELECT MAX(chall_id) as maxID FROM tb_challenge";
    $result = mysqli_query($conn, $cmd);
    $values = mysqli_fetch_assoc($result);

    $id = $values['maxID'] + 1;

    if (!file_exists("./data/challenge/" . $id . "/")) {
        mkdir("./data/challenge/" . $id . "/", 0777, true);
    }
    $target_dir = "./data/challenge/" . $id . "/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $FileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    if (file_exists($target_file)) {
        $message = "Sorry, file already exists.";
        echo "<script type='text/javascript'>alert('$message');</script>";
        rmdir($target_dir);
        return;
    }

    if ($_FILES["fileToUpload"]["size"] > 40000000) {
        $message = "Sorry, your file is too large.";
        echo "<script type='text/javascript'>alert('$message');</script>";
        rmdir($target_dir);
        return;
    }

    if ($FileType != "txt") {
        $message = "Sorry, your files are not allowed.";
        echo "<script type='text/javascript'>alert('$message');</script>";
        rmdir($target_dir);
        return;
    }

    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        $message = "The file " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " has been uploaded.";
        echo "<script type='text/javascript'>alert('$message');</script>";
        return $target_file;
    } else {
        $message = "Sorry, there was an error uploading your file.";
        echo "<script type='text/javascript'>alert('$message');</script>";
        rmdir($target_dir);
        return;
    }
}

function add_challenge($hint) {

    global $conn;

    connect_db();

    $cmd = "SELECT MAX(chall_id) as maxID FROM tb_challenge";
    $result = mysqli_query($conn, $cmd);
    $values = mysqli_fetch_assoc($result);

    $id = $values['maxID'] + 1;
    $hint = addslashes($hint);

    $sql = "INSERT INTO `tb_challenge`(`chall_id`, `chal_hint`) VALUES ('$id','$hint')";

    $query = mysqli_query($conn, $sql);

    return $id;
}

function is_chall_id_exist($id) {
    global $conn;

    connect_db();

    $id = addslashes($id);

    $sql = "SELECT chall_id FROM `tb_challenge` WHERE chall_id = '{$id}'";

    $query = mysqli_query($conn, $sql);
    $result = mysqli_fetch_assoc($query);

    if ($result === null) {
        return false;
    }
    return true;
}

function is_user_id_exist($id) {
    global $conn;

    connect_db();

    $id = addslashes($id);

    $sql = "SELECT user_id FROM `tb_user` WHERE user_id = '{$id}'";

    $query = mysqli_query($conn, $sql);
    $result = mysqli_fetch_assoc($query);

    if ($result === null) {
        return false;
    }
    return true;
}

function get_hint_by_id($id) {
    global $conn;

    connect_db();

    $id = addslashes($id);

    $sql = "SELECT chal_hint FROM `tb_challenge` WHERE chall_id = '{$id}'";

    $query = mysqli_query($conn, $sql);
    $result = mysqli_fetch_assoc($query);

    return $result;
}

function delete_chall($id) {
    $role = get_role(explode(";", $_COOKIE['Cookie'])[0])['user_role'];

    if ($role === "3" || $role === null) {
        return;
    }

    global $conn;

    connect_db();

    $id = addslashes($id);

    $sql = "
            DELETE FROM tb_challenge
            WHERE chall_id = '{$id}';
    ";

    $query = mysqli_query($conn, $sql);

    return $query;
    
}

function Delete($path)
{
    if (is_dir($path) === true)
    {
        $files = array_diff(scandir($path), array('.', '..'));

        foreach ($files as $file)
        {
            Delete(realpath($path) . '/' . $file);
        }

        return rmdir($path);
    }

    else if (is_file($path) === true)
    {
        return unlink($path);
    }

    return false;
}
