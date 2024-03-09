<?php
class CategorySection {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function displayCategories() {
        $sqlqueryCategories = "SELECT * FROM categorie";
        $stmtCategories = $this->pdo->query($sqlqueryCategories);
        $categories = $stmtCategories->fetchAll(PDO::FETCH_ASSOC);

        // Display categories
        echo '<section class="category-section section" style="margin-top: 12px;">';
        echo '<div class="row justify-content-center align-items-center">';
        foreach ($categories as $category) {
            $this->displayCategoryCard($category);
        }

        echo '</div>';
        echo '</section>';
    }

    private function displayCategoryCard($category) {
        echo '<div class="col-md-4 mb-4">';
        echo '<div class="card border-0 shadow-sm">';
        
        if (isset($category['image_categorie'])) {
            echo '<img src="assets/image/Categorie/' . $category['image_categorie'] . '" class="card-img-top" alt="' . $category['image_categorie'] . '">';
        }

        echo '<div class="card-body">';
        
        if (isset($category['nom_categorie'])) {
            echo '<h5 class="card-title">' . $category['nom_categorie'] . '</h5>';
        }

        
        

        echo '<a href="subcategories.php?categorie=' . $category['id_categorie'] . '" class="btn btn-primary">View</a>';
        
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }
}
?>
<style>
 
 .col-md-4.mb-4 {

    position: relative; /* Add this line */
    overflow: hidden; /* Hide any content that exceeds the height */
}

.card-img-top {
    height: 300px; /* Adjust this value as needed */
    width: 100%;
}

.btn.btn-primary {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    opacity: 0; /* Hidden initially */
    transition: opacity 0.3s ease-in-out;
}

.card.border-0.shadow-sm:hover .btn.btn-primary {
    opacity: 1; /* Show on hover */
}

</style>