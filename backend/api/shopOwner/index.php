<?php
require_once 'shopOwner.php';

// Headers for JSON response
header("Content-Type: application/json");

// Parse the HTTP request method
$method = $_SERVER['REQUEST_METHOD'];
$action = isset($_GET['action']) ? $_GET['action'] : null;

// Create an instance of the ShopAPI class
$shopAPI = new ShopAPI();

// Handle API requests
switch ($method) {
    case 'POST':
        switch ($action) {
            case 'register_shop_owner':
                $data = json_decode(file_get_contents('php://input'), true);
                if (isset($data['name'], $data['email'], $data['password'])) {
                    $response = $shopAPI->registerShopOwner($data['name'], $data['email'], $data['password']);
                } else {
                    $response = ['status' => 'error', 'message' => 'Invalid input'];
                }
                echo json_encode($response);
                break;

            case 'register_product':
                $data = json_decode(file_get_contents('php://input'), true);
                if (isset($data['shop_owner_id'], $data['name'], $data['description'], $data['price'], $data['quantity'], $data['photo'])) {
                    $response = $shopAPI->registerProduct(
                        $data['shop_owner_id'],
                        $data['name'],
                        $data['description'],
                        $data['price'],
                        $data['quantity'],
                        $data['photo']
                    );
                } else {
                    $response = ['status' => 'error', 'message' => 'Invalid input'];
                }
                echo json_encode($response);
                break;
            case 'get_all_products':
                    
                        $response = $shopAPI->getAllProducts();
                   
            

            case 'update_product':
                $data = json_decode(file_get_contents('php://input'), true);
                if (isset($data['product_id'], $data['name'], $data['description'], $data['price'], $data['quantity'], $data['photo'])) {
                    $response = $shopAPI->updateProduct(
                        $data['product_id'],
                        $data['name'],
                        $data['description'],
                        $data['price'],
                        $data['quantity'],
                        $data['photo']
                    );
                } else {
                    $response = ['status' => 'error', 'message' => 'Invalid input'];
                }
                echo json_encode($response);
                break;

            default:
                echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
        }
        break;

    case 'GET':
        switch ($action) {
            case 'get_all_shop_owners':
                echo json_encode($shopAPI->getAllShopOwners());
                break;

            case 'get_all_products':
                echo json_encode($shopAPI->getAllProducts());
                break;

            case 'get_products_by_shop_owner':
                if (isset($_GET['shop_owner_id'])) {
                    $shopOwnerId = intval($_GET['shop_owner_id']);
                    echo json_encode($shopAPI->getProductsByShopOwner($shopOwnerId));
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Shop owner ID is required']);
                }
                break;

            default:
                echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
        }
        break;
    default:
        echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
