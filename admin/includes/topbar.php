<?php
include('includes/connexion.php'); 
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
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="../assets/css/LineIcons.3.0.css" />
    <link rel="stylesheet" href="../assets/css/tiny-slider.css" />
    <link rel="stylesheet" href="../assets/css/glightbox.min.css" />
    <link rel="stylesheet" href="../assets/css/main.css" />
</head>

<body>
    <header class="header navbar-area">
        <!-- Start Topbar -->
        <div class="topbar">
    <div class="container">
        <div class="d-flex justify-content-end align-items-center">
            <div class="top-end col-lg-4 col-md-4 col-12">
                <?php
                if (isset($_SESSION['user'])) {
                    echo '<div class="user">';
                    echo '<i class="lni lni-user"><p class="text">Hello</p></i>';
                    echo '<span class="text"><a href="logout.php">Log Out</a></span>';
                    echo '</div>';
                } else {
                    echo '<div class="user">';
                    echo '<i class="lni lni-user"></i>';
                    echo '<span class="text"><a style="text-decoration : none; " href="log-in.php">Sign In</a> | <a href="sign-up.php">Sign Up</a></span>';
                    echo '</div>';
                }
                ?>
            </div>
        </div>
    </div>
</div>
        </div>

        <div class="header-middle">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-3 col-md-3 col-7">
                        <!-- Start Header Logo -->
                        <a class="navbar-brand" href="index.php">
                            <img src="assets/images/logo/logo.svg" alt="Logo">
                        </a>
                        <!-- End Header Logo -->
                    </div>
                    <!-- Search engine --->
                    <!-- End Search engine --->




                </div>
            </div>
        </div>
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8 col-md-6 col-12">
                    <div class="nav-inner">
                        <!-- Start Mega Category Menu -->
                        <div class="mega-category-menu">
                            <span class="cat-button"><i class="lni lni-menu"></i>All Categories</span>
                            <ul class="sub-category">
                                <?php
                        include('includes/connexion.php');

                        // Fetch categories from the database
                        $sqlqueryCategories = "SELECT * FROM categorie";
                        $stmtCategories = $pdo->query($sqlqueryCategories);
                        $categories = $stmtCategories->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($categories as $category) :
                            // Fetch subcategories for the current category
                            $sqlquerySubcategories = "SELECT * FROM scategorie WHERE id_categorie = :id_categorie";
                            $stmtSubcategories = $pdo->prepare($sqlquerySubcategories);
                            $stmtSubcategories->execute(['id_categorie' => $category['id_categorie']]);
                            $subcategories = $stmtSubcategories->fetchAll(PDO::FETCH_ASSOC);
                        ?>
                                <li>
                                    <a href="subcategories.php?categorie=<?= $category['id_categorie'] ?>">
                                        <?= $category['nom_categorie'] ?> <i class="lni lni-chevron-right"></i>
                                    </a>
                                    <ul class="inner-sub-category">
                                        <?php foreach ($subcategories as $subcategory) : ?>
                                        <li>
                                            <a href="produit.php?scategorie=<?= $subcategory['id_scategorie'] ?>">
                                                <?= $subcategory['nom_scategorie'] ?>
                                            </a>
                                        </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <!-- End Mega Category Menu -->
                        <!-- Start Navbar -->
                        <nav class="navbar navbar-expand-lg">
                            <button class="navbar-toggler mobile-menu-btn" type="button" data-bs-toggle="collapse"
                                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                                aria-expanded="false" aria-label="Toggle navigation">
                                <span class="toggler-icon"></span>
                                <span class="toggler-icon"></span>
                                <span class="toggler-icon"></span>
                            </button>
                            <div class="collapse navbar-collapse sub-menu-bar" id="navbarSupportedContent">
                                <ul id="nav" class="navbar-nav ms-auto">
                                    <li class="nav-item">
                                        <a href="index.php" class="active" aria-label="Toggle navigation">Home</a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="dd-menu collapsed" href="javascript:void(0)" data-bs-toggle="collapse"
                                            data-bs-target="#submenu-1-3" aria-controls="navbarSupportedContent"
                                            aria-expanded="false" aria-label="Toggle navigation">Shop</a>
                                        <ul class="sub-menu collapse" id="submenu-1-3">
                                            <li class="nav-item"><a href="categories.php">Categories</a></li>
                                            <li class="nav-item"><a href="produit.php">Products</a></li>
                                            <li class="nav-item"><a href="#">Cart</a></li>
                                        </ul>
                                    </li>

                                </ul>
                            </div> <!-- navbar collapse -->
                        </nav>
                        <!-- End Navbar -->
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-12">
                    <!-- Start Nav Social -->
                    <div class="nav-social">
                        <h5 class="title">Follow Us:</h5>
                        <ul>
                            <li>
                                <a href="javascript:void(0)"><i class="lni lni-facebook-filled"></i></a>
                            </li>
                            <li>
                                <a href="javascript:void(0)"><i class="lni lni-twitter-original"></i></a>
                            </li>
                            <li>
                                <a href="javascript:void(0)"><i class="lni lni-instagram"></i></a>
                            </li>
                            <li>
                                <a href="javascript:void(0)"><i class="lni lni-skype"></i></a>
                            </li>
                        </ul>
                    </div>
                    <!-- End Nav Social -->
                </div>
            </div>
        </div>
        <!-- End Header Bottom -->
    </header>

    <!-- ========================= JS here ========================= -->
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/tiny-slider.js"></script>
    <script src="assets/js/glightbox.min.js"></script>
    <script src="assets/js/main.js"></script>
    <script type="text/javascript"></script>


</body>

</html>