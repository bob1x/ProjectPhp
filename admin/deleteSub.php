<?php
require_once('includes/connexion.php');

$succmsg = '';
$errmsg = '';

// Fetch subcategories from the database
$sqlquerySubcategories = "SELECT * FROM scategorie";
$stmtSubcategories = $pdo->query($sqlquerySubcategories);
$subcategories = $stmtSubcategories->fetchAll(PDO::FETCH_ASSOC);

// Handle subcategory deletion
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['deleteSubcategory'])) {
    // Check if a subcategory is selected
    if (isset($_POST['subcategoryToDelete'])) {
        $selectedSubcategoryId = $_POST['subcategoryToDelete'];

        // Check if there are associated products
        $sqlqueryCheck = "SELECT COUNT(*) as countProducts FROM produit WHERE id_scategorie = :id_scategorie";

        try {
            $stmtCheck = $pdo->prepare($sqlqueryCheck);
            $stmtCheck->execute(['id_scategorie' => $selectedSubcategoryId]);

            $countProducts = $stmtCheck->fetchColumn();

            if ($countProducts == 0) {
                // No associated products, proceed with deletion
                $sqlqueryDelete = "DELETE FROM scategorie WHERE id_scategorie = :id_scategorie";
                $stmtDelete = $pdo->prepare($sqlqueryDelete);

                if ($stmtDelete->execute(['id_scategorie' => $selectedSubcategoryId])) {
                    $succmsg = 'Subcategory deleted successfully';
                } else {
                    $errmsg = 'Error deleting subcategory';
                }
            } else {
                $errmsg = 'Subcategory cannot be deleted. It has associated products.';
            }
        } catch (PDOException $e) {
            $errmsg = 'Error: ' . $e->getMessage();
        }
    } else {
        $errmsg = 'Please select a subcategory to delete.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Subcategory</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>

<div class="container mt-5">
    <h1>Delete Subcategory</h1>
    
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
            <label for="subcategoryToDelete" class="form-label">Select Subcategory to Delete:</label>
            <select class="form-select" id="subcategoryToDelete" name="subcategoryToDelete" required>
                <option value="" selected disabled>Select Subcategory</option>
                <?php foreach ($subcategories as $subcategory): ?>
                    <option value="<?= $subcategory['id_scategorie'] ?>"><?= $subcategory['nom_scategorie'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <button type="submit" name="deleteSubcategory" class="btn btn-danger">Delete Subcategory</button>
    </form>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>
