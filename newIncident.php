<html>
<head>
	<title>CSIRT Database</title>
</head>
<body>
	<h1> CSIRT Database </h1>
	<a href="pageSourceCode.php">Home</a>
	<!--ADD A NEW INCIDENT CODE-->
	<form>
	<h4>Add New Indient</h4> 
	
	<!--Text boxes to fill out-->
	Incident Number: <br>
	<input type = "text" name = "NUM" multiple><br>
	
	Type Of Incident: <br>
	<input type = "text" name = "TYPE" multiple><br>
	
	Date Of Incident (format: YYYY-MM-DD): <br>
	<input type = "text" name = "DATE" multiple><br>
	
	<input type = "submit">
	</form>
	
	<?php
		##Stores the variables from user inputs
		if(isset($_REQUEST['NUM']))
		{
			$NUM=$_REQUEST['NUM'];
		}
		
		if(isset($_REQUEST['TYPE']))
		{
			$TYPE=$_REQUEST['TYPE'];
		}
		
		if(isset($_REQUEST['DATE']))
		{
			$DATE=$_REQUEST['DATE'];
		}
		
		## adds the incident if filled out correctly, otherwise gives an error
		if(isset($_REQUEST['NUM']) && isset($_REQUEST['TYPE']) &&isset($_REQUEST['DATE']))
		{ 
			$db = new mysqli("127.0.0.1", "ryandeisler", "", "ryandeisler");
			$sql = "INSERT INTO incident (incidentNumber, typeOfIncident, dateOfIncident, incidentState) VALUES ('$NUM', '$TYPE', '$DATE', 'open');";
			if ($db->query($sql) === TRUE)
			{
				echo "New record created successfully";
			} 
			else 
			{
				echo "Error: " . $sql . "<br>" . $db->error;
			}	
			$db->close();
		}
	?>
</body>
</html>