<?php

require_once "connection.php";
session_start();


$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";


if($_SERVER["REQUEST_METHOD"] == "POST"){


    if(empty(trim($_POST["uname"]))){
        $username_err = "Please enter a username.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE userName = :userName";

        if($stmt = $connection->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":userName", $param_username, PDO::PARAM_STR);


            $param_username = trim($_POST["uname"]);
            $_SESSION["param_username"] = $param_username;


            if($stmt->execute()){
                if($stmt->rowCount() == 1){
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
    }else{
        $password = trim($_POST["upassword"]);
    }

    // Validate confirm password
    if(empty(trim($_POST["cpassword"]))){
        $confirm_password_err = "Please confirm password.";
    } else{
        $confirm_password = trim($_POST["cpassword"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }


    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){
        $newUserName = $_SESSION["param_username"];
        // Prepare an insert statement
        $sql = "UPDATE users SET userName = '$newUserName',  password= :password WHERE userName = :old_username";

        if($stmt = $connection->prepare($sql)){

            $stmt->bindParam(":password", $param_password, PDO::PARAM_STR);
            $stmt->bindParam(":old_username", $param_session, PDO::PARAM_STR);


            $param_username = $username;
            $param_password = $password;
            $param_session =  $_SESSION["uname"];


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
    <title>Ales Book Store | Profile</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link rel="icon" type="image/png" sizes="32x32" href="images/favicon-32x32.png">
    <link rel="stylesheet" href="CSS/style.css">
    <link rel="stylesheet" href = "https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">

    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
        <a class="dropdown-item" href="categorizingMystery.php">Mystery</a>
        <a class="dropdown-item" href="categorizingFantastic.php">Fantastic</a>
        <a class="dropdown-item" href="categorizingAction.php">Action</a>

    </div>
    <a class="navbar-brand" href="index.php">Ales Book Store</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="home.php"><i class="fa fa-home" aria-hidden="true"></i>Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="https://alimarangoz.github.io/My-Site/"><i class="fa fa-user" aria-hidden="true"></i>About Us</a>
            </li>

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-envelope" aria-hidden="true"></i>Contact</a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="mailto:ali.marangoz1999@gmail.com">E-mail</a>
                    <a class="dropdown-item" href="https://www.linkedin.com/in/ali-marangoz-794760194/">Linkedin</a>
                </div>
            </li>
            <li class="nav-item">

            </li>

        </ul>

        <div class="divbtN"><button style="margin:10px;" class="btn btn-outline my-2 my-sm-0" type="submit"><a style="text-decoration: none;" href="profile.php"><i class="fa fa-user" aria-hidden="true"> PROFILE</i></a></button></div>
        <div class="divbtN2"><button class="btn btn-outline my-2 my-sm-0" type="submit"><a style="text-decoration: none;" href="logout.php"><i class="fa fa-sign-out" aria-hidden="true"> LOG OUT</i></a></button></div>


    </div>
</nav>

<div class="formClass" style="height: 70px; width: 250px; display: flex; margin-left: 40%">

    <div class="secondDiv">

        <form style="margin-left: 10px;" action="profile.php" method="post">
            <h3 style="margin-top: 70px">Change Profile</h3>
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Username</label>
                <input placeholder="Enter an username" type="text" name="uname" class="form-control" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Password</label>
                <input placeholder="Enter a password" type="password" name="upassword" class="form-control" value="<?php echo $password; ?>">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <label>Confirm Password</label>
                <input placeholder="Confirm Password" type="password" name="cpassword" class="form-control" value="<?php echo $confirm_password; ?>">
                <span class="help-block"><?php echo $confirm_password_err; ?></span>
            </div>

            <button type="submit" style="height: 35px; width: 80px" class="btn-primary">Change</button>

        </form>
    </div>
</div>
</body>
</html>