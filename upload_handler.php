<?php
require 'db_connection.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
    $targetDir = "uploads/";
    $fileName = basename($_FILES["file"]["name"]);
    $targetFilePath = $targetDir . $fileName;

    if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)) {
        $description = $_POST['description'];
        $carType = $_POST['car_type'];

        $sql = "INSERT INTO files (user_id, file_name, file_path, description, car_type) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("issss", $userId, $fileName, $targetFilePath, $description, $carType);

        if ($stmt->execute()) {
            header("Location: index.php");
            exit;
        } else {
            echo "<script>alert('Database error.'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('File upload error.'); window.history.back();</script>";
    }
}
?>