<?php

session_start();

include("db.php");
include("log_activity.php");

if(isset($_SESSION['user'])){
    logActivity($conn, $_SESSION['user'], "Logged Out");
}

session_destroy();

header("Location: login.php");
exit();

?>