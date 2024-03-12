<?php
session_start();
include_once 'db.php';

header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        getProducts();
        break;

    case 'POST':
        $data = json_decode(file_get_contents("php://input"), true);
        createProduct($data);
        break;

    case 'PUT':
        $data = json_decode(file_get_contents("php://input"), true);
        updateProduct($data);
        break;

    case 'DELETE':
        $data = json_decode(file_get_contents("php://input"), true);
        deleteProduct($data['id']);
        break;

    default:
        http_response_code(405);
        echo json_encode(array('message' => 'Method not allowed.'));
        break;
}

function getProducts() {
    global $db;

    try {
         $sql = "SELECT * FROM product";

         $result = $db->query($sql);

        if ($result) {
            $products = array();

            while ($row = $result->fetch_assoc()) {
                $products[] = $row;
            }

            header('Content-Type: application/json');
            echo json_encode($products);
        } else {
            http_response_code(500);
            echo json_encode(array('message' => 'Error fetching products: ' . $db->error));
        }
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(array('message' => 'Error: ' . $e->getMessage()));
    }
}

function createProduct($data) {
    global $db;

    try {
        $description = $data['description'] ?? '';
        $image = $data['image'] ?? '';
        $pricing = $data['pricing'] ?? 0;
        $shippingCost = $data['ShippingCost'] ?? 0;

        $sql = "INSERT INTO product (Description, Image, Pricing, ShippingCost) 
                VALUES ('$description', '$image', $pricing, $shippingCost)";

        $result = $db->query($sql);

        if ($result) {
            http_response_code(201);
            echo json_encode(array('message' => 'Product created successfully.', 'code' => 201));
        } else {
            http_response_code(500);
            echo json_encode(array('message' => 'Error creating product: ' . $db->error, 'code' => 500));
        }
    } catch (Exception $e) {
        echo json_encode(array('message' => 'Error: ' . $e->getMessage(), 'code' => 500));
    }
}

function updateProduct($data) {
    global $db;

    try {
        $id = $data['id'] ?? 0;
        $description = $data['description'] ?? '';
        $image = $data['image'] ?? '';
        $pricing = $data['pricing'] ?? 0;
        $shippingCost = $data['ShippingCost'] ?? 0;

        $sql = "UPDATE product 
                SET Description='$description', Image='$image', Pricing=$pricing, ShippingCost=$shippingCost 
                WHERE ProductID=$id";

        $result = $db->query($sql);

        if ($result) {
            http_response_code(200);
            echo json_encode(array('message' => 'Product updated successfully', 'code' => 200));
        } else {
            http_response_code(500);
            echo json_encode(array('message' => 'Error updating product: ' . $db->error, 'code' => 500));
        }
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(array('message' => 'Error: ' . $e->getMessage(), 'code' => 500));
    }
}

function deleteProduct($id) {
    global $db;

    try {
        $sql = "DELETE FROM product WHERE id=$id";

        $result = $db->query($sql);

        if ($result) {
            echo json_encode(array('message' => 'Product deleted successfully.'));
        } else {
            http_response_code(500);
            echo json_encode(array('message' => 'Error deleting product: ' . $db->error));
        }
    } catch (Exception $e) {
        echo json_encode(array('message' => 'Error: ' . $e->getMessage()));
    }
}
?>
