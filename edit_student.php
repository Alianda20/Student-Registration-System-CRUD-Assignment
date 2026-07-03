<?php

// Connect to the database
include("db.php");

// Get the student's ID from the URL
$id = $_GET['id'];

// Retrieve the student's details
$sql = "SELECT * FROM students WHERE id = $id";
$result = mysqli_query($conn, $sql);

// Store the student's data
$row = mysqli_fetch_assoc($result);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Student</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h2>Edit Student Details</h2>

<form action="update_student.php" method="POST">

    <!-- Hidden field to store student ID -->
    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

    <label>Registration Number</label><br>
    <input type="text" name="reg_no"
           value="<?php echo $row['reg_no']; ?>" required>

    <br><br>

    <label>Full Name</label><br>
    <input type="text" name="full_name"
           value="<?php echo $row['full_name']; ?>" required>

    <br><br>

    <label>Course</label><br>
    <input type="text" name="course"
           value="<?php echo $row['course']; ?>" required>

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

    <label>Email</label><br>

    <input type="email"
           name="email"
           value="<?php echo $row['email']; ?>"
           required>

    <br><br>

    <input type="submit" value="Update Student">

</form>

<br>

<a href="view_students.php">Back to Student List</a>

</body>
</html>