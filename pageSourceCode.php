<html>
<head>
	<title>CSIRT Database</title>
</head>
<body>
	<h1>
	CSIRT Database
	</h1>
	
	<!--LINKS TO OTHER PAGES-->
	<a href="pageSourceCode.php">Home</a> <br>
	<a href="addNewComment.php">Add a New Comment</a> <br>	
	<a href="changeState.php">Change an Incident State</a> <br>
	<a href="newIncident.php">File a new Incident</a> <br>
	<a href="addRemove.php">Add or remove a person or IP Address</a> <br>
	
	<h4>Query the database:</h4>
	<form>
	Incident #: <br>
	<input type = "text" name = "incidentNum"><br>
	</form>
	
	<!--THIS PHP BLOCK PRINTS ALL FOUR TABLES-->
	<?php
	if(isset($_GET["incidentNum"]))
	{
		$num =  $_GET["incidentNum"];
	
		$db = new mysqli("127.0.0.1", "ryandeisler", "", "ryandeisler");
		
		#SQL FOR PRINTING INCIDENT TABLE
		$sql1 = "SELECT * FROM `incident` WHERE incidentNumber = $num;";
		
		#SQL FOR PRINTING COMMENTS TABLE
		$sql2 = "SELECT * FROM `comments` WHERE incidentNumber = $num ORDER BY dateWritten DESC;";
		
		#SQL FOR PRINTING PERSON TABLE
		$sql3 = "SELECT * FROM `person` WHERE incidentNumber = $num;";
		
		#SQL FOR PRINTING IPADDRESS TABLE
		$sql5 = "SELECT * FROM `ipaddress` WHERE incidentNumber = $num";
		
		#QUERIES THE DATABASE OBJECT FOR ALL FOUR TABLES
		$result = $db->query($sql1);
		$result2 = $db->query($sql2);
		$result3 = $db->query($sql3);
		$result5 = $db->query($sql5);
		
		#CASE WHERE ERROR OCCURS
		if(!$result)
		{
			echo "Problem with getting incident: " . $db->error;
		}
		#CASE WHERE INCIDENT DOES NOT EXIST
		else if($result->num_rows == 0)
		{
			echo "No incident found.";
		}
		#PRINTS THE INCIDENT TABLE
		else
		{
			echo "<table border = solid>";
			echo "<caption>Incident</caption>";
			echo "<th>Incident #</th><th>Type of Incident</th><th>Date of Incident</th><th>Incident State</th>";
			while($row = $result->fetch_assoc())
			{
				echo "<tr>";
				foreach($row as $col)
				{
					echo "<td>$col</td>";
				}
				echo "</tr>";
			}
			echo "</table>";
			echo "<br>";
			
			
		}
		
		#WRITES LIST OF COMMENTS
		#CASE WHERE ERROR OCCURS
		if(!$result2)
		{
			echo "Problem with getting comments: " . $db->error;
		}
		#CASE WHERE INCIDENT DOES NOT EXIST
		else if($result->num_rows == 0)
		{
			echo "";
		}
		#CASE WHERE NO COMMENTS EXIST
		else if($result2->num_rows == 0)
		{
			echo "No comments associated with this incident. <br>";
		}
		#PRINTS THE COMMENTS TABLE
		else
		{
			echo "<table border = solid>";
			echo "<caption>Comments</caption>";
			echo "<th>Handler ID</th><th>Comments</th><th>Incident #</th><th>Comment #</th><th>Date Written</th>";
			while($row = $result2->fetch_assoc())
			{
				echo "<tr>";
				foreach($row as $col)
				{
					echo "<td>$col</td>";
				}
				echo "</tr>";
			}
			echo "</table>";
			echo "<br>";
		}
		
		#WRITES LIST OF PEOPLE
		#CASE WHERE ERROR OCCURS
		if(!$result3)
		{
			echo "Problem with getting people: " . $db->error;
		}
		#CASE WHERE INCIDENT DOES NOT EXIST
		else if($result->num_rows == 0)
		{
			echo "";
		}
		#CASE WHERE NO PEOPLE EXIST
		else if($result3->num_rows == 0)
		{
			#echo "<caption>People</caption>";
			echo "No people associated with this incident. <br>";
		}
		#PRINTS THE PEOPLE TABLE
		else
		{
			echo "<table border = solid>";
			echo "<caption>People</caption>";
			echo "<th>Last Name</th><th>First Name</th><th>Job Title</th><th>Email Address</th><th>Reason for Association</th><th>Incident #</th>";
			while($row = $result3->fetch_assoc())
			{
				echo "<tr>";
				foreach($row as $col)
				{
					echo "<td>$col</td>";
				}
				echo "</tr>";
			}
			echo "</table>";
			echo "<br>";
		}		
		
				#WRITES LIST OF IPADDRESSES
		#CASE WHERE ERROR OCCURS
		if(!$result5)
		{
			echo "Problem with getting IP addresses: " . $db->error;
		}
		#CASE WHERE INCIDENT DOES NOT EXIST
		else if($result->num_rows == 0)
		{
			echo "";
		}
		#CASE WHERE NO IPADDRESSES EXIST
		else if($result5->num_rows == 0)
		{
			#echo "<caption>IP Addresses</caption>";
			echo "No IP Addresses associated with this incident. <br>";
		}
		#PRINTS THE IPADDRESS TABLE
		else
		{
			echo "<table border = solid>";
			echo "<caption>IP Addresses</caption>";
			echo "<th>IP Address</th><th>Reason for Association</th><th>Incident #</th>";
			while($row = $result5->fetch_assoc())
			{
				echo "<tr>";
				foreach($row as $col)
				{
					echo "<td>$col</td>";
				}
				echo "</tr>";
			}
			echo "</table>";
			echo "<br>";
		}		
		$db->close();
	}
	?>
	
</body>
</html>

<!--http://compsci.adelphi.edu/~ryandeisler/pageSourceCode.php-->