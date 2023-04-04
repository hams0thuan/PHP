<?php
require './lib/function.php';

if (!isset($_COOKIE['Cookie'])) {
    header("location: ./login.php");
}

if ($_GET['id'] === "") {
    header("location: ./challenge.php");
}

$chall_id = $_GET['id'];

$hint = get_hint_by_id($chall_id)['chal_hint'];

$chall_dir = './data/challenge/' . $chall_id . '/';
$chall = array();
if (is_dir($chall_dir)) {
    if ($dh = opendir($chall_dir)) {
        while (($file = readdir($dh)) !== false) {
            $chall[] = $file;
        }
        closedir($dh);
    } 
}
unset($chall[0]);
unset($chall[1]);
$chall = array_values($chall);
if (!is_chall_id_exist($chall_id)) {
    echo "<script>alert('Challenge not found');</script>";
    header("Refresh:0;url=./challenge.php");
}
if ($chall === []) {
    echo "<script>alert('Answer not found');</script>";
    header("Refresh:0;url=./challenge.php");
} else {
    $full_path = $chall_dir . $chall[0];
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" type="image/png" sizes="12x12" href="./images.png" />
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

    </head>
    <style>
        .test{
            display: flex;
            flex-direction: row-reverse;
            padding: 11px;
        }
        .center {
            display: block;
            margin-left: auto;
            margin-right: auto;
            margin-bottom: 15px;
        }
    </style>
    <body>
        <nav class="navbar navbar-inverse">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="./menu.php">Class Manager</a>
                </div>
                <ul class="nav navbar-nav">
                    <li><a href="./list_user.php">List user</a></li>
                    <li><a href="./homework.php">Homework</a></li>
                    <li class="active"><a href="./challenge.php">Challenge</a></li>
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

        <div class="panel panel-default" style="width: 60%; display: block; margin-left: auto;margin-right: auto;">
            <div class="panel-heading" style="text-align: center; "><h3>Hint: <?php echo $hint; ?></h3></div>
            <form method="POST">
                <textarea type="text" class="input" name="answer" rows="7" style="width: 100%;" placeholder="Write an answer"></textarea>
                <br><br>
                <input type="submit" class="btn btn-lg btn-primary center" name="submit" value="Submit">
            </form>
        </div>   
        <?php
        if (isset($_POST['submit'])) {
            $path = pathinfo($full_path);
            $answer = $path['filename'];
            $your_ans = $_POST['answer'];
            if (strtolower($answer) === strtolower($your_ans)) {
                $myfile = fopen($full_path, "r") or die("Unable to open file!");
                ?>
                <div class="panel panel-default" style="width: 60%; display: block; margin-left: auto;margin-right: auto;padding: 15px;">
                    <?php echo fread($myfile, filesize($full_path)); ?>
                </div>
                <?php
            } else {
                echo "<script>alert('Wrong answer, try again');</script>";
            }
        }
        ?>
    </body>
</html>