<?php
include dirname(__DIR__) . "/db.php";

if (isset($_GET['delete_id'])) {
  $delete_id = $_GET['delete_id'];
 
 
  // Soft delete (set is_active to 0)
  mysqli_query($conn, "UPDATE services SET is_active=0 WHERE service_id=$delete_id");
 
 
  header("Location: services_list.php");
  exit;
}

$result = mysqli_query($conn, "SELECT * FROM services ORDER BY service_id DESC");
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Services</title>
    <link rel="stylesheet" href="/assessment_beginner/style.css">
</head>
<body>
<div class="container">
<?php include dirname(__DIR__) . "/nav.php"; ?>
 
<h2>Services</h2>
<p><a href="services_add.php">+ Add Service</a></p>
 
<table>
  <tr>
    <th>ID</th><th>Name</th><th>Rate</th><th>Active</th><th>Action</th>
  </tr>
  <?php while($row = mysqli_fetch_assoc($result)) { ?>
    <tr>
      <td><?php echo $row['service_id']; ?></td>
      <td><?php echo $row['service_name']; ?></td>
      <td>₱<?php echo number_format($row['hourly_rate'],2); ?></td>
      <td><?php echo $row['is_active'] ? "Yes" : "No"; ?></td>
      <td><a href="services_edit.php?id=<?php echo $row['service_id']; ?>">Edit</a></td>
    </tr>
  <?php } ?>
</table>
</div>
</body>
</html>