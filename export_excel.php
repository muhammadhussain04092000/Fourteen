<?php
if (isset($_GET['table'])) {
    $tableName = $_GET['table'];

    $servername = "localhost";
    $username = "root";
    $password = "J@ww@d13";
    $dbname = "fourteen";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch data from the table
    $sql = "SELECT * FROM $tableName";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Set the headers to trigger a download
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment;filename=' . $tableName . '_data.csv');

        // Open output stream
        $output = fopen('php://output', 'w');

        // Fetch field names (column headers)
        $fieldInfo = $result->fetch_fields();
        $headers = [];
        foreach ($fieldInfo as $field) {
            $headers[] = $field->name;
        }
        // Output the column headers
        fputcsv($output, $headers);

        // Output the table data row by row
        while ($row = $result->fetch_assoc()) {
            fputcsv($output, $row);
        }

        // Close the output stream
        fclose($output);
        exit();
    } else {
        echo "No data found in the table.";
    }

    // Close the connection
    $conn->close();
} else {
    echo "No table selected.";
}
?>
