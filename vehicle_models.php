<body>
    <?php include 'includes/header.php'; ?>
    
    <div class="flex-container">
        <div>
            <?php include 'includes/navbar/vehicle_models_navbar.php'; ?>
        </div>
        <div>
            <?php 
                session_start();
                $username = $_SESSION['username'];
                $login_feedback = "Your are currently logged in as: ". $username;
                echo "<p class='login-feedback'>$login_feedback</p>";
            ?>
            <?php 
                require 'db_connect.php';
                $sql = "SELECT id, name FROM makes ORDER BY name ASC";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        echo '<label for="make" class="form-head>Vehicle Make Selection: </label><br><select name="make_id" id="make">';
                        echo '<option value=""></option>';

                        while ($row = $result->fetch_assoc()) {
                            echo '<option value="'.htmlspecialchars($row['id']).'">'.htmlspecialchars($row['name']).'</option>';
                        }

                        echo '</select><br>';
                    } 
            ?>
            <form method="POST" action="" class="filter-makes-form">
                <h2 class="form-head">Vehicle Make Selection:</h2><br>
                <?php
                    $sql = "SELECT id, name FROM makes ORDER BY name ASC";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        echo '<select name="make_id" id="make">';
                        echo '<option value=""></option>';

                        while ($row = $result->fetch_assoc()) {
                            echo '<option value="'.htmlspecialchars($row['id']).'">'.htmlspecialchars($row['name']).'</option>';
                        }

                        echo '</select><br>';
                    } 
                ?>

                <button type="submit" class="filter-makes-button">Submit</button>
            </form>
            
            
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST" &&  !empty($_POST['make_id'])) {   
                
                $make_id = mysqli_real_escape_string($conn, $_POST['make_id']);

                $sql = "SELECT * FROM models WHERE make_id = ?";
                $stmt = $conn->prepare($sql);

                $stmt->bind_param("i", $make_id);

                if ($stmt === false) {
                    echo "Error preparing statement: " . htmlspecialchars($conn->error);
                } else {
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $results = $result->fetch_all(MYSQLI_ASSOC);
                    if (!$results) { echo "No models found."; }
                    $result->free();
                    $stmt->close();
                }
                $conn->close();
            }
            ?>

            <h2 class="form-head">Vehicle Models</h2>
            <table>
                <tr>
                    <th>Edit</th>
                    <th>Delete</th>
                    <th>Name</th>
                </tr>
                <?php foreach ($results as $row): ?>
                    <tr>
                        <td><a href="edit_model.php?model_id=<?php echo $row['id']; ?>">Edit</a></td>
                        <td><a href="delete_model.php?model_id=<?php echo $row['id'];?>&name= <?php echo $row['name']; ?>">Delete</a></td>
                        <td><?php echo $row['name']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>

    <!-- Add your JavaScript file link here -->
    <script src="script.js"></script>
</body>
</html>