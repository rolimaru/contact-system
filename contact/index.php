<?php
session_start();
include "../db_conn.php";

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id']; // Get the user ID from session

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
    <script>
        function confirmDelete() {
            return confirm("Are you sure you want to delete this contact?");
        }
    </script>
</head>

<body>
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Contact List</h2>
            <div class="d-flex fs-5 gap-2 fw-bold">
                <a href="addContact.php" class="">Add New Contact</a>
                <span class="font-weight-bold">|</span>
                <p class="">Contact</p>
                <span>|</span>
                <a href="../logout.php" class="">Logout</a>
            </div>
        </div>

        <!-- Search Form -->
        <input type="text" id="searchInput" class="form-control mb-3" placeholder="Search contacts...">


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
            <tbody>
                <?php
                while ($row = mysqli_fetch_assoc($result)) {
                ?>
                    <tr> <!-- Start of the table row -->
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td><?php echo htmlspecialchars($row['company']); ?></td>
                        <td><?php echo htmlspecialchars($row['phone']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td>
                            <a href="editContact.php?id=<?php echo htmlspecialchars($row['id']); ?>">Edit</a>
                            <span class="fw-bold">|</span>
                            <a href="deleteContact.php?id=<?php echo htmlspecialchars($row['id']); ?>" onclick="return confirmDelete()">Delete</a>
                        </td>
                    </tr> <!-- End of the table row -->
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            // Function to fetch contacts based on search query
            function fetchContacts(query = '') {
                $.ajax({
                    url: 'searchContact.php',
                    method: 'POST',
                    data: {
                        query: query
                    },
                    success: function(data) {
                        $('#contactTableBody').html(data);
                    }
                });
            }

            // Fetch all contacts on page load
            fetchContacts();

            // Event listener for the search input
            $('#searchInput').on('input', function() {
                const query = $(this).val();
                fetchContacts(query);
            });
        });
    </script>
</body>

</html>

<?php
mysqli_stmt_close($stmt);
mysqli_close($conn);
?>