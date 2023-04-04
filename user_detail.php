<?php
require './lib/function.php';

if (!isset($_COOKIE['Cookie'])) {
    header("location: ./login.php");
}

if (!is_user_id_exist($_GET['id'])) {
    header("location: ./list_user.php");
}

$user = get_user($_GET['id']);
$cur_id = explode(";", $_COOKIE['Cookie'])[0];
$role = get_role($cur_id)['user_role'];
$profile_id = $_GET['id'];


if (isset($_POST['submit_comment'])) {
    if ($_POST['comment'] !== "") {
        save_comment($_GET['id'], explode(";", $_COOKIE['Cookie'])[0], explode(";", $_COOKIE['Cookie'])[1], $_POST['comment']);
    }
}

if ($cur_id === $_GET['id']) {
    header("location: ./profile.php");
}

$all_cmt = get_all_comment_of_profile($_GET['id']);

if (isset($_POST['updateInfor'])) {
    if (strtolower($_POST['username']) === strtolower($user['user_username'])) {
        if ($role === '2' && $user['user_role'] === '3') {
            edit_student($user['user_id'], $_POST['name'], $_POST['sex'], $_POST['mobile'], $_POST['email'], $_POST['address'], $_POST['username'], $_POST['password']);
            header("Location: ./list_user.php");
        } else {
            echo "<script>alert('You don\'t have permission');</script>";
            header("Refresh:2;Location: ./list_user.php");
        }
    } else {
        if (check_username_exist($_POST['username'])) {
            echo "<script>alert('Username already exist!');</script>";
            header("Refresh:5;Location: ./list_user.php");
        } else {
            if ($role === '2' && $user['user_role'] === '3') {
                edit_student($user['user_id'], $_POST['name'], $_POST['sex'], $_POST['mobile'], $_POST['email'], $_POST['address'], $_POST['username'], $_POST['password']);
                header("Location: ./list_user.php");
            } else {
                echo "<script>alert('You don\'t have permission');</script>";
                header("Refresh:2;Location: ./list_user.php");
            }
        }
    }
}

if (isset($_POST['del_cmt'])) {

    if ($cur_id === $_POST['commentor_id']) {
        delete_cmt_by_id($_POST['cmt_id']);
        header("location: ./user_detail.php?id=$profile_id");
    } else {
        echo "<script>alert('Something error');</script>";
    }
}

