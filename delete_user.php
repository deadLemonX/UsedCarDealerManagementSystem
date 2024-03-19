<body>

    <?php include 'includes/header.php'; ?>
    
    <div class="flex-container">
        <div>
            <?php include 'includes/navbar/manage_users_navbar.php'; ?>
        </div>
        <div>
            <?php 
                session_start();
                $username = $_SESSION['username'];
                $login_feedback = "Your are currently logged in as: ". $username;
                echo "<p class='login-feedback'>$login_feedback</p>";
            ?>
            <?php if (isset($_GET['user_id'])) 
                {
                    $first_name = '';
                    $user_id = '';
                    if (isset($_GET['user_id'])) {
                        $_SESSION['currentDeleteUserPKey'] = $_GET['user_id'];
                        $name = $_GET['name'];;
                        $user_id = $_SESSION['currentDeleteUserPKey'];
                    }
                }  
            ?>
            
            <form action="" method="POST" class="delete-user-form">
                <h2 class="form-head">Delete User</h2>
                <?php echo "<p class='form-head'><b>Are you sure you want to delete $name?</b></p>"; ?>
                <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                <input type="submit" name="confirm_delete_user" value="Yes" class="delete-user-button">
                <input type="submit" name="confirm_delete_user" value="No" class="delete-user-button">
            </form>
            <?php
                //session_start();
                if ($_SERVER["REQUEST_METHOD"] == "POST" ) {
                    // Check if user confirmed the deletion
                    if ($_POST['confirm_delete_user'] == 'Yes' && isset($_SESSION['currentDeleteUserPKey'])) {
                        $user_id = $_SESSION['currentDeleteUserPKey'];
                        require 'db_connect.php'; 

                        $stmt = $conn->prepare("DELETE FROM users WHERE user_id = ?");
                        $stmt->bind_param("i", $user_id);

                        if ($stmt->execute()) {
                            echo "User deleted successfully.";
                            header("Location: manage_users.php");
                            
                        } else {
                            echo "Error deleting user: " . htmlspecialchars($conn->error);
                        }

                        $stmt->close();
                        $conn->close();
                    } else if($_POST['confirm_delete_user'] == 'No') {
                        header("Location: manage_users.php");
                    } else {
                        exit;
                    }
                }
            ?>
        </div>
    </div>
    <?php include 'includes/footer.php'; ?>

   


