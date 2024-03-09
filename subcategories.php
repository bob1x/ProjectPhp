<?php
require_once('includes/connexion.php');
session_start();

if (isset($_GET['categorie'])) {
    $id_categorie = $_GET['categorie'];
} else {
    header("Location: index.php");
    exit();
}

$sqlquerySubcategories = "SELECT * FROM scategorie WHERE id_categorie = :id_categorie";
$stmtSubcategories = $pdo->prepare($sqlquerySubcategories);
$stmtSubcategories->execute(['id_categorie' => $id_categorie]);
$subcategories = $stmtSubcategories->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <!-- Bootstrap CSS -->
    <link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.svg" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="assets/css/LineIcons.3.0.css" />
    <link rel="stylesheet" href="assets/css/tiny-slider.css" />
    <link rel="stylesheet" href="assets/css/glightbox.min.css" />
    <link rel="stylesheet" href="assets/css/main.css" />
</head>

<body>
    <?php
    include('assets/php/topbar.php');
    require_once('assets/php/header.php');
   
    echo '<nav>';
    include('assets/php/bread.php');
    echo '</nav>';
?>

    <div class="container mt-5">
        <h1 class="text-center">Subcategories</h1>
        <div class="row justify-content-center">
            <?php foreach ($subcategories as $subcategory): ?>
            <div class="col-md-4 mb-4">
                <div class="card border-0 shadow-sm d-flex flex-column">
                    <img src="assets/image/SCategorie/<?= $subcategory['image_scategorie'] ?>" class="card-img-top"
                        alt="<?= $subcategory['nom_scategorie'] ?>">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <div>
                            <h5 class="card-title"><?= $subcategory['nom_scategorie'] ?></h5>
                        </div>
                        <a href="produit-s.php?scategorie=<?= $subcategory['id_scategorie'] ?>"
                            class="btn btn-primary mt-auto">View Products</a>
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

    <style>
    .card {
        height: 100%;
    }

    .card img {
        max-width: 100%;
        height: auto;
    }
    </style>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
</body>

</html>