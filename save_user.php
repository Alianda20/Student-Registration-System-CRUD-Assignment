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
$stmt = $conn->prepare("INSERT INTO users(full_name,email,password,role) VALUES(?,?,?,?)");

$stmt->bind_param("ssss", $fullname, $email, $hashed_password, $role);

if($stmt->execute()){
    echo "Registration Successful";
}else{
    echo "Registration Failed";
}

$stmt->close();

mysqli_close($conn);

?>