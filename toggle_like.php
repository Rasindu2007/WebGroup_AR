<?php
require 'db_connection.php';
session_start();

// Example: Simulate logged-in user
if (!isset($_SESSION['user_id'])) {
    $_SESSION['user_id'] = 1; // Replace with real user ID
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['file_id'])) {
    $file_id = intval($_GET['file_id']);

    // Check if the user already liked the post
    $stmt = $conn->prepare("SELECT * FROM likes WHERE file_id = ? AND user_id = ?");
    $stmt->bind_param("ii", $file_id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // User has already liked the post, remove the like (unlike)
        $delete_stmt = $conn->prepare("DELETE FROM likes WHERE file_id = ? AND user_id = ?");
        $delete_stmt->bind_param("ii", $file_id, $user_id);
        $delete_stmt->execute();
        $delete_stmt->close();

        // Update total likes count
        $update_likes = $conn->prepare("UPDATE files SET likes = likes - 1 WHERE file_id = ?");
        $update_likes->bind_param("i", $file_id);
        $update_likes->execute();
        $update_likes->close();

        echo json_encode(['success' => true, 'action' => 'unlike']);
    } else {
        // User has not liked the post, add a like
        $insert_stmt = $conn->prepare("INSERT INTO likes (file_id, user_id) VALUES (?, ?)");
        $insert_stmt->bind_param("ii", $file_id, $user_id);
        $insert_stmt->execute();
        $insert_stmt->close();

        // Update total likes count
        $update_likes = $conn->prepare("UPDATE files SET likes = likes + 1 WHERE file_id = ?");
        $update_likes->bind_param("i", $file_id);
        $update_likes->execute();
        $update_likes->close();

        echo json_encode(['success' => true, 'action' => 'like']);
    }
    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}
