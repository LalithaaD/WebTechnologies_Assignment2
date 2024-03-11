<?php
session_start();
include_once 'db.php';

header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        getComments();
        break;

    case 'POST':
        $data = json_decode(file_get_contents("php://input"), true);
        createComment($data);
        break;

    case 'PUT':
        $data = json_decode(file_get_contents("php://input"), true);
        updateComment($data);
        break;

    case 'DELETE':
        $data = json_decode(file_get_contents("php://input"), true);
        deleteComment($data['id']);
        break;

    default:
        http_response_code(405); // Method Not Allowed
        echo json_encode(array('message' => 'Method not allowed.'));
        break;
}

function getComments() {
    global $db;

    try {
        echo json_encode(array(
            array('id' => 1, 'product_id' => 1, 'user_id' => 1, 'rating' => 5, 'text' => 'Great product!'),
            array('id' => 2, 'product_id' => 1, 'user_id' => 2, 'rating' => 4, 'text' => 'Nice quality!')
        ));
    } catch (Exception $e) {
        http_response_code(500); // Internal Server Error
        echo json_encode(array('message' => 'Error: ' . $e->getMessage()));
    }
}

function createComment($data) {
    global $db;

    try {
        // Validate data 
        $productID = $data['product_id'] ?? '';
        $userID = $data['user_id'] ?? '';
        $rating = $data['rating'] ?? '';
        $text = $data['text'] ?? '';

        // SQL to insert a new comment
        $sql = "INSERT INTO comments (Product, User, Rating, Text) VALUES ('$productID', '$userID', '$rating', '$text')";

        // Execute the query
        $result = $db->query($sql);

        // Check if the query was successful
        if ($result) {
            http_response_code(201); // Created
            echo json_encode(array('message' => 'Comment created successfully.'));
        } else {
            http_response_code(500); // Internal Server Error
            echo json_encode(array('message' => 'Error creating comment: ' . $db->error));
        }
    } catch (Exception $e) {
        http_response_code(500); // Internal Server Error
        echo json_encode(array('message' => 'Error: ' . $e->getMessage()));
    }
}

function updateComment($data) {
    global $db;

    try {
        // Validate data 
        $id = $data['id'] ?? 0;
        $productID = $data['product_id'] ?? '';
        $userID = $data['user_id'] ?? '';
        $rating = $data['rating'] ?? '';
        $text = $data['text'] ?? '';

        // SQL to update a comment
        $sql = "UPDATE comments 
                SET Product='$productID', User='$userID', Rating='$rating', Text='$text'
                WHERE id=$id";

        // Execute the query
        $result = $db->query($sql);

        // Check if the query was successful
        if ($result) {
            echo json_encode(array('message' => 'Comment updated successfully.'));
        } else {
            http_response_code(500); // Internal Server Error
            echo json_encode(array('message' => 'Error updating comment: ' . $db->error));
        }
    } catch (Exception $e) {
        http_response_code(500); // Internal Server Error
        echo json_encode(array('message' => 'Error: ' . $e->getMessage()));
    }
}

function deleteComment($id) {
    global $db;

    try {
        // SQL to delete a comment
        $sql = "DELETE FROM comments WHERE id=$id";

        // Execute the query
        $result = $db->query($sql);

        // Check if the query was successful
        if ($result) {
            echo json_encode(array('message' => 'Comment deleted successfully.'));
        } else {
            http_response_code(500); // Internal Server Error
            echo json_encode(array('message' => 'Error deleting comment: ' . $db->error));
        }
    } catch (Exception $e) {
        http_response_code(500); // Internal Server Error
        echo json_encode(array('message' => 'Error: ' . $e->getMessage()));
    }
}
?>
