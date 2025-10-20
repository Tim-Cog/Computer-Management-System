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
        echo "Connection Successful\n";
    }



    $row = 1;

    if(($handle = fopen("test.csv","r")) !== false){
        $eachRow = array();
        while(($data =fgetcsv($handle,1000,",")) !== false){
            $num = count($data);
            for($i = 0; $i < $num; $i++){
                array_push($eachRow,$data[$i]);
            }
            print_r($eachRow);
            $sql = "INSERT INTO `Devices` (Device_Name, Device_Model, Device_Type, Serial_Number, DeviceSpecs, Vendor, Cost, Date_Purchased) VALUES ('$eachRow[0]','$eachRow[1]', '$eachRow[2]','$eachRow[3]','$eachRow[4]','$eachRow[5]','$eachRow[6]','$eachRow[7]');";
            if($conn->query($sql) === TRUE){
                echo "Record Inserted Correctly";
            }else{
                echo "Error: ".$sql."<br>".$conn->error;
            }
            $eachRow = [];
        }
    }