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
        deleteUser($data['user_id']);
        break;

    default:
        http_response_code(405);
        echo json_encode(array('message' => 'Method not allowed.'));
        break;
}

function getUser() {
    global $db;

    try {
        $sql = "SELECT * FROM user";
        $result = $db->query($sql);

        if ($result) {
            $userData = $result->fetch_all(MYSQLI_ASSOC);
            echo json_encode($userData);
        } else {
            http_response_code(500);
            echo json_encode(array('message' => 'Error fetching users: ' . $db->error));
        }
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(array('message' => 'Error: ' . $e->getMessage()));
    }
}

function createUser($data) {
    global $db;

    try {
        $email = $data['email'] ?? '';
        $password = $data['password'] ?? '';
        $username = $data['username'] ?? '';

        $sql = "INSERT INTO user (Email, Password, Username) VALUES ('$email', '$password', '$username')";

        $result = $db->query($sql);

        if ($result) {
            http_response_code(201);
            echo json_encode(array('message' => 'User created successfully.'));
        } else {
            http_response_code(500);
            echo json_encode(array('message' => 'Error creating user: ' . $db->error));
        }
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(array('message' => 'Error: ' . $e->getMessage()));
    }
}

function updateUser($data) {
    global $db;

    try {
        $user_id = $data['user_id'] ?? 0;
        $email = $data['email'] ?? '';
        $password = $data['password'] ?? '';
        $username = $data['username'] ?? '';

        $sql = "UPDATE user SET Email='$email', Password='$password', Username='$username' WHERE user_id=$user_id";

        $result = $db->query($sql);

        if ($result) {
            echo json_encode(array('message' => 'User updated successfully.'));
        } else {
            http_response_code(500);
            echo json_encode(array('message' => 'Error updating user: ' . $db->error));
        }
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(array('message' => 'Error: ' . $e->getMessage()));
    }
}

function deleteUser($user_id) {
    global $db;

    try {
        $sql = "DELETE FROM user WHERE user_id=$user_id";

        $result = $db->query($sql);

        if ($result) {
            echo json_encode(array('message' => 'User deleted successfully.'));
        } else {
            http_response_code(500);
            echo json_encode(array('message' => 'Error deleting user: ' . $db->error));
        }
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(array('message' => 'Error: ' . $e->getMessage()));
    }
}
?>
