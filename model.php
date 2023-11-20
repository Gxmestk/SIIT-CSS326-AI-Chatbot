<?php
// Start the session and include the database connection
session_start();
require 'db.php';

// Initialize an array to store model data
$modelData = [];

// Prepare the SQL query using the view
$sql = "SELECT * FROM model_feedback_summary"; // Replace with your actual view name
$result = $conn->query($sql);

if ($result) {
    // Fetch all rows from the view
    while ($row = $result->fetch_assoc()) {
        $modelData[] = $row;
    }
} else {
    echo "Error: " . $conn->error;
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Model Information</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet"> <!-- Link to your CSS file -->
</head>
<body>
    <div class="container mt-4">
        <h2>Model Information</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Model Name</th>
                    <th>Version</th>
                    <th>Description</th>
                    <th>Date Added</th>
                    <th>Upvote Counts</th>
                    <th>Downvote Counts</th>
                    <th>Latest Comments</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($modelData as $model): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($model['model_name']); ?></td>
                        <td><?php echo htmlspecialchars($model['version']); ?></td>
                        <td><?php echo htmlspecialchars($model['description']); ?></td>
                        <td><?php echo htmlspecialchars($model['date_added']); ?></td>
                        <td><?php echo htmlspecialchars($model['upvote_count']); ?></td>
                        <td><?php echo htmlspecialchars($model['downvote_count']); ?></td>
                        <?php
                            // split string htmlspecialchars($model['latest_comments']) by ||
                            $comments = explode("||", htmlspecialchars($model['latest_comments']));
                        ?>
                        <td>
                            <?php foreach ($comments as $comment): ?>
                                <p><?php echo $comment; ?></p>
                            <?php endforeach; ?>
                    </tr>
                    
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
