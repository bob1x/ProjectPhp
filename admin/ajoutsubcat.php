<?php
require_once('includes/connexion.php');

$sqlqueryCategories = "SELECT * FROM categorie";
$stmtCategories = $pdo->query($sqlqueryCategories);
$categories = $stmtCategories->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $subcategoryName = $_POST['nom_scategorie'];
    $subcategoryCategory = $_POST['id_categorie'];

    $imageFileName = $_FILES['image_scategorie']['name'];
    $imageTempPath = $_FILES['image_scategorie']['tmp_name'];
    $uploadPath = '../assets/SCategorie/' . $imageFileName; 

    move_uploaded_file($imageTempPath, $uploadPath);

    $sqlInsertSubcategory = "INSERT INTO scategorie (nom_scategorie, id_categorie, image_scategorie) VALUES (:nom_scategorie, :id_categorie, :image_scategorie)";
    $stmtInsertSubcategory = $pdo->prepare($sqlInsertSubcategory);
    $stmtInsertSubcategory->execute([
        'nom_scategorie' => $subcategoryName,
        'id_categorie' => $subcategoryCategory,
        'image_scategorie' => $imageFileName
    ]);

    header('Location: ajoutsubcat.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Subcategory</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>

<div class="container mt-5">
    <h2>Add New Subcategory</h2>
    <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="nom_scategorie" class="form-label">Subcategory Name</label>
            <input type="text" class="form-control" id="nom_scategorie" name="nom_scategorie" required>
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
            <label for="image_scategorie" class="form-label">Subcategory Image</label>
            <input type="file" class="form-control" id="image_scategorie" name="image_scategorie" required>
        </div>
        <button type="submit" class="btn btn-primary">Add Subcategory</button>
    </form>
</div>


<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>
