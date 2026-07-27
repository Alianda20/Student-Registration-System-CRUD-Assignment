<?php
session_start();

if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}

include("db.php");

$search = "";

if(isset($_GET['search'])){
    $search = $_GET['search'];
}

$search = "";

if(isset($_GET['search'])){
    $search = $_GET['search'];
}

$limit = 5;

$page = isset($_GET['page'])
    ? (int)$_GET['page']
    : 1;

$start = ($page - 1) * $limit;

$sql = "SELECT * FROM students
        WHERE full_name LIKE '%$search%'
        OR course LIKE '%$search%'
        LIMIT $start, $limit";

$result = mysqli_query($conn, $sql);
$count_sql = "SELECT COUNT(*) AS total
              FROM students
              WHERE full_name LIKE '%$search%'
              OR course LIKE '%$search%'";

$count_result = mysqli_query($conn, $count_sql);

$total_records = mysqli_fetch_assoc($count_result)['total'];

$total_pages = ceil($total_records / $limit);
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Students</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include("menu.php"); ?>

<h2>Welcome, <?php echo $_SESSION['user']; ?></h2>

<p><strong>Role:</strong> <?php echo ucfirst($_SESSION['role']); ?></p>

<hr>

<h2>Student List</h2>

<a href="index.php">Home</a> |
<a href="add_student.php">Register New Student</a>

<br><br>
<form method="GET" action="">
    <input type="text"
           name="search"
           placeholder="Search by name or course"
           value="<?php echo $search; ?>">

    <input type="submit" value="Search">
</form>

<br>

<table border="1" cellpadding="10" cellspacing="0">

<tr>
    <th>ID</th>
    <th>Registration Number</th>
    <th>Photo</th>
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

<td>
    <img src="uploads/<?php echo $row['photo']; ?>"
         width="80"
         height="80"
         style="border-radius:8px; object-fit:cover;">
</td>

<td><?php echo $row['full_name']; ?></td>

<td><?php echo $row['course']; ?></td>

<td><?php echo $row['gender']; ?></td>

<td><?php echo $row['email']; ?></td>

<td>

<?php if($_SESSION['role'] == "admin"){ ?>

<a href="edit_student.php?id=<?php echo $row['id']; ?>">Edit</a>

<?php } else { ?>

View Only

<?php } ?>

</td>

<td>

<?php if($_SESSION['role'] == "admin"){ ?>

<a href="delete_student.php?id=<?php echo $row['id']; ?>"
onclick="return confirm('Delete this student?')">
Delete
</a>

<?php } else { ?>

View Only

<?php } ?>

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
<br>

<?php if($page > 1){ ?>
<a href="?search=<?php echo $search; ?>&page=<?php echo $page-1; ?>">
Previous
</a>
<?php } ?>

<?php
for($i=1; $i<=$total_pages; $i++){
?>
    <a href="?search=<?php echo $search; ?>&page=<?php echo $i; ?>">
        <?php echo $i; ?>
    </a>
<?php
}
?>

<?php if($page < $total_pages){ ?>
<a href="?search=<?php echo $search; ?>&page=<?php echo $page+1; ?>">
Next
</a>
<?php } ?>

</body>
</html>