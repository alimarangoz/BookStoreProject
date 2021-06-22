<?php
session_start();
if(!isset($_SESSION["loggedin"]) || ($_SESSION["loggedin"]) !== true ){
    header("location: login.php");

}else{
    header("location: home.php");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ales Book Store</title>
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
    <a style="color: black" class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Category
    </a>
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
                <a class="nav-link" href="cart.php"><i class="fa fa-shopping-cart" aria-hidden="true"></i>Cart<span></span></a>
            </li>
        </ul>

            <button style="margin:10px;" class="btn btn-outline my-2 my-sm-0" type="submit"><a style="text-decoration: none;" href="login.php"><i class="fa fa-sign-in" aria-hidden="true"> LOGIN</i></a></button>
        <button class="btn btn-outline my-2 my-sm-0" type="submit"><a style="text-decoration: none;" href="register.php"><i class="fa fa-user-plus" aria-hidden="true"> SIGN UP</i></a></button>

    </div>
</nav>

<div id="content">

    <?php

    require_once "connection.php";

    $stmt = $connection->prepare("select * from books");
    $stmt->execute();
    $books = $stmt->fetchAll();

    foreach ($books as $row){
        $id = $row["authorid"];
        $stmt2 = $connection->prepare("select name from authors where id = $id");
        $stmt2->execute();
        $author = $stmt2->fetchAll(PDO::FETCH_ASSOC);
        $bookName = $row["name"];
        $bookNameSpc = str_replace(' ', '', $bookName);
        echo "<div class='item'>
			  <form method='post' action=''>
			  <input type='hidden' name='book' value=".$bookNameSpc.' '."/>
			  <div class='image' ><img height='200px' src='".$row['image']."' /></div>
			  <div class='bookNames'>".$row['name']."</div>
			  <div class='bookNames' style='color: #007bff'>".$author[0]['name']."</div>
		   	  <div class='price'>$".$row['price']."</div>
			  
			  </form>
		   	  </div>";
    }

    ?>

</div>


</div>

<script type="text/javascript" src="js/script.js" async></script>

</body>
</html>