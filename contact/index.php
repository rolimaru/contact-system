<?php
session_start();
include "../db_conn.php";

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id']; // Get the user ID from session
$sqlUser = "SELECT name FROM `user` WHERE id = $user_id";
$resultUser = mysqli_query($conn, $sqlUser);
$user = mysqli_fetch_assoc($resultUser);

// Initialize search query variable
$search_query = "";

// Check if a search term has been submitted
if (isset($_POST['search'])) {
    $search_query = $_POST['search_query'];
}

// Prepare SQL statement to fetch only the contacts for the logged-in user with search filter
$sql = "SELECT * FROM `contact` WHERE `user_id` = ? AND (
            `name` LIKE ? OR 
            `company` LIKE ? OR 
            `phone` LIKE ? OR 
            `email` LIKE ?
        )";

if ($stmt = mysqli_prepare($conn, $sql)) {
    $search_term = "%$search_query%";
    mysqli_stmt_bind_param($stmt, "issss", $user_id, $search_term, $search_term, $search_term, $search_term);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
} else {
    die("Error: Could not prepare the query: " . mysqli_error($conn));
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact List</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Optional styling for the search input */
        #searchInput {
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <div class="d-flex gap-3 ">
            user: <h3 class="text-uppercase"> <?php echo $user['name'] ?> </h3>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3>Contact List</h3>
            <div class="d-flex fs-5 gap-2 fw-bold">
                <a href="addContact.php">Add New Contact</a>
                <span class="font-weight-bold">|</span>
                <p>Contact</p>
                <span>|</span>
                <a href="../logout.php">Logout</a>
            </div>
        </div>

        <input type="text" id="searchInput" class="form-control" placeholder="Search contacts...">

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Company</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="contactTableBody">
                <!-- Contacts will be dynamically loaded here -->
                <?php
                include "../db_conn.php";

                // Pagination settings
                $limit = 5; // Number of records per page
                $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                $offset = ($page - 1) * $limit;

                // Get total number of records
                $sqlTotal = "SELECT COUNT(*) FROM `contact` WHERE `user_id` = ?";
                if ($stmt = mysqli_prepare($conn, $sqlTotal)) {
                    mysqli_stmt_bind_param($stmt, "i", $_SESSION['user_id']);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_bind_result($stmt, $totalRows);
                    mysqli_stmt_fetch($stmt);
                    mysqli_stmt_close($stmt);
                }

                // Fetch records for the current page
                $sql = "SELECT * FROM `contact` WHERE `user_id` = ? LIMIT ? OFFSET ?";
                if ($stmt = mysqli_prepare($conn, $sql)) {
                    mysqli_stmt_bind_param($stmt, "iii", $_SESSION['user_id'], $limit, $offset);
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
                ?>
            </tbody>
        </table>

        <!-- Pagination Controls -->
        <nav aria-label="Page navigation" class="d-flex justify-content-center">
            <ul class="pagination">
                <?php
                $totalPages = ceil($totalRows / $limit);

                if ($page > 1) {
                    echo '<li class="page-item"><a class="page-link" href="?page=' . ($page - 1) . '">Previous</a></li>';
                }

                for ($i = 1; $i <= $totalPages; $i++) {
                    $active = ($i === $page) ? ' active' : '';
                    echo '<li class="page-item' . $active . '"><a class="page-link" href="?page=' . $i . '">' . $i . '</a></li>';
                }

                if ($page < $totalPages) {
                    echo '<li class="page-item"><a class="page-link" href="?page=' . ($page + 1) . '">Next</a></li>';
                }
                ?>
            </ul>
        </nav>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const searchInput = document.getElementById('searchInput');
            const contactTableBody = document.getElementById('contactTableBody');

            searchInput.addEventListener('input', () => {
                const searchQuery = searchInput.value;

                fetch(`fetch_contacts.php?search=${encodeURIComponent(searchQuery)}`)
                    .then(response => response.text())
                    .then(data => {
                        contactTableBody.innerHTML = data;
                    })
                    .catch(error => {
                        console.error('Error fetching contacts:', error);
                    });
            });
        });
    </script>
</body>

</html>