<?php
session_start();

// Ensure user is logged in
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

// Only administrators can add students
if ($_SESSION['role'] != "admin") {
    die("Access Denied");
}

include("db.php");
include("log_activity.php");

// =======================
// RECEIVE FORM DATA
// =======================

$reg_no = trim($_POST['reg_no']);
$full_name = trim($_POST['full_name']);
$course = trim($_POST['course']);
$gender = trim($_POST['gender']);
$phone = trim($_POST['phone']);
$email = trim($_POST['email']);


// =======================
// VALIDATION
// =======================

// Name
if (empty($full_name)) {
    die("Student name cannot be empty.");
}

// Course
if (empty($course)) {
    die("Please select a course.");
}

// Email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("Invalid email address.");
}

// Phone (10–15 digits)
if (!preg_match('/^[0-9]{10,15}$/', $phone)) {
    die("Invalid phone number.");
}


// =======================
// CHECK DUPLICATE REG NO
// =======================

$check = $conn->prepare("SELECT reg_no FROM students WHERE reg_no=?");
$check->bind_param("s", $reg_no);
$check->execute();
$result = $check->get_result();

if ($result->num_rows > 0) {
    die("Registration number already exists.");
}

$check->close();


// =======================
// PHOTO UPLOAD
// =======================

$photo = $_FILES['photo']['name'];
$tmp = $_FILES['photo']['tmp_name'];

if (!empty($photo)) {

    $extension = strtolower(pathinfo($photo, PATHINFO_EXTENSION));

    if (
        $extension != "jpg" &&
        $extension != "jpeg" &&
        $extension != "png"
    ) {
        die("Only JPG, JPEG and PNG files are allowed.");
    }

    if ($_FILES['photo']['size'] > 2 * 1024 * 1024) {
        die("Image size must not exceed 2 MB.");
    }

    move_uploaded_file($tmp, "uploads/" . $photo);
}


// =======================
// INSERT STUDENT
// =======================

$stmt = $conn->prepare("
INSERT INTO students
(reg_no, full_name, course, gender, phone, email, photo)
VALUES (?, ?, ?, ?, ?, ?, ?)
");

$stmt->bind_param(
    "sssssss",
    $reg_no,
    $full_name,
    $course,
    $gender,
    $phone,
    $email,
    $photo
);

if ($stmt->execute()) {

    echo "<h2>Student Registered Successfully!</h2>";

    echo "<br>";

    echo "<a href='add_student.php'>Register Another Student</a>";

    echo "<br><br>";

    echo "<a href='view_students.php'>View Students</a>";

} else {

    echo "Error: " . $stmt->error;

}
logActivity($conn, $_SESSION['user'], "Added Student");

$stmt->close();
$conn->close();

?>