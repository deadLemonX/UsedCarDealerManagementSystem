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

                if (isset($_GET['user_id'])) {
                    $user_id = $_SESSION['currentEditUserPKey'];

                    require 'db_connect.php'; // Include your DB connection script

                    try {
                        $sql = "SELECT * FROM `users` WHERE user_id = ?;"; // SQL query using placeholders
                        $stmt = $conn->prepare($sql);
                        $stmt->execute([$user_id]);

                        $results = $stmt->fetch(PDO::FETCH_ASSOC); 
                    } catch(PDOException $e) {
                        echo "Error: " . $e->getMessage();
                    }

                    echo '<form method="post" action="" class="add-user-form">';
                    echo '<h2 class="form-head">Edit User</h2><br>';
                    echo '<label for="user_name">Username:</label> <input type="text" id="user_name" name="user_name" value=' . $results['user_name'] . ' required><br>';                 
                    echo '<label for="first_name">First Name:</label><input type="text" id="first_name" name="first_name" value=' . $results['first_name'] . ' required><br>';
                    echo '<label for="last_name">Last Name:</label><input type="text" id="last_name" name="last_name" value=' . $results['last_name'] . ' required><br>';
                    echo '<label for="email">Email:</label><input type="text" id="email" name="email" value=' . $results['email'] . ' required><br>';
                    echo '<label for="password">Password:  (8 - 12 characters)</label><input type="password" id="password" name="password" required><br>';
                    echo '<label for="is_admin">Is Admin:</label><input type="checkbox" id="is_admin" name="is_admin" value=1 ' . ($results['is_admin'] ? 'checked' : '') . '><br>';
                    echo '<button type="submit" class="edit-user-button">Edit</button>';
                    echo '</form> ';
                } else {
                    echo "No user selected for editing.";
                    // Redirect back or show an error message
                }
            

                // Check if the form has been submitted
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

                    // Bind parameters and execute
                    try {
                        $stmt->execute([$user_name, $first_name, $last_name, $email, $password, $is_admin, $user_id]);
                        echo "User updated successfully.";
                    } catch (PDOException $e) {
                        echo "Error: " . $e->getMessage();
                    }
                }
        ?>
        </div>
    </div>
    <?php include 'includes/footer.php'; ?>

    <!-- Add your JavaScript file link here -->
    <script src="script.js"></script>
</body>
</html>