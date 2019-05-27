<?php
include_once "dbconnector.php";

if (isset($_GET['insert'])) {
    if (empty($_SESSION['wakulimaconnectagrovetcustomer'])) {
        header("Location:login.php?log in");
    } else {
        $connection->placeorder();

    }
}
if ((isset($_SESSION['wakulimaconnectagrovetcustomer']) || isset($_COOKIE['wakulimaconnectagrovetcustomer']))) {
    if (!isset($_SESSION['wakulimaconnectagrovetcustomer'])) {
        $_SESSION['wakulimaconnectagrovetcustomer'] = $_COOKIE['wakulimaconnectagrovetcustomer'];
    }
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
        <title>WAKULIMA CONNECT CHECK OUT</title>
        <!-- Favicon  -->
        <link rel="icon" href="img/logo.png">
        <link rel="stylesheet" href="css/emojis.css">
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
                                                    <a href="products.php?id=<?php echo $rows->identifier ?>"><?php echo $rows->name; ?></a>
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
            <!--TODO CONTINUE THE CODE ...INCLUDE MPESA API-->
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
                    <!--                <li><span>delivery:</span> <span>SELECT AN ITEM</span></li>-->
                    <li><span>discount:</span> <span>0.00</span></li>
                    <li><span>total:</span> <span>0.00</span></li>
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
                <a href="#" id="rightSideCart"><img src="img/core-img/bag.svg" alt="">
                    <span><?php echo $quantity; ?></span></a>
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
                        $total_price += $price;

                    } ?>
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
                        <a href="<?php echo $_SERVER['PHP_SELF']; ?>?action=empty" class="btn essence-btn ">EMPTY
                            CART</a>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
    ?>
    <div class="breadcumb_area bg-img" style="background-image: url(img/bg-img/breadcumb.jpg);">
        <div class="container h-100">
            <div class="row h-100 align-items-center">
                <div class="col-12">
                    <div class="page-title text-center">
                        <h2 style="color: green">Lipa Na Mpesa to ######</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ##### Breadcumb Area End ##### -->

    <!-- ##### Checkout Area Start ##### -->
    <div class="checkout_area section-padding-80">
        <div class="container">
            <div class="row">

                <div class="col-12 col-md-6">
                    <div class="checkout_details_area mt-50 clearfix">

                        <div class="cart-page-heading mb-30">
                            <h5>Billing Address</h5>
                        </div>

                        <!--                        <form action="#" method="post">-->
                        <!--                            <div class="row">-->
                        <!--                                <div class="col-md-6 mb-3">-->
                        <!--                                    <label for="first_name">First Name <span>*</span></label>-->
                        <!--                                    <input type="text" class="form-control" id="first_name" value="" required>-->
                        <!--                                </div>-->
                        <!--                                <div class="col-md-6 mb-3">-->
                        <!--                                    <label for="last_name">Last Name <span>*</span></label>-->
                        <!--                                    <input type="text" class="form-control" id="last_name" value="" required>-->
                        <!--                                </div>-->
                        <!--                                <div class="col-12 mb-3">-->
                        <!--                                    <label for="company">Company Name</label>-->
                        <!--                                    <input type="text" class="form-control" id="company" value="">-->
                        <!--                                </div>-->
                        <!--                                <div class="col-12 mb-3">-->
                        <!--                                    <label for="country">Country <span>*</span></label>-->
                        <!--                                    <select class="w-100" id="country">-->
                        <!--                                        <option value="usa">United States</option>-->
                        <!--                                        <option value="uk">United Kingdom</option>-->
                        <!--                                        <option value="ger">Germany</option>-->
                        <!--                                        <option value="fra">France</option>-->
                        <!--                                        <option value="ind">India</option>-->
                        <!--                                        <option value="aus">Australia</option>-->
                        <!--                                        <option value="bra">Brazil</option>-->
                        <!--                                        <option value="cana">Canada</option>-->
                        <!--                                    </select>-->
                        <!--                                </div>-->
                        <!--                                <div class="col-12 mb-3">-->
                        <!--                                    <label for="street_address">Address <span>*</span></label>-->
                        <!--                                    <input type="text" class="form-control mb-3" id="street_address" value="">-->
                        <!--                                    <input type="text" class="form-control" id="street_address2" value="">-->
                        <!--                                </div>-->
                        <!--                                <div class="col-12 mb-3">-->
                        <!--                                    <label for="postcode">Postcode <span>*</span></label>-->
                        <!--                                    <input type="text" class="form-control" id="postcode" value="">-->
                        <!--                                </div>-->
                        <!--                                <div class="col-12 mb-3">-->
                        <!--                                    <label for="city">Town/City <span>*</span></label>-->
                        <!--                                    <input type="text" class="form-control" id="city" value="">-->
                        <!--                                </div>-->
                        <!--                                <div class="col-12 mb-3">-->
                        <!--                                    <label for="state">Province <span>*</span></label>-->
                        <!--                                    <input type="text" class="form-control" id="state" value="">-->
                        <!--                                </div>-->
                        <!--                                <div class="col-12 mb-3">-->
                        <!--                                    <label for="phone_number">Phone No <span>*</span></label>-->
                        <!--                                    <input type="number" class="form-control" id="phone_number" min="0" value="">-->
                        <!--                                </div>-->
                        <!--                                <div class="col-12 mb-4">-->
                        <!--                                    <label for="email_address">Email Address <span>*</span></label>-->
                        <!--                                    <input type="email" class="form-control" id="email_address" value="">-->
                        <!--                                </div>-->
                        <!---->
                        <!--                                <div class="col-12">-->
                        <!--                                    <div class="custom-control custom-checkbox d-block mb-2">-->
                        <!--                                        <input type="checkbox" class="custom-control-input" id="customCheck1">-->
                        <!--                                        <label class="custom-control-label" for="customCheck1">Terms and conitions</label>-->
                        <!--                                    </div>-->
                        <!--                                    <div class="custom-control custom-checkbox d-block mb-2">-->
                        <!--                                        <input type="checkbox" class="custom-control-input" id="customCheck2">-->
                        <!--                                        <label class="custom-control-label" for="customCheck2">Create an accout</label>-->
                        <!--                                    </div>-->
                        <!--                                    <div class="custom-control custom-checkbox d-block">-->
                        <!--                                        <input type="checkbox" class="custom-control-input" id="customCheck3">-->
                        <!--                                        <label class="custom-control-label" for="customCheck3">Subscribe to our newsletter</label>-->
                        <!--                                    </div>-->
                        <!--                                </div>-->
                        <!--                            </div>-->
                        <!--                        </form>-->
                        <!--                        <div class="image-holder" style="background-image:url(&quot;assets/img/logo.jpg&quot;);" data-bs-hover-animate="rubberBand"></div>-->
                        <img class="image-holder" data-bs-hover-animate="rubberBand" src="assets/img/logo.png">
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-5 ml-lg-auto">
                    <div class="order-details-confirmation">

                        <div class="cart-page-heading">
                            <h5>Your Order</h5>
                            <p>The Details</p>
                        </div>

                        <ul class="order-details-form mb-4">
                            <li><span>Product</span> <span>Total</span></li>
                            <?php
                            if (isset($_SESSION["cart_item"])){
                            foreach ($_SESSION["cart_item"] as $item) {
                                $item_price = $item["quantity"] * $item["price"];
                                if ($item['discount'] > 0) {

                                    $price = ($item['price'] * ((100 - $item['discount']) / 100)) * $item['quantity'];

                                } else {

                                    $price = $item['price'] * $item['quantity'];


                                }
                                ?>

                                <li><span><?php echo $item['name'] . " x " . $item['quantity']; ?></span>
                                    <span><?php echo $price; ?></span></li>

                                <?php
                            }
                            if (($total_price * 1 / 0.95) > 5000) {
                                echo " <li><span>Subtotal</span> <span>" . $total_price * 1 / 0.95 . "</span></li>";
                                echo " <li><span>Discount</span> <span>5%&nbsp <i class=\"em em-smile\"></i></span></li>";

                            } else {
                                echo " <li><span>Subtotal</span> <span>" . $total_price . "</span></li>";
                                echo " <li><span>Discount</span> <span>None below 5k!!<i class=\"em em-face_with_raised_eyebrow\"></i></span></li>";
                            }
                            ?>
                            <li><span>Total</span> <span><?php echo $total_price; ?></span></li>
                        </ul>
                        <?php
                        } else {
                            ?>
                            <li><span><?php echo "CART IS EMPTY"; ?></span> <span><?php echo '0'; ?></span></li>
                            <?php
                        }

                        ?>
                        <div id="accordion" role="tablist" class="mb-4">
                            <div class="card">
                                <div class="card-header" role="tab" id="headingOne">
                                    <h6 class="mb-0">
                                        <a data-toggle="collapse" href="#collapseOne" aria-expanded="false"
                                           aria-controls="collapseOne"><i class="fa fa-circle-o mr-3"></i>Paypal</a>
                                    </h6>
                                </div>

                                <div id="collapseOne" class="collapse" role="tabpanel" aria-labelledby="headingOne"
                                     data-parent="#accordion">
                                    <div class="card-body">
                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin pharetra
                                            tempor so dales. Phasellus sagittis auctor gravida. Integ er bibendum
                                            sodales arcu id te mpus. Ut consectetur lacus.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" role="tab" id="headingTwo">
                                    <h6 class="mb-0">
                                        <a class="collapsed" data-toggle="collapse" href="#collapseTwo"
                                           aria-expanded="false" aria-controls="collapseTwo"><i
                                                    class="fa fa-circle-o mr-3"></i>cash on delievery</a>
                                    </h6>
                                </div>
                                <div id="collapseTwo" class="collapse" role="tabpanel" aria-labelledby="headingTwo"
                                     data-parent="#accordion">
                                    <div class="card-body">
                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Explicabo quis in
                                            veritatis officia inventore, tempore provident dignissimos.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" role="tab" id="headingThree">
                                    <h6 class="mb-0">
                                        <a class="collapsed" data-toggle="collapse" href="#collapseThree"
                                           aria-expanded="false" aria-controls="collapseThree"><i
                                                    class="fa fa-circle-o mr-3"></i>credit card</a>
                                    </h6>
                                </div>
                                <div id="collapseThree" class="collapse" role="tabpanel" aria-labelledby="headingThree"
                                     data-parent="#accordion">
                                    <div class="card-body">
                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Esse quo sint
                                            repudiandae suscipit ab soluta delectus voluptate, vero vitae</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" role="tab" id="headingFour">
                                    <h6 class="mb-0">
                                        <a class="collapsed" data-toggle="collapse" href="#collapseFour"
                                           aria-expanded="true" aria-controls="collapseFour"><i
                                                    class="fa fa-circle-o mr-3"></i>direct bank transfer</a>
                                    </h6>
                                </div>
                                <div id="collapseFour" class="collapse show" role="tabpanel"
                                     aria-labelledby="headingThree" data-parent="#accordion">
                                    <div class="card-body">
                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Est cum autem
                                            eveniet saepe fugit, impedit magni.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <a href="<?php echo $_SERVER['PHP_SELF']; ?>?insert=true" class="btn essence-btn">Place
                            Order</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ##### Checkout Area End ##### -->

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
                            <a href="#" data-toggle="tooltip" data-placement="top" title="Twitter"><i
                                        class="fa fa-twitter" aria-hidden="true"></i></a>
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
                        <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                        Copyright &copy;<script>document.write(new Date().getFullYear());</script>
                        All rights reserved | This template is made with <i class="fa fa-heart-o"
                                                                            aria-hidden="true"></i> by <a
                                href="https://colorlib.com" target="_blank">Colorlib</a>
                        <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
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
    <?php
} else {
    header("Location:login.php?log in");
} ?>
