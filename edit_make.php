<body>
    <?php include 'includes/header.php'; ?>

    <div class="flex-container">
    <?php include 'includes/navbar/vehicle_makes_navbar.php'; ?>
        <div>
            <?php 
                session_start();
                $username = $_SESSION['username'];
                $login_feedback = "Your are currently logged in as: ". $username;
                echo "<p class='login-feedback'>$login_feedback</p>";
            ?>
            <?php
                if (isset($_GET['make_id'])) {
                    $_SESSION['currentEditMakePKey'] = $_GET['make_id']; // Update session variable with the new user_id from GET
                }
                
                if (isset($_SESSION['currentEditMakePKey'])) {
                    $id = $_SESSION['currentEditMakePKey'];
                    
                    require 'db_connect.php'; 

                    $sql = "SELECT * FROM `makes` WHERE id = ?;";

                    $stmt = $conn->prepare($sql);

                    if (false === $stmt) {
                        echo "Error preparing statement: " . htmlspecialchars($conn->error);
                    } else {
                        $stmt->bind_param("i", $id);
                        
                        if ($stmt->execute()) {
                            
                            $result = $stmt->get_result();
                            if ($row = $result->fetch_assoc()) {
                                $results = $row;
                                
                                echo '<form method="POST" action="" class="edit-make-form">';
                                echo '<h2 class="form-head">Edit User</h2><br>';
                                echo '<label for="name">Make Name:</label> <input type="text" id="name" name="name" value="' . htmlspecialchars($results['name']) . '" required><br>';
                                echo '<button type="submit" class="edit-make-button">Edit</button>';
                                echo '</form> ';
                            } else {
                                echo "No makes found.";
                            }
                            // Free result set
                            $result->free();
                        } else {
                            // Handle errors related to statement execution
                            echo "Error executing statement: " . htmlspecialchars($conn->error);
                        }
                        // Close statement
                        $stmt->close();
                    }
                    // Optionally, close the database connection here if it's no longer needed
                    //$conn->close();
                } else {
                    echo "No make selected for editing.";
                    // Redirect back or show an error message
                }
            ?>

            <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    // Collect user input
                    $name = $_POST['name'];

                    $id = $_SESSION['currentEditMakePKey']; 
                    
                    // SQL to update user data
                    $sql = "UPDATE makes SET name = ? WHERE id = ?";
                    
                    // Prepare statement
                    $stmt = $conn->prepare($sql);

                    if (false === $stmt) {
                        // Handle error in statement preparation
                        echo "Error preparing statement: " . $conn->error;
                        exit();
                    }

                    // Bind parameters and execute
                    $stmt->bind_param("si", $name,  $id);
                    
                    if ($stmt->execute()) {
                        header('Location: vehicle_makes.php');
                        echo "Make updated successfully."; // kinds pointless 
                        $stmt->close();
                        exit();
                    } else {
                        // Handle error in statement execution
                        echo "Error executing statement: " . htmlspecialchars($stmt->error);
                    }

                    // Close statement
                    $stmt->close();
                }
            ?>

        </div>
    </div>
    <?php include 'includes/footer.php'; ?>

    <!-- Add your JavaScript file link here -->
    <script src="script.js"></script>
</body>
</html>