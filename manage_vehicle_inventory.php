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
            <?php
                require 'db_connect.php';

                $sql = "SELECT 
                    v.vehicle_id,
                    m.name AS model,
                    mk.name AS make,
                    v.color,
                    vt.name AS type,
                    vpt.name AS power,
                    v.dealer_purchased_date AS purchased_date,
                    v.dealer_purchased_price AS purchased_price,
                    v.sold_date,
                    v.sold_price,
                    v.additional_cost
                    FROM vehicles v
                    INNER JOIN models m ON v.model_id = m.id
                    INNER JOIN makes mk ON m.make_id = mk.id
                    INNER JOIN vehicle_types vt ON v.vehicle_type_id = vt.id
                    INNER JOIN vehicle_power_types vpt ON v.vehicle_power_type_id = vpt.id;";

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
            
            <h2 class="form-head">Vehicle Inventory</h2>
            <table>
                <tr>
                    <th>Edit</th>
                    <th>Delete</th>
                    <th>Make</th>
                    <th>Model</th>
                    <th>Color</th>
                    <th>Type</th>
                    <th>Power</th>
                    <th>Purchased Date</th>
                    <th>Purchased Price</th>
                    <th>Sold Date</th>
                    <th>Sold Price</th>
                    <th>Additional Cost</th>
                </tr>
                <?php foreach ($results as $row): ?>
                    <tr>
                        <td><a href="edit_user.php?vehicle_id=<?php echo $row['vehicle_id']; ?>">Edit</a></td>
                        <td><a href="delete_vehicle_inventory.php?vehicle_id=<?php echo $row['vehicle_id'];?>">Delete</a></td>
                        <td><?php echo $row['make'] . " " . $row['last_name']; ?></td>
                        <td><?php echo $row['model']; ?></td>
                        <td><?php echo $row['color']; ?></td>
                        <td><?php echo $row['type']; ?></td>
                        <td><?php echo $row['power'] . " " . $row['last_name']; ?></td>
                        <td><?php echo $row['purchased_date']; ?></td>
                        <td><?php echo $row['purchased_price']; ?></td>
                        <td><?php echo $row['sold_date']; ?></td>
                        <td><?php echo $row['sold_price']; ?></td>
                        <td><?php echo $row['additional_cost']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
            
        </div>
    </div>
    <?php include 'includes/footer.php'; ?>

   


