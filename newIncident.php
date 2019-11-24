<html>
<head>
	<title>Issue Tracking System</title>
</head>
<body>
	<h1> New Incidents </h1>
	<a href="testing.php">Home</a>
    <a href="logout.php">Logout</a>
	<!--ADD A NEW INCIDENT CODE-->
	<form>
	<h4>Add New Incident</h4> 
	
	<!--Text boxes to fill out-->
	Incident Number: <br>
	<input type = "text" name = "NUM" multiple><br>
	
	Category: <br>
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
    </select><br>
        
    Status of Incident (Optional): <br>
	<select name = "STATUS">
        <option value="open">Open</option>
        <option value="closed">Closed</option>
    </select><br><br>
	
	Date Of Incident (format: YYYY-MM-DD): <br>
	<input type = "text" name = "DATE" multiple><br>
        
    Date Resolved(Optional) (format: YYYY-MM-DD): <br>
	<input type = "text" name = "RESOLVED" multiple><br>
        
    User: <br>
    <input type = "text" name = "USER" multiple> <br><br>
        
    Enter three tags: <br>
    <input type = "text" name = "TAG1" multiple> <br>
    <input type = "text" name = "TAG2" multiple> <br>
    <input type = "text" name = "TAG3" multiple> <br><br>
        
    Employee ID: <br>
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
		
		if(isset($_REQUEST['CAT']))
		{
			$CAT=$_REQUEST['CAT'];
		}
    
		if(isset($_REQUEST['STATUS']))
		{
			$STATUS=$_REQUEST['STATUS'];
		}
		
		if(isset($_REQUEST['DATE']))
		{
			$DATE=$_REQUEST['DATE'];
		}
    
        if(isset($_REQUEST['RESOLVED']))
		{
			$RESOLVED=$_REQUEST['RESOLVED'];
		}
    
        if(isset($_REQUEST['USER']))
		{
			$USER=$_REQUEST['USER'];
		}
    
        if(isset($_REQUEST['TAG1']))
		{
			$TAG1=$_REQUEST['TAG1'];
		}
    
        if(isset($_REQUEST['TAG2']))
		{
			$TAG2=$_REQUEST['TAG2'];
		}
    
        if(isset($_REQUEST['TAG3']))
		{
			$TAG3=$_REQUEST['TAG3'];
		}
    
        if(isset($_REQUEST['EMPLOYEE']))
		{
			$EMPLOYEE=$_REQUEST['EMPLOYEE'];
		}
		
        if(isset($_REQUEST['DESCRIPTION']))
		{
			$DESCRIPTION=$_REQUEST['DESCRIPTION'];
		}
    
		## adds the incident if filled out correctly, otherwise gives an error
		if(isset($_REQUEST['NUM']) && isset($_REQUEST['CAT']) &&isset($_REQUEST['DATE']) && isset($_REQUEST['RESOLVED']) &&isset($_REQUEST['TAG1']) && isset($_REQUEST['TAG2']) &&isset($_REQUEST['TAG3']) && isset($_REQUEST['EMPLOYEE'])
        &&isset($_REQUEST['DESCRIPTION']) && isset($_REQUEST['STATUS']))
		{ 
            
            $TAGS = "\"" . $TAG1 . "\", " . "\"" . $TAG2 . "\", " . "\"" . $TAG3 . "\"";
            
			$db = pg_connect("dbname=f19gsefpg1");
			$sql = "INSERT INTO incidents (incident_id, category, description, date_created, date_resolved, state, client, tags, employee_id, case_history) VALUES ('$NUM', '$CAT', '$DESCRIPTION', '$DATE', '$RESOLVED', '$STATUS', '$USER', '$TAGS', '$EMPLOYEE', 'ASK ABOUT CASE HISTORY');";
			if (pg_query($db,$sql) != FALSE)
			{
				echo "New record created successfully";
			} 
			else 
			{
				echo "Error: " . $sql . "<br>" . pg_last_error($db);
			}	
			pg_close($db);
		}
	?>
</body>
</html>