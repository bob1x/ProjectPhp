<?php
require_once('includes/connexion.php');

if (isset($_POST['dele'])) {
    $id_produit = $_POST['id_produit'];

    // Delete the product record
    $sqlqueryDelete = "DELETE FROM produit WHERE id_produit = :id_produit";
    $stmtDelete = $pdo->prepare($sqlqueryDelete);
    if ($stmtDelete->execute(['id_produit' => $id_produit])) {
        $succmsg = 'Produit supprimé avec succès';
    } else {
        $errmsg = 'Erreur lors de la suppression du produit';
    }
    header('Location: afficherprod.php');
}

if (isset($_POST['submitnomp'])) {
    $name = $_POST['nom_produit'];
    $description = $_POST['description'];
    $price = $_POST['prix_produit'];
    $quantite = $_POST['quantite'];
    $id_produit = $_POST['id_produit'];

    $newImageFileName = null;

    if ($_FILES['new_image_produit']['size'] > 0) {
        $newImageFileName = $_FILES['new_image_produit']['name'];
        $newImageTempPath = $_FILES['new_image_produit']['tmp_name'];
        $uploadPath = '../assets/image/' . $newImageFileName; 
        move_uploaded_file($newImageTempPath, $uploadPath);
    }

    $sqlUpdateProduct = "UPDATE produit SET nom_produit = :name, description = :description, prix_produit = :price, quantite = :quantite";
    if ($newImageFileName) {
        $sqlUpdateProduct .= ", image_produit = :new_image_produit";
    }
    $sqlUpdateProduct .= " WHERE id_produit = :id_produit";

    $stmtUpdateProduct = $pdo->prepare($sqlUpdateProduct);

    $params = [
        'name' => $name,
        'description' => $description,
        'price' => $price,
        'quantite' => $quantite,
        'id_produit' => $id_produit
    ];

    // Add new image parameter if a new image is provided
    if ($newImageFileName) {
        $params['new_image_produit'] = $newImageFileName;
    }

    if ($stmtUpdateProduct->execute($params)) {
        $succmsg = 'Produit mis à jour avec succès';
    } else {
        $errmsg = 'Erreur lors de la mise à jour du produit';
    }
    header('Location: index.php');
}
$sqlquery = "
    SELECT p.id_produit, p.quantite, p.nom_produit, p.prix_produit, p.id_scategorie, s.nom_scategorie, c.nom_categorie, p.description, p.image_produit
    FROM produit p
    INNER JOIN scategorie s ON p.id_scategorie = s.id_scategorie
    INNER JOIN categorie c ON s.id_categorie = c.id_categorie
";
$stmt = $pdo->query($sqlquery);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of Products</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Custom CSS -->
    <style>
    .container {
        margin-top: 50px;
    }

    .btn-action {
        padding: 5px 10px;
        margin-right: 5px;
    }

    .product-image {
        max-width: 100px;
        max-height: 100px;
    }

    .description-cell {
        width: 250px;
        /* Adjust as needed */
        height: 50px;
        /* Adjust as needed */
        overflow: auto;
        word-wrap: break-word;
    }
    </style>
</head>

<body>

    <div class="container">
        <h1 class="mb-4">List of Products</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Category</th>
                    <th>Subcategory</th>
                    <th>Product ID</th>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Image</th>
                    <th>Description</th>
                    <th>Action</th>
                </tr>
            </thead>
            <a href="addprodimg.php" class="btn btn-success mb-3">
                <i class="fas fa-plus"></i>
            </a>
            <tbody>
                <?php foreach ($products as $product): ?>
                <tr>
                    <td><?= $product['nom_categorie'] ?></td>
                    <td><?= $product['nom_scategorie'] ?></td>
                    <td><?= $product['id_produit'] ?></td>
                    <td><?= $product['nom_produit'] ?></td>
                    <td><?= $product['prix_produit'] ?></td>
                    <td><?= $product['quantite'] ?></td>s
                    <td><img src="../assets/image/<?= $product['image_produit'] ?>" alt="Product Image"
                            class="product-image"></td>
                    <td class="description-cell"><?= $product['description'] ?></td>
                    <td>
                        <form method="POST" action="#">
                            <input type="hidden" name="id_produit" value="<?= $product['id_produit'] ?>">
                            <button type="submit" name="dele" class="btn btn-danger btn-action">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                        <button type="button" class="btn btn-primary btn-action" data-bs-toggle="modal"
                            data-bs-target="#editProduct<?= $product['id_produit'] ?>">
                            <i class="fas fa-edit"></i>
                        </button>
                    </td>
                </tr>

                <!-- Edit Product Modal -->
                <div class="modal fade" id="editProduct<?= $product['id_produit'] ?>" tabindex="-1"
                    aria-labelledby="editProductLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editProductLabel">Edit Product</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form method="POST" action="afficherprod.php" enctype="multipart/form-data">
                                    <input type="hidden" name="id_produit" value="<?= $product['id_produit'] ?>">
                                    <div class="mb-3">
                                        <label for="productEditName" class="form-label">Product Name</label>
                                        <input type="text" class="form-control" id="productEditName" name="nom_produit"
                                            value="<?= $product['nom_produit'] ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="productEditPrice" class="form-label">Product Price</label>
                                        <input type="text" class="form-control" id="productEditPrice"
                                            name="prix_produit" value="<?= $product['prix_produit'] ?>" required>
                                        <label for="quantite">Quantity</label>
                                        <input type="number" class="form-control" id="quantite" name="quantite"
                                            value="<?= $product['quantite'] ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label for="productEditImage" class="form-label">New Image</label>
                                        <input type="file" class="form-control" id="productEditImage"
                                            name="new_image_produit">
                                    </div>
                                    <div class="mb-3">
                                        <label for="productEditDescription" class="form-label">Product
                                            Description</label>
                                        <textarea class="form-control" id="productEditDescription"
                                            name="description"><?= $product['description'] ?></textarea>
                                    </div>
                                    <button type="submit" name="submitnomp" class="btn btn-primary">Save
                                        Changes</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Bootstrap JS and Font Awesome -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js"
        integrity="sha384-bUJ6L2gGzS9oDjcMQ2eN/tC2DHbTi6P23U/Z9OwLid8fGqIqOMZsaz3dnhbhtvJl" crossorigin="anonymous">
    </script>

</body>

</html>