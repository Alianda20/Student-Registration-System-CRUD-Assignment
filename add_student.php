<?php
session_start();

if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}
if($_SESSION['role'] != "admin"){
    die("Access Denied");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Student</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<?php include("menu.php"); ?>

<h2>Student Registration Form</h2>


<form
action="save_student.php"
method="POST"
enctype="multipart/form-data"
onsubmit="return validateForm()">

    <label>Registration Number</label><br>
    <input type="text" id="reg_no" name="reg_no" required><br><br>

    <label>Full Name</label><br>
    <input type="text" id="full_name" name="full_name" required><br><br>

    <label>Course</label><br>
    <input type="text" id="course" name="course" required><br><br>

    <label>Gender</label><br>

    <select id="gender" name="gender" required>
        <option value="">--Select Gender--</option>
        <option>Male</option>
        <option>Female</option>
    </select>

    <br><br>
    <label>Phone Number</label><br>
<input
    type="text"
    name="phone"
    id="phone"
    required>

    <label>Email</label><br>
    <input type="email" id="email" name="email" required>

    <br><br>
    <br><br>

<label>Student Photo</label><br>
<input type="file" id="photo" name="photo" accept=".jpg,.jpeg,.png" required>

<br><br>

    <input type="submit" value="Register Student">

</form>

<br>

<a href="index.php">Home</a>
<script>

function validateForm(){

let reg=document.getElementById("reg_no").value.trim();

let name=document.getElementById("full_name").value.trim();

let course=document.getElementById("course").value;

let phone=document.getElementById("phone").value.trim();

let email=document.getElementById("email").value.trim();

if(reg==""){
alert("Registration Number is required");
return false;
}

if(name==""){
alert("Student Name is required");
return false;
}

if(course==""){
alert("Please select a course");
return false;
}

let phonePattern=/^[0-9]{10}$/;

if(!phonePattern.test(phone)){
alert("Phone number must contain exactly 10 digits");
return false;
}

let emailPattern=/^[^\s@]+@[^\s@]+\.[^\s@]+$/;

if(!emailPattern.test(email)){
alert("Enter a valid email");
return false;
}

return true;

}

</script>

</body>
</html>