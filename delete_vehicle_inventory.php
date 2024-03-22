<body>

    <?php include 'includes/header.php'; ?>
    
    <div class="flex-container">
        <div>
            <?php include 'includes/navbar/manage_vehicle_inventory.php'; ?>
        </div>
        <div>
            <?php 
                session_start();
                $username = $_SESSION['username'];
                $login_feedback = "Your are currently logged in as: ". $username;
                echo "<p class='login-feedback'>$login_feedback</p>";
            ?>
            <?php if (isset($_GET['vehicle_id'])) 
                {
                    $_SESSION['currentDeleteVehiclePKey'] = $_GET['vehicle_id'];
                    $vehicle_id = $_SESSION['currentDeleteVehiclePKey'];

                    require 'db_connect.php'; 

                    $sql = "SELECT models.name AS model, makes.name AS make, vehicles.vin AS vin, vehicles.year AS year 
                    FROM vehicles 
                    INNER JOIN models ON vehicles.model_id = models.id 
                    INNER JOIN makes ON models.make_id = makes.id 
                    WHERE vehicles.vehicle_id = ?;";

                    $stmt = $conn->prepare($sql);
                    
                    $stmt->bind_param("i", $vehicle_id);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    
                    // Since you're expecting a single record, fetch it directly
                    if ($row = $result->fetch_assoc()) {
                        $make = $row['make'];
                        $model = $row['model'];
                        $year = $row['year'];
                        $vin = $row['vin'];
                        
                    }
                    $result->free();
                    $stmt->close();
                    }  
            ?>
            
            <form action="" method="POST" class="delete-user-form">
                <h2 class="form-head">Delete Vehicle Inventory</h2>
                <?php echo "<p class='form-head'><b>Are you sure you want to delete ($make/$model/$year/$vin)?</b></p>"; ?>
                <input type="hidden" name="vehicle_id" value="<?php echo $vehicle_id; ?>">
                <input type="submit" name="confirm_delete_vehicle" value="Yes" class="delete-user-button">
                <input type="submit" name="confirm_delete_vehicle" value="No" class="delete-user-button">
            </form>

           <?php
                //session_start();
                if ($_SERVER["REQUEST_METHOD"] == "POST" ) {
                    // Check if user confirmed the deletion
                    if ($_POST['confirm_delete_vehicle'] == 'Yes' && isset($_GET['vehicle_id'])) {
                        $vehicle_id = $_POST['vehicle_id'];

                        $sql = "DELETE FROM vehicles WHERE vehicle_id = ?;";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("i", $vehicle_id);
                        
                        if ($stmt->execute()) {
                            $_SESSION['delete_inventory_confirm'] = true;
                            header("Location: confirm_vehicle_delete.php");
                            
                        } else {
                            echo "Error deleting vehicle: " . htmlspecialchars($conn->error);
                        }

                        $stmt->close();
                        $conn->close();
                    } else if($_POST['confirm_delete_vehicle'] == 'No') {
                        $_SESSION['delete_inventory_confirm'] = false;
                        header("Location: confirm_vehicle_delete.php");
                    } else {
                        exit;
                    }
                }
            ?>
        </div>
    </div>
    <?php include 'includes/footer.php'; ?>

   


