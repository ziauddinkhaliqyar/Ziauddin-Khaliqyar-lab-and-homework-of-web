<?php

include "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $full_name = trim($_POST["full_name"]);
    $father_name = trim($_POST["father_name"]);
    $email = trim($_POST["email"]);
    $phone = trim($_POST["phone"]);
    $program = trim($_POST["program"]);

    if (
        empty($full_name) ||
        empty($father_name) ||
        empty($email) ||
        empty($phone) ||
        empty($program)
    ) {
        die("All fields are required.");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email address.");
    }

    $stmt = $conn->prepare(
        "INSERT INTO applications 
        (full_name, father_name, email, phone, program)
        VALUES (?, ?, ?, ?, ?)"
    );

    $stmt->bind_param(
        "sssss",
        $full_name,
        $father_name,
        $email,
        $phone,
        $program
    );

    if ($stmt->execute()) {
        header("Location: admission.php");
        exit();
    } else {
        die("Error saving application: " . $stmt->error);
    }

    $stmt->close();
}


/* Retrieve all applications */

$result = $conn->query(
    "SELECT * FROM applications ORDER BY id DESC"
);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Student Admission Application</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

</head>

<body>

<div class="container mt-5">

    <div class="card shadow">

        <div class="card-body">

            <h2 class="text-center mb-4">
                Student Admission Application
            </h2>

            <form method="post">

                <div class="mb-3">

                    <label for="full_name" class="form-label">
                        Full Name
                    </label>

                    <input
                        type="text"
                        class="form-control"
                        id="full_name"
                        name="full_name"
                        required
                    >

                </div>


                <div class="mb-3">

                    <label for="father_name" class="form-label">
                        Father's Name
                    </label>

                    <input
                        type="text"
                        class="form-control"
                        id="father_name"
                        name="father_name"
                        required
                    >

                </div>


                <div class="mb-3">

                    <label for="email" class="form-label">
                        Email
                    </label>

                    <input
                        type="email"
                        class="form-control"
                        id="email"
                        name="email"
                        required
                    >

                </div>


                <div class="mb-3">

                    <label for="phone" class="form-label">
                        Phone
                    </label>

                    <input
                        type="tel"
                        class="form-control"
                        id="phone"
                        name="phone"
                        required
                    >

                </div>


                <div class="mb-3">

                    <label for="program" class="form-label">
                        Program
                    </label>

                    <select
                        class="form-select"
                        id="program"
                        name="program"
                        required
                    >

                        <option value="">
                            Select Program
                        </option>

                        <option value="Information Systems">
                            Information Systems
                        </option>

                        <option value="Software Engineering">
                            Software Engineering
                        </option>

                        <option value="Computer Science">
                            Computer Science
                        </option>

                    </select>

                </div>


                <button
                    type="submit"
                    class="btn btn-primary w-100"
                >
                    Submit Application
                </button>

            </form>

        </div>

    </div>


    <!-- Submitted Applications -->

    <h2 class="mt-5 mb-3">
        Submitted Applications
    </h2>


    <div class="table-responsive">

        <table class="table table-bordered table-striped table-hover">

            <thead class="table-hover   table-success">

                <tr>

                    <th>ID</th>
                    <th>Full Name</th>
                    <th>Father's Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Program</th>

                </tr>

            </thead>

            <tbody>

            <?php while ($row = $result->fetch_assoc()) { ?>

                <tr>

                    <td>
                        <?php echo htmlspecialchars($row["id"]); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($row["full_name"]); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($row["father_name"]); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($row["email"]); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($row["phone"]); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($row["program"]); ?>
                    </td>

                </tr>

            <?php } ?>

            </tbody>

        </table>

    </div>

</div>

</body>
</html>