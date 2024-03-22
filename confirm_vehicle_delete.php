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

            <div class="form-head">
            <h2>Delete Vehicle Inventory</h2>
            <?php if (isset($_SESSION['delete_inventory_confirm'])) {
                if ($_SESSION['delete_inventory_confirm']) {
                    
                    echo '<p class="form-head"><b>The vehicle has been deleted.</b></p>';
                }
                else {
                    echo '<p class="form-head"><b>The vehicle has NOT been deleted.</b></p>';
                }
            }
            ?>
            </div>
        </div>
    </div>
    <?php include 'includes/footer.php'; ?>

   


