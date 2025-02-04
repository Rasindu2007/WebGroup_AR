<?php
require 'db_connection.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $file_id = $_POST['file_id'];
    $user_id = 1; // Replace this with the logged-in user's ID.
    $comment = $_POST['comment'];

    $stmt = $conn->prepare("INSERT INTO comments (file_id, user_id, comment) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $file_id, $user_id, $comment);

    if ($stmt->execute()) {
        header("Location: index.php");
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>