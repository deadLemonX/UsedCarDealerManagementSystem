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
            
            <form method="POST" action="" class="add-user-form">
                <h2 class="form-head">Add User</h2><br>
                <label for="user_name">Username:</label><input type="text" id="user_name" name="user_name" required><br>
                <label for="first_name">First Name:</label><input type="text" id="first_name" name="first_name" required><br>
                <label for="last_name">Last Name:</label><input type="text" id="last_name" name="last_name" required><br>
                <label for="email">Email:</label><input type="text" id="email" name="email" required><br>
                <label for="password">Password:  (8 - 12 characters)</label><input type="password" id="password" name="password" required><br>
                <label for="is_admin">Is Admin:</label><input type="checkbox" id="is_admin" name="is_admin" value="true"><br>
                <button type="submit" class="add-user-button">Add</button>
            </form>

            <?php
                require 'db_connect.php';

                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                   
                    // Collect user input
                    $user_name = mysqli_real_escape_string($conn, $_POST['user_name']);
                    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
                    $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
                    $email = mysqli_real_escape_string($conn, $_POST['email']);
                    $password = mysqli_real_escape_string($conn, $_POST['password']); // Consider hashing the password before storing
                    $is_admin = isset($_POST['is_admin']) ? 1 : 0; // Store as boolean (1 or 0)
                    
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                    
                    $sql = "INSERT INTO users (user_name, first_name, last_name, email, password, is_admin) VALUES (?, ?, ?, ?, ?, ?)";
                    $stmt = $conn->prepare($sql);
                    
                    if (false === $stmt) {
                        // Handle errors related to statement preparation
                        echo "Error preparing statement: " . htmlspecialchars($conn->error);
                        exit();
                    }

                    $stmt->bind_param("sssssi", $user_name, $first_name, $last_name, $email, $hashed_password, $is_admin);
                             
                    if ($stmt->execute()) {
                        echo "New user created successfully.";
                    } else {
                        echo "Error executing statement: " . $stmt->error;
                    }
                    echo '7';
                    $stmt->close();
                   
                }
                $conn->close();
            ?>

        </div>
    </div>
            
    <?php include 'includes/footer.php'; ?>

    <!-- Add your JavaScript file link here -->
    <script src="script.js"></script>
</body>
</html>