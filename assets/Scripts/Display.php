<?php
class ProductSection {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function displayTrendingProducts() {
        $sqlqueryProducts = "SELECT * FROM produit";
        $stmtProducts = $this->pdo->query($sqlqueryProducts);
        $products = $stmtProducts->fetchAll(PDO::FETCH_ASSOC);

        // Display products
        echo '<section class="trending-product section" style="margin-top: 12px;">';
        echo '<div class="row justify-content-center align-items-center">';
        foreach ($products as $product) {
            $this->displayProductCard($product);
        }

        echo '</div>';
        echo '</section>';
    }

    private function displayProductCard($product) {
        echo '<div class="col-lg-3 col-md-6 col-12 mb-4">';
        echo '<div class="single-product">';
    
        echo '<div class="product-image">';
        echo '<img src="assets/image/' . $product['image_produit'] . '" alt="' . $product['nom_produit'] .  '">';
        echo '<div class="button">';
        echo '<a href="product-details.php?id=' . $product['id_produit'] . '" class="btn"><i class="lni lni-cart"></i> Add to Cart</a>';
        echo '</div>';
        echo '</div>';
    
        echo '<div class="product-info">';
        
        // Fetch category information for the product
        $sqlqueryCategory = "SELECT nom_categorie FROM categorie WHERE id_categorie = :id_categorie";
        $stmtCategory = $this->pdo->prepare($sqlqueryCategory);
        $stmtCategory->execute(['id_categorie' => $product['id_categorie']]);
        $category = $stmtCategory->fetch(PDO::FETCH_ASSOC);
    
        echo '<span class="category">' . $category['nom_categorie'] . '</span>';
        echo '<h4 class="title">';
        echo '<a href="product-details.php?id=' . $product['id_produit'] . '">' . $product['nom_produit'] . '</a>';
        echo '</h4>';
    
        // You need to replace this with actual review stars and review count
        echo '<ul class="review">';
        echo '<li><i class="lni lni-star-filled"></i></li>';
        echo '<li><i class="lni lni-star-filled"></i></li>';
        echo '<li><i class="lni lni-star-filled"></i></li>';
        echo '<li><i class="lni lni-star-filled"></i></li>';
        echo '<li><i class="lni lni-star-filled"></i></li>';
        echo '<li><span>5.0 Review(s)</span></li>';
        echo '</ul>';
    
        echo '<div class="price">';
        echo '<span>$' . $product['prix_produit'] . '</span>'; // You need to replace this with actual price
        echo '<span class="discount-price">$300.00</span>'; // You need to replace this with actual discount price
        echo '</div>';
    
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }
}
?>

<style>
 
 .single-product {
    height: 600px; /* Adjust this value as needed */
    overflow: hidden; /* Hide any content that exceeds the height */

}


.product-image img {
    height: 300px; /* Adjust this value as needed */
    width: 100%;
}
   

    .add-to-cart-btn {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        opacity: 0; /* Hidden initially */
        transition: opacity 0.3s ease-in-out;
    }

    .product-image:hover .add-to-cart-btn {
        opacity: 1; /* Show on hover */
    }


</style>