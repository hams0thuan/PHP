<?php
require './lib/function.php';

if (!isset($_COOKIE['Cookie'])) {
    header("location: ./login.php");
}

$user = get_all_user();
$role = get_role(explode(";", $_COOKIE['Cookie'])[0])['user_role'];
disconnect_db();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>List all user</title>
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
        table {
            width: 90%;
            margin-left: auto;
            margin-right: auto;
            border: 1px solid;
        }
        td {
            padding: 10px;
            border: 1px solid;
        }
        div.inline{
            padding: 1px;
        }
    </style>
    <body>
        <nav class="navbar navbar-inverse">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="./menu.php">Home</a>
                </div>
                <ul class="nav navbar-nav">
                    <li class="active"><a href="./list_user.php">List user</a></li>
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
        <div class="inline">
            <h2 style="text-align: center; margin-bottom: -30px;">List User</h2><br/>
            <?php if ($role === '2') { ?>
                <form method="POST" action="./user_add.php">
                    <input type="submit" name="add" style="margin-left: 5%;" value="Add new student">
                </form>
            <?php } ?>
            <br>
        </div>   

        <table>
            <tr>
                <td><h4>ID</h4></td>
                <td><h4>Name</h4></td>
                <td><h4>Sex</h4></td>
                <td><h4>Job</h4></td>
                <td><h4>Mobile</h4></td>
                <td><h4>Options</h4></td>
            </tr>
            <?php foreach ($user as $item) { ?>
                <tr>
                    <td><?php echo $item['user_id']; ?></td>
                    <td><?php echo $item['user_name']; ?></td>
                    <td><?php echo $item['user_sex']; ?></td>
                    <td><?php echo $item['user_job']; ?></td>
                    <td><?php echo $item['user_mobile']; ?></td>
                    <td>
                        <form method="post" action="user_delete.php">
                            <input onclick="window.location = 'user_detail.php?id=<?php echo $item['user_id']; ?>'" type="button" value="Detail"/>
                            <?php if ($role === '2' && $item['user_role'] === '3') { ?>
                                <input type="hidden" name="id" value="<?php echo $item['user_id']; ?>"/>
                                <input onclick="return confirm('Are you sure to delete?');" type="submit" name="delete" value="Delete"/>
                            <?php } ?>
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </body>
</html>