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
        <h2>Edit Table: <?php echo $_GET['table']; ?></h2>

        <?php
        // Fetch the table name from the URL parameter
        $tableName = isset($_GET['table']) ? $_GET['table'] : '';

        if ($tableName) {
            $servername = "localhost";
            $username = "root";
            $password = "J@ww@d13";
            $dbname = "fourteen";

            // Create connection
            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Fetch the table structure using DESCRIBE query
            $sql = "DESCRIBE $tableName";
            $result = $conn->query($sql);

            if (!$result) {
                die("Invalid Query: " . $conn->error);
            }

            // Display the existing columns for renaming
            echo "<form action='' method='post'>";
            echo "<h3>Rename Columns</h3>";

            $columns = [];
            while ($row = $result->fetch_assoc()) {
                $columns[] = $row['Field'];
                $fieldName = $row['Field'];
                $fieldType = $row['Type'];
                echo "
                    <div class='row mb-3'>
                        <div class='col'>
                            <label for='column_name_$fieldName' class='form-label'>Column Name: $fieldName</label>
                            <input type='text' class='form-control' id='column_name_$fieldName' name='column_name_$fieldName' value='$fieldName'>
                        </div>
                        <div class='col'>
                            <label for='column_type_$fieldName' class='form-label'>Data Type</label>
                            <select class='form-control' id='column_type_$fieldName' name='column_type_$fieldName' required>
                                <option value='$fieldType'>$fieldType</option>
                                <option value='MEDIUMTEXT'>MEDIUMTEXT</option>
                                <option value='LONGTEXT'>LONGTEXT</option>
                            </select>
                        </div>
                    </div>
                ";
            }

            echo "<h3>Add New Columns</h3>";

            // Add fields to add new columns
            for ($i = 1; $i <= 3; $i++) {
                echo "
                    <div class='row mb-3'>
                        <div class='col'>
                            <label for='new_column_name_$i' class='form-label'>New Column Name $i</label>
                            <input type='text' class='form-control' id='new_column_name_$i' name='new_column_name_$i'>
                        </div>
                        <div class='col'>
                            <label for='new_column_type_$i' class='form-label'>Data Type</label>
                            <select class='form-control' id='new_column_type_$i' name='new_column_type_$i'>
                                <option value='MEDIUMTEXT'>MEDIUMTEXT</option>
                                <option value='LONGTEXT'>LONGTEXT</option>
                            </select>
                        </div>
                    </div>
                ";
            }

            echo "<button type='submit' class='btn btn-success'>Save Changes</button>";
            echo "</form>";

            // Handle form submission for renaming columns and adding new ones
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                // Rename existing columns
                foreach ($columns as $column) {
                    $newColumnName = $_POST["column_name_$column"];
                    $newColumnType = $_POST["column_type_$column"];

                    // Only rename if the column name has changed
                    if ($newColumnName !== $column) {
                        $renameQuery = "ALTER TABLE $tableName CHANGE $column $newColumnName $newColumnType";
                        if (!$conn->query($renameQuery)) {
                            echo "Error renaming column $column: " . $conn->error;
                        }
                    } else {
                        // Alter column type even if name remains the same
                        $alterTypeQuery = "ALTER TABLE $tableName MODIFY $column $newColumnType";
                        if (!$conn->query($alterTypeQuery)) {
                            echo "Error changing column type for $column: " . $conn->error;
                        }
                    }
                }

                // Add new columns
                for ($i = 1; $i <= 3; $i++) {
                    $newColumnName = $_POST["new_column_name_$i"];
                    $newColumnType = $_POST["new_column_type_$i"];

                    if (!empty($newColumnName)) {
                        $addColumnQuery = "ALTER TABLE $tableName ADD $newColumnName $newColumnType";
                        if (!$conn->query($addColumnQuery)) {
                            echo "Error adding new column $newColumnName: " . $conn->error;
                        }
                    }
                }

                echo "<script>alert('Event structure updated successfully!'); window.location.href='index.php';</script>";
            }

            // Close the connection
            $conn->close();
        } else {
            echo "<p>Invalid table selected.</p>";
        }
        ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
