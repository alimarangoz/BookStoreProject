<?php
require_once "connection.php";
session_start();
$bookname = $bookname_err = $author = $price_err =$author_err = $image = $image_err = $bookcategory = $bookcategory_err = "";
$price = 0;


if($_SERVER["REQUEST_METHOD"]=="POST"){
    if(empty(trim($_POST["bookname"]))){
        $bookname_err = "Enter a book name";
    }else{
        $sql = "select name from books where name = :name";

        if($stmt = $connection->prepare($sql)){
            $stmt->bindParam(":name",$parameter_bookname,PDO::PARAM_STR);
            $parameter_bookname = trim($_POST["bookname"]);


            if($stmt->execute()){
                if($stmt->rowCount() == 1){
                    $bookname_err = "This book is already added";
                }else{
                    $bookname_err = trim($_POST["bookname"]);
                }
            }else{
                echo "Error in execute!";
            }
        }
        unset($stmt);
    }

    if(empty(trim($_POST["author"]))){
        $author_err = "Enter an author name";
    }else{
        $sql1 = "select id from authors where name = :name";
        //$sql4 = "insert into authors values(:name)";
        if($stmt1 = $connection->prepare($sql1)){
            $stmt1->bindParam(":name",$parameter_author,PDO::PARAM_STR);
            $parameter_author = trim($_POST["author"]);

            if($stmt1->execute()){
                if($stmt1->rowCount()==1){
                    $row = $stmt1->fetchAll(PDO::FETCH_ASSOC);
                    $author = $row[0]["id"];
                }else{
                    $author_err = "$author". " is not in your author list!.";
                }
            }else{
                echo "Error in execute!";
            }
        }
        unset($stmt1);
    }

    if(empty(trim($_POST["price"]))){
        $price_err = "Enter a price.";
    }else{
        $price = $_POST["price"];

    }

    if(empty(trim($_POST["bookcategory"]))){
        $bookcategory_err = "Enter a book category.";
    }else{
        $sql2 = "select id from bookcategory where name = :name";

        if($stmt2 = $connection->prepare($sql2)){
            $stmt2->bindParam(":name",$parameter_category,PDO::PARAM_STR);
            $parameter_category = trim($_POST["bookcategory"]);
            if ($stmt2->execute()){
                if($stmt2->rowCount() == 1){
                    $row1 = $stmt2->fetchAll(PDO::FETCH_ASSOC);
                    $bookcategory = $row1[0]["id"];
                }else{
                    echo "This category is not in your list.";
                }
            }else{
                echo "Error in execute!";
            }
            unset($stmt2);
        }
    }

    if(empty(trim($_POST["image"]))){
        $image_err = "Enter an image!";
    }else{
        $image = $_POST["image"];
    }

    if(!(empty($bookname)  && empty($price) && empty($author))){

        $sql3 = "insert into books(name,price,image,authorid,categoryid) values (:name,:price,:image,:authorid,:categoryid)";

        if($stmt3 = $connection->prepare($sql3)){
            $stmt3->bindParam(":name",$parameter_bookname,PDO::PARAM_STR);
            $stmt3->bindParam(":price",$parameter_price,PDO::PARAM_INT);
            $stmt3->bindParam(":image",$parameter_image,PDO::PARAM_STR);
            $stmt3->bindParam(":authorid",$parameter_authorid,PDO::PARAM_INT);
            $stmt3->bindParam(":categoryid",$parameter_categoryid,PDO::PARAM_INT);

            $parameter_bookname = trim($_POST["bookname"]);
            echo "$bookname"."1";
            $parameter_price = $price;
            $parameter_image = $image;
            $parameter_authorid = $author;
            $parameter_categoryid = $bookcategory;

            if($stmt3->execute()){

                header("location: home.php");
            }else{
                echo "Error in execute!";
            }

            unset($stmt3);

        }

    }

    unset($connection);

}

?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ales Book Store | Adding Book</title>
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

<div class="formClass" style="height: 70px; width: 250px; display: flex; margin-left: 40%">

    <div class="secondDiv">

        <form style="margin-left: 10px;" action="addingBook.php" method="post">
            <h3 style="margin-top: 10px">Adding Book</h3>
            <div class="form-group <?php echo (!empty($bookname_err)) ? 'has-error' : ''; ?>">
                <label>Book Name</label>
                <input type="text" name="bookname" class="form-control" value="<?php echo $bookname; ?>">
                <span class="help-block"><?php echo $bookname_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($author_err)) ? 'has-error' : ''; ?>">
                <label>Author</label>
                <input type="text" name="author" class="form-control" value="<?php echo $author; ?>">
                <span class="help-block"><?php echo $author_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($price_err)) ? 'has-error' : ''; ?>">
                <label>Price</label>
                <input type="number" name="price" class="form-control" value="<?php echo $price; ?>">
                <span class="help-block"><?php echo $price_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($bookcategory_err)) ? 'has-error' : ''; ?>">
                <label>Category</label>
                <input type="text" name="bookcategory" class="form-control" value="<?php echo $bookcategory; ?>">
                <span class="help-block"><?php echo $bookcategory_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($image_err)) ? 'has-error' : ''; ?>">
                <label>Image location</label>
                <input type="text" name="image" class="form-control" value="<?php echo $image; ?>">
                <span class="help-block"><?php echo $image_err; ?></span>
            </div>
            <div class="form-group">
                <input style="margin-top: 10px" type="submit" class="btn btn-primary" value="Add Book">
            </div>
        </form>
    </div>
</div>

</body>

</html>
