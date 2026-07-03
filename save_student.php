<?php

// Include the database connection
include("db.php");

// Receive data from the form
$reg_no = $_POST['reg_no'];
$full_name = $_POST['full_name'];
$course = $_POST['course'];
$gender = $_POST['gender'];
$email = $_POST['email'];

// SQL query to insert data
$sql = "INSERT INTO students (reg_no, full_name, course, gender, email)
VALUES ('$reg_no', '$full_name', '$course', '$gender', '$email')";

// Execute the query
if (mysqli_query($conn, $sql)) {
    echo "<h2>Student Registered Successfully!</h2>";

    echo "<a href='add_student.php'>Register Another Student</a><br><br>";

    echo "<a href='view_students.php'>View Students</a>";
} else {
    echo "Error: " . mysqli_error($conn);
}

// Close the database connection
mysqli_close($conn);

?>