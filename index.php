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
<header id="header">
    <div class="container-fluid">

        <div id="logo" class="pull-left">
            <h1><a href="#intro" class="scrollto">Wakulima conn</a></h1>

        </div>

        <nav id="nav-menu-container">
            <ul class="nav-menu">

                <!--                <li class="menu-active"><a href="#intro">Home</a></li>-->
                <li><a href="agrovet/">Agrovet</a></li>

                <li><a href="#posts">Posts</a></li>
                <li><a href="#team">Team</a></li>
                <li class="menu-has-children"><a href="">Categories</a>
                    <ul>
                        <?php
                        $rescat = $connection->conn->query("SELECT name FROM kenyafarmerscategories");
                        while ($row = $rescat->fetch(PDO::FETCH_OBJ)) {
//                    echo "<li><a href='categories.php?category= $row->name '>".strtoupper($row->name)."</a></li>";
                            ?>
                            <li>
                                <a href="categories.php?category=<?php echo $row->name; ?>"><?php echo strtoupper($row->name); ?></a>
                            </li>
                            <?php
                        }
                        ?>

                    </ul>
                </li>
                <li><a href="#contact">Contact</a></li>
            </ul>
        </nav><!-- #nav-menu-container -->
    </div>
</header><!-- #header -->

<!--==========================
  Intro Section
============================-->
<section id="intro">
    <div class="intro-container">
        <div id="introCarousel" class="carousel  slide carousel-fade" data-ride="carousel">

            <ol class="carousel-indicators"></ol>

            <div class="carousel-inner" role="listbox">

                <div class="carousel-item active">
                    <div class="carousel-background"><img src="img/intro-carousel/4.jpeg" alt=""></div>
                    <div class="carousel-container">
                        <div class="carousel-content">
                            <h2>USIBABAIKE KUJUA HALI YA HEWA</h2>
                            <p>
                                Click <a href="https://www.ventusky.com/">here</a> and search for your location to view
                                the weather forecast </p>
                            <a href="post/" class="btn-get-started scrollto">Upload</a>
                        </div>
                    </div>
                </div>

                <div class="carousel-item">
                    <div class="carousel-background"><img src="img/intro-carousel/3.jpeg" alt=""></div>
                    <div class="carousel-container">
                        <div class="carousel-content">
                            <h2>Agriculture ,research and technology</h2>
                            <p>
                                Advances in technology will continue to reach far into every sector of our economy.
                                Future job and economic growth in industry, defense, transportation, agriculture, health
                                care, and life sciences is directly related to scientific advancement.
                            </p>
                            <a href="post/" class="btn-get-started scrollto">Upload</a>
                        </div>
                    </div>
                </div>

            </div>

            <a class="carousel-control-prev" href="#introCarousel" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon ion-chevron-left" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>

            <a class="carousel-control-next" href="#introCarousel" role="button" data-slide="next">
                <span class="carousel-control-next-icon ion-chevron-right" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>

        </div>
    </div>
</section><!-- #intro -->

