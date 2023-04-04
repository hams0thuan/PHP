<?php
require './lib/function.php';

if (!isset($_COOKIE['Cookie'])) {
    header("location: ./login.php");
}

$role = get_role(explode(";", $_COOKIE['Cookie'])[0])['user_role'];

if ($role === "3") {
    header("location: ./list_user.php");
}

if (isset($_POST['add_stu'])) {
    if (check_username_exist($_POST['username'])) {
        echo "<script>alert('Username already exist!');</script>";
        header("Refresh:5;Location: ./user_add.php");
    } else {
        add_student($_POST['name'], $_POST['sex'], $_POST['mobile'], $_POST['email'], $_POST['address'], $_POST['username'], $_POST['password']);
        header("location: ./list_user.php");
    }
}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Student Manager</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" type="image/png" sizes="12x12" href="./images.png" />
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
                        <img src="./lib/logout.png" alt="Logo" style="width:27px;" class="rounded-pill">
                    </a>    
                    <a style="margin-right: 20px;" href="./profile.php">
                        <img src="./lib/profile.png" alt="Logo" style="width:40px;" class="rounded-pill">
                    </a>
                </div>
            </div> 
        </nav>

        <div class="container bootstrap snippet">
            <div class="row">
                <div class="col-sm-10" style="text-align: center"><h2>Add new user</h2></div>
            </div> <br><br>
            <div class="row">
                <div class="col-sm-3"><!--left col-->

                    <div class="text-center">
                        <img src="http://ssl.gstatic.com/accounts/ui/avatar_2x.png" class="avatar img-circle img-thumbnail" alt="avatar">         
                    </div></hr><br>

                </div><!--/col-3-->
                <div class="col-sm-9">
                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#home">User detail</a></li>
                    </ul>


                    <div class="tab-content">
                        <div class="tab-pane active" id="home">
                            <hr>
                            <form class="form" method="post" id="registrationForm">
                                <div class="form-group">

                                    <div class="col-xs-6">
                                        <label for="first_name"><h4>Username</h4></label>
                                        <input type="text" class="form-control" name="username" id="username" pattern="^(?=.{5,20}$)(?![_.])(?!.*[_.]{2})[a-zA-Z0-9._]+(?<![_.])$" title="A good username will be contained 5-20 characters!" placeholder="Enter username". 
                                               title="Enter your username." required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-xs-6">
                                        <label><h4>Password</h4></label>
                                        <input type="password" class="form-control" name="password" id="password" placeholder="Enter password". 
                                               title="Enter password." required>
                                    </div>
                                </div>

                                <div class="form-group">

                                    <div class="col-xs-6">
                                        <label for="last_name"><br><h4>Name</h4></label>
                                        <input type="text" class="form-control" name="name" id="user_name" placeholder="Enter name." 
                                               title="Enter your name." required>
                                    </div>
                                </div>

                                <div class="form-group">

                                    <div class="col-xs-6">
                                        <label for="phone"><br><h4>Sex</h4></label>                             
                                        <select class="form-control" name="sex" id="gender">
                                            <option value="Male" selected>Male</option>
                                            <option value="Female">Female</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-xs-6">
                                        <label for="mobile"><br><h4>Phone</h4></label>
                                        <input type="text" class="form-control" name="mobile" pattern="[0-9]{9,11}" title="A good phone number will be contained 9-11 digits" id="mobile" placeholder="Enter phone number"  required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-xs-6">
                                        <label for="email"><br><h4>Email</h4></label>
                                        <input type="email" class="form-control" name="email" pattern="\b[A-Z0-9a-z._%+-]{5,20}.+@otf\.com\b" title="Before @ requires 5 - 20 characters. After the required @ is otf.com" id="email"  placeholder="someone@example.com" title="Enter email." required>
                                    </div>
                                </div>
                                <div class="form-group">

                                    <div class="col-xs-6" style="width: 100%;">
                                        <label for="email"><br><h4>Address</h4></label>
                                        <input type="Text" class="form-control" name="address" id="location" placeholder="Enter address" title="Enter a location." required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-xs-12" style="margin-top: 30px;">
                                        <br>
                                        <button class="btn btn-lg btn-success" type="submit" name="add_stu" value="Submit"><i class="glyphicon glyphicon-ok-sign"></i> Save</button>
                                        <button class="btn btn-lg" type="reset"><i class="glyphicon glyphicon-repeat"></i>Reset</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div><!--/tab-content-->

                </div><!--/col-9-->
            </div><!--/row-->
        </div>
    </body>
</html>