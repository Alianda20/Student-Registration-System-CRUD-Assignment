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

// Check if the ID is provided
if(isset($_GET['id'])){

    $id = $_GET['id'];

    // SQL query to delete the student
    $sql = "DELETE FROM students WHERE id = $id";

    if(mysqli_query($conn, $sql)){
        // Redirect back to the student list
        header("Location: view_students.php");
        exit();
    }
    else{
        echo "Error deleting record: " . mysqli_error($conn);
    }

}
else{
    echo "No student selected.";
}

mysqli_close($conn);

?>