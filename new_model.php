<body>
    <?php include 'includes/header.php'; require 'db_connect.php'; ?>
    
    <div class="flex-container">
    <?php include 'includes/navbar/vehicle_models_navbar.php'; ?>
        <div>
            <?php 
                session_start();
                $username = $_SESSION['username'];
                $login_feedback = "Your are currently logged in as: ". $username;
                echo "<p class='login-feedback'>$login_feedback</p>";
            ?>
            
            <form method="POST" action="" class="add-model-form">
                <h2 class="form-head">Add Model</h2><br>
                <label for="model">Vehicle Model:</label><input type="text" id="name" name="name" required><br>
                
                <?php
                    
                    $sql = "SELECT id, name FROM makes ORDER BY name ASC";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        echo '<label for="make">Vehicle Make: </label><br><select name="make_id" id="make">';
                        echo '<option value=""></option>';

                        while ($row = $result->fetch_assoc()) {
                            echo '<option value="'.htmlspecialchars($row['id']).'">'.htmlspecialchars($row['name']).'</option>';
                        }

                        echo '</select><br>';
                    } else {
                        echo "<p>0 results found. Please add a make first.</p>";
                    }
                ?>

                <button type="submit" class="add-model-button">Add</button>
            </form>


            <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['name']) && !empty($_POST['make_id'])) {
                   
                    $name = mysqli_real_escape_string($conn, $_POST['name']);
                    $make_id = mysqli_real_escape_string($conn, $_POST['make_id']);

                    $sql = "INSERT INTO models (name, make_id) VALUES (?, ?)";
                    $stmt = $conn->prepare($sql);
                    
                    if (false === $stmt) {
                        // Handle errors related to statement preparation
                        echo "Error preparing statement: " . htmlspecialchars($conn->error);
                        exit();
                    }

                    $stmt->bind_param("ss", $name, $make_id);
                             
                    if ($stmt->execute()) {
                        echo "New make created successfully.";
                        header("Location: vehicle_models.php");
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