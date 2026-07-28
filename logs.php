<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

if ($_SESSION['role'] != "admin") {
    die("Access Denied");
}

include("db.php");
include("menu.php");

$result = $conn->query("SELECT * FROM logs ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Activity Logs</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h2>System Activity Logs</h2>

<table border="1" cellpadding="10">
<tr>
    <th>ID</th>
    <th>User</th>
    <th>Activity</th>
    <th>Date</th>
    <th>Time</th>
</tr>

<?php while($row = $result->fetch_assoc()) { ?>

<tr>
    <td><?php echo htmlspecialchars($row['id']); ?></td>
    <td><?php echo htmlspecialchars($row['user']); ?></td>
    <td><?php echo htmlspecialchars($row['activity']); ?></td>
    <td><?php echo htmlspecialchars($row['date']); ?></td>
    <td><?php echo htmlspecialchars($row['time']); ?></td>
</tr>

<?php } ?>

</table>

</body>
</html>