<?php
include dirname(__DIR__) . "/db.php";
 
$id = $_GET['id'];
 
$get = mysqli_query($conn, "SELECT * FROM clients WHERE client_id = $id");
$client = mysqli_fetch_assoc($get);
 
$message = "";
 
if (isset($_POST['update'])) {
  $full_name = $_POST['full_name'];
  $email = $_POST['email'];
  $phone = $_POST['phone'];
  $address = $_POST['address'];
 
  if ($full_name == "" || $email == "") {
    $message = "Name and Email are required!";
  } else {
    $sql = "UPDATE clients
            SET full_name='$full_name', email='$email', phone='$phone', address='$address'
            WHERE client_id=$id";
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
    <title>Edit Client</title>
    <link rel="stylesheet" href="/assessment_beginner/style.css">
</head>
<body>
<div class="container">
<?php include dirname(__DIR__) . "/nav.php"; ?>
 
<h2>Edit Client</h2>
<?php if($message): ?>
<p class="message message-error"><?php echo $message; ?></p>
<?php endif; ?>
 
<form method="post">
  <label>Full Name*</label>
  <input type="text" name="full_name" value="<?php echo $client['full_name']; ?>">
 
  <label>Email*</label>
  <input type="text" name="email" value="<?php echo $client['email']; ?>">
 
  <label>Phone</label>
  <input type="text" name="phone" value="<?php echo $client['phone']; ?>">
 
  <label>Address</label>
  <input type="text" name="address" value="<?php echo $client['address']; ?>">
 
  <button type="submit" name="update">Update Client</button>
</form>
</div>
</body>
</html>