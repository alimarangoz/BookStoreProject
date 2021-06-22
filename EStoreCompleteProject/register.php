<?php

require_once "connection.php";

$username_err = $password_err = $conf_password_err = "";
$username = $password = $confirm_password = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){

    if(empty(trim($_POST["uname"]))){
        $username_err = "Please enter a username.";
    }else{
        $sql = "select id from users where userName = :userName ";


            if($stmt = $connection->prepare($sql)){

                $param_username = trim($_POST["uname"]);

                $stmt->bindParam(":userName", $param_username, PDO::PARAM_STR);


                if($stmt->execute()){
                    if($stmt->rowCount() == 1){
                        $username_err = "This username is already taken.";
                    } else{
                        $username = trim($_POST["uname"]);
                    }
                } else{
                    echo "Oops! Something went wrong. Please try again later.";
                }
                unset($stmt);
            }

    }
    if(empty(trim($_POST["upassword"]))){
        $password_err = "Please enter a password.";
    } elseif(strlen(trim($_POST["upassword"])) < 6){
        $password_err = "Password must have at least 6 characters.";
    } else{
        $password = trim($_POST["upassword"]);
    }

    if(empty(trim($_POST["cpassword"]))){
        $confirm_password_err = "Please confirm password.";
    } else{
        $confirm_password = trim($_POST["cpassword"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }

    if(empty($username_err) && empty($password_err) && empty($conf_password_err)){
        $sql = "INSERT INTO users (userName, password) VALUES (:userName, :password)";

            if($stmt=$connection->prepare($sql)){
                $stmt->bindParam(":userName", $param_username, PDO::PARAM_STR);
                $stmt->bindParam(":password", $param_password, PDO::PARAM_STR);

                // Set parameters
                $param_username = $username;
                $param_password = $password;
                    //password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
                // Attempt to execute the prepared statement
                if($stmt->execute()){
                    // Redirect to login page
                    header("location: login.php");
                } else{
                    echo "Something went wrong. Please try again later.";
                }

                unset($stmt);

            }




    }
    unset($connection);


}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
    <link rel="icon" type="image/png" sizes="32x32" href="images/favicon-32x32.png">

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>


</head>
<body>

<style>

    html{
        height: 100%;
    }

    .card-header-color{
        background-color: #89e967;
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
        background-image: url('images/signup-background.jpg');
        background-position: center;
        background-size: contain;

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
                    <h4 align="center">SIGN UP</h4>

                </div>

                <div class="card-body card-body-color">

                    <form action="register.php" method="post">

                        <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                            <label for="name">Username</label>
                            <input class="form-control" type="text" placeholder="Please enter your name" id="uname" name="uname">
                            <span class="help-block"><?php echo $username_err; ?></span>
                        </div>

                        <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                            <label for="pass">Password</label>
                            <input class="form-control" type="password" placeholder="Please enter your password" id="upassword" name="upassword">
                            <span class="help-block"><?php echo $password_err; ?></span>
                        </div>

                        <div class="form-group <?php echo (!empty($conf_pass_err)) ? 'has-error' : ''; ?>">
                            <label for="pass">Confirm Password</label>
                            <input class="form-control" type="password" placeholder="Please enter your password again" id="cpassword" name="cpassword">
                            <span class="help-block"><?php echo $conf_password_err; ?></span>
                        </div>
                        <div class="btn div"><button class="btn btn-primary" type="submit">SIGN UP</button></div>

                        <p>Already have an account? <a href="login.php">Login here</a>.</p>
                    </form>

                </div>


            </div>

        </div>

        <div class="col-4"></div>

    </div>


</div>


</body>
</html>