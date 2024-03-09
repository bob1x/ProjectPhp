<?php
require_once('includes/connexion.php');
session_start();

$sqlquery = "SELECT * FROM produit";

$params = [];

if (isset($_GET['min_price']) && isset($_GET['max_price'])) {
    $minPrice = $_GET['min_price'];
    $maxPrice = $_GET['max_price'];
    $sqlquery .= " WHERE prix_produit BETWEEN :min_price AND :max_price";
    $params['min_price'] = $minPrice;
    $params['max_price'] = $maxPrice;
}

if (isset($_GET['product_name'])) {
    $productName = $_GET['product_name'];
    $sqlquery .= (strpos($sqlquery, 'WHERE') !== false) ? " AND " : " WHERE ";
    $sqlquery .= "nom_produit LIKE :product_name";
    $params['product_name'] = "%$productName%";
}

$stmt = $pdo->prepare($sqlquery);
$stmt->execute($params);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="assets/css/LineIcons.3.0.css" />
    <link rel="stylesheet" href="assets/css/tiny-slider.css" />
    <link rel="stylesheet" href="assets/css/glightbox.min.css" />
    <link rel="stylesheet" href="assets/css/main.css" />
    <link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.svg" />


</head>
<style>
.card {
    height: 100%;
}

.card img {
    max-width: 100%;
    height: auto;
}
</style>

<body>
    <?php include('assets/php/topbar.php'); ?>
    <?php include('assets/php/header.php'); ?>
    <?php
    echo '<nav>';
    include('assets/php/bread.php');
    echo '</nav>';
    ?>
    <div class="container mt-5">
        <h1>Products</h1>
        <!-- Filter Form -->
        <form method="GET" class="mb-3">
    <div class="row">
        <div class="col-md-4">
            <label for="min_price">Min Price:</label>
            <input type="number" name="min_price" id="min_price" class="form-control" value="<?= $_GET['min_price'] ?? '' ?>">
        </div>
        <div class="col-md-4">
            <label for="max_price">Max Price:</label>
            <input type="number" name="max_price" id="max_price" class="form-control" value="<?= $_GET['max_price'] ?? '' ?>">
        </div>
        <div class="col-md-4">
            <label for="product_name">Product Name:</label>
            <input type="text" name="product_name" id="product_name" class="form-control" value="<?= $_GET['product_name'] ?? '' ?>">
        </div>
        <div class="col-md-4 mt-2">
            <button type="submit" class="btn btn-primary">Filter</button>
            <button type="button" class="btn btn-secondary" onclick="resetFilter()">Clear Filter</button>
        </div>
    </div>
</form>

<script>
    function resetFilter() {
        if (
            document.getElementById("min_price").value === '' &&
            document.getElementById("max_price").value === '' &&
            document.getElementById("product_name").value === ''
        ) {
            window.location.href = window.location.pathname;
        } else {
            document.getElementById("min_price").value = '';
            document.getElementById("max_price").value = '';
            document.getElementById("product_name").value = '';
            document.querySelector('form').submit();
        }
    }
</script>
<!-- Display products only when filter parameters are present -->
<div class="row">
    <?php foreach ($products as $product): ?>
    <div class="col-md-4 mb-4">
        <div class="card">
            <!-- Product Image -->
            <div class="card-body">
                <img src="assets/image/<?= $product['image_produit'] ?>" alt="<?= $product['nom_produit'] ?>"
                    class="card-img-top">
            </div>
            <!-- Product Info -->
            <div class="card-body">
                <span class="category"><?= $product['nom_categorie'] ?></span>
                <h5 class="card-title"><?= $product['nom_produit'] ?></h5>
                <p class="card-text"><?= $product['description'] ?></p>
                <div class="price">
                    <span>$<?= $product['prix_produit'] ?></span>
                </div>
                <!-- Add to Cart button or any other action -->
                <button class="btn btn-primary">Add to Cart</button>
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