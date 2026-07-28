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

// Get student ID
$id = $_GET['id'];

// Prepared statement
$stmt = $conn->prepare("SELECT * FROM students WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("Student not found.");
}

$row = $result->fetch_assoc();

$stmt->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Student</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include("menu.php"); ?>

<h2>Edit Student Details</h2>

<form action="update_student.php"
      method="POST"
      enctype="multipart/form-data">

    <input type="hidden" name="id"
           value="<?php echo htmlspecialchars($row['id']); ?>">

    <input type="hidden" name="old_photo"
           value="<?php echo htmlspecialchars($row['photo']); ?>">

    <label>Registration Number</label><br>

    <input
        type="text"
        name="reg_no"
        value="<?php echo htmlspecialchars($row['reg_no']); ?>"
        readonly>

    <br><br>

    <label>Full Name</label><br>

    <input
        type="text"
        name="full_name"
        value="<?php echo htmlspecialchars($row['full_name']); ?>"
        required>

    <br><br>

    <label>Course</label><br>

    <input
        type="text"
        name="course"
        value="<?php echo htmlspecialchars($row['course']); ?>"
        required>

    <br><br>

    <label>Gender</label><br>

    <select name="gender">

        <option value="Male"
        <?php if($row['gender']=="Male") echo "selected"; ?>>
        Male
        </option>

        <option value="Female"
        <?php if($row['gender']=="Female") echo "selected"; ?>>
        Female
        </option>

    </select>

    <br><br>

    <label>Phone</label><br>

    <input
        type="text"
        name="phone"
        value="<?php echo htmlspecialchars($row['phone']); ?>"
        required>

    <br><br>

    <label>Email</label><br>

    <input
        type="email"
        name="email"
        value="<?php echo htmlspecialchars($row['email']); ?>"
        required>

    <br><br>

    <label>Current Photo</label><br>

    <img src="uploads/<?php echo htmlspecialchars($row['photo']); ?>"
         width="120">

    <br><br>

    <label>Change Photo</label><br>

    <input type="file" name="photo">

    <br><br>

    <input type="submit" value="Update Student">

</form>

<br>

<a href="view_students.php">Back to Student List</a>

</body>
</html>