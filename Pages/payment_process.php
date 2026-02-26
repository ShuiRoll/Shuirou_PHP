<?php
include dirname(__DIR__)."/db.php";
 
 
$booking_id = $_GET['booking_id'];
 
 
$booking = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM bookings WHERE booking_id=$booking_id"));
 
 
$paidRow = mysqli_fetch_assoc(mysqli_query($conn, "SELECT IFNULL(SUM(amount_paid),0) AS paid FROM payments WHERE booking_id=$booking_id"));
$total_paid = $paidRow['paid'];
 
 
$balance = $booking['total_cost'] - $total_paid;
$message = "";
 
 
if (isset($_POST['pay'])) {
  $amount = $_POST['amount_paid'];
  $method = $_POST['method'];
 
 
  if ($amount <= 0) {
    $message = "Invalid amount!";
  } else if ($amount > $balance) {
    $message = "Amount exceeds balance!";
  } else {
 
 
    // 1) Insert payment
    mysqli_query($conn, "INSERT INTO payments (booking_id, amount_paid, method)
      VALUES ($booking_id, $amount, '$method')");
 
 
    // 2) Recompute total paid (after insert)
    $paidRow2 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT IFNULL(SUM(amount_paid),0) AS paid FROM payments WHERE booking_id=$booking_id"));
    $total_paid2 = $paidRow2['paid'];
 
 
    // 3) Recompute new balance
    $new_balance = $booking['total_cost'] - $total_paid2;
 
 
    // 4) If fully paid, update booking status to PAID
    if ($new_balance <= 0.009) {
      mysqli_query($conn, "UPDATE bookings SET status='PAID' WHERE booking_id=$booking_id");
    }
 
 
    header("Location: bookings_list.php");
    exit;
  }
}
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Process Payment</title>
    <link rel="stylesheet" href="/assessment_beginner/style.css">
</head>
<body>
<div class="container">
<?php include dirname(__DIR__)."/nav.php"; ?>

<h2>Process Payment (Booking #<?php echo $booking_id; ?>)</h2>

<div class="payment-info">
  <div class="card">
    <h3>Total Cost</h3>
    <div class="value">₱<?php echo number_format($booking['total_cost'],2); ?></div>
  </div>
  <div class="card">
    <h3>Total Paid</h3>
    <div class="value">₱<?php echo number_format($total_paid,2); ?></div>
  </div>
  <div class="card">
    <h3>Balance</h3>
    <div class="value">₱<?php echo number_format($balance,2); ?></div>
  </div>
</div>

<?php if($message): ?>
<p class="message message-error"><?php echo $message; ?></p>
<?php endif; ?>

<form method="post">
  <label>Amount Paid</label>
  <input type="number" name="amount_paid" step="0.01">

  <label>Method</label>
  <select name="method">
    <option value="CASH">CASH</option>
    <option value="GCASH">GCASH</option>
    <option value="CARD">CARD</option>
  </select>

  <button type="submit" name="pay">Save Payment</button>
</form>
</div>
</body>
</html>