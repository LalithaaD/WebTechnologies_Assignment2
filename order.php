<?php
session_start();
include_once 'db.php';

header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        getOrders();
        break;

    case 'POST':
        $data = json_decode(file_get_contents("php://input"), true);
        createOrder($data);
        break;

    case 'PUT':
        $data = json_decode(file_get_contents("php://input"), true);
        updateOrder($data);
        break;

    case 'DELETE':
        $data = json_decode(file_get_contents("php://input"), true);
        deleteOrder($data['id']);
        break;

    default:
        http_response_code(405); // Method Not Allowed
        echo json_encode(array('message' => 'Method not allowed.'));
        break;
}

function getOrders() {
    global $db;

    try {
        echo json_encode(array(
            array('id' => 1, 'user_id' => 1, 'products' => 'Product1,Product2', 'created_at' => '2024-03-10 12:00:00'),
            array('id' => 2, 'user_id' => 2, 'products' => 'Product3,Product4', 'created_at' => '2024-03-10 14:30:00')
            
        ));
    } catch (Exception $e) {
        http_response_code(500); // Internal Server Error
        echo json_encode(array('message' => 'Error: ' . $e->getMessage()));
    }
}

function createOrder($data) {
    global $db;

    try {
        // Validate data (you may want to add more validation)
        $userID = $data['user_id'] ?? '';
        $products = $data['products'] ?? '';

        // SQL to insert a new order
        $sql = "INSERT INTO orders (User, Products) VALUES ('$userID', '$products')";

        // Execute the query
        $result = $db->query($sql);

        // Check if the query was successful
        if ($result) {
            http_response_code(201); // Created
            echo json_encode(array('message' => 'Order created successfully.'));
        } else {
            http_response_code(500); // Internal Server Error
            echo json_encode(array('message' => 'Error creating order: ' . $db->error));
        }
    } catch (Exception $e) {
        http_response_code(500); // Internal Server Error
        echo json_encode(array('message' => 'Error: ' . $e->getMessage()));
    }
}

function updateOrder($data) {
    global $db;

    try {
        // Validate data 
        $id = $data['id'] ?? 0;
        $userID = $data['user_id'] ?? '';
        $products = $data['products'] ?? '';

        // SQL to update an order
        $sql = "UPDATE orders 
                SET User='$userID', Products='$products'
                WHERE id=$id";

        // Execute the query
        $result = $db->query($sql);

        // Check if the query was successful
        if ($result) {
            echo json_encode(array('message' => 'Order updated successfully.'));
        } else {
            http_response_code(500); // Internal Server Error
            echo json_encode(array('message' => 'Error updating order: ' . $db->error));
        }
    } catch (Exception $e) {
        http_response_code(500); // Internal Server Error
        echo json_encode(array('message' => 'Error: ' . $e->getMessage()));
    }
}

function deleteOrder($id) {
    global $db;

    try {
        // SQL to delete an order
        $sql = "DELETE FROM orders WHERE id=$id";

        // Execute the query
        $result = $db->query($sql);

        // Check if the query was successful
        if ($result) {
            echo json_encode(array('message' => 'Order deleted successfully.'));
        } else {
            http_response_code(500); // Internal Server Error
            echo json_encode(array('message' => 'Error deleting order: ' . $db->error));
        }
    } catch (Exception $e) {
        http_response_code(500); // Internal Server Error
        echo json_encode(array('message' => 'Error: ' . $e->getMessage()));
    }
}
?>
