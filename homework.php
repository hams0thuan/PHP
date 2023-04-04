<?php
require './lib/function.php';
require './lib/initial.php';

if (!isset($_COOKIE['Cookie'])) {
    header("location: ./login.php");
}

$cur_id = explode(";", $_COOKIE['Cookie'])[0];
$cur_username = explode(";", $_COOKIE['Cookie'])[1];
$user = get_user($cur_id);
$role = get_role($cur_id)['user_role'];

$result = get_hw_list();

if (isset($_POST['download'])) {
    if ($role === '3') {
        $dir = get_hw_by_hw_id($_POST['assignment'])['hw_dir'];
    }
    if ($role === '2') {
        $dir = get_sub_homework($_POST['assignment_submit_1'])['sub_hw_dir'];
    }
    if ($dir !== null) {
        header("Location: $dir");
    } else {
        echo "<script>alert('File not found');</script>";
    }
}

if (isset($_POST['delete_assignment'])) {
    $hw = get_sub_homework($_POST['assignment_submit']);
    if ($hw['student_id'] === $cur_id) {
        delete_hw($hw['sub_hw_id']);
        unlink($hw['sub_hw_dir']);
    } else {
        echo "<script>alert('You dont have permission');</script>";
    }
}

if (isset($_POST['teacher_delete'])) {
    $hw = get_hw_by_hw_id($_POST['assignment']);
    if ($hw['teacher_id'] === $cur_id) {
        delete_data_link($hw['hw_id']);
        delete_teacher_hw($hw['hw_id']);
        unlink($hw['hw_dir']);
        header("Location: homework.php");
    } else {
        echo "<script>alert('You dont have permission');</script>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Homework</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" type="image/png" sizes="12x12" href="./images.png" />
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    </head>
    <style>
        .test{
            display: flex;
            flex-direction: row-reverse;
            padding: 11px;
        }
    </style>
    <body>
        <nav class="navbar navbar-inverse">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="./menu.php">Home</a>
                </div>
                <ul class="nav navbar-nav">
                    <li><a href="./list_user.php">List user</a></li>
                    <li class="active"><a href="./homework.php">Homework</a></li>
                    <li><a href="./challenge.php">Challenge</a></li>
                </ul>
                <div class="test">
                    <a href="./logout.php">
                        <img src="./lib/logout.png" alt="Logo" style="width:27px;" class="rounded-pill">
                    </a>    
                    <a style="margin-right: 20px;" href="./profile.php">
                        <img src="./lib/profile.png" alt="Logo" style="width:40px;" class="rounded-pill">
                    </a>
                </div>
            </div> 
        </nav>
        <div style="margin-bottom: 30px;text-align: center;"><h1>Homework</h1></div>

        <div class="form-group" style="width:70%;display: block; margin-left: auto;margin-right: auto;margin-top: 4%;">

            <label for="exampleInputName1">Choose Assignment</label>
            <form method="post">
                <select name="assignment" id="toggle" class="form-control" required='true' multiple>

                    <?php
                    foreach ($result as $row1) {
                        ?>  
                        <option value="<?php echo htmlentities($row1['hw_id']); ?>"><?php
                            echo $row1['hw_id']
                            . " - Name: " . $row1['hw_name'] . " - Created date: "
                            . $row1['hw_created'] . " - Created by: " . $row1['user_name'];
                            ?></option>

                    <?php } ?>
                </select>
                <br>
                <button class="btn btn-lg btn-success" type="submit" name="selected" value="Submit"><i class="glyphicon glyphicon-ok-sign"></i> Selected</button>
                <?php if ($role === '3') { ?>
                    <button class="btn btn-lg btn-primary" type="submit" name="download" value="Submit"><i class="glyphicon glyphicon-download"></i> Download</button>
                <?php } ?>

                <?php if ($role === '2') { ?>
                    <button class="btn btn-lg btn-danger" onclick="return confirm('Are you sure to delete?');" type="submit" name="teacher_delete" value="Submit"><i class="glyphicon glyphicon-remove-sign"></i> Delete</button> 
                <?php } ?>
            </form>
            <?php if ($role === '2') { ?>
            <form action="upload.php" method="post" enctype="multipart/form-data">
                    <input class="form-control" type="file" name="fileToUpload" id="fileToUpload" style="margin-top: 25px">
                    <br>
                    <button class="btn btn-lg btn-primary" type="submit" name="upload_question" value="Submit"><i class="glyphicon glyphicon-upload"></i> Upload</button>
                </form>
            <?php } ?>
        </div>       
        <?php if (isset($_POST['selected'])) { ?>
            <?php
            $homework = get_hw_by_hw_id($_POST['assignment']);
            $hw_id = $_POST['assignment'];
            $submission = get_all_submitted_hw();
            ?>

            <?php if ($role === '3') { ?>
                <div class="form-group" style="width:70%;display: block; margin-left: auto;margin-right: auto;margin-top: 4%;">

                    <label for="exampleInputName1"><?php echo "Your submission for: ID " . $homework['hw_id'] . " - Name: " . $homework['hw_name'] ?></label>
                    <form method="post">
                        <select name="assignment_submit" id="toggle" class="form-control" required='true' multiple>

                            <?php
                            foreach ($submission as $row2) {
                                if ($row2['student_id'] === $cur_id && $hw_id === $row2['id_of_hw']) {
                                    ?>  
                                    <option value="<?php echo htmlentities($row2['sub_hw_id']); ?>"><?php
                                        echo "Submission name: " . $row2['sub_hw_name'] . " - Homework name: " . $row2['hw_name'] . " - Created date: "
                                        . $row2['sub_hw_created'] . " - Created by: " . $row2['user_name'];
                                        ?></option>

                                    <?php
                                }
                            }
                            ?>
                        </select>
                        <br>                   
                        <button class="btn btn-lg btn-danger" onclick="return confirm('Are you sure to delete?');" type="submit" name="delete_assignment" value="Submit"><i class="glyphicon glyphicon-remove-sign"></i> Delete</button>
                    </form>
                    <form action="upload.php" method="post" enctype="multipart/form-data">
                        <input class="form-control" type="file" name="fileToUpload" id="fileToUpload" style="margin-top: 25px">
                        <input type="hidden" name="hw_id" value="<?php echo $hw_id ?>">
                        <br>
                        <button class="btn btn-lg btn-primary" type="submit" name="upload_answer" value="Submit"><i class="glyphicon glyphicon-upload"></i> Upload</button>
                    </form>
                </div>       
            <?php } ?>
            <?php if ($role === '2') { ?>
                <div class="form-group" style="width:70%;display: block; margin-left: auto;margin-right: auto;margin-top: 4%;">

                    <label for="exampleInputName1"><?php echo "View submission for: ID " . $homework['hw_id'] . " - Name: " . $homework['hw_name'] ?></label>
                    <form method="post">
                        <select name="assignment_submit_1" id="toggle" class="form-control" required='true' multiple>

                            <?php
                            foreach ($submission as $row2) {
                                if ($hw_id === $row2['id_of_hw']) {
                                    ?>  
                                    <option value="<?php echo htmlentities($row2['sub_hw_id']); ?>"><?php
                                        echo "Submission name: " . $row2['sub_hw_name'] . " - Homework name: " . $row2['hw_name'] . " - Created date: "
                                        . $row2['sub_hw_created'] . " - Created by: " . $row2['user_name'];
                                        ?></option>

                                    <?php
                                }
                            }
                            ?>
                        </select>
                        <br>
                        <button class="btn btn-lg btn-primary" type="submit" name="download" value="Submit"><i class="glyphicon glyphicon-download"></i> Download</button>                         
                    </form>
                </div>   
            <?php } ?>
        <?php } ?>

    </body>
</html>