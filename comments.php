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
        http_response_code(405); 
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
        http_response_code(500);
        echo json_encode(array('message' => 'Error: ' . $e->getMessage()));
    }
}

function createComment($data) {
    global $db;

    try {
        $productID = $data['product_id'] ?? '';
        $userID = $data['user_id'] ?? '';
        $rating = $data['rating'] ?? '';
        $text = $data['text'] ?? '';

        $sql = "INSERT INTO comments (Product, User, Rating, Text) VALUES ('$productID', '$userID', '$rating', '$text')";

        $result = $db->query($sql);

        if ($result) {
            http_response_code(201); 
            echo json_encode(array('message' => 'Comment created successfully.'));
        } else {
            http_response_code(500); 
            echo json_encode(array('message' => 'Error creating comment: ' . $db->error));
        }
    } catch (Exception $e) {
        http_response_code(500); 
        echo json_encode(array('message' => 'Error: ' . $e->getMessage()));
    }
}

function updateComment($data) {
    global $db;

    try {
        $id = $data['id'] ?? 0;
        $commentText = $data['comment_text'] ?? '';

        $sql = "UPDATE `comments`
                SET comment_text='$commentText'
                WHERE id='$id'";

        error_log("SQL Query: $sql");

        $result = $db->query($sql);

        if ($result) {
            echo json_encode(array('message' => 'Comment updated successfully.'));
        } else {
            error_log("Database Error: " . $db->error);

            http_response_code(500); 
            echo json_encode(array('message' => 'Error updating comment.'));
        }
    } catch (Exception $e) {
        error_log("Exception: " . $e->getMessage());

        http_response_code(500); 
        echo json_encode(array('message' => 'Error updating comment.'));
    }
}

function deleteComment($id) {
    global $db;

    try {
        if (!commentExists($id)) {
            http_response_code(404);
            echo json_encode(array('message' => 'Comment not found.'));
            return;
        }

        $sql = "DELETE FROM comments WHERE id=$id";

        $result = $db->query($sql);

        if ($result) {
            echo json_encode(array('message' => 'Comment deleted successfully.'));
        } else {
            http_response_code(500); 
            echo json_encode(array('message' => 'Error deleting comment: ' . $db->error));
        }
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(array('message' => 'Error: ' . $e->getMessage()));
    }
}

function commentExists($id) {
    global $db;

    $sql = "SELECT COUNT(*) FROM comments WHERE id=$id";

    $result = $db->query($sql);

    return $result && $result->fetch_row()[0] > 0;
}
?>
