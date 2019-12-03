<html>
<head>
	<title>Issue Tracking System</title>
</head>
<body>
	<h1> Issue Tracking System </h1>
    
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

                //if we are a user, go to user home
	            if ($_SESSION["admin"] == 0)
                {
                    echo "<a href='userHome.php'>Home</a>";
                }
                else
                {
                    // go to admin home
                    echo "<a href='testing.php'>Home</a>";
                }
    
        ?>
    <a href="logout.php">Logout</a>
	<form>
	<h4>Add New Incident</h4> 
    


	
	<!--Text boxes to fill out-->
	<!--Incident Number: <br>
	<input type = "text" name = "NUM" multiple><br>-->
	
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
	
	Date Of Incident (format: YYYY-MM-DD): <br>
	<input type = "text" name = "DATE" multiple><br>
        
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
    
    
	<?php
		##Stores the variables from user inputs
		
		if(isset($_REQUEST['CAT']))
		{
			$CAT=$_REQUEST['CAT'];
		}
    
		
		if(isset($_REQUEST['DATE']))
		{
			$DATE=$_REQUEST['DATE'];
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
            //$DESCRIPTION = addslashes($DESCRIPTION);
		}
    
		## adds the incident if filled out correctly, otherwise gives an error
		if(isset($_REQUEST['CAT']) &&isset($_REQUEST['DATE']) &&isset($_REQUEST['TAG1']) && isset($_REQUEST['TAG2']) &&isset($_REQUEST['TAG3']) && isset($_REQUEST['EMPLOYEE'])
        &&isset($_REQUEST['DESCRIPTION']))
		{ 
            //concatenate all tags into one string for storage
            $TAGS = "\"" . $TAG1 . "\", " . "\"" . $TAG2 . "\", " . "\"" . $TAG3 . "\"";
            $USER = $_SESSION["username"];
            
            //parse tags and description for apostrophes and prevent them from causing error
            $parseTags = str_split($TAGS);
            $parseDesc = str_split($DESCRIPTION);
            $lenTags = strlen($TAGS);
            $lenDesc = strlen($DESCRIPTION);
            $insertString = "'";
            for ($i = 0; $i < $lenDesc; $i++)
            {
                if ($DESCRIPTION[$i] == '\'')
                {
                    $DESCRIPTION = substr_replace($DESCRIPTION, $insertString, $i, 0);
                    break;
                }
            }
            
            for ($i = 0; $i < $lenTags; $i++)
            {
                if ($TAGS[$i] == '\'')
                {
                    $TAGS = substr_replace($TAGS, $insertString, $i, 0);
                    break;
                }
            }
            
			$db = pg_connect("dbname=f19gsefpg1");
			$sql = "INSERT INTO incidents (category, description, date_created, state, client, tags, employee_id, case_history) VALUES ('$CAT', '$DESCRIPTION', '$DATE', 'open', '$USER', '$TAGS', '$EMPLOYEE', '*Ticket created on $DATE.');";
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