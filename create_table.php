<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['table_name']) && isset($_POST['columns_count'])) {
    $tableName = $_POST['table_name'];
    $columnsCount = (int)$_POST['columns_count'];

    $servername = "localhost";
    $username = "root";
    $password = "J@ww@d13";
    $dbname = "fourteen";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Start building the CREATE TABLE query
    $createQuery = "CREATE TABLE `$tableName` (`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,"; // Automatically add the id column

    // Add the user-defined columns
    for ($i = 1; $i <= $columnsCount; $i++) {
        $columnName = $_POST["column_name_$i"];
        $columnType = $_POST["column_type_$i"];
        $columnNull = $_POST["column_null_$i"];

        $createQuery .= "`$columnName` $columnType $columnNull";

        if ($i < $columnsCount) {
            $createQuery .= ", ";
        }
    }

    $createQuery .= ");";

    // Execute the query
    if ($conn->query($createQuery) === TRUE) {
        echo "<script>alert('Event $tableName created successfully!'); window.location.href='index.php';</script>";
    } else {
        echo "Error creating table: " . $conn->error;
    }

    // Close the connection
    $conn->close();
}
?>
