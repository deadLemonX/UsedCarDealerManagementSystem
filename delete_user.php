<?php
    session_start();

    // Example security check: make sure the user is logged in
    // and has the right to delete users. Adjust according to your application's logic.
    if (!isset($_SESSION['logged_in']) || $_SESSION['is_admin'] !== 1) {
        echo "You do not have permission to perform this action.";
        exit;
    }

    // Check if a user_id is provided
    if (isset($_GET['user_id'])) {
        $user_id = $_GET['user_id'];

        // Include your DB connection script
        require 'db_connect.php';

        // Validate and sanitize the user_id
        $user_id = filter_var($user_id, FILTER_SANITIZE_NUMBER_INT);

        // Prepare the SQL statement
        $stmt = $conn->prepare("DELETE FROM users WHERE user_id = ?");

        if (false === $stmt) {
            // Handle error in statement preparation
            echo "Error preparing statement: " . htmlspecialchars($conn->error);
            exit;
        }

        // Bind parameters and execute
        $stmt->bind_param("i", $user_id);

        if ($stmt->execute()) {
            echo "User deleted successfully.";

            // Optionally, redirect to another page after successful deletion
            header('Location: manage_users.php');
            exit;
        } else {
            // Handle error in statement execution
            echo "Error executing statement: " . htmlspecialchars($stmt->error);
        }

        // Close statement and connection
        $stmt->close();
        $conn->close();
    } else {
        echo "No user selected for deletion.";
        // Redirect or display an error message
    }

?>
