<!DOCTYPE html>
<html>
<head>
    <title>User Registration</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<h2>Create Account</h2>

<form action="save_user.php" method="POST">

<label>Full Name</label><br>
<input type="text" name="full_name" required>

<br><br>

<label>Email</label><br>
<input type="email" name="email" required>

<br><br>

<label>Password</label><br>
<input type="password" name="password" required>

<br><br>

<label>Confirm Password</label><br>
<input type="password" name="confirm_password" required>

<br><br>
<label>Role</label><br>

<select name="role" required>
    <option value="student">Student</option>
    <option value="admin">Administrator</option>
</select>

<br><br>

<input type="submit" value="Register">

</form>

<br>

<p>
Already have an account?
<a href="login.php">Login</a>
</p>

</body>
</html>