<?php
    $servername = "localhost";
    $username = "root";
    $password = "J@ww@d13";
    $dbname = "fourteen";
    $u_name = $_POST["username"];
    $pwd = $_POST["password"];

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error){
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "select * from login";
    $result = $conn->query($sql);

    while ($row = $result->fetch_assoc()){
        if ($row["username"] == $u_name && $row["password"] == $pwd){
            header("Location: index.php");
        } else {
            echo "<script>alert('Invalid Credentials. Please try again later')</script>";
            header("Location: home.php");
        }
    }

    // if($flag == 0){
    //     header("Location: index.html");
    //     echo "<script>alert('Username or Password is incorrect. Please try again later')</script>";
    // }
?>