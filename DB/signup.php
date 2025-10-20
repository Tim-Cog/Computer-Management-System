<?php
    ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "Inventory";


    $conn = new mysqli($servername,$username,$password,$dbname);


    if($conn -> connect_error){
        die("Connection Failed : ".$conn->connect_error);
    }else{
        // echo "Connection Successfuln";
    }


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = htmlspecialchars(trim($_POST['username']));
        $password = trim($_POST['password']);


        if (empty($username) || empty($password)) {
            echo "Username and password are required.";
            exit;
        }

        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        $stmt = $conn->prepare("INSERT INTO `Login` (USER_NAME, PASSWORD) VALUES (?, ?)");   
        
        
        if (!$stmt) {
            echo "Database error: " . $conn->error;
            exit;
        }

        $stmt->bind_param("ss", $username, $hashedPassword);



        if ($stmt->execute()) {
            echo "Registration successful!";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();

    }

    $conn->close();