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
            <?php
                require 'db_connect.php';

                $sql = "SELECT * FROM users";
                $stmt = $conn->prepare($sql);

                if ($stmt === false) {
                    echo "Error preparing statement: " . htmlspecialchars($conn->error);
                } else {
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $results = $result->fetch_all(MYSQLI_ASSOC);
                    if (!$results) { echo "No users found."; }
                    $result->free();
                    $stmt->close();
                }
                $conn->close();
            ?>

            
            <h2 class="form-head">Registered Users</h2>
            <table>
                <tr>
                    <th>Edit</th>
                    <th>Delete</th>
                    <th>Name</th>
                    <th>User Name</th>
                    <th>Email</th>
                    <th>Date Registered</th>
                </tr>
                <?php foreach ($results as $row): ?>
                    <tr>
                        <td><a href="edit_user.php?user_id=<?php echo $row['user_id']; ?>">Edit</a></td>
                        <td><a href="delete_user.php?user_id=<?php echo $row['user_id']; ?>">Delete</a></td>
                        <td><?php echo $row['first_name'] . " " . $row['last_name']; ?></td>
                        <td><?php echo $row['user_name']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['registration_date']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
            
        </div>
    </div>
    <?php include 'includes/footer.php'; ?>

   


