<?php
/**
 * Created by PhpStorm.
 * User: steve muema
 * Date: 9/22/2018
 * Time: 10:32 PM
 */
include_once "../dbconnector.php";
if (isset($_SESSION['shopit']) || isset($_COOKIE['shopit'])) {
    if (isset($_POST['name'])) {
        $connection->newpost();

    }
    if (isset($_GET["id"])) {
        $connection->actionOnPosts($_GET["id"]);
    }

    ?>
    <html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Wakulima connect</title>
        <link rel="icon" href="../img/favicon.png">
        <link rel="stylesheet" href="newstyle.css">
        <link rel="stylesheet"
              href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
        <link rel="stylesheet" href="assets/css/styles.min.css">
        <link rel="stylesheet" href="../css/core-style.css">
        <link rel="stylesheet" href="../style.css">
    </head>
    <body style="width: 100%;height: 100%;padding: 0;margin: 0;">
    <nav class="navbar navbar-light navbar-expand-md navigation-clean-button"
         style="background-color:#28a745;font-size:22px;color:rgb(251,249,249);margin-top: 0;">
        <div class="container"><a class="navbar-brand" href="#">Wakulima Connect</a>
            <button class="navbar-toggler" data-toggle="collapse" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span
                        class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse"
                 id="navcol-1">
                <ul class="nav navbar-nav mr-auto">
                    <li class="nav-item" role="presentation"><a class="nav-link active" href="#works"
                                                                style="color:rgb(254,252,252);">MY UPLOADS</a></li>
                    <!--                            </li>-->                </ul>
                <span class="navbar-text actions"><a href="logout.php?homepage=true">LOG OUT TO HOME</a>
                    </span></div>
        </div>
    </nav>


    <section
            style="width:100%;height:100vh;background-attachment:fixed;background-size:cover;background-repeat:no-repeat;background-position:center;">
        <div class="container-fluid" style="height:100%;width:100%;overflow-x: hidden;">
            <form enctype="multipart/form-data" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <div class="form-row profile-row">
                    <div class="col-xs-4 col-md-4">
                        <div class="avatar" style="background:#28a745">
                            <div data-bs-hover-animate="swing" class="avatar-bg center"
                                 style="background-image:url(assets/img/chicken.jpg);background-color:#f7f5f5;"></div>
                        </div>
                        <input type="file" class="form-control" required name="avatar-file"></div>
                    <div class="col-xs-6 col-md-6" style="">
                        <select class="form-control" name="category"
                                style="width:100%;height:48px;margin-bottom:9%;">
                            <?php
                            $res = $connection->conn->query("SELECT * FROM kenyafarmerscategories");
                            while ($row = $res->fetch(PDO::FETCH_OBJ)) {
                                echo "<option value='$row->id' selected=>$row->name</option>";

                            }
                            ?>
                        </select>
                        <div class="group">
                            <input type="text" name='name' class="form-control" required>
                            <span class="highlight"></span>
                            <span class="bar"></span>
                            <label>NAME</label>
                        </div>


                        <div class="group">
                            <input type="text" name='location' class="form-control" required>
                            <span class="highlight"></span>
                            <span class="bar"></span>
                            <label>LOCATION</label>
                        </div>


                        <div class="group">
                            <input type="number" step='any' min="5" name='price' class="form-control" required>
                            <span class="highlight"></span>
                            <span class="bar"></span>
                            <label>PRICE</label>
                        </div>


                        <div class="group">
                            <input type="text" required step='1' class="form-control" name='quantity'>
                            <span class="highlight"></span>
                            <span class="bar"></span>
                            <label>CONTACT</label>
                        </div>

                        <div class="col-xm-4 col-md-6" style="margin: 0 auto;">
                            <button type="submit" class="pulseBtn group btn-block">SUBMIT</button>
                        </div>
                    </div>
                    <!--                <div class="form-row profile-row ">-->
                    <!--                    <div class="col">-->
                    <!--                       -->
                    <!--                    </div>-->
                    <!--                </div>-->
            </form>
        </div>
    </section>


    <section id="works" style="background-image: url('../img/intro-carousel/4.jpeg');>
        <div class="
    ">
    <h2 style="text-align: center;color:#000000;font-weight: bold"><u><i>Your uploads</i></u></h2>
    <div class="works">

        <?php
        if (empty($_SESSION['admin'])) {
            ?>
            <?php
            $resu = $connection->fetchemall();
            while ($rows = $resu->fetch(PDO::FETCH_OBJ)) {

                ?>

                <div class="pic" style="max-width: 100%;min-height: auto;">
                    <figure>
                        <img class="img-thumbnail float-left" style="max-width: 100%;min-height: 100%;" width="200px"
                             height="200px" alt="<?php echo $rows->name; ?>" src="<?php echo $rows->pic; ?>">

                        <figcaption class="center card-img-overlay">
                            <!--                            <h3>I love this title!</h3>-->
                            <!-- <p class="text-center">hey</p>-->

                            <h4 style="color:red;">NAME:<?php echo $rows->name; ?></h4>
                            <h4 style="color:red;">PRICE:<?php echo $rows->price; ?></h4>

                            <h4 style="color:red;">CONTACT:<?php echo $rows->quantity; ?></h4>
                            <h4><a href="<?php echo $_SERVER['PHP_SELF'] ?>?id=<?php echo $rows->id; ?>">DELETE</a></h4>

                        </figcaption>
                    </figure>

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


            <?php

        } else {
            ?>
            <?php
            $resu1 = $connection->fetchProducts();
            while ($rows2 = $resu1->fetch(PDO::FETCH_OBJ)) {

                ?>

                <div class="pic" style="max-width: 100%;min-height: auto;">
                    <figure>
                        <img class="img-thumbnail float-left" style="max-width: 100%;min-height: 100%;" width="200px"
                             height="200px" alt="<?php echo $rows2->name; ?>" src="<?php echo $rows2->pic; ?>">

                        <figcaption class="center card-img-overlay">
                            <!--                            <h3>I love this title!</h3>-->
                            <!-- <p class="text-center">hey</p>-->

                            <h4 style="color:red;">NAME:<?php echo $rows2->name; ?></h4>
                            <h4 style="color:red;">PRICE:<?php echo $rows2->price; ?></h4>
                            <h4 style="color:red;">UPLOADER:<?php
                                $res1 = $connection->conn->query("SELECT * FROM kenyafarmersusers WHERE id=$rows2->uploaderid");
                                while ($row1 = $res1->fetch(PDO::FETCH_OBJ)) {
                                    echo $row1->email;
                                }

                                ?></h4>
                            <h4 style="color:red;">CONTACT:<?php echo $rows2->quantity; ?></h4>
                            <h4><a href="<?php echo $_SERVER['PHP_SELF'] ?>?id=<?php echo $rows->id; ?>">DELETE</a></h4>

                        </figcaption>
                    </figure>

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