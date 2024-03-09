<?php
require_once('includes/connexion.php');
session_start();

if (!isset($_GET['scategorie'])) {
    header("Location: index.php");
    exit();
}

$id_scategorie = $_GET['scategorie'];
$sqlqueryProducts = "SELECT * FROM produit WHERE id_scategorie = :id_scategorie";
$stmtProducts = $pdo->prepare($sqlqueryProducts);
$stmtProducts->execute(['id_scategorie' => $id_scategorie]);
$products = $stmtProducts->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products - Subcategory</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="assets/css/LineIcons.3.0.css" />
    <link rel="stylesheet" href="assets/css/tiny-slider.css" />
    <link rel="stylesheet" href="assets/css/glightbox.min.css" />
    <link rel="stylesheet" href="assets/css/main.css" />
    <link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.svg" />

    <style>
        .card {
            height: 100%;
        }

        .card img {
            max-width: 100%;
            height: auto;
        }

        .product-image {
            position: relative;
            height: 400px; /* Adjust this value as needed */
            overflow: hidden;
        }

        .product-image img {
            width: 100%;
            transition: transform 0.3s ease-in-out;
        }

        .product-image:hover img {
            transform: scale(1.2); 
        }

        .add-to-cart-button {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            opacity: 0; 
            transition: opacity 0.3s ease-in-out;
        }

        .product-image:hover .add-to-cart-button {
            opacity: 1; /
        }
    </style>
</head>

<body>
    <?php include('assets/php/topbar.php'); ?>
    <?php include('assets/php/header.php'); ?>
    <?php
    echo '<nav>';
    include('assets/php/bread.php');
    echo '</nav>';
    ?>
    <div class="container mt-5">
        <h1>Products </h1>

        <!-- Display products only when filter parameters are present -->
        <div class="row">
            <?php foreach ($products as $product): ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <!-- Product Image -->
                        <div class="product-image">
                            <img src="assets/image/<?= $product['image_produit'] ?>" alt="<?= $product['nom_produit'] ?>"
                                class="card-img-top">
                            <button class="btn btn-primary add-to-cart-button">Add to Cart</button>
                        </div>
                        <!-- Product Info -->
                        <div class="card-body">
                            <span class="category"><?= $product['nom_categorie'] ?></span>
                            <h5 class="card-title"><?= $product['nom_produit'] ?></h5>
                            <p class="card-text"><?= $product['description'] ?></p>
                            <div class="price">
                                <span>$<?= $product['prix_produit'] ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <?php
    echo '<footer>';
    include('assets/php/footer1.php');
    echo '</footer>';
    ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
</body>

</html>
