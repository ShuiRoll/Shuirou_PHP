<?php
include dirname(__DIR__) . "/db.php";
 
$message = "";
 
if (isset($_POST['save'])) {
  $full_name = $_POST['full_name'];
  $email = $_POST['email'];
  $phone = $_POST['phone'];
  $address = $_POST['address'];
 
  if ($full_name == "" || $email == "") {
    $message = "Name and Email are required!";
  } else {
    $sql = "INSERT INTO clients (full_name, email, phone, address)
            VALUES ('$full_name', '$email', '$phone', '$address')";
    mysqli_query($conn, $sql);
    header("Location: clients_list.php");
    exit;
  }
}
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Client</title>
    <link rel="stylesheet" href="/assessment_beginner/style.css">
</head>
<body>
<div class="container">
<?php include dirname(__DIR__) . "/nav.php"; ?>
 
<h2>Add Client</h2>
<?php if($message): ?>
<p class="message message-error"><?php echo $message; ?></p>
<?php endif; ?>
 
<form method="post">
  <label>Full Name*</label>
  <input type="text" name="full_name">
 
  <label>Email*</label>
  <input type="text" name="email">
 
  <label>Phone</label>
  <input type="text" name="phone">
 
  <label>Address</label>
  <input type="text" name="address">
 
  <button type="submit" name="save">Save Client</button>
</form>
</div>
</body>
</html>