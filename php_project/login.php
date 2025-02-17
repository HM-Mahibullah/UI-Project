<?php 

if($_SERVER["REQUEST_METHOD"] == "POST")
{
    // RETRIEVE FORM DATA
    $username = $_POST['username'];
    $password = $_POST['password'];

    // DATABASE CONNECTION
    $host = "localhost";
    $dbusername = "root";
    $dbpassword = "";
    $dbname = "demo";

    // CREATE A NEW MYSQLi CONNECTION
    $conn = new mysqli($host, $dbusername, $dbpassword, $dbname);

    // CHECK CONNECTION
    if ($conn->connect_error)
    {
        die("Connection failed: " . $conn->connect_error);
    }

    // USE PREPARED STATEMENT TO PREVENT SQL INJECTION
    $query = $conn->prepare("SELECT * FROM login_email WHERE username = ? AND password = ?");
    $query->bind_param("ss", $username, $password);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows == 1)
    {
        // LOGIN SUCCESS
        header("Location: success.html");
        exit();
    }
    else
    {
        // LOGIN FAILED
        header("Location: error.html");
        exit();
    }

    // CLOSE CONNECTION
    $query->close();
    $conn->close();
}

?>
