<?php
// Include database connection
include("db.php");

// Fetch all student records
$sql = "SELECT * FROM students";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Students</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h2>Student List</h2>

<a href="index.php">Home</a> |
<a href="add_student.php">Register New Student</a>

<br><br>

<table border="1" cellpadding="10" cellspacing="0">

<tr>
    <th>ID</th>
    <th>Registration Number</th>
    <th>Full Name</th>
    <th>Course</th>
    <th>Gender</th>
    <th>Email</th>
    <th>Edit</th>
    <th>Delete</th>
</tr>

<?php
// Check if there are records
if (mysqli_num_rows($result) > 0) {

    while($row = mysqli_fetch_assoc($result)) {
?>

<tr>

<td><?php echo $row['id']; ?></td>

<td><?php echo $row['reg_no']; ?></td>

<td><?php echo $row['full_name']; ?></td>

<td><?php echo $row['course']; ?></td>

<td><?php echo $row['gender']; ?></td>

<td><?php echo $row['email']; ?></td>

<td>
<a href="edit_student.php?id=<?php echo $row['id']; ?>">
Edit
</a>
</td>

<td>
<a href="delete_student.php?id=<?php echo $row['id']; ?>"
onclick="return confirm('Are you sure you want to delete this student?');">
Delete
</a>
</td>

</tr>

<?php
    }

} else {

?>

<tr>
<td colspan="8">No students found.</td>
</tr>

<?php
}
?>

</table>

</body>
</html>