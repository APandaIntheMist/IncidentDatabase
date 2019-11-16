<html>
<head>
	<title>CSIRT Database</title>
</head>
<body>
	<h1> CSIRT Database </h1>
	<a href="pageSourceCode.php">Home</a>
	
	<!--WRITE NEW COMMENT CODE-->
	
	<!--CREATES FORM WITH MULTIPLE PARAMETERS FOR NEW COMMENT-->
	<form>
	<h4>Add New Comment</h4> 
	Handler ID: <br>
	<input type = "text" name = "HandlerID" multiple><br>

	

	Incident #: <br>
	<input type = "text" name = "IncidentNum" multiple><br>

	

	Comment: <br>
	<input type = "text" name = "Comments" multiple><br>

	

	Date (format: YYYY-MM-DD): <br>
	<input type = "text" name = "Date" multiple><br>
	
	<input type = "submit">
	
	</form>
	
	<?php
		#CREATES VARIABLES FOR THE NEW COMMENT
		if(isset($_REQUEST['HandlerID']))
		{
			$handlerID=$_REQUEST['HandlerID'];
		}
		if(isset($_REQUEST['IncidentNum']))
		{
			$incidentNum=$_REQUEST['IncidentNum'];
		}
		if(isset($_REQUEST['Comments']))
		{    
			$comments=$_REQUEST['Comments'];
			$commentsString = strval($comments);
			#echo $commentsString;
		}
		if(isset($_REQUEST['Date']))
		{    
			$date=$_REQUEST['Date'];  
		}
		
		#INSERTS NEW COMMENT INTO DATABASE
		if(isset($_REQUEST['HandlerID']))
		{ 
			$db = new mysqli("127.0.0.1", "ryandeisler", "", "ryandeisler");
			$sql = "INSERT INTO comments (handlerID, comments, incidentNumber, comNumber, dateWritten) VALUES ('$handlerID', '$commentsString', '$incidentNum', 0, '$date');";
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