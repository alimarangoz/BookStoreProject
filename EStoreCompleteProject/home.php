<?php

require_once("connection.php");
session_start();

if(!isset($_SESSION["loggedin"]) || ($_SESSION["loggedin"]) !== true ){
    header("location: login.php");
    exit;
}


if (isset($_POST['book']) && $_POST['book']!="") {
    $book = $_POST['book'];
    $book = preg_replace('/(?<!\ )[A-Z]/', ' $0', $book);
    $book = ltrim($book);

    $sql = $connection->prepare("select * from books where name = '$book'");
    $sql->execute();

    $sql = $sql->fetchAll(PDO::FETCH_ASSOC);
    $name = $sql[0]["name"];
    $price = $sql[0]["price"];
    $image = $sql[0]["image"];

    $cart = array(
            $book=>array(
            "name"=>$name,
            "price"=>$price,
            "quantity"=>1,
            "image"=>$image)
    );

    if(empty($_SESSION["cart"])){
        $_SESSION["cart"] = $cart;

    }else{
        $array = array_keys($_SESSION["cart"]);
        if(in_array($book,$array)){

        }else{
            $_SESSION["cart"] = array_merge($_SESSION["cart"],$cart);
        }
    }

}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ales Book Store | Home</title>
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
        <div class="navbar-nav mr-auto">
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
                <?php
                static $count = 0;
                if(!empty($_SESSION["cart"])){
                    $count = count(array_keys($_SESSION["cart"]));
                }
                ?>
                <a class="nav-link" href="cart.php"><i class="fa fa-shopping-cart" aria-hidden="true"></i>Cart<span> <?php echo $count; ?> </span></a>

            </li>
            <li style="margin-left: 80px" class="nav-item">
                <form action="searchingResult.php" method="post">
                    <input style="height:40px; width:200px" class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search" name="search" id="search">
                    </li>
                    <li class="nav-item">
                    <button formmethod="post" class="btn btn-outline-success my-2 my-sm-0" type="submit" >Search</button>
                    </li>
                </div>
        </form>
    </div>




        <div class="divbtN"><button style="margin:10px;" class="btn btn-outline my-2 my-sm-0" type="submit"><a style="text-decoration: none;" href="profile.php"><i class="fa fa-user" aria-hidden="true"> PROFILE</i></a></button></div>
        <div class="divbtN2"><button class="btn btn-outline my-2 my-sm-0" type="submit"><a style="text-decoration: none;" href="logout.php"><i class="fa fa-sign-out" aria-hidden="true"> LOG OUT</i></a></button></div>

        <?php
        $user = htmlspecialchars($_SESSION["uname"]);
        $sql = "SELECT userName from users where privilege = 1";
        foreach ($connection->query($sql) as $row) {
            if($row["userName"] == $user ){
                echo "<button style='margin:10px;' class='btn btn-outline my-2 my-sm-0' type='submit'><a href='admin.php'><i class='fa fa-lock' aria-hidden='true'> ADMIN</i></a></button>";
            }

        }
        ?>


    </div>
</nav>

<div id="content">

<?php

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
        echo "<div style='margin-top: 30px' class='item'>
			  <form method='post' action=''>
			  <input type='hidden' name='book' value=".$bookNameSpc.' '."/>
			  <div class='image' ><img height='200px' src='".$row['image']."' /></div>
			  <div class='bookNames'>".$row['name']."</div>
			  <div class='bookNames' style='color: #007bff'>".$author[0]['name']."</div>
		   	  <div class='price'>$".$row['price']."</div>
			  <button type='submit' class='btn btn-light cartButton'><i class='fa fa-shopping-cart' aria-hidden='true'></i><a class='add-cart'>ADD TO CART</a></button>
			  </form>
		   	  </div>";
    }

?>

</div>

<script type="text/javascript" src="js/script.js" async></script>

</body>
</html>