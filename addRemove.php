<html>
<head>
	<title>CSIRT Database</title>
</head>
<body>
	<h1> CSIRT Database  </h1>
	<a href="pageSourceCode.php">Home</a>
	<h4>Add/ Remove a Person or IP</h4>
<!--DROP DOWN STATE CHANGE-->
				<form id="PersonForm">
				First Name: <br>
				<input type = "text" name = "FN" multiple><br>
				
				Last Name: <br>
				<input type = "text" name = "LN" multiple><br>
				
				Job Title: <br>
				<input type = "text" name = "JOB" multiple><br>
				
				Email Address: <br>
				<input type = "text" name = "MAIL" multiple><br>
				
				Reason for Association: <br>
				<input type = "text" name = "personAS" multiple><br>
				
				Incident Number: <br>
				<input type = "text" name = "pNUM" multiple><br>
				
				<input type = "submit">
					<select name = "personChange" form = "PersonForm">
						<option value = "Add">Add</option>
						<option value = "Remove">Remove</option>
					</select>
				</form>
				
				<form id="IPForm">
				IP Address: <br>
				<input type = "text" name = "IP" multiple><br>
				
				Reason for Association: <br>
				<input type = "text" name = "ipAS" multiple><br>
				
				Incident Number: <br>
				<input type = "text" name = "IPNUM" multiple><br>
				
				<input type = "submit">
					<select name = "ipChange" form = "IPForm">
						<option value = "Add">Add</option>
						<option value = "Remove">Remove</option>
					</select>
				</form>
				
		<?php
		
		
		##  PERSON
		## Gets values from text boxes
		if(isset($_REQUEST['FN']))
		{
			$FN=$_REQUEST['FN'];
		}
		if(isset($_REQUEST['LN']))
		{
			$LN=$_REQUEST['LN'];
		}
		if(isset($_REQUEST['JOB']))
		{    
			$JOB=$_REQUEST['JOB'];  
		}
		if(isset($_REQUEST['MAIL']))
		{    
			$MAIL=$_REQUEST['MAIL'];  
		}
		if(isset($_REQUEST['personAS']))
		{    
			$personAS=$_REQUEST['personAS'];  
		}
		if(isset($_REQUEST['pNUM']))
		{    
			$pNUM=$_REQUEST['pNUM'];  
		}
		
		## Gets user input and decides to add or delete a person
		if(isset($_REQUEST['FN']) && isset($_REQUEST['LN']) && isset($_REQUEST['JOB']) && isset($_REQUEST['MAIL']) && isset($_REQUEST['personAS']) && isset($_REQUEST['pNUM']))
		{ 
			$pchoice = $_GET["personChange"];
			## Adding
			if($pchoice == "Add")
			{
				$db = new mysqli("127.0.0.1", "ryandeisler", "", "ryandeisler");
				$sql = "INSERT INTO person (lastName, firstName, jobTitle, emailAddress, reasonForAssociation, incidentNumber) VALUES ('$LN', '$FN', '$JOB', '$MAIL', '$personAS', '$pNUM');";
				if ($db->query($sql) === TRUE)
				{
					echo "New record created successfully.";
				} 
				else 
				{
					echo "Error: " . $sql . "<br>" . $db->error;
				}	
				$db->close();
			}
			## Removal
			else if($pchoice == "Remove")
			{
				$db = new mysqli("127.0.0.1", "ryandeisler", "", "ryandeisler");
				$sql = "DELETE FROM person WHERE lastName = '$LN' AND firstName = '$FN' AND incidentNumber = '$pNUM';";
				if ($db->query($sql) === TRUE)
				{
					echo "Record deleted successfully.";
				} 
				else 
				{
					echo "Error: " . $sql . "<br>" . $db->error;
				}	
				$db->close();
			}
		}

		##  IP
		## Gets values from text boxes
		if(isset($_REQUEST['IP']))
		{
			$IP=$_REQUEST['IP'];
		}
		if(isset($_REQUEST['ipAS']))
		{
			$ipAS=$_REQUEST['ipAS'];
		}
		if(isset($_REQUEST['IPNUM']))
		{    
			$IPNUM=$_REQUEST['IPNUM'];  
		}
		## Gets user input and decides to add or delete an ip address
		if(isset($_REQUEST['IP']) && isset($_REQUEST['ipAS']) && isset($_REQUEST['IPNUM']))
		{ 
			$ichoice = $_GET["ipChange"];
			## Add
			if($ichoice == "Add")
			{
				$db = new mysqli("127.0.0.1", "ryandeisler", "", "ryandeisler");
				$sql = "INSERT INTO ipaddress (ipAddress, reasonForAssociation, incidentNumber) VALUES ('$IP', '$ipAS', '$IPNUM');";
				if ($db->query($sql) === TRUE)
				{
					echo "New record created successfully.";
				} 
				else 
				{
					echo "Error: " . $sql . "<br>" . $db->error;
				}	
				$db->close();
			}
			## Remove
			else if($ichoice == "Remove")
			{
				$db = new mysqli("127.0.0.1", "ryandeisler", "", "ryandeisler");
				$sql = "DELETE FROM ipaddress WHERE ipaddress = $IP;";
				if ($db->query($sql) === TRUE)
				{
					echo "Record deleted successfully.";
				} 
				else 
				{
					echo "Error: " . $sql . "<br>" . $db->error;
				}	
				$db->close();
			}
		}
		?>
</body>
</html>