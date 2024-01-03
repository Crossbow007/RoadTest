<?php
// http://localhost/RoadTestCapstoneTheShell/RoadTest.php
// Team member:
// Add Record Upgrade - Feature 1 - Dhanan
// Add Record Upgrade - Feature 2 - Vaughn
// Add Record Upgrade - Feature 3 - Aakash
// Modify Record Upgrade  - Arnie & Kevin-

require_once("./RoadTestInclude.php");
require_once("./clsCreateRoadTestTable.php");

// main
date_default_timezone_set ('America/Toronto');
$mysqlObj = CreateConnectionObject();
$TableName = "RoadTests"; 
writeHeaders("Road Test","Driverless Car", "topdiv");
if (isset($_POST['f_CreateTable']))
  createTableForm($mysqlObj,$TableName);
else
	if (isset($_POST['f_Save'])) 
	     saveRecordtoTableForm($mysqlObj,$TableName) ;
  	else if (isset($_POST['f_AddRecord'])) 
	     addRecordForm($mysqlObj,$TableName) ;	   
  	else if (isset($_POST['f_DisplayData']))
	     displayDataForm ($mysqlObj,$TableName);
		else if (isset($_POST['f_Validate']))
			 validateForm($mysqlObj,$TableName);   
		else if (isset($_POST['f_ModifyRecord'])) 
	     modifyRecordForm($mysqlObj,$TableName) ;	
		else if (isset($_POST['f_FindExistingRecord'])) 
	     displayExistingRecordForm($mysqlObj,$TableName) ;	
		else if (isset($_POST['f_WriteChangedRecordToTable'])) 
	     writeChangedRecordToTable($mysqlObj, $TableName) ;	
	else displayMainForm();
	CloseConnection($mysqlObj);
	
echo "</div><div class=\"bottomdiv\">";
DisplayContactInfo(); 
echo "</div>";
echo "</body>\n";
echo "</html>\n";

// functions
function displayMainForm()
{
   echo "<form action=? method=post>";
   echo "<div id=\"buttonGroup\">";
	
   displayButton("f_CreateTable", "Create Table", "", "Create Tables","enabled");
   displayButton("f_AddRecord", "Add Record", "", "Add Record","enabled");
   displayButton("f_ModifyRecord", "Modify Record", "", "Modify Record","enabled");
   displayButton("f_DisplayData", "Display Data", "", "Display Data","enabled");

	 echo "</div>";
   echo "</form>"; 
} 

function createTableForm(&$mysqlObj,$TableName)
{
	echo "<form action=? method=post>"; 
	echo "<h2>Create Table Form</h2>";
	
	$createTable = new clsCreateRoadTestTable();
	$createTable->createTheTable($mysqlObj, $TableName);
	
	echo "<div id=\"buttonGroup\">";
	displayButton("f_Main","Home","", "Home","enabled");
	echo "</div>";
	echo "</form>"; 
	
}
//? how to get validation
function validateForm(&$mysqlObj,$TableName)
{
		addRecordForm($mysqlObj,$TableName);
}

