<hr>

<a href="view_students.php">Home</a>

<?php if($_SESSION['role'] == "admin"){ ?>
|
<a href="add_student.php">Add Student</a>
<?php } ?>

|
<a href="view_students.php">View Students</a>

|
<a href="view_students.php">Search Students</a>

|
<a href="logout.php">Logout</a>

<hr>