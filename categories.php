<?php
require_once('includes/connexion.php');
session_start();

$sqlquery = "SELECT * FROM categorie";
$stmt = $pdo->query($sqlquery);
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
    .card {
        height: 100%;
    }

    .card-img-top{
        width: 300px;
        height: auto;
    }

    .myButton {
        transition: all 0.3s ease;
    }

    .myButton:hover {
        background-color: #0056b3;
        color: white;
    }
    </style>
</head>

<body>
    <?php
    include('assets/php/topbar.php');
    include('assets/php/header.php');
    echo '<nav>';
    include('assets/php/bread.php');
    echo '</nav>';
    ?>

    <div class="container mt-5">
        <h1 class="text-center">Our categories :</h1>
        <br>
        <div class="row justify-content-center">
            <?php foreach ($categories as $category): ?>
            <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-sm d-flex flex-column">
                    <?php if (isset($category['image_categorie'])): ?>
                    <img src="assets/image/Categorie/<?= $category['image_categorie'] ?>" class="card-img-top"
                        alt="<?= $category['image_categorie'] ?>">
                    <?php endif; ?>
                    <div class="card-body text-center d-flex flex-column justify-content-between">
                        <?php if (isset($category['nom_categorie'])): ?>
                        <h5 class="card-title"><?= $category['nom_categorie'] ?></h5>
                        <?php endif; ?>
                        <a href="subcategories.php?categorie=<?= $category['id_categorie'] ?>"
                        class="btn btn-primary myButton mt-auto">View Subcategories</a>

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