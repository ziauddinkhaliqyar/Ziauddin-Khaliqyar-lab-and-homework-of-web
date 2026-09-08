<?php
$message = '';
$alertType = '';
$formData = ['full_name' => '', 'email' => '', 'department' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullName   = trim($_POST['full_name'] ?? '');
    $email      = trim($_POST['email'] ?? '');
    $department = trim($_POST['department'] ?? '');

    if ($fullName === '' || $email === '' || $department === '') {
        $message = 'Please complete all required fields.';
        $alertType = 'danger';
        $formData = [
            'full_name' => $fullName,
            'email' => $email,
            'department' => $department
        ];
    } else {
        $dbName = 'zia-lab';

        try {
            $conn = new mysqli('localhost', 'root', '', $dbName);

            if ($conn->connect_error) {
                throw new Exception($conn->connect_error);
            }

            $stmt = $conn->prepare(
                "INSERT INTO students (full_name, email, department) VALUES (?, ?, ?)"
            );

            if ($stmt === false) {
                throw new Exception($conn->error);
            }

            $stmt->bind_param('sss', $fullName, $email, $department);

            if ($stmt->execute()) {
                $message = "Student '$fullName' was added to the database.";
                $alertType = 'success';
                $formData = [
                    'full_name' => '',
                    'email' => '',
                    'department' => ''
                ];
            } else {
                throw new Exception($stmt->error);
            }

            $stmt->close();
            $conn->close();
        } catch (Exception $e) {
            $message = 'Database Error: ' . $e->getMessage();
            $alertType = 'danger';
            $formData = [
                'full_name' => $fullName,
                'email' => $email,
                'department' => $department
            ];
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Student Record</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Part C – Add Student</h1>

        <?php if (!empty($message)): ?>
            <div class="alert alert-<?php echo $alertType; ?> alert-dismissible fade show" role="alert">
                <?php echo htmlspecialchars($message); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="card shadow-sm">
            <div class="card-body">
                <form method="POST" action="">
                    <div class="mb-3">
                        <label for="full_name" class="form-label">Student Name</label>
                        <input
                            type="text"
                            class="form-control"
                            id="full_name"
                            name="full_name"
                            value="<?php echo htmlspecialchars($formData['full_name']); ?>"
                            required
                        >
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input
                            type="email"
                            class="form-control"
                            id="email"
                            name="email"
                            value="<?php echo htmlspecialchars($formData['email']); ?>"
                            required
                        >
                    </div>

                    <div class="mb-3">
                        <label for="department" class="form-label">Department</label>
                        <input
                            type="text"
                            class="form-control"
                            id="department"
                            name="department"
                            value="<?php echo htmlspecialchars($formData['department']); ?>"
                            required
                        >
                    </div>

                    <button type="submit" class="btn btn-success">Add Student</button>
                    <button type="reset" class="btn btn-outline-secondary">Reset Form</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
