<?php
$message = '';
$alertType = '';
$dbName = 'zia-lab';

try {
    $conn = new mysqli('localhost', 'root', '', $dbName);

    if ($conn->connect_error) {
        throw new Exception($conn->connect_error);
    }

    $sql = "CREATE TABLE IF NOT EXISTS students (
                id INT PRIMARY KEY AUTO_INCREMENT,
                full_name VARCHAR(100) NOT NULL,
                email VARCHAR(120) NOT NULL,
                department VARCHAR(80) NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )";

    if ($conn->query($sql) === TRUE) {
        $message = "The students table is ready in the '$dbName' database.";
        $alertType = 'success';
    } else {
        throw new Exception($conn->error);
    }

    $conn->close();
} catch (Exception $e) {
    $message = 'Database Error: ' . $e->getMessage();
    $alertType = 'danger';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Students Table Setup</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Part B – Students Table Setup</h1>

        <?php if (!empty($message)): ?>
            <div class="alert alert-<?php echo $alertType; ?> alert-dismissible fade show" role="alert">
                <?php echo htmlspecialchars($message); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="card shadow-sm">
            <div class="card-body">
                <p>
                    Database:
                    <strong><?php echo htmlspecialchars($dbName); ?></strong>
                </p>

                <p>
                    Use the button below to make sure the
                    <code>students</code> table exists.
                </p>

                <form method="POST" action="">
                    <button type="submit" class="btn btn-primary">
                        Set Up Students Table
                    </button>
                </form>

                <p class="mt-3 text-muted small">
                    <strong>Note:</strong> The table will not be recreated if it already exists.
                </p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
