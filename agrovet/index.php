<?php
include_once "dbconnector.php";
//cart
if (!empty($_GET["action"])) {
    switch ($_GET["action"]) {
        case "add":
            if (!empty($_POST["quantity"])) {
                $productByCode = $connection->runQuery("SELECT * FROM wakulimaconnectagrovetitems WHERE identifier=?", [$_GET["code"]]);
                $itemArray = array($productByCode[0]["identifier"] => array('name' => $productByCode[0]["name"], 'discount' => $productByCode[0]["discount"], 'identifier' => $productByCode[0]["identifier"], 'description' => $productByCode[0]["description"], 'quantity' => $_POST["quantity"], 'price' => $productByCode[0]["price"], 'pic' => $productByCode[0]["pic"]));
                if (!empty($_SESSION["cart_item"])) {
                    if (in_array($productByCode[0]["identifier"], array_keys($_SESSION["cart_item"]))) {
                        foreach ($_SESSION["cart_item"] as $k => $v) {
                            if ($productByCode[0]["identifier"] == $k) {
                                if (empty($_SESSION["cart_item"][$k]["quantity"])) {
                                    $_SESSION["cart_item"][$k]["quantity"] = 0;
                                }
                                $_SESSION["cart_item"][$k]["quantity"] += $_POST["quantity"];
                            }
                        }
                    } else {
                        $_SESSION["cart_item"] = array_merge($_SESSION["cart_item"], $itemArray);
                    }
                } else {
                    $_SESSION["cart_item"] = $itemArray;
                }
            }
            break;
        case "remove":
            if (!empty($_SESSION["cart_item"])) {
                foreach ($_SESSION["cart_item"] as $k => $v) {
                    if ($_GET["code"] == $k)
                        unset($_SESSION["cart_item"][$k]);
                    if (empty($_SESSION["cart_item"]))
                        unset($_SESSION["cart_item"]);
                }
            }
            break;
        case "empty":
            unset($_SESSION["cart_item"]);
            break;
    }
}
if (isset($_SESSION['cart_item'])) {
    $quantity = 0;
    foreach ($_SESSION["cart_item"] as $item) {
        $quantity += $item["quantity"];
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description"
          content="We will make the goverment's big 4 agenda possible by making agriculture simpler and easier for all people in kenya ">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="keywords"
          content="Wakulima connect agrovet,wakulima connect,wakulimaconnect,wcconnect,agrovets in kenya ">
    <title>WAKULIMA CONNECT HOME</title>
    <link rel="icon" href="img/logo.png">
    <link rel="stylesheet" href="css/emojis.css">
    <meta name="author" content="Stephen muema">
    <link rel="stylesheet" href="css/core-style.css">
    <link rel="stylesheet" href="style.css">

</head>


<body>

<header class="header_area">
    <div class="classy-nav-container breakpoint-off d-flex align-items-center justify-content-between">
        <nav class="classy-navbar" id="essenceNav" style="background:#28a745;color: black;font-size: 14px;">
            <a class="nav-brand" href="index.php">WC-VET</a>
            <div class="classy-navbar-toggler">
                <span class="navbarToggler"><span></span><span></span><span></span></span>
            </div>
            <div class="classy-menu">
                <div class="classycloseIcon">
                    <div class="cross-wrap"><span class="top"></span><span class="bottom"></span></div>
                </div>
                <div class="classynav">


                    <ul>
                        <li><a href="products.php">OUR SHOP</a>
                            <div class="megamenu">
                                <?php
                                $res = $connection->conn->query("SELECT * FROM wakulimaconnectagrovetcategories");
                                while ($row = $res->fetch(PDO::FETCH_OBJ)) {

                                    ?>
                                    <ul class="single-mega cn-col-4">
                                        <li class="title head"
                                            style="text-transform: uppercase;color:red;font-family: Gabriola;font-size: medium"><?php echo $row->name; ?></li>
                                        <?php $result = $connection->conn->query("SELECT * FROM wakulimaconnectagrovetitems where categoryid=$row->id");
                                        while ($rows = $result->fetch(PDO::FETCH_OBJ)) {
                                            ?>
                                            <li>
                                                <a href="products.php?id=<?php echo $rows->id; ?>"><?php echo $rows->name; ?></a>
                                            </li>
                                            <?php
                                        }
                                        ?>
                                    </ul>
                                <?php } ?>

                            </div>
                        </li>
                        <li><a href="#">Pages</a>
                            <ul class="dropdown">
                                <li><a href="products.php">Products</a></li>
                                <li><a href="checkout.php">Checkout</a></li>

                                <li><a href="contact.php">Contact</a></li>
                            </ul>
                        </li>
                        <?php
                        if (isset($_SESSION['wakulimaconnectagrovetcustomer'])) {
                            ?>
                            <li><a href="logout.php">Log out</a></li>
                            <?php
                        } else {
                            echo '<li><a href="login.php">Log in</a></li>';
                        }
                        ?>
                        <li><a href="contact.php">Contact</a></li>
                    </ul>
                </div>
                <!-- Nav End -->
            </div>
        </nav>

        <!-- Header Meta Data -->
        <div class="header-meta d-flex clearfix justify-content-end" style="background: #28a745;">
            <!-- Search Area -->
            <div class="search-area">
                <form action="products.php" method="post">
                    <input type="search" name="name" id="headerSearch" placeholder="Type for search">
                    <button type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
                </form>
            </div>
            <!-- Favourite Area -->
            <?php
            if (isset($_SESSION['wakulimaconnectagrovetcustomer'])) {
                ?>
                <div class="favourite-area" style="background: #28a745; ">
                    <a href="account.php"><img src="img/core-img/settings.svg" alt=""></a>
                </div>

                <?php
            }
            ?>
            <!-- User Login Info -->
            <?php
            if (!isset($_SESSION['wakulimaconnectagrovetcustomer']) && !isset($_COOKIE['wakulimaconnectagrovetcustomer'])) {
                ?>
                <div class="user-login-info" style="background:#28a745;">
                    <a href="login.php"><img src="img/core-img/user.svg" alt=""></a>
                </div>
                <?php
            }
            if (!isset($_SESSION['cart_item']))
            {
            ?>
            <!-- Cart Area -->

            <div class="cart-area" style="background:#28a745;">
                <a href="#" id="essenceCartBtn"><img src="img/core-img/bag.svg" alt=""> <span>0</span></a>
            </div>
        </div>

    </div>
</header>
<!-- ##### Header Area End ##### -->

<!-- ##### Right Side Cart Area ##### -->
<div class="cart-bg-overlay"></div>

<div class="right-side-cart-area">
    <!--//no items-->
    <!-- Cart Button -->
    <div class="cart-button">
        <a href="#" id="rightSideCart"><img src="img/core-img/bag.svg" alt=""> <span>0</span></a>
    </div>

    <div class="cart-content d-flex">

        <!-- Cart List Area -->
        <div class="cart-list">
            <!--

                        <!-- Single Cart Item -->
            <div class="single-cart-item">
                <a href="#" class="product-image">
                    <img src="img/logo.png" class="cart-thumb" alt="image not shown"/>

                    <div class="cart-item-desc">
                        <span class="product-remove"><i class="fa fa-close" aria-hidden="true"></i></span>
                        <span class="badge">WAKULIMA CONNECT</span>
                        <h6></h6>
                        <p class="size">WAKULIMA CONNECT</p>
                        <p class="color">WAKULIMA CONNECT</p>
                        <p class="price">WAKULIMA CONNECT</p>
                    </div>
                </a>
            </div>
        </div>

        <!-- Cart Summary -->
        <div class="cart-amount-summary">

            <h2>Summary</h2>
            <ul class="summary-table">
                <li><span>subtotal:</span> <span>0.00</span></li>
                <li><span>delivery:</span> <span>SELECT AN ITEM</span></li>
                <li><span>discount:</span> <span></span></li>
                <li><span>total:</span> <span></span></li>
            </ul>
            <!--            <div class="checkout-btn mt-100">-->
            <!--                <a href="checkout.php" class="btn essence-btn">check out</a>-->
            <!--            </div>-->
        </div>
    </div>
</div>
<?php
}
else {

    ?>

    <!--    CART HAS ITEMS-->
    <div class="cart-area" style="background:#28a745;">
        <a href="#" id="essenceCartBtn"><img src="img/core-img/bag.svg" alt="">
            <span><?php echo $quantity; ?></span></a>
    </div>
    </div>

    </div>
    </header>
    <!-- ##### Header Area End ##### -->

    <!-- ##### Right Side Cart Area ##### -->
    <div class="cart-bg-overlay"></div>

    <div class="right-side-cart-area">

        <!-- Cart Button -->
        <div class="cart-button">
            <a href="#" id="rightSideCart"><img src="img/core-img/bag.svg" alt=""> <span><?php echo $quantity; ?></span></a>
        </div>

        <div class="cart-content d-flex">

            <!-- Cart List Area -->
            <div class="cart-list">

                <?php
                $total_price = 0;
                foreach ($_SESSION["cart_item"] as $item) {
                    $item_price = $item["quantity"] * $item["price"];
                    ?>
                    <div class="single-cart-item">
                        <a href="#" class="product-image">
                            <img src="<?php echo 'admins/' . $item["pic"]; ?>" class="cart-thumb"
                                 alt="image not shown"/>
                            <!-- Cart Item Desc -->
                            <div class="cart-item-desc">
                            <span class="product-remove"
                                  onclick="window.location.href='<?php echo $_SERVER['PHP_SELF']; ?>?action=remove&code=<?php echo $item["identifier"]; ?>'"><i
                                        class="fa fa-close" aria-hidden="true"></i></span>
                                <span class="badge"><?php echo $item["name"]; ?></span>
                                <span class="size"><?php echo $item["description"]; ?></span>
                                <?php
                                if ($item['discount'] > 0) {
                                    ?>
                                    <p class="color"><?php
                                        $price = ($item['price'] * ((100 - $item['discount']) / 100)) * $item['quantity'];
                                        echo $price; ?></p>
                                    <?php
                                } else {
                                    ?>
                                    <p class="color"><?php $price = $item['price'] * $item['quantity'];
                                        echo $price;
                                        ?></p>
                                    <!--                                <p>Quantity--><?php //$item['quantity'];?><!--</p>-->

                                    <?php
                                }
                                ?>
                            </div>
                        </a>
                    </div>
                    <?php
                    $total_price += ($item["price"] * $item["quantity"]);

                }
                ?>
            </div>

            <!-- Cart Summary -->
            <div class="cart-amount-summary">

                <h2>Summary</h2>
                <ul class="summary-table">
                    <li><span>subtotal:</span> <span><?php echo $total_price; ?></span></li>
                    <li><span>items:</span> <span><?php echo $quantity; ?></span></li>
                    <!--                    --><?php //if($total_price>5000){?>
                    <!--                        <li><span>discount:</span> <span>-5%</span></li>-->
                    <!---->
                    <!---->
                    <!--                    --><?php
                    //else{
                    //                        ?>
                    <!--                        <li><span>discount:</span> <span>0%.You have to reach 5k to get a discount from us!!</span></li>-->
                    <!---->
                    <!---->
                    <!--                        --><?php
                    //                    }?>

                    <?php if ($total_price > 5000) { ?>
                        <li><span>Discount:</span> <span>5%</span></li>

                        <li><span>Total:</span> <span><?php $total_price = $total_price * 0.95;
                                echo $total_price;
                                ?></span></li>


                        <?php
                    } else {
                        ?>
                        <li><span>Discount:</span> <span>None for you</span></li>

                        <li><span>Total:</span> <span><?php echo $total_price; ?></span></li>


                        <?php
                    } ?>
                </ul>

                <div class="checkout-btn mt-100">
                    <a href="checkout.php" class="btn essence-btn">check out</a>
                </div>
                <div class="checkout-btn mt-100">
                    <a href="<?php echo $_SERVER['PHP_SELF']; ?>?action=empty" class="btn essence-btn ">EMPTY CART</a>
                </div>
            </div>
        </div>
    </div>
    <?php
}
?>
<!-- ##### Right Side Cart End ##### -->
<section id="first">

    <!-- ##### Welcome Area Start ##### -->
    <section class="welcome_area bg-img background-overlay new" style="">
        <div class="container h-100">
            <div class="row h-100 align-items-center">
                <div class="col-4" style="opacity: 1.8">
                    <div class="hero-content" style="background: rgba(177,182,182,0.25);color: white;">
                        <h4 STYLE="color:#ff0000">WAKULIMA CONNECT </h4>
                        <!--                        <h4><a href="#" class="btn  btn-warning">view items</a>-->
                        <!--                        </h4>-->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ##### Welcome Area End ##### -->


</section>


<section>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-heading text-center btn-warning">
                    <h2>OUR SERVICES</h2>
                </div>
            </div>
        </div>
    </div>
    <div class="top_catagory_area section-padding-80 clearfix">
        <div class="container">
            <div class="row justify-content-center">
                <!-- Single Catagory -->
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="single_catagory_area d-flex align-items-center justify-content-center bg-img"
                         style="background-image: url(img/animals.jpg);">
                        <div class="catagory-content">
                            <a href="products.php?category=5" style="font-size: 20px;color:#000000">ANIMALS</a>
                        </div>
                    </div>
                </div>
                <!-- Single Catagory -->
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="single_catagory_area d-flex align-items-center justify-content-center bg-img"
                         style="background-image: url(img/weather.png);">
                        <div class="catagory-content">
                            <a href="https://www.ventusky.com/" style="font-size: 20px;color:#000000">WEATHER</a>
                        </div>
                    </div>
                </div>
                <!-- Single Catagory -->
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="single_catagory_area d-flex align-items-center justify-content-center bg-img"
                         style="background-image: url(img/crops.jpg);">
                        <div class="catagory-content">
                            <a href="products.php?category=6" style="font-size: 20px;color:#000000">CROPS</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>


<!-- ##### New Arrivals Area Start ##### -->
<section class="new_arrivals_area section-padding-80 clearfix">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-heading text-center btn-warning">
                    <h2>NEW MEDICINE</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="popular-products-slides owl-carousel">
                    <?php
                    $sql = "SELECT * FROM wakulimaconnectagrovetitems order by id desc limit 6";
                    $res = $connection->conn->query($sql);

                    while ($row = $res->fetch(PDO::FETCH_OBJ)){
                    ?>
                    <div class="single-product-wrapper">
                        <!-- Product Image -->

                        <div class="product-img">
                            <img src='<?php echo 'admins/' . $row->pic; ?>' alt='<?php echo $row->name; ?> '>
                            <!--                            <div class="product-badge new-badge">-->
                            <!--                                <span>New</span>-->
                            <!--                            </div>-->
                            <!-- Product Badge -->
                            <?php
                            if ($row->discount > 0) { ?>
                                <div class="product-badge offer-badge">
                                    <span>-<?php echo $row->discount; ?>%</span>
                                </div>
                                <?php
                            }

                            ?>
                        </div>
                        <form method="post" action="index.php?action=add&code=<?php echo $row->identifier; ?>">
                            <!-- Product Description -->
                            <div class="product-description">
                                <input type="number" style="float: right" placeholder="quantity" name="quantity"
                                       value="1" size="1"/>
                                <span><?php echo $row->name ?></span>
                                <?php if ($row->discount > 0) { ?>
                                    <p class="product-price"><span
                                                class="old-price"><?php echo $row->price; ?></span> <?php echo($row->price * (1 - ($row->discount) / 100)); ?>
                                    </p>
                                <?php } else { ?> <p
                                        class="product-price"><?php echo($row->price * (1 - ($row->discount) / 100)); ?></p>
                                    <?php

                                }


                                ?>


                                <div class="hover-content">
                                    <!-- Add to Cart -->
                                    <div class="add-to-cart-btn">
                                        <button type="submit" class="btn essence-btn ">Add to Cart</button>
                                    </div>
                                </div>
                        </form>
                    </div>
                </div>
                <?php
                }
                ?>
            </div>
        </div>

    </div>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-heading text-center btn-warning">
                    <h2>ALL MEDICINE</h2>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">

                <?php
                $res = $connection->fetchProducts();
                while ($row = $res->fetch(PDO::FETCH_OBJ)){
                ?>
                <div class="col-12 col-sm-6 col-lg-4">

                    <div class="single-product-wrapper">
                        <!-- Product Image -->

                        <div class="product-img">
                            <img src='<?php echo 'admins/' . $row->pic; ?>' alt='<?php echo $row->name; ?> '>
                            <!--                            <div class="product-badge new-badge">-->
                            <!--                                <span>New</span>-->
                            <!--                            </div>-->
                            <!-- Product Badge -->
                            <?php
                            if ($row->discount > 0) { ?>
                                <div class="product-badge offer-badge">
                                    <span>-<?php echo $row->discount; ?>%</span>
                                </div>
                                <?php
                            }

                            ?>
                        </div>
                        <form method="post" action="index.php?action=add&code=<?php echo $row->identifier; ?>">
                            <!-- Product Description -->
                            <div class="product-description">
                                <input type="number" style="float: right" placeholder="quantity" name="quantity"
                                       value="1" size="1"/>
                                <span><?php echo $row->name ?></span>
                                <?php if ($row->discount > 0) { ?>
                                    <p class="product-price"><span
                                                class="old-price"><?php echo $row->price; ?></span> <?php echo($row->price * (1 - ($row->discount) / 100)); ?>
                                    </p>
                                <?php } else { ?> <p
                                        class="product-price"><?php echo($row->price * (1 - ($row->discount) / 100)); ?></p>
                                    <?php

                                }


                                ?>


                                <div class="hover-content">
                                    <!-- Add to Cart -->
                                    <div class="add-to-cart-btn">
                                        <button type="submit" class="btn essence-btn ">Add to Cart</button>
                                    </div>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
            <?php
            }
            ?>

        </div>
    </div>
</section>
<!-- ##### New Arrivals Area End ##### -->
<!-- ##### Brands Area Start ##### -->
<div class="brands-area d-flex align-items-center justify-content-between">
    <!-- Brand Logo -->
    <div class="single-brands-logo">
        <img src="img/core-img/nanotech-logo.png" alt="">
    </div>
    <!-- Brand Logo -->
    <div class="single-brands-logo">
        <img src="img/core-img/over-20-logo.png" alt="">
    </div>
    <!-- Brand Logo -->
    <div class="single-brands-logo">
        <img src="img/core-img/shop-it-logo.jpg" alt="">
    </div>

</div>
<!-- ##### Brands Area End ##### -->


<!-- ##### Footer Area Start ##### -->
<footer class="footer_area clearfix">
    <div class="container">
        <div class="row">
            <!-- Single Widget Area -->
            <div class="col-12 col-md-6">
                <div class="single_widget_area d-flex mb-30">
                    <!-- Logo -->
                    <div class="footer-logo mr-50">
                    </div>
                    <!-- Footer Menu -->
                    <div class="footer_menu">
                        <ul>
                            <li><a href="#top">WAKULIMA CONNECT</a></li>

                            <li><a href="blog.html">Blog</a></li>
                            <li><a href="contact.php">Contact</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- Single Widget Area -->
            <div class="col-12 col-md-6">
                <div class="single_widget_area mb-30">
                    <ul class="footer_widget_menu">
                        <li><a href="#">Order Status</a></li>
                        <li><a href="#">Payment Options</a></li>
                        <li><a href="#">Shipping and Delivery</a></li>
                        <li><a href="#">Guides</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                        <li><a href="#">Terms of Use</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row align-items-end">
            <!-- Single Widget Area -->
            <div class="col-12 col-md-6">
                <div class="single_widget_area">
                    <div class="footer_heading mb-30">
                        <h6>Subscribe</h6>
                    </div>
                    <div class="subscribtion_form">
                        <form action="#" method="post">
                            <input type="email" name="mail" class="mail" placeholder="Your email here">
                            <button type="submit" class="submit"><i class="fa fa-long-arrow-right"
                                                                    aria-hidden="true"></i></button>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Single Widget Area -->
            <div class="col-12 col-md-6">
                <div class="single_widget_area">
                    <div class="footer_social_area">
                        <a href="#" data-toggle="tooltip" data-placement="top" title="Facebook"><i
                                    class="fa fa-facebook" aria-hidden="true"></i></a>
                        <a href="#" data-toggle="tooltip" data-placement="top" title="Instagram"><i
                                    class="fa fa-instagram" aria-hidden="true"></i></a>
                        <a href="#" data-toggle="tooltip" data-placement="top" title="Twitter"><i class="fa fa-twitter"
                                                                                                  aria-hidden="true"></i></a>
                        <a href="#" data-toggle="tooltip" data-placement="top" title="Pinterest"><i
                                    class="fa fa-pinterest" aria-hidden="true"></i></a>
                        <a href="#" data-toggle="tooltip" data-placement="top" title="Youtube"><i
                                    class="fa fa-youtube-play" aria-hidden="true"></i></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-md-12 text-center">
                <p>
                    Copyright &copy;<script>document.write(new Date().getFullYear());</script>
                </p>
            </div>
        </div>

    </div>
</footer>
<!-- ##### Footer Area End ##### -->

<!-- jQuery (Necessary for All JavaScript Plugins) -->
<script src="js/jquery/jquery-2.2.4.min.js"></script>
<!-- Popper js -->
<script src="js/popper.min.js"></script>
<!-- Bootstrap js -->
<script src="js/bootstrap.min.js"></script>
<!-- Plugins js -->
<script src="js/plugins.js"></script>
<!-- Classy Nav js -->
<script src="js/classy-nav.min.js"></script>
<!-- Active js -->
<script src="js/active.js"></script>

</body>

</html>