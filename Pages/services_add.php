<?php
include "../db.php";
 
$message = "";
 
if (isset($_POST['save'])) {
  $service_name = $_POST['service_name'];
  $description = $_POST['description'];
  $hourly_rate = $_POST['hourly_rate'];
  $is_active = $_POST['is_active'];
 

  if ($service_name == "" || $hourly_rate == "") {
    $message = "Service name and hourly rate are required!";
  } else if (!is_numeric($hourly_rate) || $hourly_rate <= 0) {
    $message = "Hourly rate must be a number greater than 0.";
  } else {
    $sql = "INSERT INTO services (service_name, description, hourly_rate, is_active)
            VALUES ('$service_name', '$description', '$hourly_rate', '$is_active')";
    mysqli_query($conn, $sql);
 
    header("Location: services_list.php");
    exit;
  }
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Add Service</title>
<link rel="stylesheet" href="../style.css">
</head>
<body>
<?php include "../nav.php"; ?>
 
<h2>Add Service</h2>
<?php if ($message != "") { ?>
<p style="color:red;"><?php echo $message; ?></p>
<?php } ?>
 
<form method="post" class="form-horizontal">
  <div class="form-row">
    <div class="form-group">
      <label>Service Name*</label>
      <input type="text" name="service_name">
    </div>
    <div class="form-group">
      <label>Hourly Rate (₱)*</label>
      <input type="text" name="hourly_rate">
    </div>
    <div class="form-group">
      <label>Active?</label>
      <select name="is_active">
        <option value="1">Yes</option>
        <option value="0">No</option>
      </select>
    </div>
  </div>
  <div class="form-row">
    <div class="form-group form-group-wide">
      <label>Description</label>
      <textarea name="description" rows="3"></textarea>
    </div>
  </div>
  <div class="form-row">
    <button type="submit" name="save">Save Service</button>
  </div>
</form>
 
</body>
</html>