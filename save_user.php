<?php

include("db.php");

// Receive form data
$fullname = $_POST['full_name'];
$email = $_POST['email'];
$password = $_POST['password'];
$confirm = $_POST['confirm_password'];
$role = $_POST['role'];

// Check if passwords match
if($password != $confirm){
    die("Passwords do not match!");
}

// Check if the email already exists
$check = "SELECT * FROM users WHERE email='$email'";
$result = mysqli_query($conn, $check);

if(mysqli_num_rows($result) > 0){
    die("Email already exists. Please use another email.");
}

// Hash the password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Insert user into the database
$sql = "INSERT INTO users(full_name, email, password, role)
VALUES('$fullname', '$email', '$hashed_password', '$role')";

if(mysqli_query($conn, $sql)){

    echo "<h2>Registration Successful!</h2>";

    echo "<a href='login.php'>Click here to Login</a>";

}
else{

    echo "Registration Failed: " . mysqli_error($conn);

}

mysqli_close($conn);

?>