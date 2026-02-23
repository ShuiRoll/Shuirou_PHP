<?php
include dirname(__DIR__) . "/db.php";
$result = mysqli_query($conn, "SELECT * FROM clients ORDER BY client_id DESC");
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clients</title>
    <link rel="stylesheet" href="/assessment_beginner/style.css">
</head>
<body>
<div class="container">
<?php include dirname(__DIR__) . "/nav.php"; ?>
 
<h2>Clients</h2>
<p><a href="clients_add.php">+ Add Client</a></p>
 
<table>
  <tr>
    <th>ID</th><th>Name</th><th>Email</th><th>Phone</th><th>Address</th><th>Action</th>
  </tr>
  <?php while($row = mysqli_fetch_assoc($result)) { ?>
    <tr>
      <td><?php echo $row['client_id']; ?></td>
      <td><?php echo $row['full_name']; ?></td>
      <td><?php echo $row['email']; ?></td>
      <td><?php echo $row['phone']; ?></td>
      <td><?php echo $row['address']; ?></td>
      <td>
        <a href="clients_edit.php?id=<?php echo $row['client_id']; ?>">Edit</a>
      </td>
    </tr>
  <?php } ?>
</table>
</div>
</body>
</html>