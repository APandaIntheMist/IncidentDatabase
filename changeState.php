<html>
<head>
	<title>CSIRT Database</title>
</head>
<body>
	<h1> CSIRT Database  </h1>
	<a href="pageSourceCode.php">Home</a>
	<h4>Change Incident State</h4>
	
<!--DROP DOWN STATE CHANGE-->
				Incident #: <br>
				<form id = "stateForm">
					<input type = "text" name = "incidentNum2"><br>
					<input type = "submit">
					<select name = "states" form = "stateForm">
						<option value = "open">Open</option>
						<option value = "closed">Closed</option>
						<option value = "stalled">Stalled</option>
					</select>
				</form>
				
		<?php
		#UPDATES INCIDENT STATE IN DATABASE
		if(isset($_GET["states"]) && isset($_GET["incidentNum2"]))
		{
			$db2 = new mysqli("127.0.0.1", "ryandeisler", "", "ryandeisler");
			$num2 = $_GET["incidentNum2"];
			$state = $_GET["states"];
			$sql4 = "UPDATE `incident` SET incidentState = '$state' WHERE incidentNumber = $num2;";
			$result4 = $db2->query($sql4);
			
			#PRINTS ERROR
			if(!$result4)
			{
				echo "Bummer! FOUR" . $db2->error;
			}
			#CONFIRMATION
			else
			{
				echo "Changed state succesfully.";
				$db2->close();
			}
		}
		?>
</body>
</html>