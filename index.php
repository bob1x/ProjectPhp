<?php
require_once('includes/connexion.php');
require_once('assets/scripts/display.php');
require_once('assets/scripts/displayCat.php');   
$categorySection = new CategorySection($pdo); 
$productSection = new ProductSection($pdo);


session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <title>ShopGrids </title>
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.svg" />

    <!-- ========================= CSS here ========================= -->
    <link rel="stylesheet" href="assets/css/LineIcons.3.0.css" />
    <link rel="stylesheet" href="assets/css/tiny-slider.css" />
    <link rel="stylesheet" href="assets/css/glightbox.min.css" />
    <link rel="stylesheet" href="assets/css/main.css" />


    <style>
.custom-card {
    margin-top: 10px;
    margin-right: 150px;
    margin-bottom: 30px;
    margin-left: 150px;
}

/* Add styles for the category section */
.category {
    margin-top: 10px;
    margin-right: 150px;
    margin-bottom: 30px;
    margin-left: 150px;
}
.custom-cards {
    margin-top: 10px;
    margin-right: 150px;
    margin-bottom: 30px;
    margin-left: 150px;
}

</style>
</head>

<body>

    <?php
    include('assets/php/topbar.php');
    ?>
    <?php
    include('assets/php/header.php');
    ?>


    <!-- Start Hero Area -->
    <?php
// Include hero section
    include('assets/php/hero.php');
    ?>
    
    <section class="trending-product section" style="margin-top: 12px;">
    <p style="text-align: center; font-size: 50px; font-weight: bold; color: black;">Trending Products</p>
  <div class="row">
  <div class="product custom-card">
            <?php
            $productSection->displayTrendingProducts();
            ?>
        </div>
        
    </div>
    </section>

    <section class="category-section section" style="margin-top: 12px;">
    <p style="text-align: center; font-size: 50px; font-weight: bold; color: black;">Categories</p>
    <div class="row">
        <div class="category custom-cards">
            <?php
            $categorySection->displayCategories();
            ?>
        </div>
    </div>
</section>


    <!-- Start Shipping Info -->
    <?php
    include('assets/php/info.php');
    ?>
    <!-- End Shipping Info -->
    <?php
    echo '<footer>';
    include('assets/php/footer1.php');
    echo '</footer>';
    ?>



<style>

</style>

    <!-- ========================= scroll-top ========================= -->
    <a href="#" class="scroll-top">
        <i class="lni lni-chevron-up"></i>
    </a>


    <!-- ========================= JS here ========================= -->
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/tiny-slider.js"></script>
    <script src="assets/js/glightbox.min.js"></script>
    <script src="assets/js/main.js"></script>
    <script type="text/javascript">
    //========= Hero Slider 
    tns({
        container: '.hero-slider',
        slideBy: 'page',
        autoplay: true,
        autoplayButtonOutput: false,
        mouseDrag: true,
        gutter: 0,
        items: 1,
        nav: false,
        controls: true,
        controlsText: ['<i class="lni lni-chevron-left"></i>', '<i class="lni lni-chevron-right"></i>'],
    });

    //======== Brand Slider
    tns({
        container: '.brands-logo-carousel',
        autoplay: true,
        autoplayButtonOutput: false,
        mouseDrag: true,
        gutter: 15,
        nav: false,
        controls: false,
        responsive: {
            0: {
                items: 1,
            },
            540: {
                items: 3,
            },
            768: {
                items: 5,
            },
            992: {
                items: 6,
            }
        }
    });
    </script>
</body>

</html>