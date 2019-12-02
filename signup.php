<html>
<head>
	<title>Issue Tracking System</title>
</head>
<body>
	<h1> Sign Up </h1>

    <a href="login.php">Login</a>

	<form>
    

	
	<!--Text boxes to fill out-->
	Username: <br>
	<input type = "text" name = "USER" multiple><br>
	
	Password: <br>
	<input type = "password" id="PASS" name = "PASSWORD" multiple><br>
        
    Retype password: <br>
    <input type = "password" id="PASS" name = "RETYPE" multiple><br>
	
    <br>
	<input type = "submit">
	</form>
	
    <!--***TO DO: CHANGE PHP-->
    
    
    
	<?php
		##Stores the variables from user inputs
		if(isset($_REQUEST['USER']))
        {
            $user = $_REQUEST['USER'];
        }
        if(isset($_REQUEST['PASSWORD']))
        {
            $password = $_REQUEST['PASSWORD'];
        }
        if(isset($_REQUEST['RETYPE']))
        {
            $retype = $_REQUEST['RETYPE'];
        }
		
    
		## adds the user if filled out correctly, otherwise gives an error
		if(isset($_REQUEST['USER']) && isset($_REQUEST['PASSWORD']) && isset($_REQUEST['RETYPE']))
		{ 
            //start session
            session_start();
            
            if ($password != $retype)
            {
                echo "Your passwords do not match.";
            }
            else
            {
            
			$db = pg_connect("dbname=f19gsefpg1");
			$sql = "INSERT INTO users (name, password, admin) VALUES ('$user', '$password', 0);";
            $result = pg_query($db, $sql);
			if (!$result)
			{
				echo "Error: " . $sql . "<br>" . pg_last_error($db);
			} 
			else 
			{
				
                $_SESSION["loggedin"] = true;
                header("Location: openincidents.php");
                exit;
			}	
			pg_close($db);
            }
		}
        /*else
        {
            echo "Please fill out the entire form.";
        }*/
	?>
    <script src="psswdScript.js"></script>
</body>
</html>