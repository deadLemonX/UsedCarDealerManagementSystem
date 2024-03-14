
<body>

    <?php include 'includes/header.php'; ?>
    
    <div class="flex-container">
        <?php include 'includes/navbar/login_navbar.php'; ?>
        <form method="POST" action="" class="login-form">
            <h2 class="form-head">Login</h2>
            <br>
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            <br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <br>
            <button type="submit" class="login-button">Login</button>
        </form>
    </div>
    <?php
        session_start();
        require 'db_connect.php'; // Ensure this file contains your mysqli connection: $conn

        if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['username']) && !empty($_POST['password'])) {
            // Escape user inputs for security
            $username = mysqli_real_escape_string($conn, $_POST['username']);
            $submittedPass = $_POST['password']; 
            
            $sql = "SELECT user_id, user_name, password, is_admin FROM users WHERE user_name = ?";
            
            if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param("s", $username);
                
                if ($stmt->execute()) {
                    $stmt->store_result();

                    if ($stmt->num_rows == 1) {
                        $stmt->bind_result($user_id, $username, $password, $is_admin);
                        
                        if ($stmt->fetch()) {
                            echo "pass " . $password;
                            echo " sub pass " . $submittedPass;
                            
                            if (password_verify($submittedPass, $password)) {
                                $_SESSION["loggedin"] = true;
                                $_SESSION["user_id"] = $user_id;
                                $_SESSION["username"] = $username; 
                                $_SESSION["is_admin"] = $is_admin;                           
                                
                                
                                header("location: admin_page.php");
                            } else {
                                // Display an error message if password is not valid
                                echo "The password you entered was not valid.";
                            }
                        }
                    } else {
                        // Display an error message if username doesn't exist
                        echo "No account found with that username.";
                    }
                } else {
                    echo "Oops! Something went wrong. Please try again later.";
                }

                $stmt->close();
            }
        }

        $conn->close();
    ?>


    <?php include 'includes/footer.php'; ?>

    <!-- Add your JavaScript file link here -->
    <script src="script.js"></script>
</body>
</html>
