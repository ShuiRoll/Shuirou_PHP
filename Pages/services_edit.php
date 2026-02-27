<?php
include dirname(__DIR__) . "/db.php";
$id = $_GET['id'];
 
$get = mysqli_query($conn, "SELECT * FROM services WHERE service_id = $id");
$service = mysqli_fetch_assoc($get);
 
if (isset($_POST['update'])) {
  $name = $_POST['service_name'];
  $desc = $_POST['description'];
  $rate = $_POST['hourly_rate'];
  $active = $_POST['is_active'];
 
  mysqli_query($conn, "UPDATE services
    SET service_name='$name', description='$desc', hourly_rate='$rate', is_active='$active'
    WHERE service_id=$id");
 
  header("Location: services_list.php");
  exit;
}

if (isset($_POST['deactivate'])) {
  mysqli_query($conn, "UPDATE services SET is_active=0 WHERE service_id=$id");
  header("Location: services_list.php");
  exit;
}

if (isset($_POST['activate'])) {
  mysqli_query($conn, "UPDATE services SET is_active=1 WHERE service_id=$id");
  header("Location: services_list.php");
  exit;
}
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Service</title>
    <link rel="stylesheet" href="/assessment_beginner/style.css">
</head>
<body>
<div class="container">
<?php include dirname(__DIR__) . "/nav.php"; ?>
 
<h2>Edit Service</h2>

<form method="post">
  <label>Service Name</label>
  <input type="text" name="service_name" value="<?php echo $service['service_name']; ?>">

  <label>Description</label>
  <textarea name="description"><?php echo $service['description']; ?></textarea>

  <label>Hourly Rate</label>
  <input type="text" name="hourly_rate" value="<?php echo $service['hourly_rate']; ?>">

  <input type="hidden" name="is_active" value="<?php echo $service['is_active']; ?>">

  <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 10px;">
    <button type="submit" name="update">Update</button>
    <?php if ($service['is_active'] == 1) { ?>
      <button type="submit" name="deactivate" onclick="return confirm('Deactivate this service?')" style="background-color: #dc3545; color: white;">Deactivate</button>
    <?php } else { ?>
      <button type="submit" name="activate" onclick="return confirm('Activate this service?')" style="background-color: #28a745; color: white;">Activate</button>
    <?php } ?>
  </div>
</form>
</div>
</body>
</html>