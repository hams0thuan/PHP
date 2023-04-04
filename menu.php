<?php
require './lib/initial.php';
require './lib/function.php';

if (!isset($_COOKIE['Cookie'])) {
    header("location: ./login.php");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Student Manager</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" sizes="12x12" href="./images.png" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<style>
    .test {
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
                <li><a href="./list_user.php">List Player</a></li>
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
   
    <div class="home-article-detail__top-panel">
        <div class="grid-12 ratio">
            <div class="mu-content">
                <article class="mu-item xlarge">
                    <div class="img-holder">
                        <figure class="adaptive figure-adaptive " style="background-image: url(&quot;//assets.manutd.com/AssetPicker/images/0/0/17/97/1139115/A_2223_Name_Article_copy1661859595096_medium.webp&quot;); opacity: 1;">
                            <img class="img-responsive img-zoom visually-hidden no-img" alt="" title="" src="//assets.manutd.com/AssetPicker/images/0/0/17/97/1139115/A_2223_Name_Article_copy1661859595096_medium.webp">
                            <div class="mu-item__gradient--left" style="display:none"></div>
                            <div class="mu-item__gradient"></div>
                        </figure>
                    </div>
                    <div class="home-article-detail__info">
                        <h1 data-impression="article|United reach agreement for Antony transfer" class="home-article-detail__title" id="hybridTitle" style="backface-visibility:hidden;-webkit-backface-visibility:hidden">United reach agreement for Antony transfer</h1>
                    </div>
                </article>
            </div>
        </div>
    </div>
</body>

</html>