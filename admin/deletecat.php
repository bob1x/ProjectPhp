<?php
require_once('includes/connexion.php');

$succmsg = '';
$errmsg = '';

$sqlqueryCategories = "SELECT * FROM categorie";
$stmtCategories = $pdo->query($sqlqueryCategories);
$categories = $stmtCategories->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['deleteCategory'])) {
    if (isset($_POST['categoryToDelete'])) {
        $selectedCategoryId = $_POST['categoryToDelete'];

        $sqlqueryCheck = "SELECT COUNT(*) as countProducts FROM produit WHERE id_categorie = :id_categorie;
                          SELECT COUNT(*) as countSubcategories FROM scategorie WHERE id_categorie = :id_categorie;";

        try {
            $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
            
            $stmtCheck = $pdo->prepare($sqlqueryCheck);
            $stmtCheck->execute(['id_categorie' => $selectedCategoryId]);

            $countProducts = $stmtCheck->fetchColumn();

            $stmtCheck->nextRowset();

            $countSubcategories = $stmtCheck->fetchColumn();

            if ($countProducts == 0 && $countSubcategories == 0) {
                $sqlqueryDelete = "DELETE FROM categorie WHERE id_categorie = :id_categorie";
                $stmtDelete = $pdo->prepare($sqlqueryDelete);

                if ($stmtDelete->execute(['id_categorie' => $selectedCategoryId])) {
                    $succmsg = 'Category deleted successfully';
                } else {
                    $errmsg = 'Error deleting category';
                }
            } else {
                $errmsg = 'Category cannot be deleted. It has associated products or subcategories.';
            }
        } catch (PDOException $e) {
            $errmsg = 'Error: ' . $e->getMessage();
        }
    } else {
        $errmsg = 'Please select a category to delete.';
    }
    header('index.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Category</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>

<div class="container mt-5">
    <h1>Delete Category</h1>
    
    <?php if ($succmsg): ?>
        <div class="alert alert-success" role="alert">
            <?= $succmsg ?>
        </div>
    <?php elseif ($errmsg): ?>
        <div class="alert alert-danger" role="alert">
            <?= $errmsg ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="#">
        <div class="mb-3">
            <label for="categoryToDelete" class="form-label">Select Category to Delete:</label>
            <select class="form-select" id="categoryToDelete" name="categoryToDelete" required>
                <option value="" selected disabled>Select Category</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?= $category['id_categorie'] ?>"><?= $category['nom_categorie'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <button type="submit" name="deleteCategory" class="btn btn-danger">Delete Category</button>
    </form>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>
