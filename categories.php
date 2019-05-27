<?php
include "dbconnector.php";
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Wakulima connect</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicons -->
    <link href="img/favicon.png" rel="icon">
    <link href="img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,700,700i|Montserrat:300,400,500,700"
          rel="stylesheet">

    <!-- Bootstrap CSS File -->
    <link href="lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Libraries CSS Files -->
    <link href="lib/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/ionicons/css/ionicons.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/lightbox/css/lightbox.min.css" rel="stylesheet">

    <!-- Main Stylesheet File -->
    <link href="css/style.css" rel="stylesheet">

</head>

<body>

<!--==========================
  Header
============================-->
<header style="background-color: #0e0e0f" id="header">
    <div class="container-fluid">

        <div id="logo" class="pull-left">
            <h1><a href="index.php" class="scrollto">Wakulima Connect</a></h1>
            <!-- Uncomment below if you prefer to use an image logo -->
            <!-- <a href="#intro"><img src="img/logo.png" alt="" title="" /></a>-->
        </div>

        <nav id="nav-menu-container">
            <ul class="nav-menu">
                <li class="menu-active"><a href="index.php">Home</a></li>

                <li class="menu-has-children"><a href="">Categories</a>
                    <ul>
                        <?php
                        $rescat = $connection->conn->query("SELECT name FROM kenyafarmerscategories");
                        while ($row = $rescat->fetch(PDO::FETCH_OBJ)) {
//                    echo "<li><a href='categories.php?category= $row->name '>".strtoupper($row->name)."</a></li>";
                            ?>
                            <li><a href="categories.php?category=<?php echo $row->name; ?>"
                                   style="color:black"><?php echo strtoupper($row->name); ?></a></li>
                            <?php
                        }
                        ?>

                    </ul>
                </li>
                <li><a href="agrovet/">Agrovet</a></li>

                <!--                <li><a href="#contact">Contact</a></li>-->
            </ul>
        </nav><!-- #nav-menu-container -->
    </div>
</header><!-- #header -->
<br>
<br>

<main id="main">


    <!--==========================
      Portfolio Section
    ============================-->
    <section id="posts" class="section-bg">
        <div class="container">

            <header class="section-header">
                <h3 class="section-title"><?php
                    echo $_GET['category']
                    ?></h3>
            </header>


            <div class="row portfolio-container">

                <?php
                $sq = "SELECT * FROM kenyafarmerscategories WHERE name=?";
                $res = $connection->conn->prepare($sq);
                $res->execute([$_GET['category']]);
                @$id = $res->fetch(PDO::FETCH_OBJ)->id;

                $resu = $connection->fetchSpecificProducts($id);
                while (@$rows2 = $resu->fetch(PDO::FETCH_OBJ)) {

                    ?>
                    <div class="col-lg-4 col-md-6 portfolio-item filter-app wow  ">
                        <div class="portfolio-wrap">
                            <figure>
                                <img src="<?php echo 'post/' . $rows2->pic ?>" class="img-fluid" alt="">
                                <a href="<?php echo 'post/' . $rows2->pic ?>" data-lightbox="portfolio"
                                   data-title="<?php echo $rows2->name; ?>" class="link-preview" title="Preview"><i
                                            class="ion ion-eye"></i></a>
<!--                                <a href="#" class="link-details" title="More Details"><i-->
<!--                                            class="ion ion-android-open"></i></a>-->
                            </figure>

                            <div class="portfolio-info">
                                <h4><a href="#"><?php echo $rows2->name; ?></a></h4>
                                <h4><a href="tel:<?php echo  $rows2->quantity; ?>"><?php echo "Contact :". $rows2->quantity; ?></a></h4>

                                <h4><a href="#"><?php echo "Price :". $rows2->price; ?></a></h4>
                                <?php
                                $sqlcode = "SELECT * FROM kenyafarmerscategories WHERE id=$rows2->categoryid";
                                $result = $connection->conn->query($sqlcode);
                                while ($rowres = $result->fetch(PDO::FETCH_OBJ)) {
//                                    echo "<p> $rowres->name</p>";
                                }
                                ?>
                            </div>
                        </div>
                    </div>

                    <?php
                }

                ?>


            </div>

        </div>
    </section><!-- #portfolio -->
</main>
<a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>

<!-- JavaScript Libraries -->
<script src="lib/jquery/jquery.min.js"></script>
<script src="lib/jquery/jquery-migrate.min.js"></script>
<script src="lib/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="lib/easing/easing.min.js"></script>
<script src="lib/superfish/hoverIntent.js"></script>
<script src="lib/superfish/superfish.min.js"></script>
<script src="lib/wow/wow.min.js"></script>
<script src="lib/waypoints/waypoints.min.js"></script>
<script src="lib/counterup/counterup.min.js"></script>
<script src="lib/owlcarousel/owl.carousel.min.js"></script>
<script src="lib/isotope/isotope.pkgd.min.js"></script>
<script src="lib/lightbox/js/lightbox.min.js"></script>
<script src="lib/touchSwipe/jquery.touchSwipe.min.js"></script>
<!-- Contact Form JavaScript File -->
<script src="contactform/contactform.js"></script>

<!-- Template Main Javascript File -->
<script src="js/main.js"></script>
</body>
</html>