function addRecordForm(&$mysqlObj,$TableName)
{
	

  echo "<form action=? method=post>";
	echo "<h2>Road Test Data</h2>";

	echo "<div id=\"buttonGroup\">";
	echo "<button type = \"button\" id=\"f_Validate\" 
	name=\"f_Validate\" onclick = \"Validate()\">Validate</button>";
	
	displayButton("f_Save", "Save", "","saveButton", "enabled");
	displayButton("f_Main","Home","", "Home","enabled");
	echo "</div>";

	echo "<div class = \"flexContainer\">";
	echo "<div id = \"dataEntry\" class = \"flexItem\">";
	echo "<div class=\"formLabel\">";
	displayLabel("License Plate");
	echo "</div>";
  $defaultValue = "woof";
	echo "<div class=\"formLabel\">";
  echo "<input type = text name = \"f_LicensePlate\" 
	id = \"f_LicensePlate\" Size = 5 value = \"$defaultValue\">";  
	echo "</div>";
	
	echo "<div class = \"datapair\">";
	echo "<div class=\"formLabel\">";
	displayLabel("Date Stamp");
	echo "</div>";
    $defaultValue= date('Y-m-d');
	echo "<div class=\"formLabel\">";
	echo "<input type = date name = \"f_DateStamp\" 
	id = \"f_DateStamp\" Size = 10 value = \"$defaultValue\" >";  
	echo "</div>";
  echo "</div>";
	
	echo "<div class = \"datapair\">";
	echo "<div class=\"formLabel\">";
	displayLabel("Time Stamp");
	echo "</div>";
	echo "<div class=\"formLabel\">";
	displayTextbox ("time", "f_TimeStamp", 10, date('h:i')); 
	echo "</div></div>";
	
	echo "<div class = \"datapair\">";
	echo "<div class=\"formLabel\">";
	displayLabel("Number of Passengers");
	echo "</div>";

	echo "<div class=\"formLabel\">";
	displayTextbox ("number", "f_Passengers", 0, "3"); 
	echo "</div>";
  echo "</div>";

	echo "<div class = \"datapair\">";
	echo "<div class=\"formLabel\">";
	displayLabel("Incident free?");
	echo "</div>";
  echo "<input type=checkbox id=\"f_IncidentCheckbox\" 
	 name=\"f_IncidentCheckbox\">";
 	echo "</div>";
	
  echo "<div class = \"datapair\" >"; 
	echo "<div class=\"formLabel\">";
	displayLabel("Danger Status", "f_DangerStatusLabel");
	echo "</div>";
	$defaultValue = "Medium";
	echo "<div class=\"formLabel\">";
	echo "<select name=\"f_DangerStatus\" id =\"f_DangerStatus\" size=\"4\">"; 
 	echo "<option selected id = \"Low\" value=\"Low\">Low</option>";
	echo "<option id = \"Medium\" value=\"Medium\">Medium</option>";
	echo "<option id = \"High\" value=\"High\">High</option>";
	echo "<option id = \"Critical\" value=\"Critical\">Critical</option> ";
	echo "</select></div></div>";

	echo "<div class = \"datapair\">";
	echo "<div class=\"formLabel\">";
	displayLabel("Speed (km/h)", "f_SpeedLabel");
	echo "</div>";
    $defaultValue = 100;
	echo "<div class=\"formLabel\">";
	echo "<input type = text name = \"f_Speed\" id = \"f_Speed\" 
	Size = 5 value = \"$defaultValue\">";  
 	echo "</div>";

	echo "</div>";
	echo "</div>";

	echo "<div class = \"flexItem\">";
	DisplayLabel("","ERROR");
	echo "</div>";

echo "</form>";

} 

function saveRecordtoTableForm(&$mysqlObj,$TableName) 
{ 
	echo "<form action=? method=post>";
	echo "<h2>Save Record to Table Form</h2>";
	
  $passengers = $_POST['f_Passengers'];
	$baseCost = 5000;
	$honarariumPerPassenger = 100;
	$cost = $baseCost + $honarariumPerPassenger * $passengers;
	$licensePlate = $_POST['f_LicensePlate']; 
	$dateTimeStamp = $_POST['f_DateStamp'] . " " .  $_POST['f_TimeStamp'];
	$passengers = $_POST['f_Passengers'];

	// isset avoids warning.  
	if (isset($_POST['f_IncidentCheckbox']))
	   $incident =  true;
	else
	   $incident = false; 
	switch ($_POST['f_DangerStatus'])
	{
		case "Low":
			$dangerStatus = "L";
			break;
		case "Medium":
			$dangerStatus = "M";
			break;
		case "High":
			$dangerStatus = "H";
			break;
		case "Critical":
			$dangerStatus = "C";
			break;
	}
	$speed =$_POST['f_Speed'];

	$addRecord = "Insert Into $TableName Values (?, ?, ?, ?, ?, ?, ?)";
	try{
		$stmt = $mysqlObj->prepare($addRecord);  	 
		$stmt->bind_param("ssiisdd", $licensePlate, $dateTimeStamp, 
						$passengers, $incident,$dangerStatus, $speed, $cost); 
		$success = $stmt->execute();
		if ($success)
		echo "<h3>Record successfully added to " . $TableName . "</h3>";
	}
	catch (exception $e)
    {
       echo "Unable to add record to " . $TableName . ". No 
			 two license plates can have the same name."; 
	}

	echo "<div id=\"buttonGroup\">";
	displayButton("f_Main","Home","", "Home","enabled");
	echo "</div>";

	echo "</form>"; 
   	$stmt->close();
 } 


 function modifyRecordForm(&$mysqlObj,$TableName)
 {
	 echo "<form action=? method=post>";
	 echo "<h2>Modify Record Form</h2>";
		
		echo "<div id=\"buttonGroup\">";
		displayLabel("License Plate");
		echo "<input type = text name = \"f_LicensePlate\">";
		displayButton("f_FindExistingRecord","Find Existing Record","",
		 "Find Existing Record","enabled");
		echo "</div>";
	  echo "</form>"; 
 }


