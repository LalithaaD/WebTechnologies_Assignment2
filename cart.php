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
        http_response_code(405);
        echo json_encode(array('message' => 'Method not allowed.'));
        break;
}

function getCarts() {
    global $db;

    try {
        echo json_encode(array(
            array('id' => 1, 'user' => 1, 'products' => 'Product1:2,Product2:1', 'created_at' => '2024-03-10 12:00:00'),
            array('id' => 2, 'user' => 2, 'products' => 'Product3:3,Product4:2', 'created_at' => '2024-03-10 14:30:00')
        ));
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(array('message' => 'Error: ' . $e->getMessage()));
    }
}

function createCart($data) {
    global $db;

    try {
        $userID = $data['user'] ?? '';
        $products = $data['products'] ?? '';
        $quantities = $data['quantities'] ?? '';

        $sql = "INSERT INTO cart (User, Products, Quantities) VALUES ('$userID', '$products', '$quantities')";

        $result = $db->query($sql);

        if ($result) {
            http_response_code(201);
            echo json_encode(array('message' => 'Cart created successfully.'));
        } else {
            http_response_code(500);
            echo json_encode(array('message' => 'Error creating cart: ' . $db->error));
        }
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(array('message' => 'Error: ' . $e->getMessage()));
    }
}

function updateCart($data) {
    global $db;

    try {
        $id = $data['id'] ?? 0;
        $products = $data['products'] ?? '';
        $quantities = $data['quantities'] ?? '';

        $sql = "UPDATE cart SET Products='$products', Quantities='$quantities' WHERE id=$id";

        $debugOutput = array(
            'debug' => 'Start of updateCart function',
            'id' => $id,
            'products' => $products,
            'quantities' => $quantities
        );

        $debugOutput['sql'] = $sql;

        $result = $db->query($sql);

        if ($result) {
            http_response_code(200);
            echo json_encode(array_merge($debugOutput, array('message' => 'Cart updated successfully')));
        } else {
            http_response_code(500);
            echo json_encode(array_merge($debugOutput, array('message' => 'Error updating cart: ' . $db->error)));
        }
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(array('message' => 'Error: ' . $e->getMessage()));
    }
}

function deleteCart($id) {
    global $db;

    try {
        $sql = "DELETE FROM cart WHERE id=$id";

        $result = $db->query($sql);

        if ($result) {
            http_response_code(200);
            echo json_encode(array('message' => 'Cart deleted successfully.'));
        } else {
            http_response_code(500);
            echo json_encode(array('message' => 'Error deleting cart: ' . $db->error));
        }
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(array('message' => 'Error: ' . $e->getMessage()));
    }
}
?>
