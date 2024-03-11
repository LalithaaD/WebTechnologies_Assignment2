<?php
session_start();
include_once 'db.php';

header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        getCarts();
        break;

    case 'POST':
        $data = json_decode(file_get_contents("php://input"), true);
        createCart($data);
        break;

    case 'PUT':
        $data = json_decode(file_get_contents("php://input"), true);
        updateCart($data);
        break;

    case 'DELETE':
        $data = json_decode(file_get_contents("php://input"), true);
        deleteCart($data['id']);
        break;

    default:
        http_response_code(405); // Method Not Allowed
        echo json_encode(array('message' => 'Method not allowed.'));
        break;
}

function getCarts() {
    global $db;

    try {
        echo json_encode(array(
            array('id' => 1, 'user_id' => 1, 'products' => 'Product1:2,Product2:1', 'created_at' => '2024-03-10 12:00:00'),
            array('id' => 2, 'user_id' => 2, 'products' => 'Product3:3,Product4:2', 'created_at' => '2024-03-10 14:30:00')
            // Add more carts based on your schema
        ));
    } catch (Exception $e) {
        http_response_code(500); // Internal Server Error
        echo json_encode(array('message' => 'Error: ' . $e->getMessage()));
    }
}

function createCart($data) {
    global $db;

    try {
        // Validate data
        $userID = $data['user_id'] ?? '';
        $products = $data['products'] ?? '';

        // SQL to insert a new cart
        $sql = "INSERT INTO cart (User, Products) VALUES ('$userID', '$products')";

        // Execute the query
        $result = $db->query($sql);

        // Check if the query was successful
        if ($result) {
            http_response_code(201); // Created
            echo json_encode(array('message' => 'Cart created successfully.'));
        } else {
            http_response_code(500); // Internal Server Error
            echo json_encode(array('message' => 'Error creating cart: ' . $db->error));
        }
    } catch (Exception $e) {
        http_response_code(500); // Internal Server Error
        echo json_encode(array('message' => 'Error: ' . $e->getMessage()));
    }
}

function updateCart($data) {
    global $db;

    try {
        // Validate data 
        $id = $data['id'] ?? 0;
        $userID = $data['user_id'] ?? '';
        $products = $data['products'] ?? '';

        // SQL to update a cart
        $sql = "UPDATE cart 
                SET User='$userID', Products='$products'
                WHERE id=$id";

        // Execute the query
        $result = $db->query($sql);

        // Check if the query was successful
        if ($result) {
            echo json_encode(array('message' => 'Cart updated successfully.'));
        } else {
            http_response_code(500); // Internal Server Error
            echo json_encode(array('message' => 'Error updating cart: ' . $db->error));
        }
    } catch (Exception $e) {
        http_response_code(500); // Internal Server Error
        echo json_encode(array('message' => 'Error: ' . $e->getMessage()));
    }
}

function deleteCart($id) {
    global $db;

    try {
        // SQL to delete a cart
        $sql = "DELETE FROM cart WHERE id=$id";

        // Execute the query
        $result = $db->query($sql);

        // Check if the query was successful
        if ($result) {
            echo json_encode(array('message' => 'Cart deleted successfully.'));
        } else {
            http_response_code(500); // Internal Server Error
            echo json_encode(array('message' => 'Error deleting cart: ' . $db->error));
        }
    } catch (Exception $e) {
        http_response_code(500); // Internal Server Error
        echo json_encode(array('message' => 'Error: ' . $e->getMessage()));
    }
}
?>
