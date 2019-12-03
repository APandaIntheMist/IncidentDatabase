<html>
    <head>
	   <title>Issue Tracking System</title>
    </head>
    <body>
	   <h1>
	   Open Incidents
	   </h1>
        
        <?php
        
        session_start();
    
        // Check if the user is logged in, if not then redirect him to login page
        if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true)
        {
            header("location: login.php");
            exit;
        }
        else
        {
            echo "Welcome, " . $_SESSION['username'] . "<br>";
        }
        
        ?>
        
        <a href="userHome.php">Home</a>
        <a href="newIncident.php">New Incidents</a>
        <a href="logout.php">Logout</a>
        
        
        
        <?php
    
        $db = pg_connect("dbname=f19gsefpg1");
        
        $NAME = $_SESSION["username"];
        
		
		#SQL FOR PRINTING INCIDENT TABLE
		$sql1 = "SELECT * FROM incidents where state = 'open' and client = '$NAME'";
		
		
		
		#QUERIES THE DATABASE OBJECT
		$result = pg_query($db,$sql1);

		
		#CASE WHERE ERROR OCCURS
		if(!$result)
		{
			echo "Problem with getting int: " . pg_last_error($db);
		}
		#CASE WHERE INCIDENT DOES NOT EXIST
		else if(pg_num_rows($result) == 0)
		{
			echo "<br><br>No issues found.";
		}
		#PRINTS THE INCIDENT TABLE
		else
		{
			echo "<table border = solid>";
			echo "<caption>Incident</caption>";
			echo "<th>Incident ID</th><th>Category</th><th>Description</th><th>Date Created</th><th>Date Resolved</th><th>State</th><th>Client</th><th>Tags</th><th>Employee ID</th><th>Case History</th>";
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
			
		#echo "Was closure successful:" . #pg_close($db);
	
	?>
   
    </body>
</html>