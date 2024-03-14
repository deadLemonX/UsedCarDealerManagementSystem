<?php
function checkSession() {
    session_start(); // Start the session

    // Check if the session variable exists
    if(isset($_SESSION['username'])) {
        echo "good";
        return $_SESSION['username']; // Retrieve the username from session
    } else {
        // If the session variable isn't set, redirect to the login page
        echo "Error";
        header("Location: login.php");
        exit();
    }
}
?>
