<?php
require './lib/function.php';

if (!isset($_COOKIE['Cookie'])) {
    header("location: ./login.php");
}

$cur_id = explode(";", $_COOKIE['Cookie'])[0];
$cur_username = explode(";", $_COOKIE['Cookie'])[1];
$user = get_user($cur_id);
$role = get_role($cur_id)['user_role'];

if ($role !== '2') {
    header("location: ./challenge.php");
}

if (isset($_POST['upload'])) {
    if ($role === '2') {
        $result = upload_challenge();
        if ($result !== null) {
            add_challenge($_POST['hint']);
            echo "<script type='text/javascript'>alert('Challenge create successed');</script>";
        } else {
            echo "<script type='text/javascript'>alert('Challenge create failed');</script>";
        }
    } else {
        echo "<script type='text/javascript'>alert('You dont have permission');</script>";
        header("Refresh:0; url=challenge.php");
    }
}
?>

<html>
    <head>           
        <title>Create challenge</title>
        <link rel="icon" type="image/png" sizes="12x12" href="./images.png" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <div style="padding: 10px;">
        <button class="btn btn-primary btn-lg" style="display: block; margin-left: auto; margin-right: auto;" onclick="window.location = './challenge.php'">Back</button>
    </div>
</head>
<body style="background-color: #F8F9FA" >

    <div class="container mt-5 px-5 py-5 border" style="width: 60%;background-color: white; border-radius: 10px;" >
        <form method="POST" enctype="multipart/form-data">
            <h1 style="text-align: center">Create challenge</h1><br><br>
            <h4>Enter hint:</h4>
            <div class="input-group mt-3">
                <textarea class="form-control" aria-label="With textarea" rows="7" name="hint" required placeholder="Hint" style="background-color: #F8F9FA"></textarea>
            </div>
            <br><br>
            <h4>Select file to upload:</h4>
            <div class="input-group mb-3">
                <input type="file" class="form-control mt-3" id="inputGroupFile02" name="fileToUpload">
            </div>
            <div class="d-flex justify-content-center">
                <input type="submit" class="input-group-text mt-3" name="upload" value="Upload">
            </div>
        </form>
    </div>
</body>
</html>