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
include("log_activity.php");

// Receive form data
$reg_no = trim($_POST['reg_no']);
$full_name = trim($_POST['full_name']);
$course = trim($_POST['course']);
$gender = trim($_POST['gender']);
$phone = trim($_POST['phone']);
$email = trim($_POST['email']);

// Validation
if (empty($full_name)) {
    die("Student name cannot be empty.");
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("Invalid email address.");
}

if (!preg_match('/^[0-9]{10,15}$/', $phone)) {
    die("Invalid phone number.");
}

if (empty($course)) {
    die("Please select a course.");
}

// Handle photo upload
$photo = $_POST['old_photo'];

if (!empty($_FILES['photo']['name'])) {

    $photo = $_FILES['photo']['name'];
    $tmp = $_FILES['photo']['tmp_name'];

    $extension = strtolower(pathinfo($photo, PATHINFO_EXTENSION));

    if (
        $extension != "jpg" &&
        $extension != "jpeg" &&
        $extension != "png"
    ) {
        die("Only JPG, JPEG and PNG files are allowed.");
    }

    move_uploaded_file($tmp, "uploads/" . $photo);
}

// Update student

$stmt = $conn->prepare("
UPDATE students
SET
full_name=?,
course=?,
gender=?,
phone=?,
email=?,
photo=?
WHERE reg_no=?
");

$stmt->bind_param(
    "sssssss",
    $full_name,
    $course,
    $gender,
    $phone,
    $email,
    $photo,
    $reg_no
);

if ($stmt->execute()) {

    echo "<h2>Student Updated Successfully!</h2>";

    echo "<br>";

    echo "<a href='view_students.php'>View Students</a>";

} else {

    echo "Error: " . $stmt->error;

}
logActivity($conn, $_SESSION['user'], "Updated Student: $reg_no");

$stmt->close();
$conn->close();

?>