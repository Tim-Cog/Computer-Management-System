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
        echo "Connection Successfuln";
    }

    // $DeviceID = "";
    // $SerialNumber = "";
    // $AssignedTo = "";
    // $AssignedOn = "";
    // $ReturnedOn = "";
    // $Department = "";
    // $Branch = "";

    $assignmentId = time();
    $deviceName = $_POST['deviceName'];
    $serialNumber = $_POST['serialNumber'];
    $assignedTo = $_POST['assignedTo'];
    $assignedOn = $_POST['assignedOn'];
    $returnedOn = $_POST['returnedOn'];
    $department = $_POST['department'];
    $branch = $_POST['branches'];
    // $newAssignment = $_POST["newAssignment"];
    $assignCheckBox = $_POST['assignCheckBox'];

    if($returnedOn == ''){
        $returnedOn = null;
    }
    $sql;
    
    if($assignCheckBox == "yes"){
        $sql = "UPDATE `Assignments` SET Date_Returned = '$returnedOn' WHERE Assignment_ID = (SELECT MAX(Assignment_ID) FROM `Assignments` WHERE Assignments.Device_Name = '$deviceName');";
        if($conn->query($sql) === TRUE){
            echo "Record Updated Correctly";
        }else{
            echo "Error: ".$sql."<br>".$conn->error;
        }
    }else{
        $sql = "INSERT INTO `Assignments` (Assignment_ID, Device_Name, Serial_Number, User_Name, Date_Assigned, Department, Branch) VALUES ('$assignmentId','$deviceName','$serialNumber','$assignedTo','$assignedOn','$department','$branch');";
        if($conn->query($sql) === TRUE){
            echo "Record Inserted Correctly";
        }else{
            echo "Error: ".$sql."<br>".$conn->error;
        }
    }


    // $result = $conn->query(query: $sql);

    // if($conn->query($sql) === TRUE){
    //     echo "Record Inserted Correctly";
    // }else{
    //     echo "Error: ".$sql."<br>".$conn->error;
    // }