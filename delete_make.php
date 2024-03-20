<body>

    <?php include 'includes/header.php'; ?>
    
    <div class="flex-container">
        <div>
            <?php include 'includes/navbar/vehicle_makes_navbar.php'; ?>
        </div>
        <div>
            <?php 
                session_start();
                $username = $_SESSION['username'];
                $login_feedback = "Your are currently logged in as: ". $username;
                echo "<p class='login-feedback'>$login_feedback</p>";
            ?>
            <?php if (isset($_GET['make_id'])) 
                {
                    $name = '';
                    $id = '';
                    if (isset($_GET['make_id'])) {
                        $_SESSION['currentDeleteMakePKey'] = $_GET['make_id'];
                        $name = $_GET['name'];
                        $id = $_SESSION['currentDeleteMakePKey'];
                    }
                }  
            ?>
            
            <form action="" method="POST" class="delete-make-form">
                <h2 class="form-head">Delete Make</h2>
                <?php echo "<p class='form-head'><b>Are you sure you want to delete $name?</b></p>"; ?>
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <input type="submit" name="confirm_delete_make" value="Yes" class="delete-make-button">
                <input type="submit" name="confirm_delete_make" value="No" class="delete-make-button">
            </form>
            <?php
                //session_start();
                if ($_SERVER["REQUEST_METHOD"] == "POST" ) {
                    // Check if user confirmed the deletion
                    if ($_POST['confirm_delete_make'] == 'Yes' && isset($_SESSION['currentDeleteMakePKey'])) {
                        //$id = $_SESSION['currentDeleteMakePKey'];
                        require 'db_connect.php'; 

                        $stmt = $conn->prepare("DELETE FROM makes WHERE id = ?");
                        $stmt->bind_param("i", $id);

                        if ($stmt->execute()) {
                            echo "Make deleted successfully.";
                            header("Location: vehicle_makes.php");
                            
                        } else {
                            echo "Error deleting make: " . htmlspecialchars($conn->error);
                        }

                        $stmt->close();
                        $conn->close();
                    } else if($_POST['confirm_delete_make'] == 'No') {
                        header("Location: vehicle_makes.php");
                    } else {
                        exit;
                    }
                }
            ?>
        </div>
    </div>
    <?php include 'includes/footer.php'; ?>

   


