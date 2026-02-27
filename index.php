<?php
session_start();
 

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include "db.php";
 
$clients = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS c FROM clients"))['c'];
$services = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS c FROM services"))['c'];
$bookings = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS c FROM bookings"))['c'];
 
$revRow = mysqli_fetch_assoc(mysqli_query($conn, "SELECT IFNULL(SUM(amount_paid),0) AS s FROM payments"));
$revenue = $revRow['s'];
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="/assessment_beginner/style.css">
</head>
<body>
<div class="container">
    <?php include "nav.php"; ?>
    <h1>Dashboard</h1>
    <h2>Welcome, <?php echo $_SESSION['username']; ?>!</h2>

    <div class="stats-grid">
        <div class="card">
            <h3>Total Clients</h3>
            <div class="value"><?php echo $clients; ?></div>
        </div>
        <div class="card">
            <h3>Total Services</h3>
            <div class="value"><?php echo $services; ?></div>
        </div>
        <div class="card">
            <h3>Total Bookings</h3>
            <div class="value"><?php echo $bookings; ?></div>
        </div>
        <div class="card">
            <h3>Total Revenue</h3>
            <div class="value">₱<?php echo number_format($revenue, 2); ?></div>
        </div>
    </div>

    <div class="actions">
        <strong>Quick Actions:</strong>
        <a href="/assessment_beginner/pages/clients_add.php" class="btn">Add Client</a>
        <a href="/assessment_beginner/pages/bookings_create.php" class="btn">Create Booking</a>
    </div>
</div>
</body>
</html>