function displayDataForm(&$mysqlObj, $TableName)
{
    echo "<form action=? method=post>";
    echo "<h2>Display Data Form</h2>";
    
		echo "<div  class = \"flexItem\">";
        if (!$mysqlObj) {
            echo "<p>Database connection failed.</p>";
        return;
        }

    $query = "SELECT licensePlate, dateTimeStamp, nbrPassengers, incidentFree, 
              dangerStatus, speed, cost FROM $TableName ORDER BY 
							dangerStatus DESC";
    $stmt = $mysqlObj->prepare($query);

    if (!$stmt) {
        echo "<p>Failed to prepare the query.</p>";
        return;
        }

    $stmt->bind_result($licensePlate, $dateTimeStamp, $nbrPassengers, 
                       $incidentFree, $dangerStatus, $speed, $cost);
    $stmt->execute();

    echo "<div class=\"table-container\">";
    echo "<table border=\"1\">
				<tr>
						<th>License Plate</th>
						<th>Date/Time Stamp</th>
          	<th> # Passengers</th>
						<th>Incident Free</th>
						<th>Danger Status</th>
          	<th>Speed</th>
						<th>Cost</th>
				</tr>";

    while ($stmt->fetch()) {
        $dateTimeStamp = str_replace(" ", " at ", $dateTimeStamp);
        echo "<tr>
				<td>$licensePlate</td>
				<td>$dateTimeStamp</td>
              <td>$nbrPassengers</td>";
        echo "<td>" . ($incidentFree ? "Yes" : "No") . "</td>";
        switch ($dangerStatus) {
            case "L":
                $dangerStatus = "Low";
                break;
            case "M":
                $dangerStatus = "Medium";
                break;
            case "H":
                $dangerStatus = "High";
                break;
            case "C":
                $dangerStatus = "Critical";
                break;
        }
        echo "<td>$dangerStatus</td>
				<td>$speed</td>
				<td>$cost</td>
				</tr>";
    }

    echo "</table>";
    echo "</div>";

		echo "<div id=\"buttonGroup\">";
    displayButton("f_Main", "Home", "", "Home","enabled");
    echo "</div>";

    $stmt->close(); 
		echo "</div>";
    echo "</form>";  
}

