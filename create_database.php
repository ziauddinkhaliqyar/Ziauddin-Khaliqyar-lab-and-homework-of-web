<?php
/**
 * Part A – Create Database
 * Uses MySQLi Object-Oriented with exception handling.
 */
$message = '';
$alertType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $databaseName = trim($_POST['database_name']);

    // Validate: only letters, numbers, underscores
    if (!preg_match('/^[a-zA-Z0-9_]+$/', $databaseName)) {
        $message = 'Invalid database name. Only letters, numbers, underscores allowed.';
        $alertType = 'danger';
    } else {
        try {
            // Connect to MySQL (no database selected)
            $conn = new mysqli('localhost', 'root', '');

            if ($conn->connect_error) {
                throw new Exception($conn->connect_error);
            }

            $sql = "CREATE DATABASE IF NOT EXISTS `$databaseName`";

            if ($conn->query($sql) === TRUE) {
                $message = "Database '$databaseName' created successfully (or already exists).";
                $alertType = 'success';

                // Store in session for later use (optional)
                session_start();
                $_SESSION['db_name'] = $databaseName;
            } else {
                throw new Exception($conn->error);
            }

            $conn->close();

        } catch (Exception $e) {
            $message = 'Error: ' . $e->getMessage();
            $alertType = 'danger';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Create Database</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f4f6f9;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: Arial, sans-serif;
        }

        .database-container {
            width: 100%;
            max-width: 520px;
            padding: 20px;
        }

        .database-card {
            background: #ffffff;
            border: none;
            border-radius: 16px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }

        .card-header-custom {
            background: #0d6efd;
            color: #ffffff;
            padding: 25px;
            text-align: center;
        }

        .card-header-custom h1 {
            font-size: 24px;
            margin: 0;
            font-weight: 600;
        }

        .card-header-custom p {
            margin: 7px 0 0;
            opacity: 0.9;
            font-size: 14px;
        }

        .card-body {
            padding: 30px;
        }

        .form-label {
            font-weight: 600;
            color: #343a40;
        }

        .form-control {
            height: 48px;
            border-radius: 10px;
            border: 1px solid #ced4da;
        }

        .form-control:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.15);
        }

        .form-text {
            margin-top: 8px;
            color: #6c757d;
        }

        .create-btn {
            width: 100%;
            height: 48px;
            border-radius: 10px;
            font-weight: 600;
            margin-top: 10px;
        }

        .alert {
            border-radius: 10px;
        }

        .footer-text {
            text-align: center;
            margin-top: 18px;
            color: #6c757d;
            font-size: 13px;
        }
    </style>
</head>

<body>

<div class="database-container">

    <div class="database-card">

        <div class="card-header-custom">
            <h1>Create Database</h1>
            <p>Enter a name to create your MySQL database</p>
        </div>

        <div class="card-body">

            <?php if ($message): ?>
                <div class="alert alert-<?php echo $alertType; ?> alert-dismissible fade show" role="alert">
                    <?php echo htmlspecialchars($message); ?>

                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="alert"
                            aria-label="Close">
                    </button>
                </div>
            <?php endif; ?>

            <form method="POST" action="">

                <div class="mb-3">
                    <label for="database_name" class="form-label">
                        Database Name
                    </label>

                    <input
                        type="text"
                        class="form-control"
                        id="database_name"
                        name="database_name"
                        placeholder="e.g., wis_lab"
                        required
                        pattern="[A-Za-z0-9_]+"
                        title="Only letters, numbers, and underscores allowed."
                    >

                    <div class="form-text">
                        Allowed: letters, numbers, and underscores.
                    </div>
                </div>

                <button type="submit" class="btn btn-primary create-btn">
                    Create Database
                </button>

            </form>

            <div class="footer-text">
                MySQL Database Management
            </div>

        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
