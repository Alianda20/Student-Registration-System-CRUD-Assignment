<?php

// Start a session
session_start();

// Connect to the database
include("db.php");

// Receive form data
$email = $_POST['email'];
$password = $_POST['password'];

// Find the user by email
$sql = "SELECT * FROM users WHERE email='$email'";
$result = mysqli_query($conn, $sql);

// Check if the user exists
if(mysqli_num_rows($result) > 0){

    // Get the user's data
    $user = mysqli_fetch_assoc($result);

    // Verify the password
    if(password_verify($password, $user['password'])){

        // Store user information in the session
        $_SESSION['user'] = $user['full_name'];
        $_SESSION['role'] = $user['role'];

        // Redirect to the student list
        header("Location: view_students.php");
        exit();

    }else{

        echo "<h3>Incorrect Password!</h3>";
        echo "<a href='login.php'>Try Again</a>";

    }

}else{

    echo "<h3>User Not Found!</h3>";
    echo "<a href='register.php'>Create an Account</a>";

}

mysqli_close($conn);

?>