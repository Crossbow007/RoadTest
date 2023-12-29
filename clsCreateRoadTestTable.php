<?php
class clsCreateRoadTestTable 
{
    function createTheTable(&$mysqlObj,$TableName)
    {
        $mysqlObj = createConnectionObject(); 
        if (($stmt = $mysqlObj->prepare("Drop table If Exists $TableName"))) 
        $stmt->execute();
        $CreateQuery = "Create table " . $TableName . " (";
        $CreateQuery .= "licensePlate varchar(10) primary key, dateTimeStamp datetime,";
        $CreateQuery .= "nbrPassengers integer, incidentFree boolean, dangerStatus varchar(1),";
        $CreateQuery .= "speed decimal(4,1), cost decimal (7,2))";
        $stmt = $mysqlObj->prepare($CreateQuery);
        if ($stmt->error)
        { 
            echo "Prepare failed ". $stmt->error . $mysqlObj->error; 
            exit; 
        }
        if ($stmt->execute()) 
            echo "<h2>Table $TableName created.</h2>";
        else
            echo "<h2>Unable to create table $TableName.</h2>"; 
        
        $stmt->close();	
    }
}
?>