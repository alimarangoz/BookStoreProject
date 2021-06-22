<?php
require_once "connection.php";
session_start();

$id = $id_err = $bookname = $bookname_err = $author = $author_err = $bookcategory = $bookcategory_err = $price = $price_err = $image= $image_err ="";

if($_SERVER["REQUEST_METHOD"] == "POST"){

    if(empty(trim($_POST["id"]))){
        $id_err = "Enter an id.";
    }else{
        $sql = "select id from books where name = :name";

        if($stmt = $connection->prepare($sql)){
            $stmt->bindParam(":name",$parameter_id,PDO::PARAM_INT);
            $parameter_id = trim($_POST["id"]);
            $id = $parameter_id;
            $bookname = trim($_POST["bookname"]);

            if($stmt->execute()){

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

    if(empty(trim($_POST["category"]))){
        $bookcategory_err = "Enter a book category.";
    }else{
        $sql2 = "select id from bookcategory where name = :name";

        if($stmt2 = $connection->prepare($sql2)){
            $stmt2->bindParam(":name",$parameter_category,PDO::PARAM_STR);
            $parameter_category = trim($_POST["category"]);
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

    if(!(empty($id) && empty($bookname) && empty($author) && empty($price) && empty($bookcategory) && empty($image))){

        $sql3 = "update books set name = '$bookname' ,price = '$price' ,image = '$image',authorid= '$author',categoryid = '$bookcategory'
                where id = '$id'";
        $stmt3 = $connection->prepare($sql3);
        if($stmt3->execute()){
            header("Location: home.php");
        }else{
            echo "Error in execute!";
        }
    }
    unset($stmt3);

}
unset($connection);

?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ales Book Store | Updating Book</title>
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

    <div class="secondDiv" style=" position: absolute;height: 70px; width: 250px; margin-top: 30px">
        <form action="updatingBook.php" method="post">
            <h3 style="margin-top: 10px">Updating Book</h3>
            <div class="form-group <?php echo (!empty($id_err)) ? 'has-error' : ''; ?>">
                <label>Id</label>
                <input type="number" name="id" class="form-control" value="<?php echo $id; ?>" placeholder="Enter the id">
                <span class="help-block"><?php echo $id_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($bookname_err)) ? 'has-error' : ''; ?>">
                <label>Book Name</label>
                <input type="text" name="bookname" class="form-control" value="<?php echo $bookname; ?>" placeholder="Enter the new book name">
                <span class="help-block"><?php echo $bookname_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($author_err)) ? 'has-error' : ''; ?>">
                <label>Author</label>
                <input type="text" name="author" class="form-control" value="<?php echo $author; ?>" placeholder="Enter the author">
                <span class="help-block"><?php echo $author_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($price_err)) ? 'has-error' : ''; ?>">
                <label>Price</label>
                <input type="number" name="price" class="form-control" value="<?php echo $price; ?>" placeholder="Enter the new price">
                <span class="help-block"><?php echo $price_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($bookcategory_err)) ? 'has-error' : ''; ?>">
                <label>Category</label>
                <input type="text" name="category" class="form-control" value="<?php echo $bookcategory; ?>" placeholder="Enter the category">
                <span class="help-block"><?php echo $bookcategory_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($image_err)) ? 'has-error' : ''; ?>">
                <label>Image</label>
                <input type="text" name="image" class="form-control" value="<?php echo $image; ?>" placeholder="Enter the new image">
                <span class="help-block"><?php echo $image_err; ?></span>
            </div>
            <div class="form-group">
                <input style="margin-top: 10px" type="submit" class="btn btn-primary" value="Update Book">
            </div>

        </form>
    </div>
</div>

</body>

</html>
