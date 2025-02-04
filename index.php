<?php
require 'db_connection.php';
session_start();
include "navbar.html"; // Include the navbar
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vehicle Finder</title>
    <style>
        /* Same styles as before */
        body {
            font-family: 'Arial', sans-serif;
            background: #f4f7fc;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 90%;
            max-width: 1200px;
            margin: 20px auto;
        }

        .header {
            text-align: center;
            padding: 20px;
            background: #333;
            color: #fff;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .header h1 {
            margin: 0;
            font-size: 2em;
        }

        .upload-link {
            display: inline-block;
            text-decoration: none;
            background: #ff5722;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            font-weight: bold;
            margin-top: 20px;
            transition: background 0.3s ease;
        }

        .upload-link:hover {
            background: #e64a19;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Find the Vehicle You Love the Most</h1>
            <?php if (isset($_SESSION['user_id'])): ?>
                <a class="upload-link" href="upload.php">Sell Your Vehicle</a>
            <?php else: ?>
                <a class="upload-link" href="login.php">Sell Your Vehicle</a>
            <?php endif; ?>

            <!-- Search form -->
            <form method="GET" action="search_results.php" style="text-align: center; margin-bottom: 20px;">
                <input type="text" name="search" placeholder="Search by vehicle type"
                    style="padding: 8px; width: 60%; border: 1px solid #ccc; border-radius: 5px;">
                <button type="submit"
                    style="padding: 8px 15px; background: #007BFF; color: white; border: none; border-radius: 5px; cursor: pointer;">Search</button>
            </form>
        </div>
</body>

</html>