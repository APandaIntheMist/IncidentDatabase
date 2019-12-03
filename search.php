<html>
    <!--http://compsci.adelphi.edu/~ryandeisler/IssueTrackingSystem/testing.php-->
<head>
	<title>Issue Tracking System</title>
</head>
<body>
	<h1>
	Search and Edit Incident
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
        echo "Welcome, ". $_SESSION['username'] . "<br>";
    }
    ?>
    <a href="testing.php">Home</a>
    <a href="logout.php">Logout</a>
	
	<h4>Query the database:</h4>
	<form>
	Incident #: <br>
	<input type = "text" name = "incidentNum"><br>
	</form>
	
	<!--THIS PHP BLOCK PRINTS ALL FOUR TABLES-->
	
    <?php
        
    $db = pg_connect("dbname=f19gsefpg1");
    
	if(isset($_GET["incidentNum"]))
	{
		$num =  $_GET["incidentNum"];
        $_SESSION["id"] = $num;
		
		#SQL FOR PRINTING INCIDENT TABLE
		$sql1 = "SELECT * FROM incidents where incident_id = $num";
		
		
		
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
			echo "No incident found.";
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
        
			
	}
    
	?>
    <form>
        Edit Incident ID:
        <input type = "text" name = "ID" multiple> <br><br>
        Edit Category:
        <select name = "CAT">
            <!--this php block lets the incident form get categories from the database-->
        <?php
        $db = pg_connect("dbname=f19gsefpg1");
        $sql = "SELECT * FROM categories;";
        $result = pg_query($db,$sql);
        
        if (!$result)
        {
            echo "There was a problem getting categories: " . pg_last_error();
        }
        else
        {
            $allCategories = pg_fetch_all_columns($result,0);
            for ($i = 0, $size = count($allCategories); $i < $size; ++$i) {
                echo "<option value='$allCategories[$i]'>$allCategories[$i]</option>";
            }
        }
        pg_close($db);
        ?>
        </select>
        
        <br><br>Edit Description: <br>
        <?php
        if(isset($_GET["incidentNum"]))
        {
            $num = $_GET["incidentNum"];
            $db = pg_connect("dbname=f19gsefpg1");
            $sql = "SELECT * FROM incidents where incident_id = $num;";
            $result = pg_query($db,$sql);
            $sqlDescrip = pg_fetch_all_columns($result,2);
            $realDescrip = $sqlDescrip[0];
            echo "<textarea name = 'DESCRIBE' rows='10' cols='50'>$realDescrip</textarea><br>";
            
        }
        ?>
        
        Date Of Incident (format: YYYY-MM-DD):
	<input type = "text" name = "DATE" multiple><br>
        
        Date Resolved (format: YYYY-MM-DD):
	<input type = "text" name = "RESOLVED" multiple><br>
        
        Status:
        <select name = "STATUS">
            <option value='open'>Open</option>
            <option value='closed'>Closed</option>
        </select><br>
        
        Client:
        <input type="text" name="CLIENT"><br><br>
        
        Edit tags:<br>
        <?php
        if(isset($_GET["incidentNum"]))
        {
            $num = $_GET["incidentNum"];
            $db = pg_connect("dbname=f19gsefpg1");
            $sql = "SELECT * FROM incidents where incident_id = $num;";
            $result = pg_query($db,$sql);
            $sqlTags = pg_fetch_all_columns($result,7);
            $realTags = $sqlTags[0];
            echo "<textarea name = 'TAGS' rows='10' cols='50'>$realTags</textarea><br><br>";
            
        }
        ?>
        
        Edit assigned employee:
        <input type = "text" name = "EMPLOYEE"><br><br>
        
        Edit case history:<br>
        <?php
        if(isset($_GET["incidentNum"]))
        {
            $num = $_GET["incidentNum"];
            $db = pg_connect("dbname=f19gsefpg1");
            $sql = "SELECT * FROM incidents where incident_id = $num;";
            $result = pg_query($db,$sql);
            $sqlCase = pg_fetch_all_columns($result,9);
            $realCase = $sqlCase[0];
            echo "<textarea name = 'CASE' rows='10' cols='50'>$realCase</textarea><br><br>";
            
        }
        ?>
        
        <input type = "submit" value="Update">
    </form>
    
    <?php
        error_reporting(0);
        $num = $_SESSION["id"];
        $db = pg_connect("dbname=f19gsefpg1");

        if(isset($_REQUEST['ID']))
        {
            $id = $_REQUEST['ID'];
            
            $sql = "UPDATE incidents SET incident_id = $id WHERE incident_id = $num;";
            $result = pg_query($db,$sql);
            if($result != false)
            {
                echo "Updated!";
            }
            /*else
            {
                echo "Failed to update: " . pg_last_error();
            }*/
        }
    
        if(isset($_REQUEST['CAT']))
        {
            $cat = $_REQUEST['CAT'];
            
            $sql = "UPDATE incidents SET category = '$cat' WHERE incident_id = $num;";
            $result = pg_query($db,$sql);
            if($result != false)
            {
                echo "Updated!";
            }
            else
            {
                echo "Failed to update: " . pg_last_error();
            }
        }
    
        if(isset($_REQUEST['DESCRIBE']))
        {
            $describe = $_REQUEST['DESCRIBE'];
            
            $sql = "UPDATE incidents SET description = '$describe' WHERE incident_id = $num;";
            $result = pg_query($db,$sql);
            if($result != false)
            {
                echo "Updated!";
            }
            else
            {
                echo "Failed to update: " . pg_last_error();
            }
        }
    
        if(isset($_REQUEST['DATE']))
        {
            $date = $_REQUEST['DATE'];
            
            $sql = "UPDATE incidents SET date_created = $date WHERE incident_id = $num;";
            $result = pg_query($db,$sql);
            if($result != false)
            {
                echo "Updated!";
            }
            /*else
            {
                echo "Failed to update: " . pg_last_error();
            }*/
        }
    
        if(isset($_REQUEST['RESOLVED']))
        {
            $resolved = $_REQUEST['RESOLVED'];
            
            $sql = "UPDATE incidents SET date_resolved = '$resolved' WHERE incident_id = $num;";
            $result = pg_query($db,$sql);
            if($result != false)
            {
                echo "Updated!";
            }
            /*else
            {
                echo "Failed to update: " . pg_last_error();
            }*/
        }
    
        if(isset($_REQUEST['STATUS']))
        {
            $status = $_REQUEST['STATUS'];
            
            $sql = "UPDATE incidents SET state = '$status' WHERE incident_id = $num;";
            $result = pg_query($db,$sql);
            if($result != false)
            {
                echo "Updated!";
            }
            else
            {
                echo "Failed to update: " . pg_last_error();
            }
        }
    
    
        if(isset($_REQUEST['CLIENT']))
        {
            $client = $_REQUEST['CLIENT'];
            
            $sql = "UPDATE incidents SET client = $client WHERE incident_id = $num;";
            $result = pg_query($db,$sql);
            if($result != false)
            {
                echo "Updated!";
            }
            /*else
            {
                echo "Failed to update: " . pg_last_error();
            }*/
        }
    
        if(isset($_REQUEST['TAGS']))
        {
            $tags = $_REQUEST['TAGS'];
            
            $sql = "UPDATE incidents SET tags = '$tags' WHERE incident_id = $num;";
            $result = pg_query($db,$sql);
            if($result != false)
            {
                echo "Updated!";
            }
            else
            {
                echo "Failed to update: " . pg_last_error();
            }
        }
    
        if(isset($_REQUEST['EMPLOYEE']))
        {
            $employee = $_REQUEST['EMPLOYEE'];
            
            $sql = "UPDATE incidents SET employee_id = $employee WHERE incident_id = $num;";
            $result = pg_query($db,$sql);
            if($result != false)
            {
                echo "Updated!";
            }
            /*else
            {
                echo "Failed to update: " . pg_last_error();
            }*/
        }
    
        if(isset($_REQUEST['CASE']))
        {
            $case = $_REQUEST['CASE'];
            
            $sql = "UPDATE incidents SET case_history = '$case' WHERE incident_id = $num;";
            $result = pg_query($db,$sql);
            if($result != false)
            {
                echo "Updated!";
            }
            else
            {
                echo "Failed to update: " . pg_last_error();
            }
        }
      
    ?>
	
</body>
</html>

<!--http://compsci.adelphi.edu/~ryandeisler/pageSourceCode.php-->