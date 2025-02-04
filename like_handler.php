<?php
require 'db_connection.php';

$data = json_decode(file_get_contents("php://input"), true);
$fileId = intval($data['fileId']);
$action = $data['action'];

if ($action === 'like') {
    $sql = "UPDATE files SET likes = likes + 1 WHERE file_id = ?";
} else {
    $sql = "UPDATE files SET likes = likes - 1 WHERE file_id = ?";
}

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $fileId);

if ($stmt->execute()) {
    $result = $conn->query("SELECT likes FROM files WHERE file_id = $fileId");
    $row = $result->fetch_assoc();
    echo json_encode(["success" => true, "likes" => $row['likes']]);
} else {
    echo json_encode(["success" => false]);
}
?>