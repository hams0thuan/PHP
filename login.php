<?php
require './lib/function.php';
require './lib/initial.php';

//password is their fullname no capital no space, ex: ronaldo | phamvietthang

/*When you open xampp and turn on SQL, you need cancel comment "add_data_to_db(); and ctrl + s to save.
  You need comment later, because when database run the line, it delete in my code */
//add_data_to_db(); 

session_start();

if (isset($_COOKIE['Cookie'])) {
    header("Location: ./menu.php");
}

if (isset($_POST['submit'])) {
    $user = isset($_POST['username']) ? $_POST['username'] : "";
    $pass = hash('sha256', isset($_POST['pwd']) ? $_POST['pwd'] : "");

    $result = get_pass_by_username($user);
    if ($result === null) {
        $message = "Sorry, account has not registered!!!";
        echo "<script type='text/javascript'>alert('$message');</script>";
    } else {
        if ($result['user_pass'] === $pass) {
            $id = get_ID_by_username_and_pass($user, $pass);
            $tmp = $id['user_id'] . ";" . $user . ";" . $pass;
            setcookie("Cookie", $tmp, time() + 3600, '', '', 1, 1);
            header("Location: menu.php");
        } else {
            $message = "Wrong username or password";
            echo "<script type='text/javascript'>alert('$message');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="icon" type="image/png" sizes="12x12" href="./images.png" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>


<body style="background-image: url('./bg.png'); background-size: cover;">
    <section class="vh-100 gradient-custom">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card bg-dark text-white" style="border-radius: 1rem;">
                        <form method="POST">
                            <div class="card-body mt-4 p-5 text-center">
                                <h2 class="fw-bold mb-2 text-uppercase">Login</h2>
                                <p class="text-white-50">Please enter your login and password!</p>
                                <div class="text-center my-2">
                                    <img src="./Mu.png" />
                                </div>
                            </div>
                            <div class="card-body p-5">
                                <div class="form-outline form-white mb-2">
                                    <label class="form-label" for="username">Username</label>
                                    <span class="span"></span>
                                    <input type="text" name="username" class="form-control form-control-lg" required />
                                </div>
                                <div class="form-outline form-white mb-2">
                                    <label class="form-label" for="password">Password</label>
                                    <span class="span"></span>
                                    <input type="password" name="pwd" class="form-control form-control-lg" required />
                                </div>
                            </div>
                            <div class="card-body p-5 mb-2 text-center">
                                <button class="btn btn-outline-light btn-lg px-5" type="submit" name="submit" value="1">Login</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        </div>
        <footer class="text-center text-light bg-dark fixed-bottom">
            <a class="text-reset nav-link fw-bold" href="https://www.manutd.com/">Manchester United</a>
        </footer>
        </div>
    </section>
</body>

</html>