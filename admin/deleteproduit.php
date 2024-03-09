<?php
require_once('includes/connexion.php');
$succmsg = '';
$errmsg = '';

// Fetching subcategories for dropdown
$sqlquerySubcategories = "SELECT * FROM scategorie";
$stmtSubcategories = $pdo->query($sqlquerySubcategories);
$subcategories = $stmtSubcategories->fetchAll(PDO::FETCH_ASSOC);

// Fetching products for the selected subcategory
if (isset($_POST['id_scategorie'])) {
    $selectedSubcategoryId = $_POST['id_scategorie'];
    $sqlqueryProducts = "SELECT * FROM produit WHERE id_scategorie = :id_scategorie";
    $stmtProducts = $pdo->prepare($sqlqueryProducts);
    $stmtProducts->execute(['id_scategorie' => $selectedSubcategoryId]);
    $products = $stmtProducts->fetchAll(PDO::FETCH_ASSOC);
}

// Deleting a product
if (isset($_POST['dele'])) {
    $id_produit = $_POST['id_produit'];
    $sqlqueryDelete = "DELETE FROM produit WHERE id_produit = :id_produit";
    $stmtDelete = $pdo->prepare($sqlqueryDelete);
    if ($stmtDelete->execute(['id_produit' => $id_produit])) {
        $succmsg = 'Produit supprimé avec succès';
    } else {
        $errmsg = 'Erreur lors de la suppression du produit';
    }
    header('Location: afficherprod.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>

<form action="#" method="POST">
    <legend>
        <h1>Sous-catégorie</h1>

        <!-- Dropdown for selecting a subcategory -->
        <label for="subcategorySelect">sCatégorie</label>
        <select class="form-select" id="subcategorySelect" name="id_scategorie" onchange="this.form.submit()">
            <option selected>Choose...</option>
            <?php
            foreach ($subcategories as $subcategory) {
                $selected = ($subcategory['id_scategorie'] == $selectedSubcategoryId) ? 'selected' : '';
                echo '<option value="' . $subcategory['id_scategorie'] . '" ' . $selected . '>' . $subcategory['nom_scategorie'] . '</option>';
            }
            ?>
        </select>

        <!-- Fetching products for the selected subcategory -->
        <legend>
            <label for="productSelect">Produit</label>
            <select class="form-select" id="productSelect" name="id_produit">
                <option selected>Choose</option>
                <?php
                if (isset($products)) {
                    foreach ($products as $product) {
                        echo '<option value="' . $product['id_produit'] . '">' . $product['nom_produit'] . '<br>' . $product['prix_produit'] . '</option>';
                    }
                }
                ?>
            </select>

            <button type="submit" name="dele" class="btn btn-danger">Delete</button>
        </legend>
    </legend>
</form>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>
