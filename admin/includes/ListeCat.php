<?php
require_once('includes/connexion.php');
ob_start(); // Start output buffering at the beginning of the file

if (isset($_POST['delete_category'])) {
    $categoryId = $_POST['id_categorie'];

    $sqlquery = "DELETE FROM categorie WHERE id_categorie = :categoryId";
    $stmt = $pdo->prepare($sqlquery);
    $stmt->execute(['categoryId' => $categoryId]);

    exit();
}


if (isset($_POST['update_category'])) {
    $id_categorie = $_POST['id_categorie'];
    $new_name = $_POST['new_name'];

    $newImageFileName = null;

    if ($_FILES['new_image_categorie']['size'] > 0) {
        $newImageFileName = $_FILES['new_image_categorie']['name'];
        $newImageTempPath = $_FILES['new_image_categorie']['tmp_name'];
        $uploadPath = '../../assets/image/Categorie/' . $newImageFileName; 

        move_uploaded_file($newImageTempPath, $uploadPath);
    }

    $sqlUpdateCategory = "UPDATE categorie SET nom_categorie = :new_name";
    if ($newImageFileName) {
        $sqlUpdateCategory .= ", image_categorie = :new_image_categorie";
    }
    $sqlUpdateCategory .= " WHERE id_categorie = :id_categorie";

    $stmtUpdateCategory = $pdo->prepare($sqlUpdateCategory);

    $params = [
        'new_name' => $new_name,
        'id_categorie' => $id_categorie
    ];

    if ($newImageFileName) {
        $params['new_image_categorie'] = $newImageFileName;
    }

    if ($stmtUpdateCategory->execute($params)) {
        $succmsg = 'Catégorie mise à jour avec succès';
    } else {
        $errmsg = 'Erreur lors de la mise à jour de la catégorie';
    }

}

$sqlqueryCategories = "SELECT * FROM categorie";
$stmtCategories = $pdo->query($sqlqueryCategories);
$categories = $stmtCategories->fetchAll(PDO::FETCH_ASSOC);
ob_end_flush();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of Categories</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
    .container {
        margin-top: 50px;
    }

    .btn-action {
        padding: 5px 10px;
        margin-right: 5px;
    }

    .popup-form {
        display: none;
    }

    .category-image {
        max-width: 100px;
        max-height: 100px;
    }
    </style>
</head>

<body>

    <div class="container">
        <h1 class="mb-4">List of Categories</h1>
        <a href="ajoutcat.php" class="btn btn-success mb-3">
        <i class="fas fa-plus"></i> 
    </a>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Category ID</th>
                    <th>Category Name</th>
                    <th>Image</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categories as $category): ?>
                <tr>
                    <td><?= $category['id_categorie'] ?></td>
                    <td><?= $category['nom_categorie'] ?></td>
                    <td><img src="../assets/image/categorie/<?= $category['image_categorie'] ?>" alt="Category Image"
                            class="category-image"></td>
                    <td>
                        <!-- Delete category form -->
                        <form method="POST" action="#">
                            <input type="hidden" name="id_categorie" value="<?= $category['id_categorie'] ?>">
                            <button type="submit" name="delete_category" class="btn btn-danger btn-action">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </form>
                        <!-- Edit category form -->
                        <button type="button" class="btn btn-primary btn-action" data-bs-toggle="modal"
                            data-bs-target="#editCategory<?= $category['id_categorie'] ?>">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                    </td>
                </tr>

                <!-- Edit Category Modal -->
                <div class="modal fade" id="editCategory<?= $category['id_categorie'] ?>" tabindex="-1"
                    aria-labelledby="editCategoryLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editCategoryLabel">Edit Category</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form method="POST" action="<?= $_SERVER['PHP_SELF'] ?>" enctype="multipart/form-data">
                                    <input type="hidden" name="id_categorie" value="<?= $category['id_categorie'] ?>">
                                    <div class="mb-3">
                                        <label for="categoryEditName" class="form-label">Category Name</label>
                                        <input type="text" class="form-control" id="categoryEditName" name="new_name"
                                            value="<?= $category['nom_categorie'] ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="categoryEditImage" class="form-label">New Image</label>
                                        <input type="file" class="form-control" id="categoryEditImage"
                                            name="new_image_categorie">
                                    </div>
                                    <button type="submit" name="update_category" class="btn btn-primary">Save
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js"
        integrity="sha384-bUJ6L2gGzS9oDjcMQ2eN/tC2DHbTi6P23U/Z9OwLid8fGqIqOMZsaz3dnhbhtvJl" crossorigin="anonymous">
    </script>

</body>

</html>