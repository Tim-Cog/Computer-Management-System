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
        echo "Connection Successful\n";
    }

    $AssignmentId = time();
    $DeviceName = $_POST['deviceName'];
    $DeviceModel = $_POST['deviceModel'];
    $SerialNumber = $_POST['serialNumber'];
    $DeviceType = $_POST['deviceType'];
    $Vendor = $_POST['vendor'];
    $Cost = $_POST['cost'];
    $DatePurchased = $_POST['datePurchased'];
    $DateAssigned = $_POST['dateAssigned'];
    $DeviceSpecs = $_POST['specs'];
    $AssignedTo = $_POST['assignedTo'];
    $DateReturned = null;
    $Department = $_POST['department'];
    $Branch = $_POST['branches'];

    var_dump($_POST);
    // var_dump($_POST);
    // echo "\n";

    $sql;
    $sql2;
    

    $uploadedValues = array($AssignedTo,$DateAssigned,$DateReturned,$Department,$Branch);
    foreach($uploadedValues as $val){
        if($val == null){
            $sql = "INSERT INTO `Devices`(Device_Name, Device_Model, Device_Type, Serial_Number, DeviceSpecs, Vendor, Cost, Date_Purchased) VALUES ('$DeviceName','$DeviceModel','$DeviceType','$SerialNumber','$DeviceSpecs','$Vendor','$Cost','$DatePurchased');";
            if($conn->query($sql) === TRUE){
                echo "Record Inserted Correctly";
            }else{
                echo "Error: ".$sql."<br>".$conn->error;
            }
            break;
        }else{
            $sql = "INSERT INTO `Devices` (Device_Name, Device_Model, Device_Type, Serial_Number, DeviceSpecs, Vendor, Cost, Date_Purchased) VALUES ('$DeviceName','$DeviceModel', '$DeviceType','$SerialNumber','$DeviceSpecs','$Vendor','$Cost','$DatePurchased');";
            $sql2 = " INSERT INTO `Assignments`(Assignment_ID, Device_Name, Serial_Number, User_Name, Date_Assigned, Department, Branch) VALUES ('$AssignmentId','$DeviceName','$SerialNumber','$AssignedTo','$DateAssigned','$Department','$Branch');";
            if($conn->query($sql) === TRUE){
                echo "Record Inserted Correctly";
            }else{
                echo "Error: ".$sql."<br>".$conn->error;
            }
            if($conn->query($sql2) === TRUE){
                echo "Record Inserted Correctly 2";
            }else{
                // echo "Error: ".$sql."<br>".$conn->error;
                echo "Error: ".$sql2."<br>".$conn->error;
            }
        }
        break;
    }



    echo "After sql statement";