function displayExistingRecordForm(&$mysqlObj,$TableName)
{
	
	echo "<form action=? method=post>";
	echo "<h2>Edit Record Form</h2>";

	echo "<div id=\"buttonGroup\">";
	displayButton("f_WriteChangedRecordToTable","Write Changed Record",
	"", "Write Changed Record","enabled");
	displayButton("f_Main","Home","", "Home","enabled");
	echo "</div>";


	  $licensePlateToFind = $_POST['f_LicensePlate'];
    $query = "SELECT * FROM $TableName WHERE licensePlate = ?";
    $stmt = $mysqlObj->prepare($query);
    $stmt->bind_param("s", $licensePlateToFind);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $record = $result->fetch_assoc(); 

			$dateTimeString = htmlspecialchars($record['dateTimeStamp']);
	
			$dateTime = new DateTime($dateTimeString);
			$date = $dateTime->format('Y-m-d');
			$time = $dateTime->format('H:i:s');
		
			echo "<div id = \"dataEntry\" class = \"flexItem\">";
			echo "<div class=\"formLabel\">";
			displayLabel("License Plate");
			echo "</div>";

			echo "<div class=\"formLabel\">";
			echo "<input type='text' name='f_LicensePlate' 
			value='" . htmlspecialchars($record['licensePlate']) . "' />";
			echo "</div>";
		
			echo "<div class = \"datapair\">";
			echo "<div class=\"formLabel\">";
			displayLabel("Date Stamp");
			echo "</div>";

			echo "<div class=\"formLabel\">";
			echo "<input type = date name = \"f_DateStamp\" 
			id = \"f_DateStamp\" Size = 10 value = \"$date\" >";  
			echo "</div>";
			echo "</div>";
		
			echo "<div class = \"datapair\">";
			echo "<div class=\"formLabel\">";
			displayLabel("Time Stamp");
			echo "</div>";
			echo "<div class=\"formLabel\">";
			displayTextbox ("time", "f_TimeStamp", 10, $time); 
			echo "</div></div>";
		
			echo "<div class = \"datapair\">";
			echo "<div class=\"formLabel\">";
			displayLabel("Number of Passengers");
			echo "</div>";

			echo "<div class=\"formLabel\">";
			displayTextbox ("number", "f_Passengers",
			 0, htmlspecialchars($record['nbrPassengers'])); 
			echo "</div>";
			echo "</div>";

			$incidentFree = htmlspecialchars($record['incidentFree']);
			$incidentFreeValue =  ($incidentFree == 1) ? "checked" : "";
	
			echo "<div class = \"datapair\">";
			echo "<div class=\"formLabel\">";
			displayLabel("Incident free?");
			echo "</div>";
			echo "<input type=checkbox 
			id=\"f_IncidentCheckbox\" name=\"f_IncidentCheckbox\"" 
			. $incidentFreeValue . ">";
			echo "</div>";
		
			$selectedDangerStatus = htmlspecialchars($record['dangerStatus']);

			echo "<div class = \"datapair\" >"; 
			echo "<div class=\"formLabel\">";
			displayLabel("Danger Status", "f_DangerStatusLabel");
			echo "</div>";

			echo "<div class=\"formLabel\">";
			echo "<select name=\"f_DangerStatus\" id =\"f_DangerStatus\" 		 
			  size=\"4\">"; 
			echo "<option " . ($selectedDangerStatus == "L" ? 'selected' : '') .
			 " id = \"Low\" value=\"Low\">Low</option>";
			echo "<option " . ($selectedDangerStatus == "M" ? 'selected' : '') .
			 " id = \"Medium\" value=\"Medium\">Medium</option>";
			echo "<option " . ($selectedDangerStatus == "H" ? 'selected' : '') .
		 	" id = \"High\" value=\"High\">High</option>";
			echo "<option " . ($selectedDangerStatus == "C" ? 'selected' : '') .
			 " id = \"Critical\" value=\"Critical\">Critical</option> ";
			echo "</select></div></div>";
			echo "<div class = \"datapair\">";
			echo "<div class=\"formLabel\">";
			displayLabel("Speed (km/h)", "f_SpeedLabel");
			echo "</div>";

			$speed = htmlspecialchars($record['speed']);
			echo "<div class=\"formLabel\">";
			echo "<input type = text name = \"f_Speed\" id = \"f_Speed\"
			Size = 5 value = " . htmlspecialchars($record['speed']) . " />";
			echo "</div>";
			echo "</div>";
			echo "</div>";

			} 
	else {
        echo "<h3>No record found with that license plate.</h3>";
		    }
	echo "</form>";  
}

function writeChangedRecordToTable(&$mysqlObj,$TableName) 
{
	echo "<form action=? method=post>";
	echo "<h2>Change Confirmation</h2>";
	
	if (isset($_POST['f_WriteChangedRecordToTable']) && 
	 isset($_POST['f_LicensePlate'])) 
	 {
		$dateTimeStamp = $_POST['f_DateStamp'] . " " .  $_POST['f_TimeStamp'];
	  $passengers = $_POST['f_Passengers'];
			if (isset($_POST['f_IncidentCheckbox']))
				$incident =  true;
 			else
	 			$incident = false; 
		$dangerStatus = $_POST['f_DangerStatus'];
		$speed =$_POST['f_Speed'];
		$baseCost = 5000;
		$honarariumPerPassenger = 100;
		$cost = $baseCost + $honarariumPerPassenger * $passengers;
		$licensePlateToFind = $_POST['f_LicensePlate'];

		$updateRecord = "UPDATE $TableName SET dateTimeStamp = ?,
		 nbrPassengers = ? , incidentFree = ?, dangerStatus = ?,
		 speed = ?, cost = ? 	WHERE licensePlate = ?";
					
		$stmt = new mysqli_stmt($mysqlObj);
	
	try{
		$stmt = $mysqlObj->prepare($updateRecord);  	 
		$stmt->bind_param("siisdds", $dateTimeStamp, 
						$passengers, $incident, $dangerStatus, $speed, $cost, 
						 $licensePlateToFind); 
		$success = $stmt->execute();
		if ($success)
		echo "<h3>Record successfully added to " . $TableName . "</h3>";

	}
	catch (Exception $e)
    {
			echo "<h3>Unable to update record to " . $TableName. "</h3>";
    }
	} 
	else {
		echo "<h3>The form was not submitted correctly.</h3>";
			}
	
	echo "<div id=\"buttonGroup\">";
    displayButton("f_Main", "Home", "", "Home","enabled");
  echo "</div>";

	echo "</form>";  
}
?>