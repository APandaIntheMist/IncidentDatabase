<html>
<head>
	<title>Issue Tracking System</title>
</head>
<body>
	<h1> New Incidents </h1>
	<a href="testing.php">Home</a>
	<!--ADD A NEW INCIDENT CODE-->
	<form>
	<h4>Add New Incident</h4> 
	
	<!--Text boxes to fill out-->
	Incident Number: <br>
	<input type = "text" name = "NUM" multiple><br>
	
	Category: <br>
	<select name = "CAT">
        <option value="cat1">Category1</option>
        <option value="cat2">Category2</option>
    </select><br>
        
    Status of Incident (Optional): <br>
	<select name = "STATUS">
        <option value="status1">Status1</option>
        <option value="status2">Status2</option>
    </select><br><br>
	
	Date Of Incident (format: YYYY-MM-DD): <br>
	<input type = "text" name = "DATE" multiple><br>
        
    Date Resolved(Optional) (format: YYYY-MM-DD): <br>
	<input type = "text" name = "RESOLVED" multiple><br>
        
    User: <br>
    <input type = "text" name = "USER" multiple> <br><br>
        
    Enter up to three tags: <br>
    <input type = "text" name = "TAG1" multiple> <br>
    <input type = "text" name = "TAG2" multiple> <br>
    <input type = "text" name = "TAG3" multiple> <br><br>
        
    Employee: <br>
    <input type = "text" name = "EMPLOYEE" multiple> <br><br>
        
    Description of incident:<br>
    <textarea name = "DESCRIPTION" rows="10" cols="50"></textarea> <br>
	
    <br>
	<input type = "submit">
	</form>
	
    <!--***TO DO: CHANGE PHP-->
    
    
    
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