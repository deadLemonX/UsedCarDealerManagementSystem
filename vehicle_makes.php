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
            <?php
                require 'db_connect.php';

                $sql = "SELECT * FROM makes";
                $stmt = $conn->prepare($sql);

                if ($stmt === false) {
                    echo "Error preparing statement: " . htmlspecialchars($conn->error);
                } else {
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $results = $result->fetch_all(MYSQLI_ASSOC);
                    if (!$results) { echo "No makes found."; }
                    $result->free();
                    $stmt->close();
                }
                $conn->close();
            ?>
            <h2 class="form-head">Vehicle Makes</h2>
            <table>
                <tr>
                    <th>Edit</th>
                    <th>Delete</th>
                    <th>Name</th>
                </tr>
                <?php foreach ($results as $row): ?>
                    <tr>
                        <td><a href="edit_make.php?make_id=<?php echo $row['id']; ?>">Edit</a></td>
                        <td><a href="delete_make.php?make_id=<?php echo $row['id'];?>&name= <?php echo $row['name']; ?>">Delete</a></td>
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