disconnect_db();
?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>User detail</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
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
                    <li><a href="./challenge.php">Challenge</a></li>
                </ul>
                <div class="test">
                    <a href="./logout.php">
                        <img src="./lib/logout.png" alt="Logo" style="width:27px;">
                    </a>    
                    <a style="margin-right: 20px;" href="./profile.php">
                        <img src="./lib/profile.png" alt="Logo" style="width:40px;" class="rounded-pill">
                    </a>
                </div>
            </div> 
        </nav>

        <div class="container bootstrap snippet">
            <div style="margin-bottom: 30px;text-align: center;"><h1>User detail</h1></div>
            <div class="row">
                <div class="col-sm-3"><!--left col-->


                    <div class="text-center">
                        <img src="http://ssl.gstatic.com/accounts/ui/avatar_2x.png" class="avatar img-circle img-thumbnail" alt="avatar">
                    </div></hr><br>


                    <div class="panel panel-default">
                        <div class="panel-heading" style="text-align: center;">Write comment</div>
                        <form method="POST">
                            <textarea type="text" class="input" name="comment" rows="4" style="width: 100%;" placeholder="Write a comment"></textarea>
                            <br><br>
                            <input type="submit" class="center" name="submit_comment" value="Comment">
                        </form>
                    </div>              

                    <div class="panel panel-default">
                        <div class="panel-heading" style="text-align: center;">Comment</div>
                        <div class="panel-body">
                            <?php foreach ($all_cmt as $item) { ?>
                                <?php echo ($item['commentor_username']) . ": " . ($item['comment']); ?>
                                <form method="post">
                                    <?php if ($item['commentor_id'] === $cur_id) { ?>
                                        <br>
                                        <input type="hidden" name="commentor_id" value="<?php echo $item['commentor_id']; ?>"/>
                                        <input type="hidden" name="cmt_id" value="<?php echo $item['cmt_id']; ?>"/>
                                        <input class="center" onclick="return confirm('Are you sure to delete?');" type="submit" name="del_cmt" value="Delete"/>
                                    <?php } ?>
                                </form>
                                <hr>
                            <?php } ?>
                        </div>
                    </div>

                </div><!--/col-3-->
                <div class="col-sm-9">
                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#home">User detail</a></li>
                        <?php if ($role === '2' && $user['user_role'] === '3') { ?>
                            <li><a data-toggle="tab" href="#messages">Update information</a></li>
                        <?php } ?>
                    </ul>


                    <div class="tab-content">
                        <div class="tab-pane active" id="home">
                            <hr>
                            <div class="form-group">

                                <div class="col-xs-6">
                                    <label><h4>ID</h4></label>
                                    <input type="text" class="form-control" readonly value= "<?php echo $user['user_id']; ?>">
                                </div>
                            </div>
                            <div class="form-group">

                                <div class="col-xs-6">
                                    <label><h4>Username</h4></label>
                                    <input type="text" class="form-control" readonly value= "<?php echo $user['user_username']; ?>">
                                </div>
                            </div>

                            <div class="form-group">

                                <div class="col-xs-6">
                                    <label><br><h4>Name</h4></label>
                                    <input type="text" class="form-control" readonly value= "<?php echo ($user['user_name']); ?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-xs-6">
                                    <label><br><h4>Sex</h4></label>
                                    <input type="text" class="form-control" readonly value= "<?php echo ($user['user_sex']); ?>">
                                </div>
                            </div>
                            <div class="form-group">

                                <div class="col-xs-6">
                                    <label><br><h4>Phone</h4></label>
                                    <input type="text" class="form-control" readonly value= "<?php echo ($user['user_mobile']); ?>">
                                </div>
                            </div>
                            <div class="form-group">

                                <div class="col-xs-6">
                                    <label><br><h4>Email</h4></label>
                                    <input type="email" class="form-control" readonly value= "<?php echo ($user['user_email']); ?>">
                                </div>
                            </div>
                            <div class="form-group">

                                <div class="col-xs-6">
                                    <label><br><h4>Job</h4></label>
                                    <input type="text" class="form-control" readonly value= "<?php echo ($user['user_job']); ?>">
                                </div>
                            </div>
                            <div class="form-group">

                                <div class="col-xs-6">
                                    <label><br><h4>Address</h4></label>
                                    <input type="text" class="form-control" readonly value= "<?php echo ($user['user_address']); ?>">
                                </div>
                            </div>
                            <hr>
                        </div>
                        <div class="tab-pane" id="messages">
                            <h2></h2>

                            <hr>
                            <form class="form" method="post" id="registrationForm">
                                <div class="form-group">
                                    <div class="col-xs-6">
                                        <label for="first_name"><h4>Username</h4></label>
                                        <input type="text" class="form-control" name="username" id="username" placeholder="Enter username" 
                                               title="Enter username." value= "<?php echo $user['user_username']; ?>" required>
                                    </div>
                                </div>

                                <div class="form-group">

                                    <div class="col-xs-6">
                                        <label><h4>Password</h4></label>
                                        <input type="password" class="form-control" name="password" id="password" placeholder="Enter password" 
                                               title="Enter password." required>
                                    </div>
                                </div>

                                <div class="form-group">

                                    <div class="col-xs-6">
                                        <label for="last_name"><br><h4>Name</h4></label>
                                        <input type="text" class="form-control" name="name" id="user_name" placeholder="Enter name" 
                                               title="Enter name." value= "<?php echo $user['user_name']; ?>" required>
                                    </div>
                                </div>                              

                                <div class="form-group">

                                    <div class="col-xs-6">
                                        <label for="phone"><br><h4>Sex</h4></label>                             
                                        <select class="form-control" name="sex" id="gender">
                                            <option value="Male" <?php
                                            if ($user['user_sex'] === 'Male') {
                                                echo "selected";
                                            }
                                            ?>>Male</option>
                                            <option value="Female" <?php
                                            if ($user['user_sex'] === 'Female') {
                                                echo "selected";
                                            }
                                            ?>>Female</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-xs-6">
                                        <label for="mobile"><br><h4>Phone</h4></label>
                                        <input type="text" class="form-control" name="mobile" id="mobile" placeholder="Enter phone number" title="Enter phone number." value= "<?php echo $user['user_mobile']; ?>" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-xs-6">
                                        <label for="email"><br><h4>Email</h4></label>
                                        <input type="email" class="form-control" name="email" id="email" placeholder="someone@example.com" title="Enter email." value= "<?php echo $user['user_email']; ?>" required>
                                    </div>
                                </div>
                                <div class="form-group">

                                    <div class="col-xs-6" style="width:100%;">
                                        <label for="email"><br><h4>Address</h4></label>
                                        <input type="Text" class="form-control" name="address" id="location" placeholder="Enter address" title="Enter a location" value= "<?php echo $user['user_address']; ?>" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-xs-12" style="margin-top: 30px;">
                                        <br>
                                        <button class="btn btn-lg btn-success" type="submit" name="updateInfor" value="Submit"><i class="glyphicon glyphicon-ok-sign"></i> Save</button>
                                        <button class="btn btn-lg" type="reset"><i class="glyphicon glyphicon-repeat"></i>Reset</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</html>