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
        <h2>Add Entry to <?php echo $_GET['table']; ?></h2>

        <?php
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

            // Fetch table structure to dynamically generate form fields
            $sql = "DESCRIBE $tableName";
            $result = $conn->query($sql);

            if (!$result) {
                die("Invalid Query: " . $conn->error);
            }

            // Create a form based on the table structure
            echo "<form action='' method='post'>";
            
            while ($row = $result->fetch_assoc()) {
                $fieldName = $row['Field'];
                echo "
                    <div class='mb-3'>
                        <label for='$fieldName' class='form-label'>$fieldName</label>
                        <input type='text' class='form-control' id='$fieldName' name='$fieldName'>
                    </div>
                ";
            }

            echo "<button type='submit' class='btn btn-primary'>Submit</button>";
            echo "</form>";

            // Handle form submission
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $columns = "";
                $values = "";

                // Construct the query manually without using implode()
                $first = true;
                foreach ($_POST as $key => $value) {
                    if (!$first) {
                        $columns .= ", ";
                        $values .= ", ";
                    }
                    $columns .= "`" . $key . "`";
                    $values .= "'" . $conn->real_escape_string($value) . "'";
                    $first = false;
                }

                // Insert the new row into the table
                $sqlInsert = "INSERT INTO $tableName ($columns) VALUES ($values)";

                if ($conn->query($sqlInsert) === TRUE) {
                    echo "<script>alert('New entry added successfully!'); window.location.href='view_table.php?table=$tableName';</script>";
                } else {
                    echo "Error: " . $sqlInsert . "<br>" . $conn->error;
                }
            }

            // Close the connection
            $conn->close();
        } else {
            echo "<p>No table selected.</p>";
        }
        ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"></script>
</body>
</html>
