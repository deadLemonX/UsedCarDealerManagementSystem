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
            
            <form method="POST" action="" class="add-make-form">
                <h2 class="form-head">Add Make</h2><br>
                <label for="name">Vehicle Make:</label><input type="text" id="name" name="name" required><br>
                <button type="submit" class="add-make-button">Add</button>
            </form>

            <?php
                require 'db_connect.php';

                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                   
                    // Collect user input
                    $name = mysqli_real_escape_string($conn, $_POST['name']);
                
                    $sql = "INSERT INTO makes (name) VALUES (?)";
                    $stmt = $conn->prepare($sql);
                    
                    if (false === $stmt) {
                        // Handle errors related to statement preparation
                        echo "Error preparing statement: " . htmlspecialchars($conn->error);
                        exit();
                    }

                    $stmt->bind_param("s", $name);
                             
                    if ($stmt->execute()) {
                        echo "New make created successfully.";
                        header("Location: vehicle_makes.php");
                    } else {
                        echo "Error executing statement: " . $stmt->error;
                    }
                    
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