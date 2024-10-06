<?php
    // Check if the table name is passed as a query parameter
    if (isset($_GET['table'])) {
        $tableName = $_GET['table'];

        $servername = "localhost";
        $username = "root";
        $password = "J@ww@d13";
        $dbname = "fourteen";
    
        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
    
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // SQL query to drop (delete) the table
        $sql = "DROP TABLE $tableName";

        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Event $tableName has been deleted successfully!'); window.location.href='index.php';</script>";
        } else {
            echo "Error deleting table: " . $conn->error;
        }

        // Close the connection
        $conn->close();
    } else {
        echo "No table selected for deletion.";
    }
?>
