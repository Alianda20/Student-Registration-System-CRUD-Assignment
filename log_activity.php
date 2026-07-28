<?php

function logActivity($conn, $user, $activity)
{
    $date = date("Y-m-d");
    $time = date("H:i:s");

    $stmt = $conn->prepare(
        "INSERT INTO logs(user, activity, date, time)
         VALUES (?, ?, ?, ?)"
    );

    $stmt->bind_param("ssss", $user, $activity, $date, $time);

    $stmt->execute();

    $stmt->close();
}

?>