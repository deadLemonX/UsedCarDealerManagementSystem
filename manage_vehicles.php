<body>
    <?php include 'includes/header.php'; ?>
    
    <div class="flex-container">
        <div>
            <?php include 'includes/navbar/manage_vehicles_navbar.php'; ?>
        </div>
        <div>
            <?php 
                session_start();
                $username = $_SESSION['username'];
                $login_feedback = "Your are currently logged in as: ". $username;
                echo "<p class='login-feedback'>$login_feedback</p>";
            ?>
            <?php
                echo '<main class="image-container">
                <img src="assets/images/car_logos.png" alt="Car Logos">
                </main>';
            ?>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>

    <!-- Add your JavaScript file link here -->
    <script src="script.js"></script>
</body>
</html>