<main id="main">


    <!--==========================
      Portfolio Section
    ============================-->
    <section id="posts" class="section-bg">
        <div class="container">

            <header class="section-header">
                <h3 class="section-title">Posts</h3>
            </header>

            <div class="row">
                <div class="col-lg-12">
                    <ul id="portfolio-flters">
                        <li data-filter="*" class="filter-active">All</li>
                        <?php
                        $rescat1 = $connection->conn->query("SELECT name FROM kenyafarmerscategories");
                        while ($row1 = $rescat1->fetch(PDO::FETCH_OBJ)) {
                            ?>
                            <li data-filter='.filter-app'><a href="categories.php?category=<?php echo $row1->name; ?>"
                                                             style="color:black"><?php echo strtoupper($row1->name); ?></a>
                            </li>
                            <?php
                        }
                        ?>
                    </ul>
                </div>
            </div>

            <div class="row portfolio-container">

                <?php
                $resu = $connection->fetchProducts();
                while ($rows2 = $resu->fetch(PDO::FETCH_OBJ)) {

                    ?>
                    <div class="col-lg-4 col-md-6 portfolio-item filter-app wow fadeInRight " data-wow-delay="0.1s">
                        <div class="portfolio-wrap">
                            <figure>
                                <img src="<?php echo 'post/' . $rows2->pic ?>" class="img-fluid" height="100%" alt="">
                                <a href="<?php echo 'post/' . $rows2->pic ?>" data-lightbox="portfolio"
                                   data-title="<?php echo $rows2->name; ?>" class="link-preview" title="Preview"><i
                                            class="ion ion-eye"></i></a>
<!--                                <a href="details.php?uploader=--><?php //echo $rows2->uploaderid; ?><!--" class="link-details"-->
<!--                                   title="More Details"><i class="ion ion-android-open"></i></a>-->
                            </figure>

                            <div class="portfolio-info">
                                <h4><a href="#"><?php echo "Name :".$rows2->name; ?></a></h4>
                                <h4><a href="tel:<?php echo  $rows2->quantity; ?>"><?php echo "Contact :". $rows2->quantity; ?></a></h4>

                                <h4><a href="#"><?php echo "Price :". $rows2->price; ?></a></h4>
                                <?php
                                $sqlcode = "SELECT * FROM kenyafarmerscategories WHERE id=$rows2->categoryid";
                                $result = $connection->conn->query($sqlcode);
                                while ($rowres = $result->fetch(PDO::FETCH_OBJ)) {
//                                    echo "<p>$rowres->name</p>";
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

    <!--==========================
          Clients Section
        ============================-->
    <section id="partners" class="wow fadeInUp">
        <div class="container">

            <header class="section-header">
                <h3>Our Partners</h3>
            </header>

            <div class="owl-carousel clients-carousel">
                <a href="http://shop-it.co.ke"><img src="img/clients/shop-it-logo.jpg" alt=""></a>
                <a href="http://over20-personalblog.co.ke"><img src="img/clients/over-20-logo.png" alt=""></a>
                <a href="http://nanotechsoftwares.co.ke"> <img src="img/clients/nanotech-logo.png" alt=""></a>
                <!--                  <img src="img/clients/client-4.png" alt="">-->
                <!--                  <img src="img/clients/client-5.png" alt="">-->
                <!--                  <img src="img/clients/client-6.png" alt="">-->
                <!--                  <img src="img/clients/client-7.png" alt="">-->
                <!--                  <img src="img/clients/client-8.png" alt="">-->
            </div>

        </div>
    </section>

    <!-- #clients -->

    <!--==========================
      Clients Section
    ============================-->
    <section id="testimonials" class="section-bg wow fadeInUp">
        <div class="container">

            <header class="section-header">
                <h3>Testimonials</h3>
            </header>

            <div class="owl-carousel testimonials-carousel">

                <div class="testimonial-item">
                    <img src="img/steve.jpg" class="testimonial-img" alt="">
                    <h3>Steve Muema</h3>
                    <h4>Ceo &amp; Founder</h4>
                    <p>
                        <img src="img/quote-sign-left.png" class="quote-sign-left" alt="">
                        I am a young Kenyan Farmer and I've made this platform to help farmers get a market for their
                        goods and also to help buyers get items they need in the fastest way possible
                        <img src="img/quote-sign-right.png" class="quote-sign-right" alt="">
                    </p>
                </div>

                <div class="testimonial-item">
                    <img src="img/anon.jpg" class="testimonial-img" alt="">
                    <h3>Michele Mwende</h3>
                    <h4>Co-founder</h4>
                    <p>
                        <img src="img/quote-sign-left.png" class="quote-sign-left" alt="">
                        I am a young Kenyan Farmer and we made this platform to help farmers get a market for their
                        goods and also to help buyers get items they need in the fastest way possible
                        <img src="img/quote-sign-right.png" class="quote-sign-right" alt="">
                    </p>
                </div>


                <div class="testimonial-item">
                    <img src="img/anon.jpg" class="testimonial-img" alt="">
                    <h3>Kevin Mwangi</h3>
                    <h4>Farmer</h4>
                    <p>
                        <img src="img/quote-sign-right.png" class="quote-sign-left" alt="">
                        I am a Kenyan poultry Farmer and I appreciate the effort from the young Kenyan talent for
                        creating this platform in which aligns to the government's big 4 agenda
                        <img src="img/quote-sign-right.png" class="quote-sign-right" alt="">
                    </p>
                </div>

            </div>

        </div>
    </section><!-- #testimonials -->

    <!--==========================
      Team Section
    ============================-->
    <section id="team">
        <div class="container">
            <div class="section-header wow fadeInUp">
                <h3>Our Team</h3>
                <p>
                    Meet our team</p>
            </div>

            <div class="row">

                <div class="col-lg-3 col-md-6 wow fadeInUp">
                    <div class="member">
                        <img src="img/steve.jpg" class="img-fluid" style="height: 250px;" alt="">
                        <div class="member-info">
                            <div class="member-info-content">
                                <h4>Stephen Muema</h4>
                                <span>Founder and programmer</span>
                                <div class="social">
                                    <a href="http://nanotechsoftwares.co.ke"><i class="fa fa-chain"></i></a>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="member">
                        <img src="img/steve.jpg" class="img-fluid" style="height: 250px;" alt="">
                        <div class="member-info">
                            <div class="member-info-content">
                                <h4>Michelle Mwende</h4>
                                <span>Co-founder and programmer</span>
                                <div class="social">
                                    <a href="http://nanotechsoftwares.co.ke"><i class="fa fa-chain"></i></a>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.2s">
                    <div class="member">
                        <img src="img/steve.jpg" class="img-fluid" style="height: 250px;" alt="">
                        <div class="member-info">
                            <div class="member-info-content">
                                <h4>Almond</h4>
                                <span>System Admin</span>
                                <div class="social">
                                    <a href="http://nanotechsoftwares.co.ke"><i class="fa fa-chain"></i></a>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="member">
                        <img src="img/steve.jpg" class="img-fluid" style="height: 250px;" alt="">
                        <div class="member-info">
                            <div class="member-info-content">
                                <h4>Rose Mwikali</h4>
                                <span>First User</span>
                                <div class="social">

                                    <a href="#intro"><i class="fa fa-chain"></i></a>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </section><!-- #team -->

    <!--==========================
      Contact Section
    ============================-->
    <section id="contact" class="section-bg wow fadeInUp">
        <div class="container">

            <div class="section-header">
                <h3>Contact Us</h3>
                <p>
                    Feel free to come by and have a cup of coffee as we discuss business </p>
            </div>

            <div class="row contact-info">

                <div class="col-md-6">
                    <div class="contact-phone">
                        <i class="ion-ios-telephone-outline"></i>
                        <h3>Phone Number</h3>
                        <p><a href="tel:+254702653268">+254702653268</a></p>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="contact-email">
                        <i class="ion-ios-email-outline"></i>
                        <h3>Email</h3>
                        <p><a href="mailto:muemasn@nanotechsoftwares.co.ke">Wakulima Connect Handler</a></p>
                    </div>
                </div>

            </div>

            <div class="form">

                <form action="mail.php" method="post">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <input type="text" name="name" class="form-control" id="name" placeholder="Your Name"
                                   data-rule="minlen:4" data-msg="Please enter at least 4 chars"/>
                            <div class="validation"></div>
                        </div>
                        <div class="form-group col-md-6">
                            <input type="email" class="form-control" name="email" id="email" placeholder="Your Email"
                                   data-rule="email" data-msg="Please enter a valid email"/>
                            <div class="validation"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="subject" id="subject" placeholder="Subject"
                               data-rule="minlen:4" data-msg="Please enter at least 8 chars of subject"/>
                        <div class="validation"></div>
                    </div>
                    <div class="form-group">
                        <textarea class="form-control" name="message" rows="5" data-rule="required"
                                  data-msg="Please write something for us" placeholder="Message"></textarea>
                        <div class="validation"></div>
                    </div>
                    <div class="text-center">
                        <button type="submit">Send Message</button>
                    </div>
                </form>
            </div>

        </div>
    </section><!-- #contact -->

</main>

<!--==========================
  Footer
============================-->
<footer id="footer">


    <div class="container">
        <div class="copyright">
            &copy; Copyright<?php echo " 2017 - " . date("Y") ?> <strong>Wakulima Connect</strong>. All Rights Reserved
        </div>
        <div class="credits">
            <!--
              All the links in the footer should remain intact.
              You can delete the links only if you purchased the pro version.
              Licensing information: https://bootstrapmade.com/license/
              Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/buy/?theme=BizPage
            -->
            Designed by <a href="http://nanotechsoftwares.co.ke">Nanotech softwares</a>
        </div>
    </div>
</footer><!-- #footer -->

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
