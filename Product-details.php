<?php
require_once('includes/connexion.php');
session_start();

function fetchProduct($pdo, $product_id) {
    $sqlquery = "
        SELECT produit.*, categorie.nom_categorie AS category_name
        FROM produit
        JOIN categorie ON produit.id_categorie = categorie.id_categorie
        WHERE produit.id_produit = :id_produit
    ";

    $stmt = $pdo->prepare($sqlquery);
    $stmt->execute(['id_produit' => $product_id]);
    return $stmt->fetchAll(PDO::FETCH_OBJ);
}

function fetchRelatedProducts($pdo, $product_id, $category_id) {
    $sqlquery = "SELECT * FROM produit WHERE id_produit != :id_produit AND id_categorie = :id_categorie LIMIT 3";
    $stmt = $pdo->prepare($sqlquery);
    $stmt->execute(['id_produit' => $product_id, 'id_categorie' => $category_id]);
    return $stmt->fetchAll(PDO::FETCH_OBJ);
}

if (isset($_GET['q'])) {
    $searchTerm = $_GET['q'];
    $sqlquery = "SELECT id_produit FROM produit WHERE nom_produit LIKE :searchTerm";
    $stmt = $pdo->prepare($sqlquery);
    $stmt->execute(['searchTerm' => '%' . $searchTerm . '%']);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        header('Location: Product-details.php?id=' . $result['id_produit']);
        exit();
    } else {
        echo "Product not found";
        exit();
    }
}

if (isset($_GET['id'])) {
    $selectedProductId = $_GET['id'];
    $products = fetchProduct($pdo, $selectedProductId);
    $relatedProducts = fetchRelatedProducts($pdo, $products[0]->id_produit, $products[0]->id_categorie);
} else {
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Product Details</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.svg" />

</head>

<body>

<?php
    include('assets/php/topbar.php');
    ?>
    <?php
    include('assets/php/header.php');
    ?>



<div class="container mt-5">
    <!-- Product Details -->
    <div class="row">
        <div class="col-lg-6">
            <?php foreach ($products as $product): ?>
                <img src="assets/image/<?php echo $product->image_produit; ?>" class="img-fluid" alt="Product Image">
            <?php endforeach; ?>
        </div>
        <div class="col-lg-6">
            <?php foreach ($products as $product): ?>
                <h2><?php echo $product->nom_produit; ?></h2>
                <p class="text-muted">Category: <?php echo $product->category_name; ?></p>
                <p class="lead">$<?php echo $product->prix_produit; ?></p>
                <p><?php echo $product->description; ?></p>
                <button class="btn btn-primary">Add to Cart</button>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Related Products -->
    <div class="mt-5">
        <h3>Related Products</h3>
        <div class="row">
            <?php foreach ($relatedProducts as $relatedProduct): ?>
                <div class="col-lg-4">
                    <div class="card">
                        <img src="assets/image/<?php echo $relatedProduct->image_produit; ?>" alt="Product Image" class="card-img-top">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $relatedProduct->nom_produit; ?></h5>
                            <p class="card-text">$<?php echo $relatedProduct->prix_produit; ?></p>
                            <a href="product-details.php?id=<?php echo $relatedProduct->id_produit; ?>" class="btn btn-primary">View Details</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<?php
echo'<br>';
echo'<br>';
echo'<br>';
echo '<footer>';
include('assets/php/footer1.php');
echo '</footer>';
?>

<style>
    .container {
        margin-bottom: 50px;
    }
    .card-img-top{
        height: 400px;
    }
    .img-fluid{
        height: 60vh;
        border: 1px solid #ddd;
    }
</style>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

</body>
</html>
