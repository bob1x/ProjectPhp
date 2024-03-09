<!-- manageSubCat.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Subcategories</title>
    <!-- Include Bootstrap CSS and any other necessary stylesheets -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>

<div class="container mt-5">
    <h1 class="mb-4">Manage Categories</h1>
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Add SubCategory</h5>
                    <p class="card-text">Add a new Subcategory to the system.</p>
                    <a href="ajoutsubcat.php" class="btn btn-primary">Add Category</a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Delete SubCategory</h5>
                    <p class="card-text">Delete an existing Subcategory from the system.</p>
                    <a href="deleteSub.php" class="btn btn-danger">Delete SCategory</a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include('includes/return.php'); ?>

<!-- Your main content for managing subcategories goes here -->

<!-- Include Bootstrap JS and any other necessary scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

</body>
</html>
