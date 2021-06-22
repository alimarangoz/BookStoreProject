<?php


?>
<html lang="en">
<head>
<meta charset="UTF-8">
    <title>Ales Book Store | Admin</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link rel="icon" type="image/png" sizes="32x32" href="images/favicon-32x32.png">
    <link rel="stylesheet" href="CSS/style.css">
    <link rel="stylesheet" href = "https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>

<nav style="text-align: center" class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="admin.php">Ales Book Store | Administration Page</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">

    </div>
    <ul class="navbar-nav mr-auto">
        <li  class="nav-item active">
            <a class="nav-link" href="home.php"><i class="fa fa-home" aria-hidden="true"></i> Home</a>
        </li>
    </ul>
</nav>

<ul style="font-size: 30px; width: 350px" class="nav-item dropdown">
    <a style="color: black" class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        What you want to do
    </a>
    <div style="font-size: 20px" class="dropdown-menu" aria-labelledby="navbarDropdown">
        <a class="dropdown-item" href="addingBook.php">Add Book</a>
        <a class="dropdown-item" href="removingBook.php">Remove Book</a>
        <a class="dropdown-item" href="updatingBook.php">Update Book</a>
    </div>
</ul>

<img style="margin-left: 450px" src="images/admin-photo.jpg">
<p style="text-align: center; font-size: 45px; margin-top: 10px"><b>Welcome Boss!</b></p>

</body>

</html>