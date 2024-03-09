<main>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>

            <?php
            $currentPage = basename($_SERVER['PHP_SELF']);

            switch ($currentPage) {
                case 'categories.php':
                    echo '<li class="breadcrumb-item active" aria-current="page">Categories</li>';
                    break;
                case 'subcategories.php':
                    echo '<li class="breadcrumb-item"><a href="categories.php">Categories</a></li>';
                    echo '<li class="breadcrumb-item active" aria-current="page">Subcategories</li>';
                    break;
                case 'produit.php':
                    echo '<li class="breadcrumb-item"><a href="categories.php">Categories</a></li>';
                    echo '<li class="breadcrumb-item"><a href="subcategories.php">Subcategories</a></li>';
                    echo '<li class="breadcrumb-item active" aria-current="page">Products</li>';
                    break;
                // Add more cases for additional pages if needed
                default:
                    echo '<li class="breadcrumb-item active" aria-current="page">Unknown Page</li>';
                    break;
            }
            ?>

        </ol>
    </nav>
</main>
