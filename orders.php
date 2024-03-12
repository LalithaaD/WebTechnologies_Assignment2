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
        http_response_code(405);
        echo json_encode(array('message' => 'Method not allowed.'));
        break;
}

function getOrders() {
    global $db;

    try {
        $sql = "SELECT id, user_id, products FROM `orders`";
        $result = $db->query($sql);

        if ($result) {
            $orderData = $result->fetch_all(MYSQLI_ASSOC);
            header('Content-Type: application/json');
            echo json_encode($orderData);
        } else {
            http_response_code(500);
            echo json_encode(array('message' => 'Error fetching orders: ' . $db->error));
        }
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(array('message' => 'Error: ' . $e->getMessage()));
    }
}

function createOrder($data) {
    global $db;

    try {
        $userID = $data['user_id'] ?? '';
        $products = $data['products'] ?? '';

        $sql = "INSERT INTO `orders` (user_id, products) VALUES ('$userID', '$products')";

        $result = $db->query($sql);

        if ($result) {
            http_response_code(201);
            echo json_encode(array('message' => 'Order created successfully.'));
        } else {
            http_response_code(500);
            echo json_encode(array('message' => 'Error creating order: ' . $db->error));
        }
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(array('message' => 'Error: ' . $e->getMessage()));
    }
}

function updateOrder($data) {
    global $db;

    try {
        $id = $data['id'] ?? 0;
        $userID = $data['user_id'] ?? '';
        $products = $data['products'] ?? '';

        $sql = "UPDATE `orders`
                SET user_id='$userID', products='$products'
                WHERE id='$id'";

        error_log("SQL Query: $sql");

        $result = $db->query($sql);

        if ($result) {
            echo json_encode(array('message' => 'Order updated successfully.'));
        } else {
            error_log("Database Error: " . $db->error);

            http_response_code(500);
            echo json_encode(array('message' => 'Error updating order.'));
        }
    } catch (Exception $e) {
        error_log("Exception: " . $e->getMessage());

        http_response_code(500);
        echo json_encode(array('message' => 'Error updating order.'));
    }
}

function deleteOrder($id) {
    global $db;

    try {
        $sql = "DELETE FROM `orders` WHERE id='$id'";

        $result = $db->query($sql);

        if ($result) {
            echo json_encode(array('message' => 'Order deleted successfully.'));
        } else {
            http_response_code(500);
            echo json_encode(array('message' => 'Error deleting order: ' . $db->error));
        }
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(array('message' => 'Error: ' . $e->getMessage()));
    }
}
?>
