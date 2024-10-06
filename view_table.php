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
        <h2>Event Name: <?php $tableName = isset($_GET['table']) ? $_GET['table'] : ''; echo $tableName ?></h2>

        <!-- Add Entry Button -->
        <form action="add_entry.php" method="get">
            <p>Please ignore the 'id' column on the left</p>
            <input type="hidden" name="table" value="<?php $tableName = isset($_GET['table']) ? $_GET['table'] : ''; echo $tableName; ?>">
            <button type="submit" class="btn btn-success">Add Entry</button>
        </form>
        <br><br>

        <?php
            // Get the table name from the URL
            $tableName = isset($_GET['table']) ? $_GET['table'] : '';

            if ($tableName) {
                $servername = "localhost";
                $username = "root";
                $password = "J@ww@d13";
                $dbname = "fourteen";
            
                $conn = new mysqli($servername, $username, $password, $dbname);
            
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // SQL query to get all data from the selected table
                $sql = "SELECT * FROM $tableName";
                $result = $conn->query($sql);

                if (!$result) {
                    die("Invalid Query: " . $conn->error);
                }

                if ($result->num_rows > 0) {
                    echo "<table class='table'>
                            <thead>
                                <tr>";

                    // Display table headers dynamically
                    $fieldInfo = $result->fetch_fields();
                    foreach ($fieldInfo as $field) {
                        echo "<th>{$field->name}</th>";
                    }

                    echo "<th>Actions</th>";  // Add an 'Actions' column for Edit/Delete buttons
                    echo "</tr></thead><tbody>";

                    // Display table data with Edit and Delete buttons
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        
                        // Display each row's data
                        foreach ($row as $data) {
                            echo "<td>$data</td>";
                        }

                        // Extract the primary key or a unique identifier (assumed to be 'id')
                        $rowId = $row['id'];  // Adjust this if your table uses a different unique identifier

                        // Add Edit and Delete buttons
                        echo "<td>
                            <a href='edit_row.php?table=$tableName&id=$rowId' class='btn btn-primary btn-sm'>Edit</a>&nbsp
                            <a href='view_table.php?table=$tableName&delete_id=$rowId' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure you want to delete this row?\");'>Delete</a>
                        </td>";

                        echo "</tr>";
                    }

                    echo "</tbody></table>";
                } else {
                    echo "<p>No data available in the table.</p>";
                }

                // Handle deletion of a row
                if (isset($_GET['delete_id'])) {
                    $deleteId = $_GET['delete_id'];

                    // SQL query to delete the row based on its primary key (assumed 'id')
                    $deleteSql = "DELETE FROM $tableName WHERE id=$deleteId";  // Adjust the primary key if necessary

                    if ($conn->query($deleteSql) === TRUE) {
                        echo "<script>alert('Row deleted successfully!'); window.location.href='view_table.php?table=$tableName';</script>";
                    } else {
                        echo "Error deleting row: " . $conn->error;
                    }
                }

                // Close the connection
                $conn->close();
            } else {
                echo "<p>No table selected.</p>";
            }
        ?>
        <form action="export_excel.php" method="get" class="d-inline">
            <input type="hidden" name="table" value="<?php echo $tableName; ?>">
            <button type="submit" class="btn btn-info">Export to Excel</button>
        </form>

        <!-- Print Button -->
        <button onclick="printTable()" class="btn btn-warning">Print</button>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        function printTable() {
            var printContents = document.querySelector('.table').outerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
        }
    </script>
</body>
</html>
