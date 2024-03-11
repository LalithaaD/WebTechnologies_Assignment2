<?php
session_start();
include_once 'db.php';

// fetch all products
function getProducts() {
    global $db; 

    try {
        // sql to fetch products
        $sql = "SELECT * FROM product";
        
        // query
        $result = $db->query($sql);

        // check  the query 
        if ($result) {
            // Initialize an array to store products
            $products = array();

            // Fetch each row from the result set
            while ($row = $result->fetch_assoc()) {
                // Add the row to the products array
                $products[] = $row;
            }

            // Return products as JSON
            echo json_encode($products);
        } else {
            // If the query fails, output an error message
            echo "Error: " . $db->error;
        }
    } catch(Exception $e) {
        // Handle any errors that occur during database interaction
    }
}