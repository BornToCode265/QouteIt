<?php
require_once '../common/config.php';

class ShopAPI {
    private $pdo;

    public function __construct() {
        $db = new Database();
        $this->pdo = $db->getConnection();
    }

    // Register a new shop owner
    public function registerShopOwner($name, $email, $password, $district, $area) {
        try {
            $role = "owner";

            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $stmt = $this->pdo->prepare("INSERT INTO user_address (address_id, )")

            $stmt = $this->pdo->prepare("INSERT INTO users (name, email, password, role,address_id) VALUES (?,?, ?, ?,?,?)");
            $stmt->execute([$name, $email, $hashedPassword, ]);
            return ['status' => 'success', 'message' => 'Shop owner registered successfully'];
        } catch (Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }



 // Fetch all shop owners
    public function getAllShopOwners() {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM users WHERE role='owner'");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

       // Fetch all products
    public function getAllProducts() {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM products");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }



    // Fetch products by shop owner
    public function getProductsByShopOwner($shopOwnerId) {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM products WHERE shop_owner_id = ?");
            $stmt->execute([$shopOwnerId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }
    // Register a new product for a shop owner
    public function registerProduct($shopOwnerId, $name, $description, $price, $quantity, $photo) {
        try {
            $stmt = $this->pdo->prepare("INSERT INTO products (shop_owner_id, name, description, price, quantity, photo) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$shopOwnerId, $name, $description, $price, $quantity, $photo]);
            return ['status' => 'success', 'message' => 'Product registered successfully'];
        } catch (Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    // Update an existing product
    public function updateProduct($productId, $name, $description, $price, $quantity, $photo) {
        try {
            $stmt = $this->pdo->prepare("UPDATE products SET name = ?, description = ?, price = ?, quantity = ?, photo = ? WHERE product_id = ?");
            $stmt->execute([$name, $description, $price, $quantity, $photo, $productId]);
            return ['status' => 'success', 'message' => 'Product updated successfully'];
        } catch (Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }
}

