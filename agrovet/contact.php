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
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- The above 4 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <!-- Title  -->
    <title>SHOP IT HOME</title>
    <!-- Favicon  -->
    <link rel="icon" href="img/logo.png">

    <!-- Core Style CSS -->
    <link rel="stylesheet" href="css/core-style.css">
    <link rel="stylesheet" href="style.css">

</head>

<body>

<!-- ##### Header Area Start ##### -->
<header class="header_area">
    <div class="classy-nav-container breakpoint-off d-flex align-items-center justify-content-between">
        <!-- Classy Menu -->
        <nav class="classy-navbar" id="essenceNav" style="background:#28a745;color: black;font-size: 14px;">
            <!-- Logo -->
            <a class="nav-brand" href="index.php">WC-VET</a>
            <!-- Navbar Toggler -->
            <div class="classy-navbar-toggler">
                <span class="navbarToggler"><span></span><span></span><span></span></span>
            </div>
            <!-- Menu -->
            <div class="classy-menu">
                <!-- close btn -->
                <div class="classycloseIcon">
                    <div class="cross-wrap"><span class="top"></span><span class="bottom"></span></div>
                </div>
                <!-- Nav Start -->
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
                                                <a href="products.php?id=<?php echo $rows->id ?>"><?php echo $rows->name; ?></a>
                                            </li>
                                            <?php
                                        }
                                        ?>
                                    </ul>
                                <?php } ?>
                                <div class="single-mega cn-col-4">
                                    <img src="img/bg-img/bg-6.jpg" alt="">
                                </div>
                            </div>
                        </li>
                        <li><a href="#">Pages</a>
                            <ul class="dropdown">
                                <li><a href="products.php">Products</a></li>
                                <li><a href="checkout.php">Checkout</a></li>

                                <li><a href="contact.php">Contact</a></li>
                            </ul>
                        </li>
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
            <!--            <div class="favourite-area" style="background: #28a745; ">-->
            <!--                <a href="#"><img src="img/core-img/heart.svg" alt=""></a>-->
            <!--            </div>-->
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
                    <div class="cart-item-desc">
                        <span class="product-remove"
                              onclick="window.location.href='<?php echo $_SERVER['PHP_SELF']; ?>?action=remove&code=<?php echo $item["identifier"]; ?>'"><i
                                    class="fa fa-close" aria-hidden="true"></i></span>
                        <span class="badge"></span>
                        <h6></h6>
                        <p class="size"></p>
                        <p class="color"></p>
                        <p class="price"></p>
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
                            <img src="<?php echo 'admins/' . $item["pic"]; ?>" class="cart-thumb" alt="image not shown"
                                 style="height: inherit">
                            <!-- Cart Item Desc -->
                            <div class="cart-item-desc">
                                <span class="product-remove"
                                      onclick="window.location.href='<?php echo $_SERVER['PHP_SELF']; ?>?action=remove&code=<?php echo $item["identifier"]; ?>'"><i
                                            class="fa fa-close" aria-hidden="true"></i></span>
                                <span class="badge"><?php echo $item["name"]; ?></span>
                                <h6><?php echo $item["description"]; ?></h6>
                                <!--                               <p class="size">Size: S</p>-->
                                <!--                               <p class="color">Color: Red</p>-->
                                <?php
                                if ($item['discount'] > 0) {
                                    ?>
                                    <p class="price"><?php echo ($item['price'] * ((100 - $item['discount']) / 100)) * $item['quantity'];
                                        $price = ($item['price'] * ((100 - $item['discount']) / 100)) * $item['quantity'];
                                        ?></p>
                                    <?php
                                } else {
                                    ?>
                                    <p class="price"><?php echo $item['price'] * $item['quantity'];
                                        $price = $item['price'] * $item['quantity']; ?></p>

                                    <?php
                                }
                                ?>
                            </div>
                        </a>
                    </div>
                    <?php
                    $total_price += $price;

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
                        <li><span>Total:</span> <span><?php $total_price = $total_price * 0.95;
                                echo $total_price;
                                ?></span></li>


                        <?php
                    } else {
                        ?>
                        <li><span>Total:</span> <span><?php echo $total_price; ?></span></li>


                        <?php
                    } ?>
                </ul>

                <div class="checkout-btn mt-100">
                    <a href="checkout.php" class="btn essence-btn">check out</a>
                </div>
                <div class="checkout-btn mt-100">
                    <a href="<?php echo $_SERVER['PHP_SELF']; ?>?action=empty" class="btn essence-btn">EMPTY CART</a>
                </div>
            </div>
        </div>
    </div>
    <?php
}
?>
<!-- ##### Right Side Cart End ##### -->


<div class="contact-area d-flex align-items-center">

    <!--        <div class="google-map">-->
    <!--            <div id="googleMap"></div>-->
    <!--        </div>-->

    <div class="contact-info">
        <h2>How to Find Us</h2>
        <p>We are located at .....</p>

        <div class="contact-address mt-50">
            <!--            <p><span>address:</span> 10 Suffolk st Soho, London, UK</p>-->
            <p><span>telephone:</span> +254702653268</p>
            <p><a href="mailto:wcagrovet@wakulimaconnect.co.ke">wcagrovet@wakulimaconnect.co.ke</a></p>
        </div>
    </div>

</div>

<!-- ##### Footer Area Start ##### -->
<footer class="footer_area clearfix">
    <div class="container">
        <div class="row">
            <!-- Single Widget Area -->
            <div class="col-12 col-md-6">
                <div class="single_widget_area d-flex mb-30">
                    <!-- Logo -->
                    <div class="footer-logo mr-50">
                        <a href="#">WAKULIMA CONNECT</a>
                    </div>
                    <!-- Footer Menu -->
                    <div class="footer_menu">
                        <ul>

                            <li><a href="blog.php">Blog</a></li>
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
                    All rights reserved....made by <a href="http://nanotechsoftwares.co.ke" target="_blank">Nanotech
                        softwares</a>
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
<!-- Google Maps -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAwuyLRa1uKNtbgx6xAJVmWy-zADgegA2s"></script>
<script src="js/map-active.js"></script>

</body>

</html>