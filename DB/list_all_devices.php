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

    

    $sql = "SELECT Devices.*, Assignments.Assignment_ID, Assignments.Branch, Assignments.Department, Assignments.User_Name, Assignments.Date_Assigned, Assignments.Date_Returned FROM `Devices` LEFT JOIN `Assignments` ON Devices.Device_Name = Assignments.Device_Name AND Assignments.Assignment_ID = ( SELECT MAX(Assignment_ID) FROM `Assignments` AS A WHERE A.Device_Name = Devices.Device_Name );";

    $result = $conn->query($sql);

    // echo $result;

    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            // print_r(array_keys($row));
            $data[] = [
                "Devices_Name" => $row["Device_Name"],
                "Device_Model" => $row["Device_Model"],
                "Device_Type" => $row["Device_Type"],
                "Serial_Number" => $row["Serial_Number"],
                "Cost" => $row["Cost"],
                "Specs" => $row["DeviceSpecs"],
                "Vendor" => $row["Vendor"],
                "Date_Purchased" => $row["Date_Purchased"],
                "Department" => $row["Department"],
                "Branch" => $row["Branch"],
                "Asigned_To" => $row["User_Name"],
                "Date_Assigned" => $row["Date_Assigned"],
                "Date_Returned" => $row["Date_Returned"],
            ];        
        }
        echo json_encode($data);
    } else {
        echo json_encode([]);
        // echo "No results found";        
    }