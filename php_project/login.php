<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // RETRIEVE FORM DATA
    $username = $_POST['username'];
    $password = $_POST['password'];

    // DATABASE CONNECTION
    $host = "localhost";//name is userIdentified
    $dbusername = "root";//name is userIdentified
    $dbpassword = "";//name is userIdentified
    $dbname = "demo";//name is userIdentified

    // CREATE A NEW MYSQLi CONNECTION
    $conn = new mysqli($host, $dbusername, $dbpassword, $dbname);




    // CHECK CONNECTION
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // USE PREPARED STATEMENT TO PREVENT SQL INJECTION
    $query = $conn->prepare("SELECT * FROM login_email WHERE username = ? AND password = ?");
    $query->bind_param("ss", $username, $password);
    /* 
    "ss" in bind_param means that both $username and $password are treated as strings
      s = string
      i = integer
      d = double
      b = blob
      blind_prams ensures that the variables are safely inserted into the SQL query, preventing SQL injection attacks. 
      */
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows == 1) {
        // LOGIN SUCCESS
        header("Location: success.html");
        exit();
    }

    /*     
    If num_rows == 1, it means the username and password are correct, and the user exists.

    If num_rows == 0, it means no matching user was found (invalid credentials).

    If num_rows > 1, it means there are duplicate records, which indicates a problem with the
     */ 
    
    
    
    else {
        // LOGIN FAILED
        header("Location: error.html");
        exit();
    }

    // CLOSE CONNECTION
    $query->close();
    $conn->close();
}

?>