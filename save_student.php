<?php

session_start();

if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}
if($_SESSION['role'] != "admin"){
    die("Access Denied");
}

include("db.php");

// Receive data from the form
$reg_no = $_POST['reg_no'];
$full_name = $_POST['full_name'];
$course = $_POST['course'];
$gender = $_POST['gender'];
$email = $_POST['email'];
$photo = $_FILES['photo']['name'];
$tmp = $_FILES['photo']['tmp_name'];

$type = strtolower(pathinfo($photo, PATHINFO_EXTENSION));

if($type != "jpg" && $type != "jpeg" && $type != "png"){
    die("Invalid file. Only JPG, JPEG and PNG are allowed.");
}

if($_FILES['photo']['size'] > 2 * 1024 * 1024){
    die("File size must not exceed 2MB.");
}

move_uploaded_file($tmp, "uploads/" . $photo);

// SQL query to insert data
$sql = "INSERT INTO students (reg_no, full_name, course, gender, email, photo)
VALUES ('$reg_no', '$full_name', '$course', '$gender', '$email', '$photo')";;

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