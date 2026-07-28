
<a href="view_students.php">View Students</a>

<?php if($_SESSION['role']=="admin"){ ?>

| <a href="add_student.php">Add Student</a>
| <a href="logs.php">Activity Logs</a>

<?php } ?>

| <a href="search.php">Search Students</a>
| <a href="change_password.php">Change Password</a>
| <a href="logout.php">Logout</a>