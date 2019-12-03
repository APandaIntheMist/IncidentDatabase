<html>
    
    <!--http://compsci.adelphi.edu/~ryandeisler/IssueTrackingSystem/login.php-->
    
    <head>
	   <title>Issue Tracking System</title>
       
    </head>
    <body>
       <h1>
       Issue Tracking System
       </h1>
	   <h2>
	   Login
	   </h2>
    
        <form>
            <h3>Username</h3>
            <input type=text name="USER" multiple>
        
            <h3>Password</h3>
            <input type="password" id="PASS" name="PASS" multiple><br><br>
            <input type=submit>
        </form>
        
        <p>Not a member?  <a href="signup.php">Sign up!</a></p>
        
        <?php
        //using sessions to provide security
        session_start();
        
        ##Stores the variables from user inputs
		  if(isset($_REQUEST['USER']) && isset($_REQUEST['PASS']))
		  {
              $user=$_REQUEST['USER'];
              $pass=$_REQUEST['PASS'];
              
              $db = pg_connect("dbname=f19gsefpg1");
        
              $sql = "SELECT * FROM users WHERE name='$user' AND password='$pass'";
        
              $result = pg_query($db,$sql);
        
            //if incorrect login
               if(pg_num_rows($result) == 0)
              {
                echo "Incorrect username or password.";
              }
              else
              {
                  //tell session user is logged in
                $_SESSION["loggedin"] = true;
                $_SESSION["username"] = pg_fetch_result($result,0,0);
                
                
                if (pg_fetch_result($result,0,3) == 0)
                {
                    $_SESSION["admin"] = 0;
                    header("Location: userHome.php");
                    exit;
                }
                else
                {
                    $_SESSION["admin"] = 1;
                    header("Location: testing.php");
                    exit;
                }
              }
		  }
		

        

        
        ?>
   <script src="psswdScript.js"></script>
    </body>
</html>