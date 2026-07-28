<?php

include("db.php");

$search = "";

if(isset($_GET['search'])){

    $search = "%" . trim($_GET['search']) . "%";

}

$stmt = $conn->prepare("
SELECT *
FROM students
WHERE full_name LIKE ?
OR course LIKE ?
");

$stmt->bind_param("ss",$search,$search);

$stmt->execute();

$result = $stmt->get_result();

echo "<table border='1' cellpadding='10'>";

echo "<tr>";

echo "<th>Photo</th>";
echo "<th>Reg No</th>";
echo "<th>Name</th>";
echo "<th>Course</th>";
echo "<th>Email</th>";

echo "</tr>";

while($row=$result->fetch_assoc()){

echo "<tr>";

echo "<td><img src='uploads/".htmlspecialchars($row['photo'])."' width='70'></td>";

echo "<td>".htmlspecialchars($row['reg_no'])."</td>";

echo "<td>".htmlspecialchars($row['full_name'])."</td>";

echo "<td>".htmlspecialchars($row['course'])."</td>";

echo "<td>".htmlspecialchars($row['email'])."</td>";

echo "</tr>";

}

echo "</table>";

$stmt->close();

$conn->close();

?>