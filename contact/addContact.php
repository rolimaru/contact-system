<?php
session_start();
include "../db_conn.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $company = $_POST['company'];
    $email = $_POST['email'];
    $user_id = $_SESSION['user_id']; // Get user ID from session

    $sql = "INSERT INTO `contact` (`name`, `phone`, `company`, `email`, `user_id`) VALUES (?, ?, ?, ?, ?)";
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "ssssi", $name, $phone, $company, $email, $user_id);
        if (mysqli_stmt_execute($stmt)) {
            header("Location: index.php?msg=New Contact Added");
            exit();
        } else {
            die("Error: Could not execute the query: " . mysqli_error($conn));
        }
        mysqli_stmt_close($stmt);
    } else {
        die("Error: Could not prepare the query: " . mysqli_error($conn));
    }

    mysqli_close($conn);
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Contact</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

</head>

<body>
    <div class="container mt-5">
        <a href="index.php" class="btn btn-secondary mb-3">
            <i class="bi bi-arrow-left"></i> Back
        </a>
        <h2>Add New Contact</h2>

        <form action="" method="POST">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter name" required>
            </div>
            <div class="mb-3">
                <label for="company" class="form-label">Company</label>
                <input type="text" class="form-control" id="company" name="company" placeholder="Enter company" required>
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Phone</label>
                <input type="tel" class="form-control" id="phone" name="phone" placeholder="Enter phone" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" required>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Add Contact</button>
        </form>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>