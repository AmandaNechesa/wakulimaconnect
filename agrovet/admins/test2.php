<?php
/**
 * Created by PhpStorm.
 * User: steve muema
 * Date: 9/22/2018
 * Time: 10:32 PM
 */
include_once "../dbconnector.php";
if (isset($_SESSION['wakulimaconnectagrovet']) || isset($_COOKIE['wakulimaconnectagrovet'])) {
    if (isset($_POST['name'])) {
        $connection->newposts();

    }
    if (isset($_GET["id"])) {
        $connection->actionOnPosts($_GET["id"]);
    }

    ?>
    <html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>admins</title>
        <link rel="stylesheet" href="newstyle.css">
        <link rel="stylesheet"
              href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
        <link rel="stylesheet" href="assets/css/styles.min.css">
    </head>
    <body>
    <section
            style="width:100%;height:130vh;background-attachment:fixed;background-size:cover;background-repeat:no-repeat;background-position:center;">
        <nav class="navbar navbar-light navbar-expand-md navigation-clean-button "
             style="background-color:rgb(73,203,28);font-size:22px;color:rgb(251,249,249);">
            <div class="container"><a class="navbar-brand" href="#">WC-VET</a>
                <button class="navbar-toggler" data-toggle="collapse" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span
                            class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse"
                     id="navcol-1">
                    <ul class="nav navbar-nav mr-auto ">
                        <li class="nav-item" role="presentation"><a class="nav-link active" href="#"
                                                                    style="color:rgb(254,252,252);">HOME</a></li>
                        <li class="nav-item" role="presentation"><a class="nav-link" href="#"
                                                                    style="color:rgb(251,252,254);">AGENTS</a></li>
                        <li class="nav-item " role="presentation"><a class="nav-link" href="logout.php"
                                                                     style="color:rgb(251,252,254);">LOG OUT</a></li>
                        <li class="nav-item" role="presentation"><a class="nav-link" href="logout.php?homepage=true"
                                                                    style="color:rgb(251,252,254);">LOG OUT TO HOME</a>
                        </li>

                        <li class="dropdown"><a class="dropdown-toggle nav-link dropdown-toggle" data-toggle="dropdown"
                                                aria-expanded="false" href="#"
                                                style="color:rgb(253,253,254);">Dropdown </a>
                            <div class="dropdown-menu" role="menu"><a class="dropdown-item" role="presentation"
                                                                      href="#">First Item</a><a class="dropdown-item"
                                                                                                role="presentation"
                                                                                                href="#">Second Item</a><a
                                        class="dropdown-item" role="presentation" href="#">Third Item</a></div>
                        </li>
                    </ul>
                </div>
        </nav>
        <div class="container" style="margin-top:3%;height:80%;width:100%;">
            <form enctype="multipart/form-data" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <div class="form-row profile-row">
                    <div class="col-md-4 relative">
                        <div class="avatar">
                            <div data-bs-hover-animate="swing" class="avatar-bg center"
                                 style="background-image:url(&quot;assets/img/logo.jpg&quot;);background-color:#f7f5f5;"></div>
                        </div>
                        <input type="file" class="form-control" required name="avatar-file"></div>
                    <div class="col" style="padding-left:20%;"><select class="form-control" name="category"
                                                                       style="width:60%;height:48px;margin-bottom:9%;">
                            <!--                            <option value="12" selected="">CATEGORY</option>-->
                            <!--                            <option value="13">This is item 2</option>-->
                            <!--                            <option value="14">This is item 3</option>-->
                            <?php
                            $res = $connection->conn->query("SELECT * FROM shopitcategories");
                            while ($row = $res->fetch(PDO::FETCH_OBJ)) {
                                echo "<option value='$row->id' selected=>$row->name</option>";

                            }
                            ?>
                        </select>
                        <div class="group">
                            <input type="text" name='name' required>
                            <span class="highlight"></span>
                            <span class="bar"></span>
                            <label>NAME</label>
                        </div>


                        <div class="group">
                            <input type="text" name='description' required>
                            <span class="highlight"></span>
                            <span class="bar"></span>
                            <label>DESCRIPTION</label>
                        </div>


                        <div class="group">
                            <input type="number" step='any' name='price' required>
                            <span class="highlight"></span>
                            <span class="bar"></span>
                            <label>PRICE</label>
                        </div>


                        <div class="group">
                            <input type="number" required step='any' name='discount'>
                            <span class="highlight"></span>
                            <span class="bar"></span>
                            <label>DISCOUNT</label>
                        </div>


                    </div>
                </div>
                <div class="form-row profile-row">
                    <div class="col">
                        <div class="container">
                            <div>
                                <button type="submit" class="pulseBtn ">SUBMIT</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
    <section id="works" style="background-image: url('assets/img/burger.jpg')">
        <div class="container ">
            <h2 style="text-align: center;color:red;"><u><i>Your uploads</i></u></h2>
            <div class="works">

                <?php
                $resu = $connection->fetchemall();
                while ($rows = $resu->fetch(PDO::FETCH_OBJ)) {

                    ?>

                    <div class="pic">
                        <figure>
                            <img alt="<?php echo $rows->name; ?>" src="<?php echo $rows->pic; ?>">

                            <figcaption class="center">
                                <!--                            <h3>I love this title!</h3>-->
                                <!-- <p class="text-center">hey</p>-->

                                <h1>NAME: <?php echo $rows->name; ?></h1>
                                <h1>PRICE: <?php echo $rows->price; ?></h1>

                                <h1>DISCOUNT: <?php echo $rows->discount; ?></h1>

                            </figcaption>
                        </figure>
                        <h1><a href="panel.php?id=<?php echo $rows->id; ?>">DELETE SITE</a></h1>

                        <br>
                        <!--                        <form method="post" action="panel.php">-->
                        <!--                                                <input type="hidden" value="-->
                        <?php //echo $rows->id
                        ?><!--" name="id">-->
                        <!--                            <button type="submit">DELETE</button>-->
                        <!--                        </form>-->
                    </div>
                    <?php
                }
                ?>


            </div>
        </div>
    </section>

    <div class="footer-basic" style="padding-top:15px;height:136px;">
        <footer>
            <div class="social" style="padding-bottom:11px;color:rgb(9,10,10);"><a href="#"
                                                                                   style="width:55px;height:55px;color:rgb(10,10,10);">
                    <i
                            class="icon ion-social-instagram"></i></a><a href="#" style="width:55px;height:55px;"><i
                            class="icon ion-social-snapchat"></i></a><a href="#" style="width:55px;height:55px;"><i
                            class="icon ion-social-twitter"></i></a>
                <a
                        href="#" style="width:55px;height:55px;"><i class="icon ion-social-facebook"></i></a>
            </div>
            <ul class="list-inline">
                <li class="list-inline-item"><a href="#">Home</a></li>
                <li class="list-inline-item"><a href="#">Services</a></li>
                <li class="list-inline-item"><a href="#">About</a></li>
                <li class="list-inline-item"><a href="#">Terms</a></li>
                <li class="list-inline-item"><a href="#">Privacy Policy</a></li>
            </ul>
        </footer>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/script.min.js"></script>

    </body>
    </html>
    <?php
} else {
    $_SESSION['error'] = 'You have to be logged in to use the panel';
    header("Location:index.php?" . $_SESSION['error']);
}
?>