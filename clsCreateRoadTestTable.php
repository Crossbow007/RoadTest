<?php
class clsCreateRoadTestTable 
{
    function createTheTable(&$mysqlObj,$TableName)
    {
        $mysqlObj = createConnectionObject(); 
        if (($stmt = $mysqlObj->prepare("Drop table If Exists $TableName"))) 
            $stmt->execute();
        $CreateQuery = "Create table " . $TableName . " (";
        $CreateQuery .= "licensePlate varchar(10) primary key, 
        dateTimeStamp datetime,";
        $CreateQuery .= "nbrPassengers integer, 
        incidentFree boolean, dangerStatus varchar(1),";
        $CreateQuery .= "speed decimal(4,1), cost decimal (7,2))";

        $stmt = $mysqlObj->prepare($CreateQuery);
        if ($stmt->error)
        { 
            echo "Prepare failed ". $stmt->error . $mysqlObj->error; 
            exit; 
        }
        
        if ($stmt->execute()) 
            echo "<h3>Table $TableName created.</h3>";
        else
            echo "<h3>Unable to create table $TableName.</h3>"; 
        
        $stmt->close();	
    }
}
?>