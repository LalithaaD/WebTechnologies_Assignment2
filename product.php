<?php
session_start();
include_once 'db.php';

// Set the response content type to JSON
header('Content-Type: application/json');

// Check the request method
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        // Fetch all products
        getProducts();
        break;

    case 'POST':
        // Create a new product
        $data = json_decode(file_get_contents("php://input"), true);
        createProduct($data);
        break;

    case 'PUT':
        // Update a product
        $data = json_decode(file_get_contents("php://input"), true);
        updateProduct($data);
        break;

    case 'DELETE':
        // Delete a product
        $data = json_decode(file_get_contents("php://input"), true);
        deleteProduct($data['id']);
        break;

    default:
        http_response_code(405); // Method Not Allowed
        echo json_encode(array('message' => 'Method not allowed.'));
        break;
}

// Fetch all products
function getProducts() {
    global $db;

    try {
        // SQL to fetch products
        $sql = "SELECT * FROM product";

        // Query
        $result = $db->query($sql);

        // Check the query
        if ($result) {
            // Initialize an array to store products
            $products = array();

            // Fetch each row from the result set
            while ($row = $result->fetch_assoc()) {
                // Add the row to the products array
                $products[] = $row;
            }

            // Return products as JSON
            header('Content-Type: application/json'); // Set Content-Type
            echo json_encode($products);
        } else {
            // If the query fails, output an error message
            http_response_code(500); // Internal Server Error
            echo json_encode(array('message' => 'Error fetching products: ' . $db->error));
        }
    } catch (Exception $e) {
        // Handle any errors that occur during database interaction
        http_response_code(500); // Internal Server Error
        echo json_encode(array('message' => 'Error: ' . $e->getMessage()));
    }
}

// Create a new product
function createProduct($data) {
    global $db;

    try {
        // Validate data (you may want to add more validation)
        $description = $data['description'] ?? '';
        $image = $data['image'] ?? '';
        $pricing = $data['pricing'] ?? 0;
        $shippingCost = $data['ShippingCost'] ?? 0; // Update to match the actual column name

        // SQL to insert a new product
        $sql = "INSERT INTO product (Description, Image, Pricing, ShippingCost) 
                VALUES ('$description', '$image', $pricing, $shippingCost)";

        // Execute the query
        $result = $db->query($sql);

        // Check if the query was successful
        if ($result) {
            http_response_code(201); // Created
            echo json_encode(array('message' => 'Product created successfully.'));
        } else {
            http_response_code(500); // Internal Server Error
            echo json_encode(array('message' => 'Error creating product: ' . $db->error));
        }
    } catch (Exception $e) {
        echo json_encode(array('message' => 'Error: ' . $e->getMessage()));
    }
}

// Update a product
function updateProduct($data) {
    global $db;

    try {
        // Validate data (you may want to add more validation)
        $id = $data['id'] ?? 0;
        $description = $data['description'] ?? '';
        $image = $data['image'] ?? '';
        $pricing = $data['pricing'] ?? 0;
        $shippingCost = $data['ShippingCost'] ?? 0; // Update to match the actual column name

        // SQL to update a product
        $sql = "UPDATE product 
                SET Description='$description', Image='$image', Pricing=$pricing, ShippingCost=$shippingCost 
                WHERE id=$id";

        // Execute the query
        $result = $db->query($sql);

        // Check if the query was successful
        if ($result) {
            echo json_encode(array('message' => 'Product updated successfully.'));
        } else {
            http_response_code(500); // Internal Server Error
            echo json_encode(array('message' => 'Error updating product: ' . $db->error));
        }
    } catch (Exception $e) {
        echo json_encode(array('message' => 'Error: ' . $e->getMessage()));
    }
}

// Delete a product
function deleteProduct($id) {
    global $db;

    try {
        // SQL to delete a product
        $sql = "DELETE FROM product WHERE id=$id";

        // Execute the query
        $result = $db->query($sql);

        // Check if the query was successful
        if ($result) {
            echo json_encode(array('message' => 'Product deleted successfully.'));
        } else {
            http_response_code(500); // Internal Server Error
            echo json_encode(array('message' => 'Error deleting product: ' . $db->error));
        }
    } catch (Exception $e) {
        echo json_encode(array('message' => 'Error: ' . $e->getMessage()));
    }
}
?>
