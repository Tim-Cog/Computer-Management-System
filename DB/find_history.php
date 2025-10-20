<?php

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);


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


    $history_parameter = $_POST['transitionHistoryDeviceID'];

    // var_dump($_POST);

    $sql = "SELECT Assignments.*, Devices.Date_Purchased FROM `Assignments` LEFT JOIN `Devices` ON Assignments.Device_Name = Devices.Device_Name WHERE Assignments.Device_Name = '$history_parameter';";

    $result = $conn->query($sql);


    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            // print_r(array_keys($row));
            $data[] = [
                "Devices_Name" => $row["Device_Name"],
                "Date_Assigned" => $row["Date_Assigned"],
                "Date_Returned" => $row["Date_Returned"],
                "Department" => $row["Department"],
                "Branch" => $row["Branch"],
                "Asigned_To" => $row["User_Name"],
            ];        
        }
        echo json_encode($data);
    } else {
        echo json_encode([]);
        // echo "No results found";        
    }