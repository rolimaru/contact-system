<?php
include "../db_conn.php";

$query = isset($_POST['query']) ? $_POST['query'] : '';
$user_id = $_SESSION['user_id']; // Ensure the user is logged in and user_id is set

$sql = "SELECT * FROM `contact` WHERE `user_id` = ? AND (
            `name` LIKE ? OR 
            `company` LIKE ? OR 
            `phone` LIKE ? OR 
            `email` LIKE ?
        )";
$searchTerm = "%" . $query . "%";

if ($stmt = mysqli_prepare($conn, $sql)) {
    mysqli_stmt_bind_param($stmt, "issss", $user_id, $searchTerm, $searchTerm, $searchTerm, $searchTerm);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($row['name']) . '</td>';
            echo '<td>' . htmlspecialchars($row['company']) . '</td>';
            echo '<td>' . htmlspecialchars($row['phone']) . '</td>';
            echo '<td>' . htmlspecialchars($row['email']) . '</td>';
            echo '<td>';
            echo '<a href="editContact.php?id=' . htmlspecialchars($row['id']) . '">Edit</a>';
            echo '<span class="fw-bold">|</span>';
            echo '<a href="deleteContact.php?id=' . htmlspecialchars($row['id']) . '" onclick="return confirm(\'Are you sure you want to delete this contact?\')">Delete</a>';
            echo '</td>';
            echo '</tr>';
        }
    } else {
        echo '<tr><td colspan="5" class="text-center">No contacts found</td></tr>';
    }
    mysqli_stmt_close($stmt);
}
mysqli_close($conn);
