<!DOCTYPE html>
<html>
<head>
    <title>Add Student</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<h2>Student Registration Form</h2>

<form action="save_student.php" method="POST">

    <label>Registration Number</label><br>
    <input type="text" name="reg_no" required><br><br>

    <label>Full Name</label><br>
    <input type="text" name="full_name" required><br><br>

    <label>Course</label><br>
    <input type="text" name="course" required><br><br>

    <label>Gender</label><br>

    <select name="gender" required>
        <option value="">--Select Gender--</option>
        <option>Male</option>
        <option>Female</option>
    </select>

    <br><br>

    <label>Email</label><br>
    <input type="email" name="email" required>

    <br><br>

    <input type="submit" value="Register Student">

</form>

<br>

<a href="index.php">Home</a>

</body>
</html>