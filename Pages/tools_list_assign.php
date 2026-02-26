<?php
include dirname(__DIR__)."/db.php";
 
$message = "";
$messageType = "";
 
// ASSIGN TOOL
if (isset($_POST['assign'])) {
  $booking_id = $_POST['booking_id'];
  $tool_id = $_POST['tool_id'];
  $qty = $_POST['qty_used'];
 
  $toolRow = mysqli_fetch_assoc(mysqli_query($conn, "SELECT quantity_available FROM tools WHERE tool_id=$tool_id"));
 
  if ($qty > $toolRow['quantity_available']) {
    $message = "Not enough available tools!";
    $messageType = "error";
  } else {
    mysqli_query($conn, "INSERT INTO booking_tools (booking_id, tool_id, qty_used)
      VALUES ($booking_id, $tool_id, $qty)");
 
    mysqli_query($conn, "UPDATE tools SET quantity_available = quantity_available - $qty WHERE tool_id=$tool_id");
 
    $message = "Tool assigned successfully!";
    $messageType = "success";
  }
}
 
$tools = mysqli_query($conn, "SELECT * FROM tools ORDER BY tool_name ASC");
$bookings = mysqli_query($conn, "SELECT booking_id FROM bookings ORDER BY booking_id DESC");
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tools</title>
    <link rel="stylesheet" href="/assessment_beginner/style.css">
</head>
<body>
<div class="container">
<?php include dirname(__DIR__)."/nav.php"; ?>

<h2>Tools / Inventory</h2>
<?php if($message): ?>
<p class="message message-<?php echo $messageType; ?>"><?php echo $message; ?></p>
<?php endif; ?>

<div class="side-by-side">
<div class="side-left">
<h3>Available Tools</h3>
<table>
  <tr><th>Name</th><th>Total</th><th>Available</th></tr>
  <?php while($t = mysqli_fetch_assoc($tools)) { ?>
    <tr>
      <td><?php echo $t['tool_name']; ?></td>
      <td><?php echo $t['quantity_total']; ?></td>
      <td><?php echo $t['quantity_available']; ?></td>
    </tr>
  <?php } ?>
</table>
</div>

<div class="side-right">
<h3>Assign Tool to Booking</h3>
<form method="post">
  <label>Booking ID</label>
  <select name="booking_id">
    <?php while($b = mysqli_fetch_assoc($bookings)) { ?>
      <option value="<?php echo $b['booking_id']; ?>">#<?php echo $b['booking_id']; ?></option>
    <?php } ?>
  </select>

  <label>Tool</label>
  <select name="tool_id">
    <?php
      $tools2 = mysqli_query($conn, "SELECT * FROM tools ORDER BY tool_name ASC");
      while($t2 = mysqli_fetch_assoc($tools2)) {
    ?>
      <option value="<?php echo $t2['tool_id']; ?>">
        <?php echo $t2['tool_name']; ?> (Avail: <?php echo $t2['quantity_available']; ?>)
      </option>
    <?php } ?>
  </select>

  <label>Qty Used</label>
  <input type="number" name="qty_used" min="1" value="1">

  <button type="submit" name="assign">Assign</button>
</form>
</div>
</div>
</div>
</body>
</html>