<body>
    <?php include 'includes/header.php'; require 'db_connect.php';?>
    
    <div class="flex-container">
        <?php include 'includes/navbar/manage_vehicle_inventory.php'; ?>
        <div>
            <?php 
                session_start();
                $username = $_SESSION['username'];
                $login_feedback = "Your are currently logged in as: ". $username;
                echo "<p class='login-feedback'>$login_feedback</p>";
            ?>
            
            <form method="POST" action="" class="add-vehicle-inventory-form">
                
                <h2 class="form-head">Add Vehicle Inventory</h2><br>

                <?php
                    $sql = "SELECT id, name FROM models ORDER BY name ASC";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        echo '<label for="model">Model: </label><select name="model_id">';
                        echo '<option value=""></option>';
                        while ($row = $result->fetch_assoc()) {
                            echo '<option value="'.htmlspecialchars($row['id']).'">'.htmlspecialchars($row['name']).'</option>';
                        }
                        echo '</select><br>';
                    }
                ?>
                <label for="year">Year:</label><input type="text" name="year" required><br>
                <label for="color">Color:</label><input type="text" name="color" required><br>
                <label for="vin">VIN:</label><input type="text" name="vin" required><br>
               
                <?php
                    $sql = "SELECT id, name FROM vehicle_types ORDER BY name ASC";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        echo '<label for="type">Type: </label><select name="type_id">';
                        echo '<option value=""></option>';
                        while ($row = $result->fetch_assoc()) {
                            echo '<option value="'.htmlspecialchars($row['id']).'">'.htmlspecialchars($row['name']).'</option>';
                        }
                        echo '</select><br>';
                    }
                ?>
                <?php
                    $sql = "SELECT id, name FROM vehicle_power_types ORDER BY name ASC";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        echo '<label for="power_type">Power Type: </label><select name="power_type_id">';
                        echo '<option value=""></option>';
                        while ($row = $result->fetch_assoc()) {
                            echo '<option value="'.htmlspecialchars($row['id']).'">'.htmlspecialchars($row['name']).'</option>';
                        }
                        echo '</select><br>';
                    }
                ?>

                <label for="purchased_date">Purchased Date: </label><br><input type="date" name="purchased_date" class="date_input" required><br><br>
                <label for="purchased_price">Purchased Price: </label><input type="text" name="purchased_price" required><br>
                <label for="sold_date">Sold Date: </label><br><input type="date" name="sold_date" class="date_input" required><br><br>
                <label for="sold_price">Sold Price: </label><input type="text" name="sold_price" required><br>
                <label for="additional_cost">Additional Cost: </label><input type="text" name="additional_cost" required><br>
                <button type="submit" class="add-vehicle-inventory-button">Add</button>
            </form>

            <?php

                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                   
                    // Collect user input
                    $model_id = mysqli_real_escape_string($conn, $_POST['model_id']);
                    $year = mysqli_real_escape_string($conn, $_POST['year']);
                    $color = mysqli_real_escape_string($conn, $_POST['color']);
                    $vin = mysqli_real_escape_string($conn, $_POST['vin']);
                    $type_id = mysqli_real_escape_string($conn, $_POST['type_id']); 
                    $power_type_id = mysqli_real_escape_string($conn, $_POST['power_type_id']);
                    $purchased_date = mysqli_real_escape_string($conn, $_POST['purchased_date']);
                    $purchased_price = mysqli_real_escape_string($conn, $_POST['purchased_price']);
                    $sold_date = mysqli_real_escape_string($conn, $_POST['sold_date']);
                    $sold_price = mysqli_real_escape_string($conn, $_POST['sold_price']);
                    $additional_cost = mysqli_real_escape_string($conn, $_POST['additional_cost']); 
                    

                    $sql = "INSERT INTO vehicles (model_id, year, color, vin, vehicle_type_id, vehicle_power_type_id, dealer_purchased_date, dealer_purchased_price, sold_date, sold_price, additional_cost) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                    $stmt = $conn->prepare($sql);
                    
                    if (false === $stmt) {
                        echo "Error preparing statement: " . htmlspecialchars($conn->error);
                        exit();
                    }

                    $stmt->bind_param("isssiisdsdd", $model_id, $year, $color, $vin, $type_id, $power_type_id, $purchased_date, $purchased_price, $sold_date, $sold_price, $additional_cost);
                             
                    if ($stmt->execute()) {
                        echo('The vehicle with VIN(' .$vin.') has been added.');
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