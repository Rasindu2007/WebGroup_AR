<?php
include "db_connection.php";

// Fetch files from the database with optional search filter
$searchTerm = isset($_GET['search']) ? trim($_GET['search']) : '';

if ($searchTerm) {
    $sql = "SELECT * FROM files WHERE car_type LIKE ? ORDER BY uploaded_at DESC";
    $stmt = $conn->prepare($sql);
    $likeTerm = '%' . $searchTerm . '%';
    $stmt->bind_param('s', $likeTerm);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $sql = "SELECT * FROM files ORDER BY uploaded_at DESC";
    $result = $conn->query($sql);
}

?>