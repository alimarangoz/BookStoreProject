<?php
session_start();

$name ="";
$password = "";

$username_err ="";
$password_err ="";


if($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST['uname'];
    $pass = $_POST['upassword'];
    $_SESSION["uname"] = $name;
    $_SESSION["upassword"] = $pass;


    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "bookstoredb";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "select * from users where userName = '$name' and password = '$pass'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row

        while ($row = $result->fetch_assoc()) {
            if($row['userName'] == $name && $row['password'] ==$pass){
                $_SESSION["loggedin"] = true;
                header("Location: home.php");
            }
        }
    }else {
        if (empty(trim($_POST['uname']))) {
            $username_err = "Please enter an username.";
        }

        if (empty(trim($_POST['upassword']))) {
            $password_err = "Please enter a password.";
        }
    }
    $conn->close();

}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
    <link rel="icon" type="image/png" sizes="32x32" href="images/favicon-32x32.png">

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>


</head>
<body>

<style  >

    html{
        height: 100%;
    }

    .card-header-color{
        background-color: #2ce38d;
        color: #fff;

    }

    .card-body-color{
        background-color: #E8EFE6;
    }


    .background-image{
        position: absolute;
        top:0;
        width: 100%;
        height: 100%;
       background-image: url('images/login-page.jpg');
        background-position: center;
        background-size: contain;

        .error{
            background:firebrick;
            color: red;
            padding: 10px;
            width: 95%;
            border-radius: 5px;
        }

    }


</style>

<div class="background-image">
</div>



<div class="container" style="margin-top: 150px; ">


    <div class="row">

        <div class="col-4">

        </div>

        <div class="col-4">

            <div class="card">

                <div class="card-header card-header-color">
                    <h4 align="center">LOGIN</h4>

                </div>

                <div class="card-body card-body-color">

                    <form action="login.php" method="post">

                        <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                            <label for="name">Username</label>
                            <input class="form-control" type="text" placeholder="Please enter your name" id="uname" name="uname" value="<?php echo $name; ?>">
                            <span class="help-block"><?php echo $username_err; ?></span>
                        </div>

                        <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                            <label for="pass">Password</label>
                            <input class="form-control" type="password" placeholder="Please enter your password" id="upassword" name="upassword">
                            <span class="help-block"><?php echo $password_err; ?></span>
                        </div>
                        <div class="btndiv"><button class="btn btn-primary" type="submit">LOGIN</button></div>
                        <p>If you don't have an account, <a href="register.php">SIGN UP</a>.</p>

                    </form>

                </div>


            </div>

        </div>

        <div class="col-4"></div>

    </div>


</div>


</body>
</html>