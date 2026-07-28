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

$reg_no = $_GET['reg_no'];

$stmt = $conn->prepare("DELETE FROM students WHERE reg_no=?");

$stmt->bind_param("s", $reg_no);

if ($stmt->execute()) {

    header("Location: view_students.php");
    exit();

} else {

    echo "Delete Failed.";

}
logActivity($conn, $_SESSION['user'], "Deleted Student: $reg_no");

$stmt->close();
$conn->close();

?>