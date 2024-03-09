<?php
require_once('includes/connexion.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $categoryName = $_POST['nom_categorie'];

    $imageFileName = $_FILES['image_categorie']['name'];
    $imageTempPath = $_FILES['image_categorie']['tmp_name'];
    $uploadPath = '../assets/categorie/' . $imageFileName; 

    move_uploaded_file($imageTempPath, $uploadPath);

    $sqlInsertCategory = "INSERT INTO categorie (nom_categorie, image_categorie) VALUES (:nom_categorie, :image_categorie)";
    $stmtInsertCategory = $pdo->prepare($sqlInsertCategory);
    $stmtInsertCategory->execute([
        'nom_categorie' => $categoryName,
        'image_categorie' => $imageFileName
    ]);

    
    header('Location: index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Category</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>

<div class="container mt-5">
    <h2>Add New Category</h2>
    <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="nom_categorie" class="form-label">Category Name</label>
            <input type="text" class="form-control" id="nom_categorie" name="nom_categorie" required>
        </div>
        <div class="mb-3">
            <label for="image_categorie" class="form-label">Category Image</label>
            <input type="file" class="form-control" id="image_categorie" name="image_categorie" required>
        </div>
        <button type="submit" class="btn btn-primary">Add Category</button>
    </form>
</div>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>
