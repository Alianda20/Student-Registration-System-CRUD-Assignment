<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

include("db.php");

// Search
$search = "";
if (isset($_GET['search'])) {
    $search = trim($_GET['search']);
}

// Pagination
$limit = 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

if ($page < 1) {
    $page = 1;
}

$start = ($page - 1) * $limit;

// Search text for LIKE
$search_like = "%" . $search . "%";

// Prepared statement
$stmt = $conn->prepare("
SELECT *
FROM students
WHERE full_name LIKE ?
OR course LIKE ?
LIMIT ?, ?
");

$stmt->bind_param("ssii", $search_like, $search_like, $start, $limit);

$stmt->execute();

$result = $stmt->get_result();

// Count records
$count = $conn->prepare("
SELECT COUNT(*) AS total
FROM students
WHERE full_name LIKE ?
OR course LIKE ?
");

$count->bind_param("ss", $search_like, $search_like);

$count->execute();

$count_result = $count->get_result();

$total_records = $count_result->fetch_assoc()['total'];

$total_pages = ceil($total_records / $limit);
?>

<!DOCTYPE html>
<html>
<head>

<title>Student List</title>

<link rel="stylesheet" href="style.css">

</head>

<body>

<?php include("menu.php"); ?>

<h2>
Welcome,
<?php echo htmlspecialchars($_SESSION['user']); ?>
</h2>

<p>
<strong>Role:</strong>
<?php echo htmlspecialchars(ucfirst($_SESSION['role'])); ?>
</p>

<hr>

<h2>Student List</h2>

<form method="GET">

<input
type="text"
name="search"
placeholder="Search by Name or Course"
value="<?php echo htmlspecialchars($search); ?>">

<input
type="submit"
value="Search">

</form>

<br>

<table border="1" cellpadding="10">

<tr>

<th>ID</th>
<th>Reg No</th>
<th>Photo</th>
<th>Full Name</th>
<th>Course</th>
<th>Gender</th>
<th>Phone</th>
<th>Email</th>

<?php if($_SESSION['role']=="admin"){ ?>

<th>Edit</th>
<th>Delete</th>

<?php } ?>

</tr>

<?php

if($result->num_rows>0){

while($row=$result->fetch_assoc()){

?>

<tr>

<td><?php echo htmlspecialchars($row['id']); ?></td>

<td><?php echo htmlspecialchars($row['reg_no']); ?></td>

<td>

<?php if(!empty($row['photo'])){ ?>

<img
src="uploads/<?php echo htmlspecialchars($row['photo']); ?>"
width="80"
height="80"
style="border-radius:8px;object-fit:cover;">

<?php } ?>

</td>

<td><?php echo htmlspecialchars($row['full_name']); ?></td>

<td><?php echo htmlspecialchars($row['course']); ?></td>

<td><?php echo htmlspecialchars($row['gender']); ?></td>

<td><?php echo htmlspecialchars($row['phone']); ?></td>

<td><?php echo htmlspecialchars($row['email']); ?></td>

<?php if($_SESSION['role']=="admin"){ ?>

<td>

<a href="edit_student.php?id=<?php echo $row['id']; ?>">

Edit

</a>

</td>

<td>

<a
href="delete_student.php?id=<?php echo $row['id']; ?>"
onclick="return confirm('Delete this student?')">

Delete

</a>

</td>

<?php } ?>

</tr>

<?php

}

}else{

?>

<tr>

<td colspan="10">

No students found.

</td>

</tr>

<?php

}

?>

</table>

<br>

<?php

if($page>1){

?>

<a href="?search=<?php echo urlencode($search); ?>&page=<?php echo $page-1; ?>">

Previous

</a>

<?php

}

for($i=1;$i<=$total_pages;$i++){

?>

<a href="?search=<?php echo urlencode($search); ?>&page=<?php echo $i; ?>">

<?php echo $i; ?>

</a>

<?php

}

if($page<$total_pages){

?>

<a href="?search=<?php echo urlencode($search); ?>&page=<?php echo $page+1; ?>">

Next

</a>

<?php

}

$stmt->close();
$count->close();
$conn->close();

?>

</body>
</html>