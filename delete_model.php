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
            <?php if (isset($_GET['model_id'])) 
                {
                    $name = '';
                    $id = '';
                    $_SESSION['currentDeleteModelPKey'] = $_GET['model_id'];
                    $name = $_GET['name'];;
                    $id = $_SESSION['currentDeleteModelPKey'];
                }  
            ?>
            
            <form action="" method="POST" class="delete-user-form">
                <h2 class="form-head">Delete Model</h2>
                <?php echo "<p class='form-head'><b>Are you sure you want to delete $name?</b></p>"; ?>
                <input type="hidden" name="user_id" value="<?php echo $id; ?>">
                <input type="submit" name="confirm_delete_model" value="Yes" class="delete-user-button">
                <input type="submit" name="confirm_delete_model" value="No" class="delete-user-button">
            </form>
            <?php
                //session_start();
                if ($_SERVER["REQUEST_METHOD"] == "POST" ) {
                    // Check if user confirmed the deletion
                    if ($_POST['confirm_delete_model'] == 'Yes' && isset($_SESSION['currentDeleteModelPKey'])) {
                        $user_id = $_SESSION['currentDeleteModelPKey'];
                        require 'db_connect.php'; 

                        $stmt = $conn->prepare("DELETE FROM models WHERE id = ?");
                        $stmt->bind_param("i", $user_id);

                        if ($stmt->execute()) {
                            echo "Model deleted successfully.";
                            header("Location: vehicle_models.php");
                            
                        } else {
                            echo "Error deleting model: " . htmlspecialchars($conn->error);
                        }

                        $stmt->close();
                        $conn->close();
                    } else if($_POST['confirm_delete_model'] == 'No') {
                        header("Location: vehicle_models.php");
                    } else {
                        exit;
                    }
                }
            ?>
        </div>
    </div>
    <?php include 'includes/footer.php'; ?>

   


