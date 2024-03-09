<?php
include(__DIR__ . '/../includes/connexion.php');

// Fetch subcategories from the database
$sqlSelect = "SELECT id_scategorie, nom_scategorie, image_scategorie FROM scategorie";
$stmtSelect = $pdo->prepare($sqlSelect);
$stmtSelect->execute();
$subcategories = $stmtSelect->fetchAll(PDO::FETCH_ASSOC);


if (isset($_POST['delete_subcategory'])) {
    $id_scategorie = $_POST['id_scategorie'];

    $sqlDelete = "DELETE FROM scategorie WHERE id_scategorie = :id_scategorie";
    $stmtDelete = $pdo->prepare($sqlDelete);
    $stmtDelete->execute(['id_scategorie' => $id_scategorie]);
}

if (isset($_POST['update_subcategory'])) {
    $id_scategorie = $_POST['id_scategorie'];
    $new_name = $_POST['new_name'];

    $newImageFileName = null;

    // Check if a new image is uploaded
    if ($_FILES['new_image_scategorie']['size'] > 0) {
        $newImageFileName = $_FILES['new_image_scategorie']['name'];
        $newImageTempPath = $_FILES['new_image_scategorie']['tmp_name'];
        $uploadPath = '../../assets/image/SCategorie/' . $newImageFileName; 

        move_uploaded_file($newImageTempPath, $uploadPath);
    }

    // Update the subcategory record with the new name and image
    $sqlUpdate = "UPDATE scategorie SET nom_scategorie = :new_name";
    if ($newImageFileName) {
        $sqlUpdate .= ", image_scategorie = :new_image_scategorie";
    }
    $sqlUpdate .= " WHERE id_scategorie = :id_scategorie";

    $stmtUpdate = $pdo->prepare($sqlUpdate);

    $params = ['new_name' => $new_name, 'id_scategorie' => $id_scategorie];

    if ($newImageFileName) {
        $params['new_image_scategorie'] = $newImageFileName;
    }

    if ($stmtUpdate->execute($params)) {
        $succmsg = 'Sous-catégorie mise à jour avec succès';
    } else {
        $errmsg = 'Erreur lors de la mise à jour de la sous-catégorie';
    }

    header('Location: ../index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of Subcategories</title>
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

    .subcategory-image {
        max-width: 100px;
        max-height: 100px;
    }
    </style>
</head>

<body>

    <div class="container">
        <h1 class="mb-4">List of Subcategories</h1>
        <a href="ajoutsubcat.php" class="btn btn-success mb-3">
            <i class="fas fa-plus"></i> 
        </a>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Subcategory ID</th>
                    <th>Subcategory Name</th>
                    <th>Image</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($subcategories as $subcategory): ?>
                <tr>
                    <td><?= $subcategory['id_scategorie'] ?></td>
                    <td><?= $subcategory['nom_scategorie'] ?></td>
                    <td><img src="../assets/image/SCategorie/<?= $subcategory['image_scategorie'] ?>" alt="ImageSCat"
                            class="SCAT-image"></td>
                    <td>
                        <!-- Delete subcategory form -->
                        <form method="POST" action="#">
                            <input type="hidden" name="id_scategorie" value="<?= $subcategory['id_scategorie'] ?>">
                            <button type="submit" name="delete_subcategory" class="btn btn-danger btn-action">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </form>
                        <!-- Edit subcategory form -->
                        <button type="button" class="btn btn-primary btn-action" data-bs-toggle="modal"
                            data-bs-target="#editSubcategory<?= $subcategory['id_scategorie'] ?>">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                    </td>
                </tr>

                <!-- Edit Subcategory Modal -->
                <div class="modal fade" id="editSubcategory<?= $subcategory['id_scategorie'] ?>" tabindex="-1"
                    aria-labelledby="editSubcategoryLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editSubcategoryLabel">Edit Subcategory</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form method="POST"action="includes/ListeSCat.php" enctype="multipart/form-data">
                                    <input type="hidden" name="id_scategorie"
                                        value="<?= $subcategory['id_scategorie'] ?>">
                                    <div class="mb-3">
                                        <label for="subcategoryEditName" class="form-label">Subcategory Name</label>
                                        <input type="text" class="form-control" id="subcategoryEditName"
                                            name="new_name" value="<?= $subcategory['nom_scategorie'] ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="subcategoryEditImage" class="form-label">New Image</label>
                                        <input type="file" class="form-control" id="subcategoryEditImage"
                                            name="new_image_scategorie">
                                    </div>
                                    <button type="submit" name="update_subcategory" class="btn btn-primary">Save
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
