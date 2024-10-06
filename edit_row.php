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
        <h2>Edit Row</h2>

        <?php
        $tableName = isset($_GET['table']) ? $_GET['table'] : '';
        $rowId = isset($_GET['id']) ? $_GET['id'] : '';

        if ($tableName && $rowId) {
            $servername = "localhost";
            $username = "root";
            $password = "J@ww@d13";
            $dbname = "fourteen";

            // Create connection
            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Fetch the row data to edit
            $sql = "SELECT * FROM $tableName WHERE id=$rowId";  // Adjust the primary key if necessary
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();

                // Generate a form with the row's current data
                echo "<form action='' method='post'>";
                
                foreach ($row as $field => $value) {
                    echo "
                        <div class='mb-3'>
                            <label for='$field' class='form-label'>$field</label>
                            <input type='text' class='form-control' id='$field' name='$field' value='$value'>
                        </div>
                    ";
                }

                echo "<button type='submit' class='btn btn-primary'>Save Changes</button>";
                echo "</form>";

                // Handle form submission and update the row
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    $updateQuery = "UPDATE $tableName SET ";

                    // Build the SET clause for the SQL UPDATE query
                    $first = true;
                    foreach ($_POST as $key => $value) {
                        if (!$first) {
                            $updateQuery .= ", ";
                        }
                        $updateQuery .= "`$key`='" . $conn->real_escape_string($value) . "'";
                        $first = false;
                    }

                    // Add the WHERE clause to target the specific row by id
                    $updateQuery .= " WHERE id=$rowId";  // Adjust the primary key if necessary

                    // Execute the query
                    if ($conn->query($updateQuery) === TRUE) {
                        echo "<script>alert('Row updated successfully!'); window.location.href='view_table.php?table=$tableName';</script>";
                    } else {
                        echo "Error updating row: " . $conn->error;
                    }
                }
            } else {
                echo "<p>No data found for the specified row.</p>";
            }

            // Close the connection
            $conn->close();
        } else {
            echo "<p>Invalid table or row selected.</p>";
        }
        ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>