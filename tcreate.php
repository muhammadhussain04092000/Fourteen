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
        <h2>Create a New Table</h2>
        <p style='color: red'>Please make sure <strong>THE EVENT NAME IS LOWERCASE</strong> and make sure you <strong>DO NOT</strong> have any <strong>SPACES IN YOUR EVENT NAME</strong> as this could create some issues when working on this event in the future.</p>
        <form action="" method="post">
            <div class="mb-3">
                <label for="table_name" class="form-label">Event Name</label>
                <input type="text" class="form-control" id="table_name" name="table_name" required>
            </div>
            <div class="mb-3">
                <label for="columns" class="form-label">Number of Columns</label>
                <input type="number" class="form-control" id="columns" name="columns" min="1" required>
            </div>
            <button type="submit" class="btn btn-primary">Next</button>
        </form>

        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['table_name']) && isset($_POST['columns'])) {
            $tableName = $_POST['table_name'];
            $columnsCount = (int)$_POST['columns'];

            // Step 2: Dynamically generate fields for column details based on the number of columns
            echo "
            <h3>Define Columns for Event: $tableName</h3>
            <p><strong>Note:</strong> The table will include an 'id' column as INT, AUTO_INCREMENT, and PRIMARY KEY by default.</p>
            <p style='color: red'>Please make sure <strong>THE COLUMN NAME IS LOWERCASE</strong> and make sure you <strong>DO NOT</strong> have any <strong>SPACES IN YOUR COLUMN NAME</strong> as this could create some issues when working on this event in the future.</p>
            <form action='create_table.php' method='post'>
                <input type='hidden' name='table_name' value='$tableName'>
                <input type='hidden' name='columns_count' value='$columnsCount'>
            ";
            for ($i = 1; $i <= $columnsCount; $i++) {
                echo "
                <div class='row mb-3'>
                    <div class='col'>
                        <label for='column_name_$i' class='form-label'>Column Name $i</label>
                        <input type='text' class='form-control' id='column_name_$i' name='column_name_$i' required>
                    </div>
                    <div class='col'>
                        <label for='column_type_$i' class='form-label'>Data Type</label>
                        <select class='form-control' id='column_type_$i' name='column_type_$i' required>
                            <option value='MEDIUMTEXT'>MEDIUMTEXT</option>
                            <option value='LONGTEXT'>LONGTEXT</option>
                        </select>
                    </div>
                    <div class='col'>
                        <label for='column_null_$i' class='form-label'>Allow NULL</label>
                        <select class='form-control' id='column_null_$i' name='column_null_$i' required>
                            <option value='NOT NULL'>No</option>
                        </select>
                    </div>
                </div>
                ";
            }

            echo "
                <button type='submit' class='btn btn-success'>Create Event</button>
            </form>
            ";
        }
        ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
