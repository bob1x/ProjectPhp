<?php

class Cart
{
    private $cartItems;

    public function __construct()
    {
        // Start or resume the session

        // Initialize the cart items as an empty array if not set
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = array();
        }

        // Assign the session cart items to the class property
        $this->cartItems = $_SESSION['cart'];
    }

    public function addToCart($product_id)
    {
        // Check if the product is not already in the cart, add it
        if (!in_array($product_id, $this->cartItems)) {
            $this->cartItems[] = $product_id;
            $_SESSION['cart'] = $this->cartItems; // Update the session variable
            return true; // Product added to the cart
        }

        return false; // Product is already in the cart
    }

    // Add a product with details to the cart
    public function addProductToCart($product_id, $product_name, $unit_price, $quantity)
    {
        // Create an associative array with product details
        $productDetails = array(
            'id' => $product_id,
            'name' => $product_name,
            'price' => $unit_price,
            'quantity' => $quantity
        );

        // Check if the product is not already in the cart, add it
        if (!in_array($productDetails, $this->cartItems)) {
            $this->cartItems[] = $productDetails;
            $_SESSION['cart'] = $this->cartItems; // Update the session variable
            return true; // Product added to the cart
        }

        return false; // Product is already in the cart
    }

    // Get the current cart items
    public function getCartItems()
    {
        return $this->cartItems;
    }

    // Clear the cart
    public function clearCart()
    {
        $_SESSION['cart'] = array(); // Clear the session cart
        $this->cartItems = array(); // Clear the class property
    }

}


?>
