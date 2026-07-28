<?php
session_start();

if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>

<title>Live Student Search</title>

<link rel="stylesheet" href="style.css">

</head>

<body>

<?php include("menu.php"); ?>

<h2>Live Student Search</h2>

<input
type="text"
id="search"
placeholder="Type student name or course...">

<br><br>

<div id="result">

</div>

<script src="script.js"></script>

</body>

</html>