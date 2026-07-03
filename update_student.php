<?php

// Connect to the database
include("db.php");

// Receive updated data
$id = $_POST['id'];
$reg_no = $_POST['reg_no'];
$full_name = $_POST['full_name'];
$course = $_POST['course'];
$gender = $_POST['gender'];
$email = $_POST['email'];

// SQL query to update the record
$sql = "UPDATE students SET

reg_no='$reg_no',
full_name='$full_name',
course='$course',
gender='$gender',
email='$email'

WHERE id=$id";

// Execute the query
if(mysqli_query($conn, $sql))
{
    // Redirect to student list
    header("Location: view_students.php");
    exit();
}
else
{
    echo "Update failed: " . mysqli_error($conn);
}

?>