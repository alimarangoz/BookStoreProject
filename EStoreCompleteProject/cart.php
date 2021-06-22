<?php

session_start();

if (isset($_POST['action']) && $_POST['action']=="remove"){
    if(!empty($_SESSION["cart"])) {
        foreach($_SESSION["cart"] as $key => $value) {
            if($_POST["name"] == $key){
                unset($_SESSION["cart"][$key]);

            }
            if(empty($_SESSION["cart"]))
                unset($_SESSION["cart"]);
        }
    }
}

if (isset($_POST['action']) && $_POST['action']=="change"){
    foreach($_SESSION["cart"] as &$value){
        if($value['name'] === $_POST["name"]){
            $value['quantity'] = $_POST["quantity"];
            break; // Stop the loop after we've found the product
        }
    }

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ales Book Store | Cart</title>
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
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit"><a href="logout.php"></a>LOG OUT</button>

    </div>
</nav>



    <div class="shopping_cart">
        <?php
        if(isset($_SESSION["cart"])){
            $total_price = 0;
            ?>
            <table class="table">
                <tbody>
                <tr>
                    <td><b>ITEM IMAGE</b></td>
                    <td><b>ITEM NAME</b></td>
                    <td><b>QUANTITY</b></td>
                    <td> <b> UNIT PRICE </b></td>
                    <td> <b> ITEMS TOTAL </b></td>
                </tr>
                <?php
                foreach ($_SESSION["cart"] as $book){
                    ?>
                    <tr>

                        <td>

                            <img src='<?php echo $book["image"]; ?>' width="100" height="100" /></td>
                        <td><?php echo $book["name"]; ?><br />
                            <form method='post' action=''>
                                <input type='hidden' name='name' value="<?php echo $book["name"]; ?>" />
                                <input type='hidden' name='action' value="remove" />
                                <button  type='submit' class="btn btn-danger" class='remove'><i class="fa fa-trash" aria-hidden="true"></i></button>
                            </form>
                        </td>
                        <td>
                            <form method='post' action=''>
                                <input type='hidden' name='name' value="<?php echo $book["name"]; ?>" />
                                <input type='hidden' name='action' value="change" />
                                <select name='quantity' class='quantity' onchange="this.form.submit()">
                                    <option <?php if($book["quantity"]==1) echo "selected";?> value="1">1</option>
                                    <option <?php if($book["quantity"]==2) echo "selected";?> value="2">2</option>
                                    <option <?php if($book["quantity"]==3) echo "selected";?> value="3">3</option>
                                </select>
                            </form>
                        </td>
                        <td><?php echo "$".$book["price"]; ?></td>
                        <td><?php echo "$".$book["price"]*$book["quantity"]; ?></td>
                    </tr>
                    <?php
                    $total_price += ($book["price"]*$book["quantity"]);
                }
                ?>
                <tr>
                    <td colspan="5" align="center">
                        <strong>TOTAL: <?php echo "$".$total_price; ?></strong>
                        <br>
                        <div class="products">

                        </div>
                        <button class="btn btn-primary btn-purchase" type="button">PURCHASE</button>
                        <select class="form-select" aria-label="Default select example">
                            <option selected>Select your payment method</option>
                            <option value="1">Credit Cart</option>
                            <option value="2">Wire transfer</option>
                        </select>

                        <form>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="inputEmail4">Name</label>
                                    <input type="text" class="form-control" id="inputEmail4" placeholder="Name">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="inputPassword4">Surname</label>
                                    <input type="text" class="form-control" id="inputPassword4" placeholder="Surname">
                                </div>
                            </div>
                            <div class="form-row">
                                <label for="inputAddress">Shipping Address</label>
                                <input type="text" class="form-control" id="inputAddress" placeholder="1234 Main St">
                            </div>
                            <div class="form-row">
                                <label for="inputAddress2">Cart Number</label>
                                <input type="text" class="form-control" id="inputAddress2" placeholder="Maximum 16 Number">
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="inputCity">City</label>
                                    <input type="text" class="form-control" id="inputCity">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="inputState">State</label>
                                    <select id="inputState" class="form-control">
                                        <option selected>Choose...</option>
                                        <option>...</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="inputZip">Zip</label>
                                    <input type="text" class="form-control" id="inputZip">
                                </div>
                                <button type="submit" class="btn btn-primary btn-continue"><a href="thanks.php">Finish The Shopping</a></button>
                            </div>


                        </form>
                        <button class="btn btn-primary btn-continue" type="button"><a href="home.php">Continue The Shopping</a></button>
    </div>


                        <script type="text/javascript" src="js/script.js" async></script>
                    </td>
                </tr>
                </tbody>
            </table>

            <?php
        }else{
            echo "<img style=' height:300px; background-color: white; margin-left: 500px' src='images/empty-cart.png' alt=''>";
            echo "<h3 style='text-align: center;'>Looks like you have no items in your shopping cart.</h3>";
            echo "<div class='clck' style='text-align: center'><h4>Click " . "<a href='home.php'>Here</a>"." to continue shopping. </h4></div>";
        }
        ?>
    </div>

    <br/><br/>

</div>
</body>
</html>