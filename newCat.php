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
	<!--ADD A NEW INCIDENT CODE-->
	
	<h4>Add New Category</h4> 
    


	
	<!--Text boxes to fill out-->	
	Current Categories: <br>
    <ul>

        <!--this php block gets categories from the database-->
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
            //for loop that goes through all the categories
            $allCategories = pg_fetch_all_columns($result,0);
            for ($i = 0, $size = count($allCategories); $i < $size; ++$i) {
                echo "<li value='$allCategories[$i]'>$allCategories[$i]</li>";
            }
        }
        pg_close($db);
        ?>
</ul>
    
    <h4>Enter new category: </h4>
    <form>
        <input type = "text" name = "NEWCAT"><br>
        <input type = "submit">
    </form>
    
    
	<?php
		##Stores the variables from user inputs
		
		if(isset($_REQUEST['NEWCAT']))
		{
			$NEWCAT=$_REQUEST['NEWCAT'];
		}
    
    
		## adds the incident if filled out correctly, otherwise gives an error
		if(isset($_REQUEST['NEWCAT']))
		{ 
            
			$db = pg_connect("dbname=f19gsefpg1");
			$sql = "INSERT INTO categories (type) VALUES ('$NEWCAT');";
            
            $allCategories = pg_fetch_all_columns($result,0);
            for ($i = 0, $size = count($allCategories); $i < $size; ++$i)
            {
                $exists = false;
                if ($allCategories[$i] == $NEWCAT)
                {
                    echo "That category already exists.";
                    $exists = true;
                }
            }
            
            if(!$exists)
            {
                $result = pg_query($db,$sql);
            }
			if ($result != FALSE)
			{
				echo "New category created successfully";
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