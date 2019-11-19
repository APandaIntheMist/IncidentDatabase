<html>
    <!--http://compsci.adelphi.edu/~ryandeisler/IssueTrackingSystem/testing.php-->
<head>
	<title>Issue Tracking System</title>
</head>
<body>
	<h1>
	Issue Tracking System
	</h1>
    <a href="newIncident.php">New Incidents</a>
	
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
	
		$db = pg_connect("dbname=f19gsefpg1");
        
        $status = pg_connection_status($db);
        
        if ($status === PGSQL_CONNECTION_OK){
            echo "GOOD CONNECTION";
        }
        else{
            echo "BAD CONNECTION";
        }
		
		#SQL FOR PRINTING INCIDENT TABLE
		$sql1 = "SELECT * FROM example where column1 = $num";
		
		
		
		#QUERIES THE DATABASE OBJECT
		$result = pg_query($db,$sql1);

		
		#CASE WHERE ERROR OCCURS
		if(!$result)
		{
			echo "Problem with getting int: " . $db->error;
		}
		#CASE WHERE INCIDENT DOES NOT EXIST
		else if(pg_num_rows($result) == 0)
		{
			echo "No int found.";
		}
		#PRINTS THE INCIDENT TABLE
		else
		{
			echo "<table border = solid>";
			echo "<caption>Incident</caption>";
			echo "<th>Int</th>";
			while($row = pg_fetch_row($result))
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
			
		echo "Was closure successful:" . pg_close($db);
	}
	?>
	
</body>
</html>

<!--http://compsci.adelphi.edu/~ryandeisler/pageSourceCode.php-->