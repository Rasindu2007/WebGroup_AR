<?php
require 'db_connection.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

include "navbar.html";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload File</title>
</head>

<body>
    <div class="container">
        <h2>Sell your Vehicle</h2><br><br><br><br>
        <form action="upload_handler.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="user_id" value="<?= $_SESSION['user_id'] ?>">
            <input type="text" name="car_type" placeholder="Vehicle Model Name" required>
            <textarea name="description" placeholder="Description of the vehicle"></textarea>
            <input type="file" name="file" required>
            <button type="submit">Upload</button>
        </form>
    </div>
</body>

</html>