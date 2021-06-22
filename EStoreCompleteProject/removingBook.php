<?php
require_once "connection.php";
$deletebookname = $deletebookname_err = $deleteimage = $deleteimage_err = "";


if($_SERVER["REQUEST_METHOD"]=="POST"){
    if(empty(trim($_POST["deletebookname"]))){
        $deletebookname_err = "Enter a book name";
    }else{
        $sql = "select name from books where name = :name";

        if($stmt = $connection->prepare($sql)){
            $stmt->bindParam(":name",$parameter_bookname,PDO::PARAM_STR);
            $parameter_bookname = trim($_POST["deletebookname"]);
            $deletebookname = $parameter_bookname;

            if($stmt->execute()){
                if(!($stmt->rowCount() == 1)){
                    $deletebookname_err = "This book is not in your list.";
                }else{
                    //$deletebookname_err = trim($_POST["deletebookname"]);
                }
            }else{
                echo "Error in execute!";
            }
        }
        unset($stmt);
    }

    if(empty(trim($_POST["deleteimage"]))){
        $deleteimage_err = "Enter an image!";
    }else{
        $deleteimage = $_POST["deleteimage"];
    }
    if(!(empty($deletebookname)  && empty($deleteimage))){
        $sql3 = "delete from books where name = :name and image = :image ";

        if($stmt3 = $connection->prepare($sql3)){
            $stmt3->bindParam(":name",$parameter_bookname,PDO::PARAM_STR);
            $stmt3->bindParam(":image",$parameter_image,PDO::PARAM_STR);

            $parameter_bookname = trim($_POST["deletebookname"]);
            $parameter_image = $deleteimage;

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
    <title>Ales Book Store | Removing Book</title>
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
        <form action="removingBook.php" method="post">
            <h3>Deleting Book</h3>
            <div class="form-group <?php echo (!empty($deletebookname_err)) ? 'has-error' : ''; ?>">
                <label>Book Name</label>
                <input type="text" name="deletebookname" class="form-control" value="<?php echo $deletebookname; ?>">
                <span class="help-block"><?php echo $deletebookname_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($deleteimage_err)) ? 'has-error' : ''; ?>">
                <label>Image location</label>
                <input type="text" name="deleteimage" class="form-control" value="<?php echo $deleteimage; ?>">
                <span class="help-block"><?php echo $deleteimage_err; ?></span>
            </div>
            <div class="form-group">
                <input style="margin-top: 10px" type="submit" class="btn btn-primary" value="Remove Book">
            </div>

        </form>
    </div>
</div>

</body>

</html>
