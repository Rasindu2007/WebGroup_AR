<?php
require 'db_connection.php';
session_start();

// Check if the user is an admin
if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    die('Access denied');
}

// Validate the POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['file_id'])) {
    $file_id = intval($_POST['file_id']);

    // Delete related rows in the likes table
    $delete_likes_stmt = $conn->prepare("DELETE FROM likes WHERE file_id = ?");
    $delete_likes_stmt->bind_param("i", $file_id);
    $delete_likes_stmt->execute();
    $delete_likes_stmt->close();

    // Delete the file entry and the physical file
    $stmt = $conn->prepare("SELECT file_path FROM files WHERE file_id = ?");
    $stmt->bind_param("i", $file_id);
    $stmt->execute();
    $stmt->bind_result($file_path);
    if ($stmt->fetch()) {
        $stmt->close();

        // Delete the file from the file system
        if (file_exists($file_path)) {
            unlink($file_path);
        }

        // Remove the record from the database
        $delete_stmt = $conn->prepare("DELETE FROM files WHERE file_id = ?");
        $delete_stmt->bind_param("i", $file_id);
        $delete_stmt->execute();
        $delete_stmt->close();

        // Reassign file_id values to remain contiguous
        // Step 1: Create a temporary variable
        $conn->query("SET @rownum = 0");

        // Step 2: Update file_id to be contiguous
        $conn->query("UPDATE files SET file_id = (@rownum := @rownum + 1) ORDER BY file_id");
    }
    header("Location: index.php");
    exit;
} else {
    header("Location: index.php");
    exit;
}
?>