<?php
require './lib/function.php';

if (!isset($_COOKIE['Cookie'])) {
    header("location: ./login.php");
}
$cur_id = explode(";", $_COOKIE['Cookie'])[0];
$cur_username = explode(";", $_COOKIE['Cookie'])[1];
$user = get_user($cur_id);
$role = get_role($cur_id)['user_role'];

$chall_dir = './data/challenge/';
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
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <link rel="icon" type="image/png" sizes="12x12" href="./images.png" />
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
    </style>
    <body>
        <nav class="navbar navbar-inverse">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="./menu.php">Home</a>
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
        <div class="container"><h1 style="text-align: center;">CHALLENGE</h1></div>
        <?php if (($role) === '2') : ?>
            <a class="btn btn-primary" href="./add_challenge.php" style="display: block; margin-left: auto; margin-right: auto;width: 50%" >Add challenge</a><br /><br />
        <?php endif; ?>
        <div class="list-group" style="width: 50%;display: block;margin-left: auto;margin-right: auto;">
            <?php if ($chall !== []) { ?>
                <?php foreach ($chall as $item) {?>
            
                    <a href = "./submit_challenge.php?id=<?php echo $item; ?>" class = "list-group-item"><?php echo "Challenge " . $item; ?> <?php if ($role === '2') { ?><span style="display: inline;float: right;"> <form method="post"> <input type="hidden" name="id" value="<?php echo $item; ?>"/>
                                    <input onclick="return confirm('Are you sure to delete?');" type="submit" name="delete" value="Delete"/></form></span><?php } ?></a>
                    <?php
                }
            } else {
                ?>
                <p class = "list-group-item"> Challenge is empty, please add more !</p>
            <?php } ?>
        </div>
        <?php
        if (isset($_POST['delete'])) {
            if ($role === '2') {
                $id_chall = $_POST['id'];
                Delete($chall_dir.$id_chall);
                delete_chall($id_chall);
            }
            header("Location: challenge.php");
        }
        ?>
    </body>
</html>
