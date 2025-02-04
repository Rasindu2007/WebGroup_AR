<?php
include 'server.php';

$term = strtolower($_GET['term']);
$stmt = $conn->prepare("SELECT * FROM cars WHERE LOWER(carDescription) LIKE ?");
$searchTerm = "%" . $term . "%";
$stmt->bind_param("s", $searchTerm);
$stmt->execute();
$result = $stmt->get_result();
$cars = [];
while ($row = $result->fetch_assoc()) {
    $cars[] = $row;
}
echo json_encode(value: $cars);

$stmt->close();
$conn->close();
?>