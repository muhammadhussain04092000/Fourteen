<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="shortcut icon" type="x-icon" href="logo.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fourteen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .navbar-brand {
            font-size: larger;
        }
        .navbar-brand img {
            height: 50px;
        }
    </style>
</head>
<body>
    <nav class="navbar bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="home.php">
                <img src="logo.png" alt="Logo" class="d-inline-block align-text-top">
            </a>
            <a href="index.html" style="float: right; color: black; text-decoration: none;">Logout</a>
        </div>
    </nav>
    <div class="container my-5">
        <h2>Programs & Events</h2>
        <a class="btn btn-primary" href="../new-event/" role="button">+ New Event</a>
        <br>
        <table class="table">
            <thead>
                <tr>
                    <th>Event Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $servername = "localhost";
                    $username = "root";
                    $password = "J@ww@d13";
                    $dbname = "fourteen";
                
                    $conn = new mysqli($servername, $username, $password, $dbname);
                
                    if ($conn->connect_error){
                        die("Connection failed: " . $conn->connect_error);
                    }

                    // SQL query to show all tables in the database
                    $sql = "SHOW TABLES";
                    $result = $conn->query($sql);

                    if (!$result) {
                        die("Invalid Query: " . $conn->error);
                    }

                    // Display each table in the database as a clickable link
                    while ($row = $result->fetch_array()) {
                        $tableName = $row[0];
                        echo "
                            <tr>
                                <td>
                                    <a href='view_table.php?table=$tableName'>$tableName</a>
                                </td>
                                <td>
                                    <a href='edit_table.php?table=$tableName' class='btn btn-primary btn-sm'>Edit</a>
                                    <a href='delete_table.php?table=$tableName' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure you want to delete the $tableName and the $tableName Data?\");'>Delete</a>
                                </td>
                            </tr>
                        ";
                    }

                    // Close the database connection
                    $conn->close();
                ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
