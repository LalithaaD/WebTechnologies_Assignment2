<?php
session_start();
include_once 'db.php';

header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        getUser();
        break;

    case 'POST':
        $data = json_decode(file_get_contents("php://input"), true);
        createUser($data);
        break;

    case 'PUT':
        $data = json_decode(file_get_contents("php://input"), true);
        updateUser($data);
        break;

    case 'DELETE':
        $data = json_decode(file_get_contents("php://input"), true);
        deleteUser($data['id']);
        break;

    default:
        http_response_code(405); // Method Not Allowed
        echo json_encode(array('message' => 'Method not allowed.'));
        break;
}

function getUser() {
    global $db;

    try {
        echo json_encode(array(
            'id' => 1,
            'email' => 'example@example.com',
            'username' => 'example_user'
          
        ));
    } catch (Exception $e) {
        http_response_code(500); // Internal Server Error
        echo json_encode(array('message' => 'Error: ' . $e->getMessage()));
    }
}

function createUser($data) {
    global $db;

    try {
        // Validate data 
        $email = $data['email'] ?? '';
        $password = $data['password'] ?? '';
        $username = $data['username'] ?? '';

        // SQL to insert a new user
        $sql = "INSERT INTO user (Email, Password, Username) VALUES ('$email', '$password', '$username')";

        // Execute the query
        $result = $db->query($sql);

        // Check if the query was successful
        if ($result) {
            http_response_code(201); // Created
            echo json_encode(array('message' => 'User created successfully.'));
        } else {
            http_response_code(500); // Internal Server Error
            echo json_encode(array('message' => 'Error creating user: ' . $db->error));
        }
    } catch (Exception $e) {
        http_response_code(500); // Internal Server Error
        echo json_encode(array('message' => 'Error: ' . $e->getMessage()));
    }
}

function updateUser($data) {
    global $db;

    try {
        // Validate data 
        $id = $data['id'] ?? 0;
        $email = $data['email'] ?? '';
        $password = $data['password'] ?? '';
        $username = $data['username'] ?? '';

        // SQL to update a user
        $sql = "UPDATE user SET Email='$email', Password='$password', Username='$username' WHERE id=$id";

        // Execute the query
        $result = $db->query($sql);

        // Check if the query was successful
        if ($result) {
            echo json_encode(array('message' => 'User updated successfully.'));
        } else {
            http_response_code(500); // Internal Server Error
            echo json_encode(array('message' => 'Error updating user: ' . $db->error));
        }
    } catch (Exception $e) {
        http_response_code(500); // Internal Server Error
        echo json_encode(array('message' => 'Error: ' . $e->getMessage()));
    }
}

function deleteUser($id) {
    global $db;

    try {
        // SQL to delete a user
        $sql = "DELETE FROM user WHERE id=$id";

        // Execute the query
        $result = $db->query($sql);

        // Check if the query was successful
        if ($result) {
            echo json_encode(array('message' => 'User deleted successfully.'));
        } else {
            http_response_code(500); // Internal Server Error
            echo json_encode(array('message' => 'Error deleting user: ' . $db->error));
        }
    } catch (Exception $e) {
        http_response_code(500); // Internal Server Error
        echo json_encode(array('message' => 'Error: ' . $e->getMessage()));
    }
}
?>
