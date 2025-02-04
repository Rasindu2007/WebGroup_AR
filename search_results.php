<?php
require 'db_connection.php';
session_start();
include "navbar.html"; // Include the navbar

$searchTerm = isset($_GET['search']) ? trim($_GET['search']) : '';

if ($searchTerm) {
    $sql = "SELECT * FROM files WHERE car_type LIKE ? ORDER BY uploaded_at DESC";
    $stmt = $conn->prepare($sql);
    $likeTerm = '%' . $searchTerm . '%';
    $stmt->bind_param('s', $likeTerm);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = null; // No search term provided
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
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

        .card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            overflow: hidden;
        }

        .card img {
            width: 100%;
            max-height: auto;
            object-fit: cover;
            border-bottom: 1px solid #ddd;
        }

        .card-body {
            padding: 20px;
        }

        .card-title {
            font-size: 1.2em;
            font-weight: bold;
            color: #333;
        }

        .card-description {
            margin-top: 10px;
            color: #555;
        }

        .card-meta {
            margin-top: 15px;
            font-size: 0.9em;
            color: #777;
        }

        .card-actions {
            margin-top: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .like-section {
            display: flex;
            align-items: center;
            font-size: 1.2em;
            color: #ff5252;
            cursor: pointer;
            transition: color 0.3s ease;
        }

        .like-section span {
            margin-left: 5px;
            font-size: 1em;
            color: #555;
        }

        .like-section:hover {
            color: #ff1744;
        }

        .liked {
            color: #ff1744;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Search Results</h1>
            <p>Showing results for "<?= htmlspecialchars($searchTerm) ?>"</p>
        </div>

        <?php if ($result && $result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="card">
                    <img src="<?= htmlspecialchars($row['file_path']) ?>" alt="Uploaded Image">
                    <div class="card-body">
                        <div class="card-title">Vehicle Type: <?= htmlspecialchars($row['car_type']) ?></div>
                        <div class="card-meta">Uploaded by: <?= htmlspecialchars($row['uploader_name']) ?> (<?= htmlspecialchars($row['uploader_phone']) ?>)</div>
                        <div class="card-meta">Uploaded At: <?= $row['uploaded_at'] ?></div>
                        <div class="card-description" style="white-space: pre-line; line-height: 0.8;">
                            Vehicle Details: <br><br><?= nl2br(htmlspecialchars($row["description"])) ?>
                        </div>
                        <div class="card-actions">
                            <div class="like-section" onclick="toggleLike(<?= $row['file_id'] ?>, this)">
                                ❤️ <span><?= $row['likes'] ?></span>
                            </div>
                            <?php if ($_SESSION['is_admin']): ?>
                                <form method="POST" action="delete_post.php" style="display:inline;">
                                    <input type="hidden" name="file_id" value="<?= $row['file_id'] ?>">
                                    <button type="submit" class="delete-button">Delete</button>
                                </form>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No results found for "<?= htmlspecialchars($searchTerm) ?>".</p>
        <?php endif; ?>
    </div>
</body>

</html>