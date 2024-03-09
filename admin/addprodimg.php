<?php
require_once('includes/connexion.php');

// Fetch categories from the database
$sqlqueryCategories = "SELECT * FROM categorie";
$stmtCategories = $pdo->query($sqlqueryCategories);
$categories = $stmtCategories->fetchAll(PDO::FETCH_ASSOC);

// Fetch subcategories from the database
$sqlquerySubcategories = "SELECT * FROM scategorie";
$stmtSubcategories = $pdo->query($sqlquerySubcategories);
$subcategories = $stmtSubcategories->fetchAll(PDO::FETCH_ASSOC);

// Handle form submission to add a new product
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productName = $_POST['nom_produit'];
    $productPrice = $_POST['prix_produit'];
    $productCategory = $_POST['id_categorie'];
    $productSubcategory = $_POST['id_scategorie'];
    $productDescription = $_POST['description']; 

    $imageFileName = $_FILES['image_produit']['name'];
    $imageTempPath = $_FILES['image_produit']['tmp_name'];
    $uploadPath = '../assets/image/' . $imageFileName; 

    move_uploaded_file($imageTempPath, $uploadPath);

    // Insert the product into the database
    $sqlInsertProduct = "INSERT INTO produit (nom_produit, id_scategorie, id_categorie, prix_produit, image_produit, description) 
                        VALUES (:nom_produit, :id_scategorie, :id_categorie, :prix_produit, :image_produit, :description)";
    $stmtInsertProduct = $pdo->prepare($sqlInsertProduct);
    $stmtInsertProduct->execute([
        'nom_produit' => $productName,
        'id_scategorie' => $productSubcategory,
        'id_categorie' => $productCategory,
        'prix_produit' => $productPrice,
        'image_produit' => $imageFileName,
        'description' => $productDescription 
    ]);

    // Redirect to the same page after product insertion
    header('Location: afficherprod.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>

<div class="container mt-5">
    <h2>Add New Product</h2>
    <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="nom_produit" class="form-label">Product Name</label>
            <input type="text" class="form-control" id="nom_produit" name="nom_produit" required>
        </div>
        <div class="mb-3">
            <label for="prix_produit" class="form-label">Product Price</label>
            <input type="text" class="form-control" id="prix_produit" name="prix_produit" required>
        </div>
        <div class="mb-3">
            <label for="id_categorie" class="form-label">Category</label>
            <select class="form-select" id="id_categorie" name="id_categorie" required>
                <option selected>Choose...</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?= $category['id_categorie'] ?>"><?= $category['nom_categorie'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="id_scategorie" class="form-label">Subcategory</label>
            <select class="form-select" id="id_scategorie" name="id_scategorie" required>
                <option selected>Choose...</option>
                <?php foreach ($subcategories as $subcategory): ?>
                    <option value="<?= $subcategory['id_scategorie'] ?>"><?= $subcategory['nom_scategorie'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Product Description</label>
            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
        </div>
        <div class="mb-3">
            <label for="image_produit" class="form-label">Product Image</label>
            <input type="file" class="form-control" id="image_produit" name="image_produit" required>
        </div>
        <button type="submit" class="btn btn-primary">Add Product</button>
    </form>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>
