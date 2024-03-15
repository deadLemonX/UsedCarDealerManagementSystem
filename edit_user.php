<body>
    <?php include 'includes/header.php'; ?>

    <div class="flex-container">
        <?php include 'includes/navbar/manage_users_navbar.php'; ?>
        <div>
            <?php 
                session_start();
                $username = $_SESSION['username'];
                $login_feedback = "Your are currently logged in as: ". $username;
                echo "<p class='login-feedback'>$login_feedback</p>";
            ?>
            <?php
                if (isset($_GET['user_id'])) {
                    $_SESSION['currentEditUserPKey'] = $_GET['user_id']; // Update session variable with the new user_id from GET
                }
                
                if (isset($_SESSION['currentEditUserPKey'])) {
                    $user_id = $_SESSION['currentEditUserPKey'];

                    require 'db_connect.php'; 

                    $sql = "SELECT * FROM `users` WHERE user_id = ?;";

                    $stmt = $conn->prepare($sql);

                    if (false === $stmt) {
                        echo "Error preparing statement: " . htmlspecialchars($conn->error);
                    } else {
                        $stmt->bind_param("i", $user_id);
                        
                        if ($stmt->execute()) {
                            
                            $result = $stmt->get_result();
                            if ($row = $result->fetch_assoc()) {
                                $results = $row;
                                
                                echo '<form method="post" action="" class="add-user-form">';
                                echo '<h2 class="form-head">Edit User</h2><br>';
                                echo '<label for="user_name">Username:</label> <input type="text" id="user_name" name="user_name" value="' . htmlspecialchars($results['user_name']) . '" required><br>';
                                echo '<label for="first_name">First Name:</label><input type="text" id="first_name" name="first_name" value="' . htmlspecialchars($results['first_name']) . '" required><br>';
                                echo '<label for="last_name">Last Name:</label><input type="text" id="last_name" name="last_name" value="' . htmlspecialchars($results['last_name']) . '" required><br>';
                                echo '<label for="email">Email:</label><input type="text" id="email" name="email" value="' . htmlspecialchars($results['email']) . '" required><br>';
                                echo '<label for="password">Password:  (8 - 12 characters)</label><input type="password" id="password" name="password" required><br>';
                                $checked = $results['is_admin'] ? 'checked' : '';
                                echo '<label for="is_admin">Is Admin:</label><input type="checkbox" id="is_admin" name="is_admin" value=1 ' . $checked . '><br>';
                                echo '<button type="submit" class="edit-user-button">Edit</button>';
                                echo '</form> ';
                            } else {
                                echo "No user found.";
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
                    echo "No user selected for editing.";
                    // Redirect back or show an error message
                }
            ?>

                <?php
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        // Collect user input
                        $user_name = $_POST['user_name'];
                        $first_name = $_POST['first_name'];
                        $last_name = $_POST['last_name'];
                        $email = $_POST['email'];
                        $password = $_POST['password']; // Consider hashing the password before storing
                        $is_admin = isset($_POST['is_admin']) ? 1 : 0; // Store as boolean (1 or 0)
                    
                        // Assuming you're using a session or a predetermined value for user_id
                        $user_id = $_SESSION['currentEditUserPKey']; // Or however you're obtaining the user_id

                        // SQL to update user data
                        $sql = "UPDATE users SET user_name = ?, first_name = ?, last_name = ?, email = ?, password = ?, is_admin = ? WHERE user_id = ?";

                        // Prepare statement
                        $stmt = $conn->prepare($sql);

                        if (false === $stmt) {
                            // Handle error in statement preparation
                            echo "Error preparing statement: " . htmlspecialchars($conn->error);
                            exit();
                        }

                        // Hash the password before storing
                        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                        // Bind parameters and execute
                        $stmt->bind_param("sssssii", $user_name, $first_name, $last_name, $email, $hashed_password, $is_admin, $user_id);

                        if ($stmt->execute()) {
                            header('Location: manage_users.php');
                            $stmt->close();
                            exit();
                            echo "User updated successfully.";
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