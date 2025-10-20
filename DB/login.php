<?php

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
        // Sanitize inputs
        $username = htmlspecialchars(trim($_POST['username']));
        $password = trim($_POST['password']);
    
        // Validate inputs
        if (empty($username) || empty($password)) {
            echo "Username and password are required.";
            exit;
        }

        $stmt = $conn->prepare("SELECT USER_NAME, PASSWORD FROM `Login` WHERE USER_NAME = ?;");
        if (!$stmt) {
            echo "Database error: " . $conn->error;
            exit;
        }

        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();

            if (password_verify($password, $user['password'])) {
                echo "Login successful! Redirecting...";
                header("Location: dashboard.php");
                exit;
            }else{
                echo "Invalid Username or Password";
            }
            echo "Invalid Username or Password";
        }
    }